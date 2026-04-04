<?php

namespace IMO\Modules\Marketing\Controllers;

use IMO\Core\Controller;
use IMO\Core\Security\Auth;
use IMO\Core\Database\Connection;
use IMO\Core\Infrastructure\QueueService;
use IMO\Modules\Marketing\Jobs\SendCampaignEmailJob;
use IMO\Modules\Audit\Services\AuditService;
use Exception;

/**
 * CampaignController - Gestión de Campañas Azure Shield
 * empresaIMO — Con Queue Real, Mail Builder, y Analytics
 */
class CampaignController extends Controller
{
    /**
     * GET /manager/marketing/campaigns/create
     * Interfaz de creación con Drag&Drop Mail Builder integrado.
     */
    public function create(): void
    {
        if (!Auth::check() || !in_array(Auth::user()['role_id'], [1, 2])) {
            header('Location: ' . config('app.url') . '/login');
            exit;
        }

        $this->view('Marketing/Views/create', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * GET /manager/marketing/campaigns/analytics
     * Dashboard de métricas y heatmap de campaña.
     */
    public function analytics(): void
    {
        if (!Auth::check() || !in_array(Auth::user()['role_id'], [1, 2])) {
            header('Location: ' . config('app.url') . '/login');
            exit;
        }

        try {
            $pdo = Connection::getInstance();

            // Estadísticas de la cola en tiempo real
            $queueStats = QueueService::stats();

            // Últimas campañas
            $stmt = $pdo->prepare("
                SELECT c.*, u.email as created_by_email
                FROM campaigns c
                LEFT JOIN users u ON c.created_by = u.id
                ORDER BY c.created_at DESC
                LIMIT 10
            ");
            $stmt->execute();
            $campaigns = $stmt->fetchAll();

            $this->view('Marketing/Views/analytics', [
                'user'       => Auth::user(),
                'campaigns'  => $campaigns,
                'queueStats' => $queueStats,
            ]);

        } catch (Exception $e) {
            error_log("[IMO][Marketing] analytics error: " . $e->getMessage());
            // Fallback a datos vacíos
            $this->view('Marketing/Views/analytics', [
                'user'       => Auth::user(),
                'campaigns'  => [],
                'queueStats' => [],
            ]);
        }
    }

    /**
     * POST /api/v1/marketing/campaigns
     * Persiste la campaña en DB y encola los emails masivos en background.
     * La respuesta HTTP se devuelve INMEDIATAMENTE sin esperar el envío.
     */
    public function store(): void
    {
        header('Content-Type: application/json');

        if (!Auth::check() || !in_array(Auth::user()['role_id'], [1, 2])) {
            http_response_code(403);
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }

        try {
            $pdo = Connection::getInstance();

            // ── Validar datos básicos
            $name    = trim(strip_tags($_POST['campaign_name'] ?? ''));
            $subject = trim(strip_tags($_POST['campaign_subject'] ?? "Campaña de $name"));
            $htmlBody = $_POST['html_body'] ?? ''; // Viene del Mail Builder

            if (empty($name)) {
                echo json_encode(['status' => 'error', 'message' => 'La campaña requiere un nombre.']);
                return;
            }

            if (empty($htmlBody)) {
                echo json_encode(['status' => 'error', 'message' => 'El cuerpo del correo no puede estar vacío. Usa el Mail Builder.']);
                return;
            }

            // ── Parsear lista de destinatarios (CSV o JSON upload)
            $recipients = [];

            if (!empty($_FILES['recipient_list']['tmp_name'])) {
                $ext      = strtolower(pathinfo($_FILES['recipient_list']['name'], PATHINFO_EXTENSION));
                $content  = file_get_contents($_FILES['recipient_list']['tmp_name']);

                if ($ext === 'csv') {
                    $rows = array_map('str_getcsv', array_filter(explode("\n", $content)));
                    $headers = array_map('strtolower', array_map('trim', array_shift($rows) ?? []));
                    $emailCol = array_search('email', $headers);
                    $nameCol  = array_search('name', $headers);
                    if ($emailCol === false) $emailCol = 0;
                    foreach ($rows as $row) {
                        $email = filter_var(trim($row[$emailCol] ?? ''), FILTER_VALIDATE_EMAIL);
                        if ($email) {
                            $recipients[] = [
                                'email' => $email,
                                'name'  => trim($row[$nameCol] ?? '') ?: '',
                            ];
                        }
                    }
                } elseif ($ext === 'json') {
                    $data = json_decode($content, true);
                    foreach ((array)$data as $item) {
                        $email = filter_var(trim($item['email'] ?? ''), FILTER_VALIDATE_EMAIL);
                        if ($email) {
                            $recipients[] = [
                                'email' => $email,
                                'name'  => $item['name'] ?? '',
                            ];
                        }
                    }
                }
            }

            // Fallback: usar leads de la DB como destinatarios de prueba
            if (empty($recipients)) {
                $leads = $pdo->query("SELECT encrypted_payload FROM leads LIMIT 100")->fetchAll();
                // En producción, desencriptar. Por ahora, modo demo:
                $recipients = [
                    ['email' => 'demo@empresaimo.com', 'name' => 'Demo Lead'],
                ];
            }

            if (empty($recipients)) {
                echo json_encode(['status' => 'error', 'message' => 'No hay destinatarios válidos.']);
                return;
            }

            // ── Generar UUID (Fallback robusto sin dependencia externa)
            $data = random_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // v4
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant
            $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

            $campaignId = $this->insertCampaign($pdo, $uuid, $name, $subject, $htmlBody, count($recipients));

            // ── Encolar cada email en background (LIBERA LA UI INMEDIATAMENTE)
            $jobIds = [];
            foreach ($recipients as $recipient) {
                $recipientId = $this->insertRecipient($pdo, $campaignId, $recipient);

                $jobId = QueueService::dispatch(
                    QueueService::QUEUE_EMAILS,
                    SendCampaignEmailJob::class,
                    [
                        'campaign_id'          => $campaignId,
                        'recipient_id'         => $recipientId,
                        'email'                => $recipient['email'],
                        'name'                 => $recipient['name'],
                        'subject'              => $subject,
                        'html_body'            => $htmlBody,
                        'tracking_campaign_id' => $uuid,
                    ]
                );

                // Vincular job al destinatario
                $pdo->prepare("UPDATE campaign_recipients SET job_id = :jid WHERE id = :id")
                    ->execute(['jid' => $jobId, 'id' => $recipientId]);

                $jobIds[] = $jobId;
            }

            // Marcar campaña como encolada
            $pdo->prepare("UPDATE campaigns SET status = 'queued' WHERE id = :id")
                ->execute(['id' => $campaignId]);

            AuditService::log(
                Auth::user()['id'],
                'CAMPAIGN_QUEUED',
                'campaigns',
                $campaignId,
                "Campaña '$name' encolada con " . count($recipients) . " destinatarios. UUID: $uuid"
            );

            echo json_encode([
                'status'          => 'success',
                'message'         => '✅ Campaña encolada exitosamente. El envío masivo se procesa en segundo plano.',
                'campaign_id'     => $uuid,
                'campaign_db_id'  => $campaignId,
                'recipient_count' => count($recipients),
                'jobs_queued'     => count($jobIds),
                'status_url'      => config('app.url') . "/api/v1/marketing/campaigns/$campaignId/status",
            ]);

        } catch (Exception $e) {
            error_log("[IMO][Marketing] store error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Error de servidor interno: ' . $e->getMessage()]);
        }
    }

    /**
     * GET /api/v1/marketing/campaigns/{id}/status
     * Retorna estado en tiempo real del progreso de una campaña (SSE/polling).
     */
    public function queueStatus(int $id): void
    {
        header('Content-Type: application/json');

        if (!Auth::check()) {
            http_response_code(403);
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }

        try {
            $pdo  = Connection::getInstance();
            $stmt = $pdo->prepare("
                SELECT c.*,
                    SUM(CASE WHEN cr.status = 'sent'   THEN 1 ELSE 0 END) as sent_count,
                    SUM(CASE WHEN cr.status = 'failed' THEN 1 ELSE 0 END) as failed_count,
                    SUM(CASE WHEN cr.status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                    SUM(CASE WHEN cr.status = 'opened' THEN 1 ELSE 0 END) as opened_count
                FROM campaigns c
                LEFT JOIN campaign_recipients cr ON c.id = cr.campaign_id
                WHERE c.id = :id
                GROUP BY c.id
            ");
            $stmt->execute(['id' => $id]);
            $campaign = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$campaign) {
                $this->json(['status' => 'error', 'message' => 'Campaña no encontrada.'], 404);
                return;
            }

            $total     = (int)$campaign['recipient_count'];
            $sent      = (int)$campaign['sent_count'];
            $progress  = $total > 0 ? round(($sent / $total) * 100, 1) : 0;

            echo json_encode([
                'status'          => 'success',
                'campaign_id'     => $id,
                'campaign_status' => $campaign['status'],
                'progress'        => $progress,
                'total'           => $total,
                'sent'            => $sent,
                'failed'          => (int)$campaign['failed_count'],
                'pending'         => (int)$campaign['pending_count'],
                'opened'          => (int)$campaign['opened_count'],
                'queue_stats'     => QueueService::stats(),
            ]);

        } catch (Exception $e) {
            $this->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * GET /api/v1/track/{campaign_id}/{lead_id}
     * Tracking Pixel Endpoint para Heatmaps y Retargeting.
     */
    public function trackOpen(string $campaignId, int $leadId): void
    {
        try {
            AuditService::log(null, 'EMAIL_OPENED', 'leads', $leadId, "Pixel cargado - Campaña: $campaignId");

            // Actualizar estado del destinatario
            $pdo = Connection::getInstance();
            $pdo->prepare("
                UPDATE campaign_recipients
                SET status = 'opened', opened_at = NOW()
                WHERE job_id IN (
                    SELECT id FROM job_queue
                    WHERE JSON_EXTRACT(payload, '$.payload.tracking_campaign_id') = :cid
                      AND JSON_EXTRACT(payload, '$.payload.recipient_id') = :lid
                    LIMIT 1
                )
            ")->execute(['cid' => $campaignId, 'lid' => $leadId]);

        } catch (Exception $e) {
            error_log("[IMO][Tracking] " . $e->getMessage());
        }

        // Retorna un pixel transparente 1x1 GIF
        header('Content-Type: image/gif');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        echo base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw==');
        exit;
    }

    // ── Helpers Privados ────────────────────────────────────────────────────

    private function insertCampaign(\PDO $pdo, string $uuid, string $name, string $subject, string $htmlBody, int $count): int
    {
        $stmt = $pdo->prepare("
            INSERT INTO campaigns (uuid, name, subject, html_body, recipient_count, created_by, status)
            VALUES (:uuid, :name, :subject, :html_body, :count, :created_by, 'draft')
        ");
        $stmt->execute([
            'uuid'       => $uuid,
            'name'       => $name,
            'subject'    => $subject,
            'html_body'  => $htmlBody,
            'count'      => $count,
            'created_by' => Auth::user()['id'],
        ]);
        return (int)$pdo->lastInsertId();
    }

    private function insertRecipient(\PDO $pdo, int $campaignId, array $recipient): int
    {
        $stmt = $pdo->prepare("
            INSERT INTO campaign_recipients (campaign_id, email, name)
            VALUES (:cid, :email, :name)
        ");
        $stmt->execute([
            'cid'   => $campaignId,
            'email' => $recipient['email'],
            'name'  => $recipient['name'],
        ]);
        return (int)$pdo->lastInsertId();
    }
}
