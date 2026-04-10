<?php
/**
 * Configuración de Servicios Externos
 * empresaIMO - Arquitectura Clean
 */

return [
    'groq' => [
        'url' => env('GROQ_API_URL', 'https://api.groq.com/openai/v1/chat/completions'),
    ],
    
    'mailgun' => [
        'url' => env('MAILGUN_API_URL', 'https://api.mailgun.net/v3/'),
    ],
    
    'sendgrid' => [
        'url' => env('SENDGRID_API_URL', 'https://api.sendgrid.com/v3/mail/send'),
    ],
    
    'avatars' => [
        'url' => env('AVATAR_API_URL', 'https://ui-avatars.com/api/'),
    ]
];
