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

// Contratos y Firma Digital
$router->get('/contracts/{uuid}', 'Contracts/Controllers/ContractController@show');
$router->post('/contracts/{uuid}/sign', 'Contracts/Controllers/ContractController@sign');

// Supervisión (Manager)
$router->get('/manager/dashboard', 'Manager/Controllers/ManagerDashboardController@index');

// Autenticación
$router->get('/login',  'Agent/Controllers/AuthController@showLogin');
$router->post('/login', 'Agent/Controllers/AuthController@login');
$router->get('/logout', 'Agent/Controllers/AuthController@logout');

// Portal
$router->get('/agent/dashboard', 'Agent/Controllers/DashboardController@index');

// Ejecución del Despachador
$router->dispatch();


