# DOCUMENTACIÓN DE SEGURIDAD: PROTOCOLO HIPAA Y ZERO TRUST (IMO-OS)

## 1. Visión General de Seguridad
**empresaIMO (IMO-OS)** implementa una arquitectura de seguridad integral basada en el principio de **Privacidad por Diseño** (**Privacy by Design**), cumpliendo con los estándares de **HIPAA** (Health Insurance Portability and Accountability Act) y **PCI DSS** (opcional).

## 2. Protección de Datos (Cifrado)
- **Datos en Reposo**: La información de prospectos (Nombre, Teléfono, Correo) se almacena en la tabla `leads.encrypted_payload` utilizando cifrado simétrico **AES-256-GCM** con una clave maestra (`APP_SECRET`) única por entorno.
- **Datos en Tránsito**: Obligación de uso de **TLS 1.3** para todas las comunicaciones entre el cliente y el servidor, y entre el servidor y las APIs externas (Groq/OpenAI).

## 3. Bitácora de Auditoría Inmutable (Immutable Audit Trail)
- **Registro Automático**: Cada acceso a datos PHI (Protected Health Information) se registra mediante `triggers` de base de datos MySQL, vinculando la identidad del usuario y la IP de origen, independientemente de si la acción se realiza vía web o CLI.
- **Integridad**: Los registros en la tabla `audit_logs` no pueden ser eliminados ni modificados, garantizando la trazabilidad histórica exigida en auditorías bancarias y de seguros.

## 4. Control de Acceso (RBAC)
- **Roles Definidos**: Admin, Manager, Agente.
- **Principio de Privilegio Mínimo**: Los agentes sólo tienen acceso a los prospectos asignados a su ID de usuario. Los gerentes pueden ver métricas agregadas pero no ver el detalle de PII a menos que sea necesario para aprobación de contratos.
- **Manejo de Sesión**: Política de cierre automático tras **15 minutos** de inactividad, con advertencia previa por interfaz.

## 5. Prevención de Ataques
- **SQL Injection**: Implementación estricta de Sentencias Preparadas (Prepared Statements) en todas las consultas a base de datos.
- **CSRF**: Tokens dinámicos generados por sesión (`$_SESSION['csrf_token']`) validados en todas las solicitudes POST/PUT/DELETE.
- **Brute Force Protection**: El sistema monitoriza los intentos fallidos de inicio de sesión y bloquea IPs/Cuentas tras 5 intentos (vía `Auth::login`).

---
*Ultima actualización: Abril 2026*
