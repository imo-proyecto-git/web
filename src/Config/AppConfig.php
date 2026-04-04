<?php

namespace IMO\Config;

/**
 * AppConfig - Sistema de Configuración Jerárquico
 * empresaIMO - Arquitectura Clean
 */
class AppConfig
{
    private static array $config = [];
    private static bool $loaded = false;

    /**
     * Carga todos los archivos de configuración de la carpeta config/
     */
    private static function load(): void
    {
        if (self::$loaded) return;

        $configPath = __DIR__ . '/../../config';
        if (!is_dir($configPath)) {
            self::$loaded = true;
            return;
        }

        $files = glob($configPath . '/*.php');
        foreach ($files as $file) {
            $key = basename($file, '.php');
            self::$config[$key] = require $file;
        }

        self::$loaded = true;
    }

    /**
     * Obtiene una configuración mediante notación de punto.
     * Ejemplo: config('app.name')
     */
    public static function get(string $key, $default = null)
    {
        self::load();

        $segments = explode('.', $key);
        $data = self::$config;

        foreach ($segments as $segment) {
            if (!is_array($data) || !isset($data[$segment])) {
                return $default;
            }
            $data = $data[$segment];
        }

        return $data;
    }

    /**
     * Devuelve los tokens para la vista, cargados dinámicamente desde UI Config.
     */
    public static function getViewTokens(): array
    {
        return [
            'font_url'              => self::get('ui.fonts.url'),
            'font_heading'          => self::get('ui.fonts.heading'),
            'font_body'             => self::get('ui.fonts.body'),
            'surface'               => self::get('ui.colors.surface'),
            'surface_low'           => self::get('ui.colors.surface_low'),
            'surface_highest'       => self::get('ui.colors.surface_highest'),
            'surface_lowest'        => self::get('ui.colors.surface_lowest'),
            'border_light'          => self::get('ui.colors.border_light'),
            'primary_color'         => self::get('ui.colors.primary'),
            'secondary_color'       => self::get('ui.colors.secondary'),
            'tertiary_color'        => self::get('ui.colors.tertiary'),
            'tertiary_container'    => self::get('ui.colors.tertiary_container'),
            'on_tertiary_container' => self::get('ui.colors.on_tertiary_container'),
            'radius_sm'             => self::get('ui.radius.sm'),
            'radius_md'             => self::get('ui.radius.md'),
            'radius_lg'             => self::get('ui.radius.lg'),
            'radius_xl'             => self::get('ui.radius.xl'),
            'COMPANY_NAME'          => self::get('app.company.name'),
            'COMPANY_SLOGAN'        => self::get('app.company.slogan'),
            'COMPANY_MAIL'          => self::get('app.company.email'),
            'APP_URL'               => self::get('app.url'),
        ];
    }
}
