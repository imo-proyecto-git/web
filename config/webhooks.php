<?php
/**
 * Configuración de Webhooks Externos (CRM/ERP)
 * empresaIMO - Arquitectura Zero-Hardcode
 */

return [
    'hubsport' => [
        'enabled' => env('HUBSPOT_WEBHOOK_ENABLED', false),
        'url'     => env('HUBSPOT_WEBHOOK_URL', ''),
        'token'   => env('HUBSPOT_API_TOKEN', ''),
    ],
    
    'monday' => [
        'enabled' => env('MONDAY_WEBHOOK_ENABLED', false),
        'url'     => env('MONDAY_WEBHOOK_URL', ''),
    ],
    
    'zapier' => [
        'enabled' => env('ZAPIER_WEBHOOK_ENABLED', true),
        'url'     => env('ZAPIER_WEBHOOK_URL', 'https://hooks.zapier.com/v1/event/example'),
    ],
    
    'timeout' => 5, // Segundos de espera
];
