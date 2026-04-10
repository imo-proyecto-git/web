<?php

namespace IMO\Modules\Marketing\Services;

use IMO\Config\AppConfig;
use IMO\Modules\Audit\Services\AuditService;
use IMO\Core\Database\Connection;
use Exception;

/**
 * MailerService - Servicio de Correo Electrónico (Mailgun / SendGrid)
 * Maneja entrega SMTP vía HTTP REST API para máxima velocidad en Campañas de Nutrición.
 */
class MailerService
{
    private string $provider;
    private string $apiKey;
    private string $domain;
    private string $fromAddress;
    private string $fromName;

    public function __construct()
    {
        $this->provider    = AppConfig::get('MAIL_PROVIDER', 'mailgun'); // 'mailgun' o 'sendgrid'
        $this->apiKey      = AppConfig::get('MAIL_API_KEY', '');
        $this->domain      = AppConfig::get('MAIL_DOMAIN', ''); 
        $this->fromAddress = AppConfig::get('MAIL_FROM_ADDRESS', 'no-reply@' . strtolower(str_replace(' ', '', config('app.company.name'))));
        $this->fromName    = AppConfig::get('MAIL_FROM_NAME', config('app.company.name'));
    }

    /**
     * Envía un correo con Tracking Pixel embebido para Retargeting.
     */
    public function sendWithTracking(string $to, string $subject, string $htmlBody, string $campaignId, int $leadId): bool
    {
        // Inject Tracking Pixel
        $trackingUrl = config('app.url') . "/api/v1/track/{$campaignId}/{$leadId}";
        $pixel = "<img src=\"{$trackingUrl}\" width=\"1\" height=\"1\" alt=\"\" style=\"display:none;\" />";
        $htmlBody = str_replace('</body>', $pixel . '</body>', $htmlBody);
        if (strpos($htmlBody, $pixel) === false) {
            $htmlBody .= $pixel; 
        }

        return $this->send($to, $subject, $htmlBody);
    }

    /**
     * Envío base usando la API del proveedor
     */
    public function send(string $to, string $subject, string $htmlBody): bool
    {
        if (AppConfig::get('MAIL_ENABLED', 'false') !== 'true') {
            error_log("[MailerService] Correo simulado a: $to Asunto: $subject");
            return true; // Simulación para entorno local si MAIL_ENABLED=false
        }

        try {
            if ($this->provider === 'sendgrid') {
                return $this->sendViaSendGrid($to, $subject, $htmlBody);
            } else {
                return $this->sendViaMailgun($to, $subject, $htmlBody);
            }
        } catch (Exception $e) {
            error_log("[MailerService] Fallo de envío: " . $e->getMessage());
            AuditService::log(null, 'MAIL_DELIVERY_FAILED', null, null, "Destino: $to - " . $e->getMessage());
            return false;
        }
    }

    private function sendViaMailgun(string $to, string $subject, string $htmlBody): bool
    {
        $baseUrl = config('services.mailgun.url', 'https://api.mailgun.net/v3/');
        $url = rtrim($baseUrl, '/') . "/{$this->domain}/messages";
        
        $postData = [
            'from'    => "{$this->fromName} <{$this->fromAddress}>",
            'to'      => $to,
            'subject' => $subject,
            'html'    => $htmlBody
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "api:{$this->apiKey}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return true;
        }
        
        throw new Exception("Mailgun API Error (HTTP $httpCode): $result");
    }

    private function sendViaSendGrid(string $to, string $subject, string $htmlBody): bool
    {
        $url = config('services.sendgrid.url', 'https://api.sendgrid.com/v3/mail/send');
        
        $payload = [
            "personalizations" => [[ "to" => [[ "email" => $to ]] ]],
            "from" => [ "email" => $this->fromAddress, "name" => $this->fromName ],
            "subject" => $subject,
            "content" => [[ "type" => "text/html", "value" => $htmlBody ]]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$this->apiKey}",
            "Content-Type: application/json"
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return true;
        }

        throw new Exception("SendGrid API Error (HTTP $httpCode): $result");
    }
}
