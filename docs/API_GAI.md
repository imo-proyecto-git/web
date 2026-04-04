# DOCUMENTACIÓN DE API: MOTOR DE CALIFICACIÓN PREDICTIVA (GAI)

## 1. Visión General
El motor de **GAI (Generative Artificial Intelligence)** de **empresaIMO (IMO-OS)** se integra con múltiples proveedores de inferencia (Groq, OpenAI, Ollama) para calificar prospectos interesados en productos de seguros y finanzas. 

El modelo base es **LLaMA 3.1 (70B/8B Instant)**, optimizado mediante **Prompt Engineering** para el mercado hispano de EE.UU.

## 2. Endpoints Principales

### 2.1. Calificación de Prospecto (Scoring)
- **POST** `/api/v1/gai/qualify`
- **Autenticación**: JWT / Sesión.
- **Payload**:
  ```json
  {
      "lead_id": 12345,
      "data": {
          "name": "Juan Perez",
          "insurance_type": "Life",
          "timestamp": "2026-04-04 17:30"
      }
  }
  ```
- **Response**:
  ```json
  {
      "score": 85,
      "priority": "VIP",
      "analysis": "Interés genuino en protección familiar. Target óptimo (35-55).",
      "recommended_action": "Contactar en los próximos 5 minutos.",
      "agent_script": "Hola Juan, vi que consultaste nuestra cobertura de Vida. Muchos padres como tú están asegurando hoy el futuro de sus hijos ante las nuevas tarifas..."
  }
  ```

## 3. Lógica de Scoring (Psicología de Ventas)
El motor de IA analiza tres dimensiones críticas:
1. **Intención**: ¿Qué tipo de seguro busca y con qué urgencia? (Puntuación base).
2. **Psicología**: Aplicación de sesgos cognitivos (Aversión a la pérdida, Social Proof).
3. **Conversión**: Generación de un micro-guion personalizado para el asesor comercial.

## 4. Configuración (Zero-Hardcode)
Los parámetros del motor de IA se encuentran en `config/ai.php`:
- `AI_PROVIDER`: `groq` | `openai` | `ollama`.
- `AI_MODEL`: `llama-3.1-8b-instant`.
- `AI_THRESHOLD_VIP`: `80`+.

## 5. Auditoría y Logs
Cada llamada al motor de scoring se registra en la tabla `audit_logs` con el tipo de evento `AI_SCORING`, asegurando trazabilidad bajo estándares de cumplimiento de datos sensibles.

---
*Ultima actualización: Abril 2026*
