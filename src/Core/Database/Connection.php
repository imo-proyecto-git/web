<?php

namespace IMO\Core\Database;

use PDO;
use PDOException;
use IMO\Config\AppConfig;

/**
 * Singleton PDO Connection - HIPAA Compliant
 * connect_timeout en el DSN para prevenir bloqueos en XAMPP/Windows
 */
class Connection
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host    = AppConfig::get('DB_HOST',    '127.0.0.1');
            $port    = AppConfig::get('DB_PORT',    '3306');
            $db      = AppConfig::get('DB_NAME',    'empresaIMO_db');
            $user    = AppConfig::get('DB_USER',    'root');
            $pass    = AppConfig::get('DB_PASS',    '');
            $charset = AppConfig::get('APP_CHARSET','utf8mb4');

            $timeout = AppConfig::get('DB_TIMEOUT', '5');

            // connect_timeout en el DSN es el único timeout real para conexión inicial en MySQL
            $dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset};connect_timeout={$timeout}";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_PERSISTENT         => false,
            ];

            try {
                $pdo = new PDO($dsn, $user, $pass, $options);
                
                // INYECCIÓN DE CONTEXTO PARA TRIGGERS MYSQL (Immutable Ledger)
                // Esto permite a los triggers grabar auditorías automáticamente con la identidad del atacante/usuario.
                $userId = $_SESSION['user_id'] ?? null;
                $ip = $_SERVER['REMOTE_ADDR'] ?? 'CLI';
                
                if ($userId) {
                    $pdo->exec("SET @imo_user_id = " . (int)$userId . ";");
                } else {
                    $pdo->exec("SET @imo_user_id = NULL;");
                }
                $pdo->exec("SET @imo_ip = " . $pdo->quote($ip) . ";");

                self::$instance = $pdo;

            } catch (PDOException $e) {
                $env = AppConfig::get('APP_ENV', 'local');
                if ($env === 'local') {
                    $msg = "DB Error [{$e->getCode()}]: {$e->getMessage()}";
                } else {
                    $msg = "Error crítico de base de datos. Contacte al administrador.";
                }
                throw new PDOException($msg, (int)$e->getCode());
            }
        }

        return self::$instance;
    }

    /** Resetea la instancia (útil para tests) */
    public static function reset(): void
    {
        self::$instance = null;
    }
}
