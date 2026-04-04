#!/usr/bin/env php
<?php
/**
 * ┌──────────────────────────────────────────────────────────────────────────┐
 * │  IMO-OS Background Queue Worker                                          │
 * │  empresaIMO Digital — Arquitectura de Alta Disponibilidad                │
 * │                                                                          │
 * │  USO:                                                                    │
 * │    php worker.php [--queue=emails] [--sleep=3] [--max-jobs=0]            │
 * │                                                                          │
 * │  PRODUCCIÓN (ejecutar como servicio/daemon):                             │
 * │    nohup php worker.php --queue=emails >> storage/logs/worker.log 2>&1 & │
 * │    pm2 start worker.php --interpreter=php --name=imo-worker              │
 * │                                                                          │
 * │  WINDOWS (XAMPP - Task Scheduler):                                       │
 * │    C:\xampp\php\php.exe C:\xampp\htdocs\empresaIMO\worker.php            │
 * └──────────────────────────────────────────────────────────────────────────┘
 */
declare(strict_types=1);

// ── Bootstrap ──────────────────────────────────────────────────────────────
define('IMO_WORKER', true);
define('IMO_ROOT', __DIR__);

// Cargar .env
(function (): void {
    $path = IMO_ROOT . '/.env';
    if (!file_exists($path)) return;
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) continue;
        [$name, $value] = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value, " \t\"'");
    }
})();

// Autoloader PSR-4
spl_autoload_register(function (string $class): void {
    $prefix  = 'IMO\\';
    $baseDir = IMO_ROOT . '/src/';
    if (!str_starts_with($class, $prefix)) return;
    $file = $baseDir . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (file_exists($file)) require $file;
});

// Helpers
require_once IMO_ROOT . '/src/Helpers/functions.php';

// ── Importaciones ──────────────────────────────────────────────────────────
use IMO\Core\Infrastructure\QueueService;

// ── Argumentos CLI ──────────────────────────────────────────────────────────
$opts     = getopt('', ['queue:', 'sleep:', 'max-jobs:', 'once']);
$queue    = $opts['queue']    ?? QueueService::QUEUE_EMAILS;
$sleep    = (int)($opts['sleep']    ?? 3);    // segundos entre ciclos
$maxJobs  = (int)($opts['max-jobs'] ?? 0);   // 0 = infinito
$runOnce  = isset($opts['once']);             // procesar 1 job y salir

// ── Registro de Jobs disponibles ────────────────────────────────────────────
$JOB_REGISTRY = [
    \IMO\Modules\Marketing\Jobs\SendCampaignEmailJob::class => \IMO\Modules\Marketing\Jobs\SendCampaignEmailJob::class,
];

// ── Helpers locales ─────────────────────────────────────────────────────────
function workerLog(string $level, string $msg): void
{
    $ts  = date('Y-m-d H:i:s');
    $pid = getmypid();
    $line = "[$ts] [PID:$pid] [$level] $msg" . PHP_EOL;
    echo $line;

    // Persistir en archivo
    $logDir = IMO_ROOT . '/storage/logs';
    if (!is_dir($logDir)) @mkdir($logDir, 0775, true);
    @file_put_contents("$logDir/worker.log", $line, FILE_APPEND | LOCK_EX);
}

// ── Señales Unix (solo Linux/Mac) ───────────────────────────────────────────
$running = true;
if (function_exists('pcntl_signal') && defined('SIGTERM') && defined('SIGINT')) {
    pcntl_signal(SIGTERM, function () use (&$running) { $running = false; }); // @phpstan-ignore-line
    pcntl_signal(SIGINT,  function () use (&$running) { $running = false; }); // @phpstan-ignore-line
}

// ── Arranque ────────────────────────────────────────────────────────────────
workerLog('INFO', "Worker iniciado. Cola: [$queue] | Sleep: {$sleep}s | MaxJobs: " . ($maxJobs ?: '∞'));

$processedJobs = 0;

while ($running) {
    if (function_exists('pcntl_signal_dispatch')) pcntl_signal_dispatch();

    $job = QueueService::dequeue($queue);

    if (!$job) {
        if ($runOnce) break;
        sleep($sleep);
        continue;
    }

    $jobId    = (int)$job['id'];
    $jobClass = $job['data']['class'] ?? '';
    $payload  = $job['data']['payload'] ?? [];

    workerLog('INFO', "Procesando Job #$jobId [$jobClass]");

    try {
        if (!class_exists($jobClass) || !method_exists($jobClass, 'handle')) {
            throw new \RuntimeException("Job class no encontrada o sin método handle(): $jobClass");
        }

        $result = $jobClass::handle($payload);

        QueueService::markDone($jobId);
        workerLog('OK', "Job #$jobId completado exitosamente.");

    } catch (\Throwable $e) {
        $errMsg = $e->getMessage();
        QueueService::markFailed($jobId, $errMsg);
        workerLog('ERROR', "Job #$jobId falló: $errMsg");
    }

    $processedJobs++;

    if ($runOnce || ($maxJobs > 0 && $processedJobs >= $maxJobs)) {
        break;
    }

    // Pequeña pausa anti-hammering entre jobs
    usleep(100_000); // 100ms
}

workerLog('INFO', "Worker detenido. Jobs procesados: $processedJobs.");
exit(0);
