# empresaIMO - Plataforma Enterprise Agent Portal / IMO-OS
v5.0 - High Availability & Smart Compliance

Plataforma CRM y de gestión de prospectos de alto rendimiento diseñada para una gestora de seguros (IMO). Arquitectura resiliente, segura y altamente parametrizable.

## Arquitectura y Estándares
- **Clean Architecture**: Capas desacopladas (Core, Modules, Infrastructure).
- **Cero Hardcodeo (Zero-Hardcode)**: Todas las URIs (Unsplash, UI Avatars, SendGrid, Groq), parámetros base de datos y cadenas literales fijas ("empresaIMO") fueron abstraídas. Toda personalización opera vía `.env` y archivos en `config/`.
- **HIPAA Ready**:
    - **Cifrado AES-256-GCM** para datos PII (Prospectos).
    - **Audit Trail PHI-Secure**: Bitácora inmutable de accesos a datos sensibles.
    - **Enmascaramiento de Datos**: Privacidad por diseño en vistas generales.
- **COPC 7.1 Compliance**: Dashboards con métricas de eficiencia (Speed to Lead).

## Stack Tecnológico
- **Backend**: PHP 8+ (Clean PHP)
- **Base de Datos**: MySQL / MariaDB (Optimización para hosting compartido)
- **Motor de IA**: Groq Integration (LLaMA 3.1) para Lead Scoring asíncrono.
- **Frontend**: Vanilla JS + Tailwind CSS (Bento Layout System + Framer-like animations).
- **Global Layout System**: Arquitectura de navegación unificada (Shared Components) para Agentes y Managers, optimizando la coherencia visual y carga cognitiva.
- **Inyección de Contexto**: El Motor de Vistas (`Engine.php`) inyecta automáticamente el estado global (User, Config) eliminando el boiler-plate en controladores.
- **UX Premium**: Sistema de Parallax dinámico y jerarquía visual optimizada.

## Módulos Principales
1. **Marketing Suite**: Módulo de "Océano Azul" y Estilo de Vida (Gamificación Visual).
2. **IA Asistente (Ana)**: Chat inteligente con orquestación por scroll (3 fases).
3. **Pipeline Kanban**: Gestión táctica de leads mediante tableros dinámicos (Drag & Drop).
4. **Contract Builder**: Constructor de acuerdos legales interconectado con la ficha del Lead para cierres rápidos.
5. **Dashboard Manager**: KPIs reales (Insurtech Metrics) y Auditoría HIPAA Centralizada con navegación simplificada.
6. **Incomes & Financials**: Visualización de comisiones y estructura residual para agentes.
7. **IA Lead Scoring**: Motor predictivo LLaMa para priorización de prospectos.
8. **Seguridad Zero Trust**: Encriptación AES-256 de PII y ledger inmutable de auditoría.

## Instalación y Configuración
1. Clonar el repositorio.
2. Configurar el archivo `.env` basado en `.env.example` (incluir `APP_SECRET` y `AI_API_KEY`).
3. Ejecutar `database/schema.sql` en su gestor de DB.
4. Apuntar su servidor web a la carpeta `/public`.

## Seguridad y Auditoría
Cualquier acceso a información de salud protegida (PHI) es auditado automáticamente mediante `AuditService::log`, registrando Usuario, IP, Acción y Timestamp UTC.
