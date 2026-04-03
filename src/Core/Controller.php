<?php

namespace IMO\Core;

use IMO\Core\View\Engine as ViewEngine;

/**
 * Controlador Base - empresaIMO
 */
abstract class Controller
{
    protected ViewEngine $view;

    public function __construct()
    {
        $this->view = new ViewEngine();
    }

    /**
     * Helper para renderizar vistas desde cualquier controlador.
     */
    protected function view(string $viewPath, array $params = []): void
    {
        $this->view->render($viewPath, $params);
    }

    /**
     * Helper para retornar respuestas JSON (APIs).
     */
    protected function json(array $data, int $code = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($data);
        exit; // Termina la ejecución tras una respuesta JSON
    }
}
