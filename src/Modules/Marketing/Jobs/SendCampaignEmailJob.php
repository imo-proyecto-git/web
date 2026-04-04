<?php

namespace IMO\Modules\Marketing\Jobs;

use IMO\Modules\Marketing\Services\MailerService;
use IMO\Core\Database\Connection;
use IMO\Modules\Audit\Services\AuditService;
use Exception;

/**
 * SendCampaignEmailJob — Handler del Worker para envío de un email masivo
 * Procesado por worker.php en segundo plano.
 *
 * Payload esperado:
 * {
 *   "campaign_id": <int>,
 *   "recipient_id": <int>,
 *   "email": "user@example.com",
 *   "name": "Juan Pérez",
 *   "subject": "Asunto del correo",
 *   "html_body": "<html>...</html>",
 *   "tracking_campaign_id": "CMP-XXXXXX"
 * }
 */
class SendCampaignEmailJob
{
    public static function handle(array $payload): bool
    {
        $pdo = Connection::getInstance();

        try {
            // Validar payload mínimo
            foreach (['campaign_id', 'recipient_id', 'email', 'subject', 'html_body'] as $key) {
                if (empty($payload[$key])) {
                    throw new Exception("Payload incompleto: falta '$key'");
                }
            }

            $campaignId  = (int)$payload['campaign_id'];
            $recipientId = (int)$payload['recipient_id'];
            $email       = $payload['email'];
            $name        = $payload['name'] ?? '';
            $subject     = $payload['subject'];
            $htmlBody    = $payload['html_body'];
            $trackId     = $payload['tracking_campaign_id'] ?? 'CMP-UNKNOWN';

            // Personalizar el cuerpo del correo
            $htmlBody = str_replace(['{{NAME}}', '{{EMAIL}}'], [$name, $email], $htmlBody);

            // Enviar via MailerService con tracking pixel
            $mailer  = new MailerService();
            $success = $mailer->sendWithTracking($email, $subject, $htmlBody, $trackId, $recipientId);

            // Actualizar estado del destinatario
            $newStatus = $success ? 'sent' : 'failed';
            $pdo->prepare("
                UPDATE campaign_recipients
                SET status = :status, sent_at = NOW()
                WHERE id = :id
            ")->execute(['status' => $newStatus, 'id' => $recipientId]);

            // Actualizar contador de la campaña
            if ($success) {
                $pdo->prepare("
                    UPDATE campaigns SET sent_count = sent_count + 1
                    WHERE id = :id
                ")->execute(['id' => $campaignId]);
            }

            return $success;

        } catch (Exception $e) {
            // Marcar destinatario como fallido
            if (!empty($recipientId)) {
                try {
                    $pdo->prepare("
                        UPDATE campaign_recipients SET status = 'failed'
                        WHERE id = :id
                    ")->execute(['id' => $recipientId]);
                } catch (\Throwable $t) { /* silenciar */ }
            }
            throw $e; // Re-lanzar para que el worker lo registre
        }
    }
}
