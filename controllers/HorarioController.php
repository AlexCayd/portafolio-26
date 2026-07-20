<?php

namespace Controllers;

use MVC\Router;
use Model\Materia;
use Model\HorarioBloque;
use Model\MateriaCriterio;

class HorarioController
{
    public static function index(Router $router)
    {
        protegerAdmin();
        // Criterios de evaluación por materia (simulador de calificaciones)
        $criterios = [];
        foreach (Materia::ordenados() as $m) {
            $criterios[(int) $m->id] = MateriaCriterio::porMateria((int) $m->id);
        }
        $router->render('admin/horario', [
            'titulo'        => 'Horario', 'modulo' => 'horario', 'usaPdf' => true,
            'materias'      => Materia::ordenados(),
            'bloques'       => HorarioBloque::conMateria(),
            'totalCreditos' => Materia::totalCreditos(),
            'criterios'     => $criterios,
            'editando'      => isset($_GET['id']) ? Materia::find((int) $_GET['id']) : null,
        ], 'admin-layout');
    }

    // Reemplaza el set de criterios de una materia (nombre[], peso[], calificacion[])
    public static function guardarCriterios()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['materia_id'])) {
            $materiaId = (int) $_POST['materia_id'];
            MateriaCriterio::eliminarPorMateria($materiaId);
            $nombres = $_POST['nombre'] ?? [];
            $pesos   = $_POST['peso'] ?? [];
            $califs  = $_POST['calificacion'] ?? [];
            $orden = 0;
            if (is_array($nombres)) {
                foreach ($nombres as $i => $nombre) {
                    $nombre = trim($nombre);
                    $peso   = (float) ($pesos[$i] ?? 0);
                    $calif  = (float) ($califs[$i] ?? 0);
                    // Ignora filas totalmente vacías
                    if ($nombre === '' && $peso == 0 && $calif == 0) continue;
                    (new MateriaCriterio([
                        'materia_id'   => $materiaId,
                        'nombre'       => $nombre,
                        'peso'         => max(0, $peso),
                        'calificacion' => max(0, $calif),
                        'orden'        => ++$orden,
                    ]))->guardar();
                }
            }
            flash('Criterios guardados', 'editado');
        }
        header('Location: /admin/horario'); exit;
    }

    public static function guardarMateria()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $m = new Materia($_POST);
            $m->creditos = (float) ($_POST['creditos'] ?? 0);
            $m->id = !empty($_POST['id']) ? (int) $_POST['id'] : null;
            if (!$m->id) $m->orden = count(Materia::all()) + 1;
            $m->guardar();
            flash($m->id && !empty($_POST['id']) ? 'Materia actualizada' : 'Materia agregada', !empty($_POST['id']) ? 'editado' : 'ok');
        }
        header('Location: /admin/horario'); exit;
    }

    public static function eliminarMateria()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $m = Materia::find((int) $_POST['id']);
            if ($m) { $m->eliminar(); flash('Materia eliminada', 'eliminado'); } // bloques por ON DELETE CASCADE
        }
        header('Location: /admin/horario'); exit;
    }

    // Acepta un solo bloque o un lote (dia[], hora_inicio[], hora_fin[])
    public static function guardarBloque()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['materia_id'])) {
            $materiaId = (int) $_POST['materia_id'];
            $dias = $_POST['dia'] ?? [];
            $his  = $_POST['hora_inicio'] ?? [];
            $hfs  = $_POST['hora_fin'] ?? [];
            $n = 0;
            if (is_array($dias)) {
                foreach ($dias as $i => $dia) {
                    if (empty($his[$i]) || empty($hfs[$i])) continue;
                    (new HorarioBloque([
                        'materia_id'  => $materiaId,
                        'dia'         => $dia,
                        'hora_inicio' => $his[$i],
                        'hora_fin'    => $hfs[$i],
                    ]))->guardar();
                    $n++;
                }
            } elseif (!empty($_POST['dia'])) {
                $b = new HorarioBloque($_POST);
                $b->materia_id = $materiaId;
                $b->guardar();
                $n = 1;
            }
            if ($n) flash($n === 1 ? 'Bloque agregado' : $n . ' bloques agregados', 'ok');
        }
        header('Location: /admin/horario'); exit;
    }

    public static function eliminarBloque()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $b = HorarioBloque::find((int) $_POST['id']);
            if ($b) { $b->eliminar(); flash('Bloque eliminado', 'eliminado'); }
        }
        header('Location: /admin/horario'); exit;
    }
}
