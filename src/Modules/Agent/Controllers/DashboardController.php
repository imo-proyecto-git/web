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
            $user = Auth::user();
            
            // Unificación de Roles: Si es Manager/Superadmin ve todo, si es agente solo sus asignados o los libres.
            $whereClause = ($user['role'] === 'agent') ? "WHERE assigned_user_id IS NULL OR assigned_user_id = :uid" : "WHERE 1=1";
            
            $stmt = $pdo->prepare("SELECT * FROM leads $whereClause ORDER BY score DESC, created_at DESC LIMIT 50");
            if ($user['role'] === 'agent') {
                $stmt->execute(['uid' => $user['id']]);
            } else {
                $stmt->execute();
            }
            $leads = $stmt->fetchAll();

            $processedLeads = [];
            $topLeads = [];
            $pipelineValue = 0;

            foreach ($leads as $lead) {
                try {
                    $pii = json_decode(Encrypter::decrypt($lead['encrypted_payload']), true);
                    $lead['name']  = $pii['name'] ?? 'N/A';
                    $lead['email'] = $this->maskEmail($pii['email'] ?? '');
                    $lead['phone'] = $this->maskPhone($pii['phone'] ?? '');
                } catch (Exception $e) {
                    $lead['name'] = '[DATA_CORRUPT_HIPAA]';
                    $lead['email'] = '***';
                }

                $ai = json_decode($lead['ai_insights'] ?? '{}', true);
                $lead['profile'] = $ai['profile'] ?? 'Sin perfil.';

                // Calcular Pipeline Simulado (Gamificación)
                $premium = ($lead['insurance_type'] === 'wealth') ? 5000 : 1200;
                $pipelineValue += ($premium * ((int)$lead['score'] / 100));

                if ((int)$lead['score'] >= 80 && count($topLeads) < 2) {
                    $topLeads[] = $lead;
                }

                $processedLeads[] = $lead;
            }

            // Auditoría de Visualización
            AuditService::log($user['id'], 'VIEW_CRM', 'leads', null, 'Listado Operativo CRM / Pipeline.');

            $this->view('Agent/Views/dashboard', [
                'leads' => $processedLeads,
                'user'  => $user,
                'stats' => $this->calculateStats($processedLeads, $pipelineValue),
                'topLeads' => $topLeads
            ]);

        } catch (Exception $e) {
            error_log("[IMO][Dashboard] Error: " . $e->getMessage());
            $this->view('Landing/Views/404');
        }
    }

    private function maskEmail(string $email): string
    {
        if (!$email) return 'N/A';
        $parts = explode('@', $email);
        if (count($parts) < 2) return '***';
        return substr($parts[0], 0, 1) . str_repeat('*', max(0, strlen($parts[0]) - 1)) . '@' . $parts[1];
    }

    private function maskPhone(string $phone): string
    {
        if (!$phone) return 'N/A';
        return str_repeat('*', max(0, strlen($phone) - 4)) . substr($phone, -4);
    }

    /**
     * GET /agent/incomes
     * Visualización de Comisiones y Rendimiento Financiero.
     */
    public function incomes(): void
    {
        if (!Auth::check()) {
            header('Location: ' . config('app.url') . '/login');
            exit;
        }

        try {
            $pdo  = Connection::getInstance();
            $user = Auth::user();

            // Solo traer leads convertidos para este agente
            $stmt = $pdo->prepare("SELECT * FROM leads WHERE status = 'converted' AND assigned_user_id = :uid");
            $stmt->execute(['uid' => $user['id']]);
            $closedLeads = $stmt->fetchAll();

            $totalEarnings = 0;
            $commissions = [];

            foreach ($closedLeads as $lead) {
                try {
                    $pii = json_decode(Encrypter::decrypt($lead['encrypted_payload']), true);
                    $name = $pii['name'] ?? 'Cliente Protegido';
                } catch (Exception $e) {
                    $name = 'HIPAA Masked';
                }

                // Cálculo de comisión simulado (B.T.I.D. model)
                $premium = ($lead['insurance_type'] === 'wealth') ? 5000 : 1200;
                $commissionRate = 0.20; // 20% flat fee for the example
                $earned = $premium * $commissionRate;
                $totalEarnings += $earned;

                $commissions[] = [
                    'client' => $name,
                    'type'   => strtoupper($lead['insurance_type']),
                    'date'   => $lead['updated_at'],
                    'premium'=> $premium,
                    'earned' => $earned
                ];
            }

            $this->view('Agent/Views/incomes', [
                'user'          => $user,
                'totalEarnings' => $totalEarnings,
                'commissions'   => $commissions,
                'stats'         => [
                    'active_pipeline' => 45000, // Hardcoded for demo
                    'last_month'      => 8200
                ]
            ]);

        } catch (Exception $e) {
            $this->view('Landing/Views/404');
        }
    }

    private function calculateStats(array $leads, float $pipelineValue): array
    {
        $converted = count(array_filter($leads, fn($l) => $l['status'] === 'converted'));
        $total = max(count($leads), 1);
        $conversionRate = ($converted / $total) * 100;

        return [
            'total'          => count($leads),
            'new'            => count(array_filter($leads, fn($l) => $l['status'] === 'new')),
            'qualified'      => count(array_filter($leads, fn($l) => $l['status'] === 'qualified')),
            'conversionRate' => round($conversionRate, 1),
            'pipelineValue'  => $pipelineValue,
            'speed'          => '< 120s'
        ];
    }
}
