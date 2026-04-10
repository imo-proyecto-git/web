<?php
/**
 * Front Controller — empresaIMO
 * Punto de entrada único. Todo pasa por aquí.
 */

/**
 * ── 1. Carga de .env ANTES de nada ──────────────────────────────────────────
 */
(function (): void {
    $path = __DIR__ . '/../.env';
    if (!file_exists($path)) return;
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) continue;
        [$name, $value] = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value, " \t\"'");
    }
})();

// ── 2. Autoloader PSR-4 ────────────────────────────────────────────────────
spl_autoload_register(function (string $class): void {
    $prefix  = 'IMO\\';
    $baseDir = __DIR__ . '/../src/';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) return;
    $file = $baseDir . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (file_exists($file)) require $file;
});

// ── 3. Cargar Helpers Globales ───────────────────────────────────────────────
require_once __DIR__ . '/../src/Helpers/functions.php';

// ── 4. Configuración de Sesión (usando config()) ────────────────────────────
ini_set('session.cookie_httponly', config('security.session.http_only', '1'));
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_path', '/');
session_start();

// ── 5. Enrutamiento Dinámico (Cero Hardcode) ─────────────────────────────
use IMO\Core\Router\Router;

$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$basePath = ($scriptName === '/' || $scriptName == '\\') ? '' : $scriptName;

$router = new Router($basePath);

// Registro de Rutas (Módulos)
$router->get('/', 'Landing/Controllers/HomeController@index');

// Leads
$router->get('/agent/leads/{uuid}', 'Leads/Controllers/LeadController@show');
$router->get('/agent/leads/{uuid}/report', 'Leads/Controllers/LeadController@report');
$router->post('/api/v1/leads', 'Leads/Controllers/LeadController@store');
$router->post('/agent/leads/{uuid}/status', 'Leads/Controllers/LeadController@updateStatus');
$router->post('/api/v1/sync/offline', 'Leads/Controllers/LeadController@syncOffline');

// Contratos y Firma Digital + OTP
$router->get('/contracts/{uuid}', 'Contracts/Controllers/ContractController@show');
$router->post('/contracts/{uuid}/otp/request', 'Contracts/Controllers/ContractController@requestOtp');
$router->post('/contracts/{uuid}/otp/verify', 'Contracts/Controllers/ContractController@verifyOtp');
$router->post('/contracts/{uuid}/sign', 'Contracts/Controllers/ContractController@sign');

// Supervisión (Manager)
$router->get('/manager/dashboard', 'Manager/Controllers/ManagerDashboardController@index');
$router->get('/manager/users', 'Manager/Controllers/ManagerDashboardController@users');
$router->post('/manager/api/v1/users/store', 'Manager/Controllers/ManagerDashboardController@store');
$router->get('/manager/roles', 'Manager/Controllers/ManagerDashboardController@roles');
$router->get('/manager/audit', 'Audit/Controllers/AuditController@index');
$router->get('/manager/audit/export', 'Audit/Controllers/AuditController@exportCsv');

// Marketing (Azure Shield)
$router->get('/manager/marketing/campaigns/create', 'Marketing/Controllers/CampaignController@create');
$router->get('/manager/marketing/campaigns/analytics', 'Marketing/Controllers/CampaignController@analytics');
$router->post('/api/v1/marketing/campaigns', 'Marketing/Controllers/CampaignController@store');
$router->get('/api/v1/marketing/campaigns/{id}/status', 'Marketing/Controllers/CampaignController@queueStatus');
$router->get('/api/v1/track/{campaign_id}/{lead_id}', 'Marketing/Controllers/CampaignController@trackOpen');

// Autenticación & Configuración
$router->get('/login',  'Agent/Controllers/AuthController@showLogin');
$router->post('/login', 'Agent/Controllers/AuthController@login');
$router->get('/logout', 'Agent/Controllers/AuthController@logout');
$router->get('/settings/security', 'Agent/Controllers/SettingsController@security');

// Portal
$router->get('/agent/dashboard', 'Agent/Controllers/DashboardController@index');
$router->get('/agent/pipeline', 'Agent/Controllers/PipelineController@index');

// Ejecución del Despachador
$router->dispatch();


