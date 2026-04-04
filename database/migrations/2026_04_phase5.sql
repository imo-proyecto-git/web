-- ============================================================
-- MIGRACIÓN FASE 5: Contratos OTP + Queue + Campañas
-- empresaIMO Digital (HIPAA / COPC 7.1)
-- Ejecutar sobre: empresaIMO_db
-- ============================================================

USE empresaIMO_db;

-- ── 1. OTP para firma de contratos ───────────────────────────
CREATE TABLE IF NOT EXISTS contract_otps (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contract_id BIGINT UNSIGNED NOT NULL,
    otp_code CHAR(6) NOT NULL,
    email VARCHAR(255) NOT NULL,
    expires_at TIMESTAMP NOT NULL,
    used_at TIMESTAMP NULL,
    ip_address VARCHAR(45) NOT NULL,
    attempts TINYINT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contract_id) REFERENCES contracts(id) ON DELETE CASCADE,
    INDEX idx_contract_otp (contract_id, otp_code)
) ENGINE=InnoDB COMMENT='OTP de un solo uso para validación de firma digital HIPAA';

-- Añadir columna email de contacto al contrato
ALTER TABLE contracts
    ADD COLUMN IF NOT EXISTS contact_email VARCHAR(255) NULL COMMENT 'Email del firmante para envío de OTP',
    ADD COLUMN IF NOT EXISTS otp_verified TINYINT(1) DEFAULT 0 COMMENT '1=OTP verified before sign',
    ADD COLUMN IF NOT EXISTS pdf_path VARCHAR(512) NULL COMMENT 'Ruta relativa al PDF generado post-firma';

-- ── 2. Cola de trabajos background (Queue Engine) ────────────
CREATE TABLE IF NOT EXISTS job_queue (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(100) NOT NULL DEFAULT 'default' COMMENT 'Nombre de la cola (emails, reports, etc)',
    payload LONGTEXT NOT NULL COMMENT 'JSON serializado del job',
    status ENUM('pending', 'processing', 'done', 'failed') DEFAULT 'pending',
    attempts TINYINT UNSIGNED DEFAULT 0,
    max_attempts TINYINT UNSIGNED DEFAULT 3,
    available_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    started_at TIMESTAMP NULL,
    done_at TIMESTAMP NULL,
    failed_reason TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_queue_status (queue, status, available_at),
    INDEX idx_status_attempts (status, attempts)
) ENGINE=InnoDB COMMENT='Cola de trabajos asíncronos - Worker procesa en segundo plano';

-- ── 3. Campaña enriquecida con estado de cola ────────────────
CREATE TABLE IF NOT EXISTS campaigns (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    subject VARCHAR(500) NOT NULL,
    html_body LONGTEXT NOT NULL COMMENT 'Cuerpo HTML generado por el Mail Builder',
    status ENUM('draft', 'queued', 'sending', 'sent', 'failed', 'paused') DEFAULT 'draft',
    recipient_count INT UNSIGNED DEFAULT 0,
    sent_count INT UNSIGNED DEFAULT 0,
    open_count INT UNSIGNED DEFAULT 0,
    click_count INT UNSIGNED DEFAULT 0,
    created_by BIGINT UNSIGNED NOT NULL,
    scheduled_at TIMESTAMP NULL,
    started_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ── 4. Destinatarios de campaña ──────────────────────────────
CREATE TABLE IF NOT EXISTS campaign_recipients (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    campaign_id BIGINT UNSIGNED NOT NULL,
    email VARCHAR(255) NOT NULL,
    name VARCHAR(255) NULL,
    status ENUM('pending', 'sent', 'failed', 'bounced', 'opened', 'clicked') DEFAULT 'pending',
    sent_at TIMESTAMP NULL,
    opened_at TIMESTAMP NULL,
    job_id BIGINT UNSIGNED NULL COMMENT 'FK a job_queue',
    FOREIGN KEY (campaign_id) REFERENCES campaigns(id) ON DELETE CASCADE,
    INDEX idx_campaign_status (campaign_id, status)
) ENGINE=InnoDB;
