<?php

namespace Controllers;

use MVC\Router;
use Model\CurriculumMateria;

class CurriculumController
{
    public static function anahuac(Router $router)
    {
        self::mostrar($router, 'anahuac', 'Mapa Curricular Anáhuac', 'Ingeniería en Sistemas y Tecnologías de la Información');
    }

    public static function unam(Router $router)
    {
        self::mostrar($router, 'unam', 'Mapa Curricular UNAM', 'Ciencias de la Comunicación');
    }

    private static function mostrar(Router $router, string $mapa, string $titulo, string $sub)
    {
        protegerAdmin();
        $router->render('admin/curriculum', [
            'titulo' => $titulo, 'modulo' => $mapa, 'sub' => $sub, 'mapa' => $mapa,
            'grupos' => CurriculumMateria::porMapa($mapa),
        ], 'admin-layout');
    }

    // Cicla el estado de una materia al hacer click
    public static function estado()
    {
        protegerAdmin();
        header('Content-Type: application/json');
        $m = CurriculumMateria::find((int) ($_POST['id'] ?? 0));
        if (!$m) { echo json_encode(['ok' => false]); exit; }
        $m->estado = $m->siguienteEstado();
        $m->guardar();
        echo json_encode(['ok' => true, 'estado' => $m->estado]);
        exit;
    }
}
