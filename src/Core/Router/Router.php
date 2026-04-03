<?php

namespace IMO\Core\Router;

use Exception;

/**
 * Router - empresaIMO
 * Sistema de enrutamiento dinámico con soporte para parámetros (Regex).
 */
class Router {
    private array $routes = [];
    private string $basePath;

    public function __construct(string $basePath = '') {
        $this->basePath = $basePath;
    }

    public function get(string $path, $handler): void {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, $handler): void {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, $handler): void {
        $path = '/' . trim($path, '/');
        
        // Convertimos {param} en regex
        $pattern = preg_replace('/\{([a-zA-Z0-9_\-]+)\}/', '(?P<$1>[a-zA-Z0-9_\-]+)', $path);
        $pattern = "#^" . $pattern . "$#";

        $this->routes[] = [
            'method'  => $method,
            'pattern' => $pattern,
            'handler' => $handler
        ];
    }

    public function dispatch(): void {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        if ($this->basePath && strpos($uri, $this->basePath) === 0) {
            $uri = substr($uri, strlen($this->basePath));
        }
        
        $path   = '/' . trim($uri, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $path, $matches)) {
                
                // Limpiamos los matches numéricos, solo dejamos los nombrados
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                $this->execute($route['handler'], $params);
                return;
            }
        }

        http_response_code(404);
        $tokens = \IMO\Config\AppConfig::getViewTokens();
        extract($tokens);
        include __DIR__ . '/../../Modules/Landing/Views/404.php';
    }

    private function execute($handler, array $params = []): void {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
            return;
        }

        if (is_string($handler) && strpos($handler, '@') !== false) {
            [$controllerName, $method] = explode('@', $handler);
            $controllerClass = "IMO\\Modules\\" . str_replace('/', '\\', $controllerName);
            
            if (!class_exists($controllerClass)) {
                throw new Exception("El controlador {$controllerClass} no existe.");
            }

            $controller = new $controllerClass();
            if (!method_exists($controller, $method)) {
                throw new Exception("El método {$method} no existe en {$controllerClass}.");
            }

            call_user_func_array([$controller, $method], $params);
            return;
        }

        throw new Exception("Handler de ruta inválido.");
    }
}
