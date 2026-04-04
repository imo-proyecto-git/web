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
        'surface' => env('UI_COLOR_SURFACE', '#faf8ff'),
        'surface_low' => env('UI_COLOR_SURFACE_LOW', '#f2f3ff'),
        'surface_highest' => env('UI_COLOR_SURFACE_HIGHEST', '#dae2fd'),
        'surface_lowest' => env('UI_COLOR_SURFACE_LOWEST', '#ffffff'),
        'border_light' => env('UI_COLOR_BORDER_LIGHT', 'rgba(197, 198, 210, 0.2)'),
        'primary' => env('UI_PRIMARY_COLOR', '#00113a'),
        'secondary' => env('UI_SECONDARY_COLOR', '#002366'),
        'tertiary' => env('UI_TERTIARY_COLOR', '#00a371'),
        'tertiary_container' => env('UI_TERTIARY_CONTAINER', 'rgba(0, 163, 113, 0.1)'),
        'on_tertiary_container' => env('UI_ON_TERTIARY_CONTAINER', '#00a371'),
        'success' => env('UI_COLOR_SUCCESS', '#00a371'),
        'warning' => env('UI_COLOR_WARNING', '#ffdad6'),
    ],
    
    'radius' => [
        'sm' => env('UI_RADIUS_SM', '8px'),
        'md' => env('UI_RADIUS_MD', '12px'),
        'lg' => env('UI_RADIUS_LG', '20px'),
        'xl' => env('UI_RADIUS_XL', '32px'),
        'pill' => env('UI_RADIUS_PILL', '50rem'),
    ],
    
    'assets' => [
        'logo' => '/assets/img/logo.png',
        'favicon' => '/assets/img/favicon.ico',
    ]
];
