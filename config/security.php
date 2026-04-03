<?php
/**
 * Configuración de Seguridad y RBAC
 * empresaIMO - Arquitectura Clean (HIPAA Ready)
 */

return [
    'auth' => [
        'mode' => env('RBAC_MODE', 'granular'),
        'max_attempts' => env('AUTH_MAX_ATTEMPTS', 5),
        'decay' => env('AUTH_RATE_LIMIT_DECAY', 60),
        'lockout_time' => env('AUTH_BRUTE_FORCE_BLOCK', 1800),
        'hash_algo' => env('AUTH_HASH_ALGO', 'argon2id'),
    ],
    
    'jwt' => [
        'secret' => env('JWT_SECRET', 'super-secret-token-change-this-now'),
        'ttl' => env('JWT_TTL', 3600),
        'refresh_ttl' => env('REFRESH_TOKEN_TTL', 2592000),
    ],
    
    'session' => [
        'lifetime' => 14400, // 4 hours
        'warning_seconds' => 300,
        'secure' => true,
        'http_only' => true,
    ],
    
    'hipaa' => [
        'phi_encryption' => true,
        'audit_at_rest' => true,
        'auto_logout_minutes' => 15,
        'mask_pii' => true, // Enmascara datos sensibles por defecto
    ]
];
