<?php

namespace Controllers;

use MVC\Router;
use Model\Videojuego;

class VideojuegoController
{
    public static function index(Router $router)
    {
        protegerAdmin();
        $router->render('admin/videojuegos', [
            'titulo'      => 'Videojuegos', 'modulo' => 'videojuegos',
            'videojuegos' => Videojuego::ordenados(),
            'editando'    => isset($_GET['id']) ? Videojuego::find((int) $_GET['id']) : null,
        ], 'admin-layout');
    }

    public static function guardar()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = !empty($_POST['id']) ? (int) $_POST['id'] : null;
            $editando = $id ? Videojuego::find($id) : null;
            $vj = new Videojuego($_POST);
            $vj->horas_iniciales = (float) ($_POST['horas_iniciales'] ?? 0);
            $vj->horas_totales   = ($_POST['horas_totales'] ?? '') !== '' ? (float) $_POST['horas_totales'] : null;
            $vj->id = $id;
            if (!$vj->id) $vj->orden = count(Videojuego::all()) + 1;
            $portada = subirArchivo('portada_file', rutaBuild('img/videojuegos'), 'vj', ['png','jpg','jpeg','webp','avif']);
            if ($portada) $vj->portada = $portada; elseif ($editando) $vj->portada = $editando->portada;
            $vj->guardar();
            flash($editando ? 'Videojuego actualizado' : 'Videojuego agregado', $editando ? 'editado' : 'ok');
        }
        header('Location: /admin/videojuegos'); exit;
    }

    public static function eliminar()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $vj = Videojuego::find((int) $_POST['id']);
            if ($vj) { $vj->eliminar(); flash('Videojuego eliminado', 'eliminado'); }
        }
        header('Location: /admin/videojuegos'); exit;
    }

    public static function orden()
    {
        protegerAdmin();
        Videojuego::reordenar($_POST['ids'] ?? []);
        header('Content-Type: application/json'); echo json_encode(['ok' => true]); exit;
    }
}
