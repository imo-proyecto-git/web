<?php
/**
 * Configuración de Base de Datos
 * empresaIMO - Arquitectura Clean
 */

return [
    'default' => env('DB_CONNECTION', 'mysql'),
    
    'mysql' => [
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_NAME', 'empresaIMO_db'),
        'username' => env('DB_USER', 'root'),
        'password' => env('DB_PASS', ''),
        'charset' => env('APP_CHARSET', 'utf8mb4'),
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => false,
        ],
    ],
    
    // Configuración para el motor de encriptación in-DB
    'encryption' => [
        'method' => env('DB_ENCRYPTION_METHOD', 'aes-256-gcm'),
        'key'    => env('APP_SECRET'), // No debe guardarse en el repo
    ]
];
