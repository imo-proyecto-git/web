<?php

namespace IMO\Modules\Agent\Controllers;

use IMO\Core\Controller;
use IMO\Core\Security\Auth;
use IMO\Core\Database\Connection;
use IMO\Core\Security\Encrypter;
use IMO\Modules\Audit\Services\AuditService;
use Exception;

/**
 * DashboardController - Panel de Gestión de Agentes
 * empresaIMO
 */
class DashboardController extends Controller
{
    /**
     * GET /agent/dashboard
     * Muestra métricas y el listado de leads (PII-Masked para cumplimiento HIPAA).
     */
    public function index(): void
    {
        if (!Auth::check()) {
            header('Location: ' . config('app.url') . '/login');
            exit;
        }

        try {
            $pdo = Connection::getInstance();
            
            // 1. Obtener leads con orden cronológico
            $stmt = $pdo->query("SELECT * FROM leads ORDER BY created_at DESC LIMIT 50");
            $leads = $stmt->fetchAll();

            $processedLeads = [];
            foreach ($leads as $lead) {
                try {
                    $pii = json_decode(Encrypter::decrypt($lead['encrypted_payload']), true);
                    
                    // HIPAA Masking: Solo mostrar lo necesario en el listado
                    $lead['name']  = $pii['name'] ?? 'N/A';
                    $lead['email'] = $this->maskEmail($pii['email'] ?? '');
                    $lead['phone'] = $this->maskPhone($pii['phone'] ?? '');
                    
                } catch (Exception $e) {
                    $lead['name'] = '[DATA_CORRUPT_HIPAA_ALERT]';
                }
                $processedLeads[] = $lead;
            }

            // 2. Auditoría de Visualización
            AuditService::log(
                Auth::user()['id'], 
                'VIEW_DASHBOARD', 
                'leads', 
                null, 
                'Visualización de listado de leads con máscara de PII.'
            );

            // 3. Renderizar vista con datos procesados
            $this->view('Agent/Views/dashboard', [
                'leads' => $processedLeads,
                'user'  => Auth::user(),
                'stats' => $this->calculateStats($processedLeads)
            ]);

        } catch (Exception $e) {
            error_log("[IMO][Dashboard] Error: " . $e->getMessage());
            $this->view('Landing/Views/404'); // Fallback a 404/Error
        }
    }

    /**
     * Enmascara el email: j***@empresa.com
     */
    private function maskEmail(string $email): string
    {
        if (!$email) return 'N/A';
        $parts = explode('@', $email);
        if (count($parts) < 2) return '***';
        return substr($parts[0], 0, 1) . str_repeat('*', max(0, strlen($parts[0]) - 1)) . '@' . $parts[1];
    }

    /**
     * Enmascara el teléfono: ****-5555
     */
    private function maskPhone(string $phone): string
    {
        if (!$phone) return 'N/A';
        return str_repeat('*', max(0, strlen($phone) - 4)) . substr($phone, -4);
    }

    /**
     * Genera métricas rápidas para el dashboard (simulado).
     */
    private function calculateStats(array $leads): array
    {
        return [
            'total'     => count($leads),
            'new'       => count(array_filter($leads, fn($l) => $l['status'] === 'new')),
            'qualified' => count(array_filter($leads, fn($l) => $l['status'] === 'qualified')),
            'speed'     => '< 120s' // Placeholder métrica COPC
        ];
    }
}
