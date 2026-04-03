-- --------------------------------------------------------
-- SCRIPT DE INICIALIZACIÓN - empresaIMO Digital (HIPAA / COPC 7.1)
-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS empresaIMO_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE empresaIMO_db;

-- 1. Tabla de Roles Estrictos (RBAC)
CREATE TABLE IF NOT EXISTS roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    key_name VARCHAR(50) NOT NULL UNIQUE,
    display_name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Tabla de Usuarios (Zero Trust)
CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    role_id INT UNSIGNED NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    two_factor_secret VARCHAR(255) NULL,
    status ENUM('active', 'inactive', 'locked') DEFAULT 'active',
    last_login_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 3. Tabla de Leads (Cotizaciones) - Datos PII Encapsulados
CREATE TABLE IF NOT EXISTS leads (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    encrypted_payload TEXT NOT NULL COMMENT 'JSON encriptado AES256 con PII (Nombre, Email, Teléfono)',
    insurance_type VARCHAR(100) NOT NULL,
    status ENUM('new', 'contacted', 'qualified', 'converted', 'rejected') DEFAULT 'new',
    score INT DEFAULT 0 COMMENT 'Lead Scoring (AI/Rules)',
    assigned_user_id BIGINT UNSIGNED NULL,
    origin_ip VARCHAR(45) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 4. Motor de Auditoría Fuerte (HIPAA Requirenment - Inmutable By Policy)
CREATE TABLE IF NOT EXISTS audit_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    action VARCHAR(100) NOT NULL COMMENT 'Ej: VIEW_LEAD, EXPORT_DATA, LOGIN_FAILED',
    target_table VARCHAR(50) NULL,
    target_record_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent VARCHAR(255) NULL,
    details TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 5. Módulo de Contratos y Firma Digital (HIPAA compliant)
CREATE TABLE IF NOT EXISTS contracts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(36) NOT NULL UNIQUE,
    lead_id BIGINT UNSIGNED NOT NULL,
    status ENUM('draft', 'sent', 'signed', 'expired', 'rejected') DEFAULT 'draft',
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    signature_hash VARCHAR(128) NULL COMMENT 'SHA-256 de la firma digital (Click-to-sign)',
    ip_address VARCHAR(45) NULL,
    signed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (lead_id) REFERENCES leads(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. Auditoría PHI-Secure de Contratos
CREATE TABLE IF NOT EXISTS contract_audit (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    contract_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NULL,
    event_type VARCHAR(50) NOT NULL COMMENT 'VIEW, SIGN, DOWNLOAD',
    ip_address VARCHAR(45) NOT NULL,
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contract_id) REFERENCES contracts(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- DATOS SEMILLA (Seeders)
INSERT IGNORE INTO roles (key_name, display_name) VALUES 
('superadmin', 'Super Administrador'),
('manager', 'Gerente Comercial'),
('agent', 'Agente de Ventas');

INSERT IGNORE INTO users (uuid, role_id, email, password_hash) VALUES 
(UUID(), 1, 'admin@empresaimo.com', '$2y$10$M6P/aAEXiQoB5zB0t/ZpAuvQ1m7H1EEX9R/5xR/gAIfOqf8j7aVfK');
