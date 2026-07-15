<?php

namespace Controllers;

use MVC\Router;
use Model\Libro;

class LibrosController
{
    // Página de gestión (solo admin)
    public static function index(Router $router)
    {
        protegerAdmin();
        $router->render('libros/index', [
            'titulo'     => 'Libros',
            'modulo'     => 'libros',
            'pendientes' => Libro::pendientes(),
            'leidos'     => Libro::leidos(),
        ], 'admin-layout');
    }

    // Crear un libro pendiente (al final por orden de inserción)
    public static function crear()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty(trim($_POST['titulo'] ?? ''))) {
            $libro = new Libro([
                'titulo'   => trim($_POST['titulo']),
                'autor'    => trim($_POST['autor'] ?? ''),
                'estado'   => 'pendiente',
                'posicion' => Libro::maxPosicion() + 1,
            ]);
            $libro->guardar();
        }
        header('Location: /admin/libros'); exit;
    }

    // Interacción de estado.
    // - Pendiente: alterna su marca "completado" (cualquiera se puede completar).
    //   Los completados solo migran a "leídos" cuando el PRIMERO de la lista
    //   está completado; entonces se arrastran los consecutivos completados.
    // - Leído: regresa a pendientes (se des-completa).
    public static function estado()
    {
        protegerAdmin();
        self::json(function () {
            $libro = Libro::find((int) ($_POST['id'] ?? 0));
            if (!$libro) return ['ok' => false];

            if ($libro->estado === 'leido') {
                $libro->estado = 'pendiente';
                $libro->completado = 0;
                $libro->guardar();
                return ['ok' => true, 'accion' => 'pendiente'];
            }

            // pendiente: alternar completado
            $libro->completado = (int) $libro->completado === 1 ? 0 : 1;
            $libro->guardar();

            // migrar consecutivos completados desde el inicio de la lista
            Libro::promoverCompletados();

            // Al marcar completado se pide la calificación (estrellas) del libro clicado.
            return [
                'ok'         => true,
                'accion'     => 'toggle',
                'completado' => (int) $libro->completado,
                'id'         => (int) $libro->id,
                'titulo'     => $libro->titulo,
            ];
        });
    }

    // Editar título + autor (opcionalmente mover al final)
    public static function editar()
    {
        protegerAdmin();
        self::json(function () {
            $libro = Libro::find((int) ($_POST['id'] ?? 0));
            if (!$libro) return ['ok' => false];
            $libro->titulo = trim($_POST['titulo'] ?? $libro->titulo);
            $libro->autor  = trim($_POST['autor'] ?? $libro->autor);
            if (!empty($_POST['al_final'])) $libro->posicion = Libro::maxPosicion() + 1;
            $libro->guardar();
            return ['ok' => true];
        });
    }

    // Guardar reseña (estrellas 0.5-5 + comentario)
    public static function resenar()
    {
        protegerAdmin();
        self::json(function () {
            $libro = Libro::find((int) ($_POST['id'] ?? 0));
            if (!$libro) return ['ok' => false];
            $estrellas = (float) ($_POST['estrellas'] ?? 0);
            $libro->estrellas  = max(0, min(5, round($estrellas * 2) / 2));
            // El comentario solo se sobrescribe si viene en la petición (el modal de
            // calificación no lo envía, para no borrar un comentario existente).
            if (array_key_exists('comentario', $_POST)) $libro->comentario = trim($_POST['comentario']);
            $libro->guardar();
            return ['ok' => true];
        });
    }

    // Eliminar libro
    public static function eliminar()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $libro = Libro::find((int) $_POST['id']);
            if ($libro) $libro->eliminar();
        }
        header('Location: /admin/libros'); exit;
    }

    private static function json(callable $fn) : void
    {
        header('Content-Type: application/json');
        echo json_encode($fn());
        exit;
    }
}
