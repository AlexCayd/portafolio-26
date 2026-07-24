<?php

namespace Controllers;

use MVC\Router;
use Model\Libro;

class LibrosController
{
    const POR_PAGINA = 25;   // libros leídos por página

    // Página de gestión (solo admin)
    public static function index(Router $router)
    {
        protegerAdmin();
        $leidosTodos = Libro::leidos();               // ya ordenados por fecha de completado (desc)
        $totalLeidos = count($leidosTodos);
        $totalPag    = max(1, (int) ceil($totalLeidos / self::POR_PAGINA));
        $pag         = max(1, min($totalPag, (int) ($_GET['pag'] ?? 1)));
        $leidos      = array_slice($leidosTodos, ($pag - 1) * self::POR_PAGINA, self::POR_PAGINA);

        $router->render('libros/index', [
            'titulo'      => 'Libros',
            'modulo'      => 'libros',
            'pendientes'  => Libro::pendientes(),
            'leidos'      => $leidos,
            'totalLeidos' => $totalLeidos,
            'pag'         => $pag,
            'totalPag'    => $totalPag,
            'inicioLeido' => ($pag - 1) * self::POR_PAGINA,   // offset para numerar la posición
        ], 'admin-layout');
    }

    // Búsqueda: localiza un libro en cualquier columna y devuelve su posición
    // (y la página de «Leídos» donde aparece) para poder saltar a él.
    public static function buscar()
    {
        protegerAdmin();
        self::json(function () {
            $q = mb_strtolower(trim($_GET['q'] ?? $_POST['q'] ?? ''));
            if ($q === '') return ['ok' => true, 'resultados' => []];

            $coincide = function ($l) use ($q) {
                return mb_strpos(mb_strtolower($l->titulo . ' ' . $l->autor), $q) !== false;
            };
            $res = [];
            foreach (Libro::pendientes() as $i => $l) {
                if ($coincide($l)) $res[] = [
                    'id' => (int) $l->id, 'titulo' => $l->titulo, 'autor' => $l->autor,
                    'columna' => 'Pendientes', 'posicion' => $i + 1, 'pagina' => null,
                ];
            }
            foreach (Libro::leidos() as $i => $l) {
                if ($coincide($l)) $res[] = [
                    'id' => (int) $l->id, 'titulo' => $l->titulo, 'autor' => $l->autor,
                    'columna' => 'Leídos', 'posicion' => $i + 1,
                    'pagina' => intdiv($i, self::POR_PAGINA) + 1,
                ];
            }
            return ['ok' => true, 'resultados' => $res];
        });
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
                $libro->fecha_leido = null;   // al volver a pendientes se limpia la fecha de lectura
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
            if (array_key_exists('fecha_leido', $_POST)) {
                $libro->fecha_leido = trim($_POST['fecha_leido']) !== '' ? $_POST['fecha_leido'] : null;
            }
            if (!empty($_POST['al_final'])) $libro->posicion = Libro::maxPosicion() + 1;
            $libro->guardar();
            // Reordenar a una posición concreta (solo aplica a pendientes)
            if (isset($_POST['nueva_pos']) && trim((string) $_POST['nueva_pos']) !== '' && $libro->estado === 'pendiente') {
                Libro::moverAPosicion((int) $libro->id, (int) $_POST['nueva_pos']);
            }
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
            if ($libro) { $libro->eliminar(); flash('Libro eliminado', 'eliminado'); }
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
