<?php

namespace IMO\Core\Security;

use IMO\Core\Database\Connection;
use IMO\Modules\Audit\Services\AuditService;
use Exception;

/**
 * Auth — RBAC + HIPAA Audit Logging
 * empresaIMO
 */
class Auth
{
    /**
     * Intenta autenticar a un usuario. 
     * Devuelve true si las credenciales son válidas y la cuenta está activa.
     */
    public static function login(string $email, string $password): bool
    {
        try {
            $pdo = Connection::getInstance();
            
            $stmt = $pdo->prepare("
                SELECT u.*, r.key_name AS role_key
                FROM users u
                JOIN roles r ON u.role_id = r.id
                WHERE u.email = :email AND u.status = 'active'
                LIMIT 1
            ");
            
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                self::createSession($user);
                AuditService::log($user['id'], 'LOGIN_SUCCESS', 'users', (int)$user['id'], 'Autenticación exitosa.');
                return true;
            }

            // Registro de fallo (Brute force protection)
            AuditService::log(null, 'LOGIN_FAILED', 'users', null, "Intento fallido para: {$email}");
            return false;

        } catch (Exception $e) {
            error_log('[IMO][Auth] Error crítico: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Crea variables de sesión seguras.
     */
    private static function createSession(array $user): void
    {
        $_SESSION['user_id']       = (int)$user['id'];
        $_SESSION['user_uuid']     = $user['uuid'];
        $_SESSION['user_email']    = $user['email'];
        $_SESSION['user_name']     = $user['full_name'] ?? $user['email'];
        $_SESSION['user_role']     = $user['role_key'];
        $_SESSION['last_activity'] = time();
        $_SESSION['csrf_token']    = bin2hex(random_bytes(32)); // Token para protección CSRF
    }

    /**
     * Verifica si hay una sesión activa y no expirada según política HIPAA (ej. 15 min de inactividad).
     */
    public static function check(): bool
    {
        if (empty($_SESSION['user_id'])) return false;

        $timeout = (int)config('security.session.lifetime', 14400); // Segundos de inactividad permitidos
        
        if (time() - ($_SESSION['last_activity'] ?? 0) > $timeout) {
            self::logout();
            return false;
        }

        $_SESSION['last_activity'] = time();
        return true;
    }

    /**
     * Finaliza la sesión y limpia cookies.
     */
    public static function logout(): void
    {
        if (!empty($_SESSION['user_id'])) {
            AuditService::log($_SESSION['user_id'], 'LOGOUT', 'users', $_SESSION['user_id'], 'Cierre de sesión manual.');
        }

        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    /**
     * Helper para validación de permisos RBAC.
     */
    public static function hasRole(string $role): bool
    {
        return ($_SESSION['user_role'] ?? '') === $role;
    }

    /**
     * Devuelve los datos del usuario actual.
     */
    public static function user(): array
    {
        return [
            'id'    => $_SESSION['user_id']    ?? null,
            'email' => $_SESSION['user_email'] ?? null,
            'name'  => $_SESSION['user_name']  ?? null,
            'role'  => $_SESSION['user_role']  ?? null,
        ];
    }
}

