<?php

namespace Controllers;

use MVC\Router;
use Model\GymDia;

class GymController
{
    public static function index(Router $router)
    {
        protegerAdmin();
        $anio = (int) ($_GET['anio'] ?? date('Y'));
        $mes  = (int) ($_GET['mes']  ?? date('n'));
        if ($mes < 1 || $mes > 12) $mes = (int) date('n');
        $vista = ($_GET['vista'] ?? 'mes') === 'anio' ? 'anio' : 'mes';

        $router->render('admin/gym', [
            'titulo'   => 'Gym', 'modulo' => 'gym', 'usaCharts' => true,
            'vista'    => $vista,
            'anio'     => $anio, 'mes' => $mes,
            'dias'     => $vista === 'mes' ? GymDia::delMes($anio, $mes) : GymDia::delAnio($anio),
            'totales'  => GymDia::totales(),
            'porMes'   => GymDia::porMesAnioActual(),
        ], 'admin-layout');
    }

    // Cicla el estado de un día: sin registro -> Sí -> No -> sin registro
    public static function toggle()
    {
        protegerAdmin();
        header('Content-Type: application/json');
        $fecha = $_POST['fecha'] ?? '';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) { echo json_encode(['ok' => false]); exit; }

        $dia = GymDia::where('fecha', $fecha);
        $estado = 'none';
        if (!$dia) {
            $dia = new GymDia(['fecha' => $fecha, 'asistio' => 1]);
            $dia->guardar();
            $estado = 'si';
        } elseif ((int) $dia->asistio === 1) {
            $dia->asistio = 0; $dia->guardar();
            $estado = 'no';
        } else {
            $dia->eliminar();
            $estado = 'none';
        }

        echo json_encode([
            'ok'      => true,
            'estado'  => $estado,
            'totales' => GymDia::totales(),
            'porMes'  => GymDia::porMesAnioActual(),
        ]);
        exit;
    }
}
