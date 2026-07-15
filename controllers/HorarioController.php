<?php

namespace Controllers;

use MVC\Router;
use Model\Materia;
use Model\HorarioBloque;

class HorarioController
{
    public static function index(Router $router)
    {
        protegerAdmin();
        $router->render('admin/horario', [
            'titulo'        => 'Horario', 'modulo' => 'horario', 'usaPdf' => true,
            'materias'      => Materia::ordenados(),
            'bloques'       => HorarioBloque::conMateria(),
            'totalCreditos' => Materia::totalCreditos(),
            'editando'      => isset($_GET['id']) ? Materia::find((int) $_GET['id']) : null,
        ], 'admin-layout');
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
