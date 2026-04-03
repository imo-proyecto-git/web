<?php
/**
 * Configuración de Diseño y UX (Branding Visual)
 * empresaIMO - Arquitectura Clean
 */

return [
    'fonts' => [
        'url' => env('FONT_URL', 'https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&display=swap'),
        'heading' => env('FONT_HEADING', "'Manrope', sans-serif"),
        'body' => env('FONT_BODY', "'Inter', sans-serif"),
        'mono' => env('FONT_MONO', "monospace"),
    ],
    
    'colors' => [
        'bg_light' => env('UI_COLOR_BG_LIGHT', '#faf8ff'),
        'surface_light' => env('UI_COLOR_SURFACE_LIGHT', '#ffffff'),
        'border_light' => env('UI_COLOR_BORDER_LIGHT', 'rgba(197, 198, 210, 0.4)'),
        'primary' => env('UI_PRIMARY_COLOR', '#00113a'),
        'secondary' => env('UI_SECONDARY_COLOR', '#002366'),
        'gold' => env('UI_GOLD_COLOR', '#4edea3'),
        'success' => env('UI_COLOR_SUCCESS', '#00a371'),
        'warning' => env('UI_COLOR_WARNING', '#ffdad6'),
        'danger' => env('UI_COLOR_DANGER', '#ba1a1a'),
        'info' => env('UI_COLOR_INFO', '#758dd5'),
    ],
    
    'radius' => [
        'sm' => env('UI_RADIUS_SM', '6px'),
        'md' => env('UI_RADIUS_MD', '12px'),
        'lg' => env('UI_RADIUS_LG', '20px'),
        'pill' => env('UI_RADIUS_PILL', '50rem'),
    ],
    
    'assets' => [
        'logo' => '/assets/img/logo.png',
        'favicon' => '/assets/img/favicon.ico',
    ]
];
