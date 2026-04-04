# DOCUMENTACIÓN TÉCNICA: ARQUITECTURA DE SISTEMAS (IMO-OS)

## 1. Visión General
**empresaIMO (IMO-OS)** es una arquitectura modular basada en PHP 8.x, diseñada para operar en entornos de alta regulación (Insurtech/Fintech) siguiendo los estándares **HIPAA** y **COPC 7.1**.

## 2. Capas del Sistema

### 2.1. Capa Core (`src/Core`)
- **Router**: Sistema de enrutamiento basado en controladores y acciones, desacoplado del servidor web nativo.
- **Security**: Motor centralizado de Auth (RBAC), CSRF, y manejadores de encriptación AES-256-GCM.
- **Database**: Implementación Singleton de PDO con inyección automática de contexto de usuario para disparadores (triggers) de base de datos.
- **Infrastructure**: Servicios transversales de logging, caché y comunicaciones (Mailer, AI Client).

### 2.2. Capa de Módulos (`src/Modules`)
Diseño de dominios independientes:
- **Agent/Manager**: Portales de usuario final diferenciados por rol.
- **Leads**: Gestión del ciclo de vida del prospecto.
- **GAI (GenAI)**: Orquestación de inferencia con LLMs (Groq/OpenAI) para scoring comercial.
- **Marketing**: Motor de campañas masivas (en desarrollo).
- **Audit**: Ledger inmutable de eventos sensibles.

## 3. Flujo de Datos y Seguridad (HIPAA)
1. **Captura**: Las entradas de datos sensibles (PHI/PII) pasan por un `EncryptionService` antes de persistir en `leads.encrypted_payload`.
2. **Acceso**: Cualquier lectura de la tabla de leads genera un registro automático en `audit_logs` vinculando el User ID, IP y el ID del registro consultado.
3. **Persistencia**: MySQL 8.0 garantiza la integridad mediante foreign keys y triggers que impiden la modificación de registros de auditoría históricos.

## 4. Estrategia de Resiliencia y Alta Disponibilidad (Fase 5)
Para garantizar la escalabilidad y disponibilidad 24/7 de **empresaIMO (IMO-OS)**:
- **Queue System (Real-time DBQ)**: Implementación de una arquitectura de colas persistente en base de datos (`job_queue`). Utiliza bloqueo pesimista (`SKIP LOCKED`) para permitir múltiples workers simultáneos sin colisiones.
- **Worker Daemon**: Proceso CLI asíncrono para el despacho masivo de campañas de marketing y procesos pesados (Lead Scoring), liberando recursos inmediatos en la UI.
- **Smart Contracts & OTP**: Capa de legitimación legal mediante firma electrónica Click-to-Sign, reforzada por verificación de identidad One-Time Password (OTP) enviada por canales seguros.

## 5. Próximas Evoluciones (Roadmap)
- Integración de Webhooks para eventos de apertura y click (Tracking Pixels).
- Soporte para adjuntos pesados en colas de envío.
- Dashboard de monitoreo de salud del Worker (Heartbeat).

---
*Ultima actualización: 04 Abril 2026 - Fase 5 Desplegada*
