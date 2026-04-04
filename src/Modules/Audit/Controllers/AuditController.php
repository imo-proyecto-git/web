<?php

namespace IMO\Modules\Audit\Controllers;

use IMO\Core\Controller;
use IMO\Core\Database\Connection;
use IMO\Core\Security\Auth;
use Exception;

/**
 * AuditController - Gestión de Logs de Auditoría
 * empresaIMO - HIPAA Compliance
 */
class AuditController extends Controller
{
    /**
     * GET /manager/audit
     * Bitácora de Auditoría Completa.
     */
    public function index(): void
    {
        if (!Auth::check() || !in_array(Auth::user()['role_id'], [1, 2])) {
            header('Location: ' . config('app.url') . '/login');
            exit;
        }

        try {
            $pdo = Connection::getInstance();
            
            // Listado de auditoría enriquecido con el email del usuario
            $logs = $pdo->query("
                SELECT a.*, u.email as user_email 
                FROM audit_logs a 
                LEFT JOIN users u ON a.user_id = u.id 
                ORDER BY a.created_at DESC 
                LIMIT 100
            ")->fetchAll();

            $this->view('Audit/Views/index', [
                'logs' => $logs,
                'user' => Auth::user(),
                'stats' => [
                    'total_logs' => $pdo->query("SELECT COUNT(*) FROM audit_logs")->fetchColumn(),
                    'security_alerts' => 3, // Mock para el look de AdminBastion
                    'phi_exports' => $pdo->query("SELECT COUNT(*) FROM audit_logs WHERE action = 'EXPORT_PHI'")->fetchColumn(),
                ]
            ]);
        } catch (Exception $e) {
            die("Fallo en la carga de auditoría.");
        }
    }

    /**
     * GET /manager/audit/export
     * Descarga segura de Audit Logs en formato CSV (HIPAA Requirement).
     */
    public function exportCsv(): void
    {
        if (!Auth::check() || !in_array(Auth::user()['role_id'], [1, 2])) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }

        try {
            $pdo = Connection::getInstance();
            $stmt = $pdo->query("
                SELECT a.created_at, a.action, a.target_table, a.target_record_id, a.ip_address, u.email as user_email, a.details
                FROM audit_logs a 
                LEFT JOIN users u ON a.user_id = u.id 
                ORDER BY a.created_at DESC
            ");
            
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="IMO_Audit_Ledger_' . date('Y_m_d_His') . '.csv"');
            
            $output = fopen('php://output', 'w');
            fputcsv($output, ['TIMESTAMP', 'ACTION', 'TARGET_TABLE', 'RECORD_ID', 'IP_ADDRESS', 'USER_EMAIL', 'DETAILS']);
            
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $row['details'] = trim(preg_replace('/\s+/', ' ', $row['details'])); // Prevents CSV layout breaking
                fputcsv($output, $row);
            }
            
            fclose($output);
            
            // Audit Log para el Export
            \IMO\Modules\Audit\Services\AuditService::log(Auth::user()['id'], 'EXPORT_AUDIT', 'audit_logs', null, 'Exportó la bitácora completa en CSV (Cumplimiento Regulatorio).');

        } catch (Exception $e) {
            die("Error generando exportación.");
        }
    }
}
