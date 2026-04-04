<?php

namespace IMO\Modules\Agent\Controllers;

use IMO\Core\Controller;
use IMO\Core\Security\Auth;
use Exception;

/**
 * SettingsController - Gestión de Perfil y Seguridad del Usuario
 * empresaIMO
 */
class SettingsController extends Controller
{
    /**
     * GET /settings/security
     * Interfaz de Seguridad de la Cuenta (Azure Shield Protection).
     */
    public function security(): void
    {
        if (!Auth::check()) {
            header('Location: ' . config('app.url') . '/login');
            exit;
        }

        $this->view('Agent/Views/security', [
            'user' => Auth::user(),
            'sessions' => $this->getActiveSessions()
        ]);
    }

    /**
     * Simula la obtención de sesiones activas para el look premium.
     */
    private function getActiveSessions(): array
    {
        return [
            [
                'device' => 'Windows PC - Edge Browser',
                'location' => 'San Antonio, TX',
                'current' => true,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                'last_active' => 'Activa ahora'
            ],
            [
                'device' => 'iPhone 15 Pro - Safari',
                'location' => 'Miami, FL',
                'current' => false,
                'ip' => '192.168.1.45',
                'last_active' => 'Hace 2 horas'
            ]
        ];
    }
}
