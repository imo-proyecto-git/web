<?php

namespace IMO\Modules\GAI\Services;

use IMO\Core\Database\Connection;
use IMO\Modules\Audit\Services\AuditService;
use Exception;

/**
 * ScoringService - Calificación Predictiva de Prospectos
 * empresaIMO - Arquitectura Fintech
 */
class ScoringService
{
    private GroqClient $client;

    public function __construct()
    {
        $this->client = new GroqClient();
    }

    /**
     * Califica un prospecto basado en sus metadatos (Scoring y Psicología).
     * Retorna un entero (0-100) y actualiza la base de datos con el scoring e insights.
     */
    public function qualify(int $leadId, array $data): int
    {
        try {
            // Skill: Marketing Psychology & Copywriting
            // Prompt Ingeniería Avanzada para LLaMA 3.1
            $system = [
                "Eres un Agente de Inteligencia Comercial Experto en IMOs (Seguros/Finanzas).",
                "Objetivo: Evaluar la viabilidad comercial y generar un Perfil Psicológico basado en los datos del prospecto.",
                "Instrucciones de Psicología de Ventas:",
                "1. Si busca 'Seguro de Vida' (Life), apela al 'Sesgo de Protección Familiar' y 'Aversión a la Pérdida'.",
                "2. Si es corporativo o busca 'Patrimonio' (Wealth), apela al 'Estatus' (Status Seeking) y Conservación de Riqueza.",
                "3. Escribe un Micro-Guion (script) altamente persuasivo y directo que el asesor pueda leer al llamar.",
                "Formato de respuesta OBLIGATORIO: Regresa ÚNICAMENTE un JSON válido con la siguiente estructura:",
                "{",
                "  \"score\": (int 0-100),",
                "  \"priority\": \"Standard\" | \"VIP\",",
                "  \"psychological_profile\": \"Breve caracterización psicológica\",",
                "  \"agent_script\": \"El guion exacto de 2 oraciones para abrir la llamada.\"",
                "}",
            ];

            $prompt = json_encode([
                'lead_name' => $data['name'] ?? 'Desconocido',
                'insurance_type' => $data['insurance_type'] ?? 'General',
                'submission_time' => $data['timestamp'] ?? date('H:i')
            ]);

            $response = $this->client->complete($prompt, $system);

            // Parseo robusto de la respuesta JSON del LLM
            preg_match('/\{.*\}/s', $response, $matches);
            $jsonResponse = json_decode($matches[0] ?? '{}', true);

            $score = (int)($jsonResponse['score'] ?? 50);
            $priority = $jsonResponse['priority'] ?? 'Standard';
            
            // Consolidar Insights
            $insights = json_encode([
                'profile' => $jsonResponse['psychological_profile'] ?? 'Perfil estándar.',
                'script'  => $jsonResponse['agent_script'] ?? 'Hola ' . ($data['name'] ?? '') . ', ¿podemos hablar sobre tu cobertura?'
            ]);

            // Actualización del Lead
            $this->updateLeadScoring($leadId, $score, $priority, $insights);

            // Auditoría HIPAA
            AuditService::log(null, 'AI_SCORING', 'leads', $leadId, "Scoring Generado: $score ($priority). Insights de Mktng Psicológico añadidos.");

            return $score;

        } catch (Exception $e) {
            error_log("[IMO][AI-Scoring] Failed for lead $leadId: " . $e->getMessage());
            return 0;
        }
    }

    private function updateLeadScoring(int $leadId, int $score, string $priority, string $insights): void
    {
        $pdo = Connection::getInstance();
        $stmt = $pdo->prepare("UPDATE leads SET score = :s, status = :st, ai_insights = :ai WHERE id = :id");
        
        $status = ($score >= 80) ? 'qualified' : 'new';
        
        $stmt->execute([
            's'  => $score,
            'st' => $status,
            'ai' => $insights,
            'id' => $leadId
        ]);
    }
}
