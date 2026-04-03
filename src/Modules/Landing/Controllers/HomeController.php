<?php

namespace IMO\Modules\Landing\Controllers;

use IMO\Core\Controller;

/**
 * HomeController - Landing Page de Conversión
 * empresaIMO
 */
class HomeController extends Controller
{
    /**
     * Muestra la página principal (reproducción del prototipo Stitch).
     */
    public function index(): void
    {
        $this->view('Landing/Views/home', [
            'title' => __('Expertos en expansión regional IMO'),
            'subtitle' => __('Tu ecosistema digital de seguros y servicios financieros.'),
        ]);
    }
}
