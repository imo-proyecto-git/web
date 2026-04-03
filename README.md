# empresaIMO - Plataforma Enterprise Agent Portal

Plataforma CRM y de gestión de prospectos de alto rendimiento diseñada para una gestora de seguros (IMO). Arquitectura resiliente, segura y altamente parametrizable.

## Arquitectura y Estándares
- **Clean Architecture**: Capas desacopladas (Core, Modules, Infrastructure).
- **Cero Hardcodeo**: Configuración jerárquica vía `.env` y archivos en `config/`.
- **HIPAA Ready**:
    - **Cifrado AES-256-GCM** para datos PII (Prospectos).
    - **Audit Trail PHI-Secure**: Bitácora inmutable de accesos a datos sensibles.
    - **Enmascaramiento de Datos**: Privacidad por diseño en vistas generales.
- **COPC 7.1 Compliance**: Dashboards con métricas de eficiencia (Speed to Lead).

## Stack Tecnológico
- **Backend**: PHP 8+ (Clean PHP)
- **Base de Datos**: MySQL / MariaDB (Optimización para hosting compartido)
- **Motor de IA**: Groq Integration (LLaMA 3.1) para Lead Scoring asíncrono.
- **Frontend**: Vanilla JS + Tailwind CSS (Bento Layout System).

## Módulos Principales
1. **Landing Page**: Alta conversión con captura segura de prospectos.
2. **Dashboard Agente**: Gestión de pipeline, métricas y detalles de lead 360°.
3. **Firma Digital**: Firma electrónica integrada (Click-to-sign) con prueba de integridad SHA-256.
4. **Dashboard Supervisión**: KPIs globales y auditoría centralizada para gerencia.
5. **Generador de Reportes**: Exportación segura de informes PII (Print-optimized).

## Instalación y Configuración
1. Clonar el repositorio.
2. Configurar el archivo `.env` basado en `.env.example` (incluir `APP_SECRET` y `AI_API_KEY`).
3. Ejecutar `database/schema.sql` en su gestor de DB.
4. Apuntar su servidor web a la carpeta `/public`.

## Seguridad y Auditoría
Cualquier acceso a información de salud protegida (PHI) es auditado automáticamente mediante `AuditService::log`, registrando Usuario, IP, Acción y Timestamp UTC.
