<?php

namespace IMO\Modules\Leads\Services;

use IMO\Core\Database\Connection;
use IMO\Modules\GAI\Services\GroqClient;
use IMO\Core\Security\Encrypter;
use Exception;

/**
 * ScoringService - Motor Inteligente de Calificación de Leads
 * empresaIMO - AI Integration
 */
class ScoringService
{
    private GroqClient $ai;

    public function __construct()
    {
        $this->ai = new GroqClient();
    }

    /**
     * Analiza un lead específico usando I.A. (LLaMA 3.1)
     * 
     * @param int $leadId El ID del lead a procesar
     */
    public function analyze(int $leadId): array
    {
        try {
            $pdo = Connection::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM leads WHERE id = :id");
            $stmt->execute(['id' => $leadId]);
            $lead = $stmt->fetch();

            if (!$lead) throw new Exception("Lead no encontrado.");

            // 1. Obtener PII de forma segura para la I.A.
            $pii = json_decode(Encrypter::decrypt($lead['encrypted_payload']), true);
            
            // 2. Preparar el Prompt del Sistema
            $systemPrompt = [
                "Eres un asistente experto en calificación de leads para una empresa de seguros (IMO).",
                "Determina la intención de compra y asigna un puntaje del 0 al 100.",
                "Basado en: Nombre, Correo, Teléfono y Tipo de Seguro solicitado.",
                "Regresa el resultado SIEMPRE en formato JSON puro: { \"score\": int, \"intent\": string, \"reason\": string }"
            ];

            // 3. Prompt de Usuario
            $userPrompt = "Analiza este prospecto:\n";
            $userPrompt .= "Nombre: " . $pii['name'] . "\n";
            $userPrompt .= "Email: " . $pii['email'] . "\n";
            $userPrompt .= "Seguro: " . $lead['insurance_type'] . "\n";

            // 4. Llamada a la I.A. (GAI)
            $aiResponse = $this->ai->complete($userPrompt, $systemPrompt);
            $analysis = json_decode($aiResponse, true);

            if (!$analysis || !isset($analysis['score'])) {
                throw new Exception("La I.A. retornó un formato no válido.");
            }

            // 5. Persistir el score
            $update = $pdo->prepare("UPDATE leads SET score = :s, status = :st WHERE id = :id");
            $threshold = config('ai.scoring.qualified_threshold', 70);
            $status = ($analysis['score'] >= $threshold) ? 'qualified' : 'contacted';
            $update->execute(['s' => $analysis['score'], 'st' => $status, 'id' => $leadId]);

            return $analysis;

        } catch (Exception $e) {
            error_log("[IMO][Scoring] Falló el análisis del lead $leadId: " . $e->getMessage());
            return ['score' => 0, 'error' => $e->getMessage()];
        }
    }
}
