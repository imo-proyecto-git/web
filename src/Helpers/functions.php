<?php
/**
 * Global Helpers - empresaIMO
 * Prevé funciones globales para evitar hardcoding en toda la app.
 */

if (!function_exists('env')) {
    /**
     * Obtiene una variable de entorno con soporte para valores por defecto.
     */
    function env(string $key, $default = null) {
        $value = $_ENV[$key] ?? getenv($key);
        
        if ($value === false) return $default;
        
        // Parsea booleanos y nulos representados como string
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        // Elimina comillas si existen
        if (is_string($value) && strlen($value) > 1 && $value[0] === '"' && $value[strlen($value) - 1] === '"') {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

if (!function_exists('config')) {
    /**
     * Accede a la configuración jerárquicamente usando notación de punto.
     * Ejemplo: config('app.name') carga 'app.php' y accede a ['name']
     */
    function config(string $key, $default = null) {
        return \IMO\Config\AppConfig::get($key, $default);
    }
}

if (!function_exists('__')) {
    /**
     * Placeholder para traducciones futuras i18n
     */
    function __(string $key, array $replace = [], ?string $locale = null) {
        // Por ahora devuelve la misma llave o lo que determine el sistema de traducciones
        return $key;
    }
}

if (!function_exists('avatar_url')) {
    /**
     * Generador unificado de URLs de Avatares (Zero-Hardcode)
     */
    function avatar_url(string $name, string $bg = '00113a', string $color = 'fff', ?int $size = null): string {
        $baseUrl = config('services.avatars.url', 'https://ui-avatars.com/api/');
        $url = $baseUrl . "?name=" . urlencode($name) . "&background={$bg}&color={$color}";
        if ($size) {
            $url .= "&size={$size}";
        }
        return $url;
    }
}
