<?php

namespace IMO\Core\Infrastructure\Webhooks;

use Exception;

/**
 * WebhookService - Orquestador de Integraciones Externas
 * empresaIMO - Arquitectura Moderna / No Bloqueante
 */
class WebhookService
{
    /**
     * Envía datos del lead a HubSpot si está habilitado.
     */
    public static function sendToHubSpot(array $data): bool
    {
        if (!config('webhooks.hubsport.enabled', false)) return false;
        
        $url = config('webhooks.hubsport.url');
        return self::dispatch($url, $data);
    }

    /**
     * Envía datos a Monday.com si está habilitado.
     */
    public static function sendToMonday(array $data): bool
    {
        if (!config('webhooks.monday.enabled', false)) return false;
        
        $url = config('webhooks.monday.url');
        return self::dispatch($url, $data);
    }

    /**
     * Dispatcher genérico vía cURL.
     */
    private static function dispatch(string $url, array $payload): bool
    {
        if (empty($url)) return false;

        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_TIMEOUT, config('webhooks.timeout', 5));
            
            $res = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return ($code >= 200 && $code < 300);
        } catch (Exception $e) {
            error_log("[IMO][Webhook] Error al enviar a $url: " . $e->getMessage());
            return false;
        }
    }
}
