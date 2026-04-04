<?php

namespace IMO\Modules\Leads\Controllers;

use IMO\Core\Controller;
use IMO\Core\Database\Connection;
use IMO\Core\Security\Encrypter;
use IMO\Modules\Audit\Services\AuditService;
use IMO\Core\Security\Auth;
use Exception;
use PDO;

/**
 * LeadController - Captura Segura de Prospectos
 * empresaIMO - Arquitectura Clean (HIPAA Ready)
 */
class LeadController extends Controller
{
    /**
     * Endpoint API: POST /api/v1/leads
     * Captura el lead desde la landing page, sanitiza y encripta PII.
     */
    public function store(): void
    {
        // 1. Sanitización de Inputs
        $fields = [
            'full_name'    => trim(strip_tags($_POST['full_name'] ?? '')),
            'email'        => filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL),
            'phone'        => trim(strip_tags($_POST['phone'] ?? '')),
            'service_type' => trim(strip_tags($_POST['service_type'] ?? 'unknown')),
        ];

        // 2. Validación de campos obligatorios
        if (empty($fields['full_name']) || empty($fields['email']) || !$fields['email']) {
            $this->json(['status' => 'error', 'message' => __('Favor completar todos los campos correctamente.')], 400);
        }

        try {
            $pdo = Connection::getInstance();

            // 3. Preparación de PII (Datos Sensibles Encapsulados)
            $piiData = json_encode([
                'name'  => $fields['full_name'],
                'email' => $fields['email'],
                'phone' => $fields['phone'],
                'captured_at' => date('Y-m-d H:i:s'),
                'origin' => 'Landing Page Principal'
            ]);

            // 4. Encriptación Grado HIPAA (AES-256-GCM)
            $encryptedPayload = Encrypter::encrypt($piiData);

            // 5. Inserción Segura
            $uuid = $this->generateUuid();
            $stmt = $pdo->prepare("
                INSERT INTO leads (uuid, encrypted_payload, insurance_type, origin_ip, status) 
                VALUES (:u, :p, :ins, :ip, 'new')
            ");
            
            $stmt->execute([
                'u'   => $uuid,
                'p'   => $encryptedPayload,
                'ins' => $fields['service_type'],
                'ip'  => $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN'
            ]);

            // 6. Auditoría HIPAA
            AuditService::log(null, 'CAPTURE_LEAD', 'leads', (int)$pdo->lastInsertId(), 'Conversión exitosa desde Landing Page.');

            // 7. Motor de Scoring IA (Asíncrono simulado en Monolito)
            $scoring = new \IMO\Modules\GAI\Services\ScoringService();
            $scoring->qualify((int)$pdo->lastInsertId(), [
                'name' => $fields['full_name'],
                'email' => $fields['email'],
                'phone' => $fields['phone'],
                'insurance_type' => $fields['service_type'],
                'timestamp' => date('H:i')
            ]);

            // 8. Respuesta de Éxito
            $this->json([
                'status' => 'success', 
                'message' => __('Información recibida. Un asesor te contactará pronto.'),
                'ref' => substr($uuid, 0, 8)
            ]);

        } catch (Exception $e) {
            error_log("[IMO][LeadCapture] Error: " . $e->getMessage());
            
            $this->json([
                'status' => 'error', 
                'message' => config('app.env') === 'local' ? $e->getMessage() : __('Error al procesar la solicitud.')
            ], 500);
        }
    }

    /**
     * Vista de Detalle: GET /agent/leads/{uuid}
     * Realiza un Drill-down profundo con Auditoría HIPAA y Cálculo de Comisiones.
     */
    public function show(string $uuid): void
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }

        try {
            $pdo = Connection::getInstance();
            
            // 1. Buscar el lead por UUID
            $stmt = $pdo->prepare("SELECT * FROM leads WHERE uuid = :u LIMIT 1");
            $stmt->execute(['u' => $uuid]);
            $lead = $stmt->fetch();

            if (!$lead) {
                http_response_code(404);
                $this->view('Landing/Views/404');
                return;
            }

            // 2. Registro de Acceso a PHI (HIPAA Audit)
            AuditService::log(
                Auth::user()['id'], 
                'VIEW_PHI', 
                'leads', 
                (int)$lead['id'], 
                'Acceso detallado a datos sensibles del prospecto.'
            );

            // 3. Desencriptación y Proceso de PHI
            $phi = json_decode(Encrypter::decrypt($lead['encrypted_payload']), true);

            // 4. Calculadora de Comisiones Modular
            $commissions = \IMO\Modules\Agent\Services\CommissionService::calculate(
                $lead['insurance_type'], 
                config('commissions.simulated_premium_base', 1200.00), 
                (int)$lead['score']
            );

            // 5. Trazabilidad de Auditoría para este registro
            $logs = AuditService::getLogsForRecord('leads', (int)$lead['id']);

            // 6. Renderizado
            $this->view('Leads/Views/details', [
                'lead'        => $lead,
                'phi'         => $phi,
                'commissions' => $commissions,
                'logs'        => $logs
            ]);

        } catch (Exception $e) {
            error_log("[IMO][LeadDetails] Error: " . $e->getMessage());
            $this->redirect('/agent/dashboard');
        }
    }

    /**
     * Generación de Reporte PII-Secure (Print-ready)
     */
    public function report(string $uuid): void
    {
        if (!Auth::check()) { $this->redirect('/login'); }

        try {
            $pdo = Connection::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM leads WHERE uuid = :u LIMIT 1");
            $stmt->execute(['u' => $uuid]);
            $lead = $stmt->fetch();

            if (!$lead) { http_response_code(404); return; }

            // Auditoría de Exportación HIPAA
            AuditService::log(Auth::user()['id'], 'EXPORT_PHI', 'leads', (int)$lead['id'], 'Generación de reporte PII-Secure para impresión.');

            $phi = json_decode(Encrypter::decrypt($lead['encrypted_payload']), true);
            $commissions = \IMO\Modules\Agent\Services\CommissionService::calculate(
                $lead['insurance_type'], 
                config('commissions.simulated_premium_base', 1200.00), 
                (int)$lead['score']
            );

            $this->view('Leads/Views/print', [
                'lead' => $lead,
                'phi'  => $phi,
                'commissions' => $commissions
            ]);

        } catch (Exception $e) { $this->redirect('/agent/dashboard'); }
    }

    /**
     * Actualizar Estado del Lead: POST /agent/leads/{uuid}/status
     */
    public function updateStatus(string $uuid): void
    {
        if (!Auth::check()) { $this->json(['status' => 'error', 'message' => 'No autorizado'], 401); return; }

        $status = trim(strip_tags($_POST['status'] ?? ''));
        $allowed = ['new', 'contacted', 'qualified', 'converted', 'rejected'];

        if (!in_array($status, $allowed)) {
            $this->json(['status' => 'error', 'message' => 'Estado no válido'], 400); return;
        }

        try {
            $pdo = Connection::getInstance();
            
            // Buscar lead para el audit
            $stmt = $pdo->prepare("SELECT id FROM leads WHERE uuid = :u LIMIT 1");
            $stmt->execute(['u' => $uuid]);
            $lead = $stmt->fetch();

            if (!$lead) { $this->json(['status' => 'error', 'message' => 'Lead no encontrado'], 404); return; }

            // Actualización
            $update = $pdo->prepare("UPDATE leads SET status = :s WHERE uuid = :u");
            $update->execute(['s' => $status, 'u' => $uuid]);

            // Auditoría HIPAA
            AuditService::log(
                Auth::user()['id'], 
                'UPDATE_STATUS', 
                'leads', 
                (int)$lead['id'], 
                "Estado del prospecto cambiado a: " . strtoupper($status)
            );

            $this->json(['status' => 'success', 'message' => 'Estado del prospecto actualizado.']);

        } catch (Exception $e) { $this->json(['status' => 'error', 'message' => $e->getMessage()], 500); }
    }

    /**
     * Sincronización de Leads Offline: POST /api/v1/sync/offline
     */
    public function syncOffline(): void
    {
        header('Content-Type: application/json');
        
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        
        if (empty($data['batch']) || !is_array($data['batch'])) {
            $this->json(['status' => 'error', 'message' => 'Lote vacío o inválido.'], 400);
            return;
        }

        try {
            $pdo = Connection::getInstance();
            $pdo->beginTransaction();
            
            $scoring = new \IMO\Modules\GAI\Services\ScoringService();
            $processed = 0;

            foreach ($data['batch'] as $leadData) {
                // Sanitización 
                $fields = [
                    'full_name'    => trim(strip_tags($leadData['full_name'] ?? '')),
                    'email'        => filter_var($leadData['email'] ?? '', FILTER_VALIDATE_EMAIL),
                    'phone'        => trim(strip_tags($leadData['phone'] ?? '')),
                    'service_type' => trim(strip_tags($leadData['service_type'] ?? 'unknown')),
                ];
                
                if (empty($fields['full_name']) || empty($fields['email'])) continue;

                $piiData = json_encode([
                    'name'  => $fields['full_name'],
                    'email' => $fields['email'],
                    'phone' => $fields['phone'],
                    'captured_at' => $leadData['timestamp'] ?? date('Y-m-d H:i:s'),
                    'origin' => 'Landing Page (Offline Sync)'
                ]);

                $encryptedPayload = Encrypter::encrypt($piiData);
                $uuid = $this->generateUuid();

                $stmt = $pdo->prepare("
                    INSERT INTO leads (uuid, encrypted_payload, insurance_type, origin_ip, status) 
                    VALUES (:u, :p, :ins, :ip, 'new')
                ");
                
                $stmt->execute([
                    'u'   => $uuid,
                    'p'   => $encryptedPayload,
                    'ins' => $fields['service_type'],
                    'ip'  => $_SERVER['REMOTE_ADDR'] ?? 'OFFLINE'
                ]);

                $leadId = (int)$pdo->lastInsertId();
                AuditService::log(null, 'CAPTURE_LEAD', 'leads', $leadId, 'Sincronización Offline (Resiliencia).');

                // Autonomía IAM (Scoring)
                $scoring->qualify($leadId, [
                    'name' => $fields['full_name'],
                    'email' => $fields['email'],
                    'phone' => $fields['phone'],
                    'insurance_type' => $fields['service_type']
                ]);
                
                $processed++;
            }

            $pdo->commit();
            $this->json(['status' => 'success', 'message' => "Sincronizados $processed leads exitosamente."]);

        } catch (Exception $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("[IMO][SyncOffline] Error: " . $e->getMessage());
            $this->json(['status' => 'error', 'message' => 'Fallo en la sincronización del lote.'], 500);
        }
    }

    private function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    private function redirect(string $path): void
    {
        header('Location: ' . config('app.url') . $path);
        exit;
    }
}
