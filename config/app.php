<?php
/**
 * Configuración General de la Aplicación
 * empresaIMO - Arquitectura Clean
 */

return [
    'name'     => env('APP_NAME', 'empresaIMO Digital'),
    'env'      => env('APP_ENV', 'production'),
    'url'      => env('APP_URL', 'http://localhost/empresaIMO/public'),
    'timezone' => env('APP_TIMEZONE', 'UTC'),
    'locale'   => env('APP_LOCALE', 'es'),
    'charset'  => env('APP_CHARSET', 'utf8mb4'),
    
    // Branding
    'company' => [
        'name'     => env('COMPANY_NAME', 'empresaIMO'),
        'slogan'   => env('COMPANY_SLOGAN', 'Arquitectura resiliente'),
        'email'    => env('COMPANY_MAIL', 'contacto@empresaIMO.com'),
        'phone'    => env('COMPANY_PHONE', '+1 (555) 000-0000'),
        'address'  => env('COMPANY_ADDRESS', 'San Antonio, TX, USA'),
        'year_est' => env('COMPANY_EST_YEAR', '2024'),
    ],
    
    // SLA / Métricas (COPC 7.1)
    'sla' => [
        'response_time' => env('SLA_RESPONSE_TIME', '24h'),
        'speed_to_lead' => (int) env('SLA_SPEED_TO_LEAD', 120), // Segundos
        'compliance_rate' => (float) env('SYSTEM_COMPLIANCE_RATE', 98.4),
        'signature_algo' => env('SIGNATURE_ALGO', 'sha256'),
    ]
];
