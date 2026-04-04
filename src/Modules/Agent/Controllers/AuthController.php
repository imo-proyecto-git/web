<?php

namespace IMO\Modules\Agent\Controllers;

use IMO\Core\Controller;
use IMO\Core\Security\Auth;
use IMO\Config\AppConfig;

/**
 * AuthController - Gestión de Accesos del Portal del Agente
 * empresaIMO
 */
class AuthController extends Controller
{
    /**
     * GET /login
     * Muestra el formulario de acceso con Design System Tokens.
     */
    public function showLogin(): void
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (in_array($user['role'] ?? 'agent', ['superadmin', 'manager', 'admin'])) {
                $this->redirect('/manager/dashboard');
            } else {
                $this->redirect('/agent/dashboard');
            }
            return;
        }

        // El token CSRF ya se genera en Auth::createSession, 
        // pero para el login (sin sesión previa) lo manejamos aquí o en el engine.
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);

        $this->view('Agent/Views/login', [
            'csrf_token' => $_SESSION['csrf_token'],
            'error'      => $error
        ]);
    }

    /**
     * POST /login
     * Procesa las credenciales y establece la sesión.
     */
    public function login(): void
    {
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');
        $token    = $_POST['csrf_token']    ?? '';

        // Validación de Seguridad CSRF
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            $_SESSION['login_error'] = __('Solicitud no autorizada o expirada.');
            $this->redirect('/login');
            return;
        }

        if (Auth::login($email, $password)) {
            // Regenerar token tras login (Seguridad)
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            
            $user = Auth::user();
            if (in_array($user['role'] ?? 'agent', ['superadmin', 'manager'])) {
                $this->redirect('/manager/dashboard');
            } else {
                $this->redirect('/agent/dashboard');
            }
        } else {
            $_SESSION['login_error'] = __('Credenciales incorrectas o cuenta inactiva.');
            $this->redirect('/login');
        }
    }

    /**
     * GET /logout
     * Cierra la sesión de forma segura (Audit Logged).
     */
    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/login');
    }

    /**
     * Redirección dinámica respetando la base del APP.
     */
    private function redirect(string $path): void
    {
        $url = config('app.url') . $path;
        header('Location: ' . $url);
        exit;
    }
}
