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
    /**
     * POST /manager/api/v1/users/store
     * Crea un nuevo usuario en el sistema con auditoría HIPAA.
     */
     public function store(): void
     {
         if (!Auth::check() || (!Auth::hasRole('superadmin') && !Auth::hasRole('manager'))) {
             header('Content-Type: application/json');
             echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
             return;
         }

         $email    = trim($_POST['email'] ?? '');
         $password = trim($_POST['password'] ?? '');
         $roleId   = (int)($_POST['role_id'] ?? 3);

         if (!$email || !$password) {
             header('Content-Type: application/json');
             echo json_encode(['status' => 'error', 'message' => 'Email y contraseña son obligatorios']);
             return;
         }

         try {
             $pdo = Connection::getInstance();

             // Verificar duplicado
             $check = $pdo->prepare("SELECT id FROM users WHERE email = :email");
             $check->execute(['email' => $email]);
             if ($check->fetch()) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'El email ya está registrado']);
                return;
             }

             // Generar UUID
             $data = random_bytes(16);
             $data[6] = chr(ord($data[6]) & 0x0f | 0x40); 
             $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
             $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

             $hash = password_hash($password, PASSWORD_BCRYPT);

             $stmt = $pdo->prepare("
                INSERT INTO users (uuid, role_id, email, password_hash, status) 
                VALUES (:uuid, :role, :email, :hash, 'active')
             ");
             
             $stmt->execute([
                 'uuid'  => $uuid,
                 'role'  => $roleId,
                 'email' => $email,
                 'hash'  => $hash
             ]);

             $newId = $pdo->lastInsertId();

             // Log de Auditoría HIPAA
             \IMO\Modules\Audit\Services\AuditService::log(
                 Auth::user()['id'], 
                 'USER_CREATE', 
                 'users', 
                 (int)$newId, 
                 "Creado nuevo usuario: $email con rol ID $roleId"
             );

             header('Content-Type: application/json');
             echo json_encode(['status' => 'success', 'message' => 'Usuario enrolado exitosamente']);

         } catch (Exception $e) {
             header('Content-Type: application/json');
             echo json_encode(['status' => 'error', 'message' => 'Fallo en la base de datos: ' . $e->getMessage()]);
         }
     }
}
