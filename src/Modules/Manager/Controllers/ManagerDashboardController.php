<?php

namespace IMO\Modules\Manager\Controllers;

use IMO\Core\Controller;
use IMO\Core\Database\Connection;
use IMO\Core\Security\Auth;
use Exception;
use PDO;

/**
 * ManagerDashboardController - Vista Global de Supervisión
 * empresaIMO - Arquitectura Clean
 */
class ManagerDashboardController extends Controller
{
    /**
     * GET /manager/dashboard
     * Dashboard ejecutivo con KPIs y Auditoría.
     */
    public function index(): void
    {
        // 1. Autorización (Solo Manager o SuperAdmin)
        if (!Auth::check() || (!Auth::hasRole('superadmin') && !Auth::hasRole('manager'))) {
            header('Location: ' . config('app.url') . '/login');
            exit;
        }

        try {
            $pdo = Connection::getInstance();

            // 2. KPIs Globales
            $stats = [
                'total_leads' => $pdo->query("SELECT COUNT(*) FROM leads")->fetchColumn(),
                'active_sessions' => $pdo->query("SELECT COUNT(*) FROM users WHERE status = 'active'")->fetchColumn(),
                'signed_contracts' => $pdo->query("SELECT COUNT(*) FROM contracts WHERE status = 'signed'")->fetchColumn(),
                'compliance_pct' => config('app.sla.compliance_rate', 98.4)
            ];

            // 3. Listado de Agentes Bajo Supervisión
            $agents = $pdo->query("
                SELECT u.id, u.email, u.status, r.display_name as role 
                FROM users u 
                JOIN roles r ON u.role_id = r.id 
                WHERE u.role_id = 3 
                LIMIT 10
            ")->fetchAll();

            // 4. Auditoría de Seguridad Reciente (HIPAA Feed)
            $logs = $pdo->query("
                SELECT a.*, u.email as user_email 
                FROM audit_logs a 
                LEFT JOIN users u ON a.user_id = u.id 
                ORDER BY a.created_at DESC 
                LIMIT 15
            ")->fetchAll();

            $this->view('Manager/Views/dashboard', [
                'stats'  => $stats,
                'agents' => $agents,
                'logs'   => $logs,
                'user'   => Auth::user()
            ]);

        } catch (Exception $e) {
            error_log("[IMO][Manager] Error: " . $e->getMessage());
            die("Fallo en la carga del dashboard de supervisión.");
        }
    }
    /**
     * GET /manager/users
     * Gestión de Directorio de Usuarios.
     */
    public function users(): void
    {
        if (!Auth::check() || (!Auth::hasRole('superadmin') && !Auth::hasRole('manager'))) {
            header('Location: ' . config('app.url') . '/login');
            exit;
        }

        try {
            $pdo = Connection::getInstance();
            
            $usersList = $pdo->query("
                SELECT u.*, r.display_name as role_name 
                FROM users u 
                JOIN roles r ON u.role_id = r.id 
                ORDER BY u.created_at DESC
            ")->fetchAll();

            $this->view('Manager/Views/users', [
                'users' => $usersList,
                'user'  => Auth::user(),
                'stats' => [
                    'total_users' => count($usersList),
                    'active_now'  => 84, // Simulado para el look Bastion
                ]
            ]);
        } catch (Exception $e) {
            die("Fallo en la carga del directorio de usuarios.");
        }
    }

    /**
     * GET /manager/roles
     * Vista de Roles y Permisos.
     */
    public function roles(): void
    {
        if (!Auth::check() || (!Auth::hasRole('superadmin') && !Auth::hasRole('manager'))) {
            header('Location: ' . config('app.url') . '/login');
            exit;
        }

        $this->view('Manager/Views/roles', [
            'user' => Auth::user()
        ]);
    }
}
