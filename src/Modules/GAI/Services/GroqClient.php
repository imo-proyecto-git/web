<?php

namespace IMO\Modules\GAI\Services;

use Exception;

/**
 * GroqClient - Integración con LLaMA 3.1 para Lead Scoring
 * empresaIMO
 */
class GroqClient
{
    private string $apiKey;
    private string $model;
    private string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('ai.api_key') ?: env('AI_API_KEY');
        $this->model  = config('ai.model', 'llama-3.1-8b-instant');
        $this->apiUrl = config('services.groq.url', 'https://api.groq.com/openai/v1/chat/completions');
    }

    /**
     * Envía un prompt a Groq y retorna el contenido de la respuesta.
     */
    public function complete(string $prompt, array $system = []): string
    {
        if (empty($this->apiKey)) {
            throw new Exception("Configuración de IA incompleta: Falta AI_API_KEY.");
        }

        $messages = [];
        if (!empty($system)) {
            $messages[] = ['role' => 'system', 'content' => implode("\n", $system)];
        }
        $messages[] = ['role' => 'user', 'content' => $prompt];

        $payload = [
            'model' => $this->model,
            'messages' => $messages,
            'temperature' => 0.2, // Baja temperatura para scoring determinista
            'max_tokens' => 300,
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || !$response) {
            error_log("[IMO][AI] Groq API fail (HTTP $httpCode): " . $response);
            throw new Exception("Fallo en la comunicación con el motor de IA.");
        }

        $result = json_decode($response, true);
        return $result['choices'][0]['message']['content'] ?? '';
    }
}
