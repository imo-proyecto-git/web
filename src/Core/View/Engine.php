<?php

namespace IMO\Core\View;

use IMO\Config\AppConfig;
use Exception;

/**
 * View Engine - empresaIMO
 * Motor liviano para renderizar vistas PHP con inyección automática de tokens de diseño.
 */
class Engine
{
    private string $basePath;
    private array $data = [];

    public function __construct()
    {
        // La ruta base de las vistas es src/Modules/
        $this->basePath = __DIR__ . '/../../Modules/';
        
        // Inyectamos automáticamente los tokens del Design System
        $this->data = AppConfig::getViewTokens();

        // Inyectamos el usuario actual si hay sesión
        if (\IMO\Core\Security\Auth::check()) {
            $this->data['user'] = \IMO\Core\Security\Auth::user();
        }
    }

    /**
     * Renderiza una vista inyectando datos.
     * @param string $viewPath Ruta relativa a Modules (ej: Landing/Views/home)
     * @param array $params Datos adicionales para la vista
     */
    public function render(string $viewPath, array $params = []): void
    {
        $file = $this->basePath . str_replace('.', '/', $viewPath) . '.php';

        if (!file_exists($file)) {
            throw new Exception("La vista no existe en: {$file}");
        }

        // Combinamos tokens globales con parámetros específicos
        extract(array_merge($this->data, $params));

        // Iniciamos el buffer de salida
        ob_start();
        include $file;
        echo ob_get_clean();
    }
}
