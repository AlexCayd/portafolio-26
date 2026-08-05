<?php

namespace Controllers;

use MVC\Router;
use Model\GymDia;

class GymController
{
    const MESES = [1=>'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

    public static function index(Router $router)
    {
        protegerAdmin();
        [$anio, $mes, $vista] = self::ambitoPedido();

        $router->render('admin/gym', [
            'titulo'   => 'Gym', 'modulo' => 'gym', 'usaCharts' => true,
            'vista'    => $vista,
            'anio'     => $anio, 'mes' => $mes,
            'dias'     => $vista === 'mes' ? GymDia::delMes($anio, $mes) : GymDia::delAnio($anio),
            'ambito'   => self::etiqueta($anio, $mes, $vista),
            'totales'  => self::totalesDelAmbito($anio, $mes, $vista),
            'serie'    => self::serieDelAmbito($anio, $mes, $vista),
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

        // Se recalcula en el mismo ámbito que está viendo la página, para que
        // el refresco sin recarga no salte al año en curso.
        [$anio, $mes, $vista] = self::ambitoPedido();

        echo json_encode([
            'ok'      => true,
            'estado'  => $estado,
            'totales' => self::totalesDelAmbito($anio, $mes, $vista),
            'serie'   => self::serieDelAmbito($anio, $mes, $vista),
        ]);
        exit;
    }

    /* =============================================================== Helpers */

    // Año / mes / vista pedidos, normalizados. Sirve para GET y para POST.
    private static function ambitoPedido() : array
    {
        $datos = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
        $anio = (int) ($datos['anio'] ?? date('Y'));
        if ($anio < 1970 || $anio > 2999) $anio = (int) date('Y');
        $mes  = (int) ($datos['mes'] ?? date('n'));
        if ($mes < 1 || $mes > 12) $mes = (int) date('n');
        $vista = ($datos['vista'] ?? 'mes') === 'anio' ? 'anio' : 'mes';
        return [$anio, $mes, $vista];
    }

    private static function etiqueta(int $anio, int $mes, string $vista) : string
    {
        return $vista === 'mes' ? self::MESES[$mes] . ' ' . $anio : 'Año ' . $anio;
    }

    // KPIs y dona: del mes seleccionado o del año completo
    private static function totalesDelAmbito(int $anio, int $mes, string $vista) : array
    {
        if ($vista === 'mes') {
            $inicio = sprintf('%04d-%02d-01', $anio, $mes);
            return GymDia::totalesRango($inicio, date('Y-m-t', strtotime($inicio)));
        }
        return GymDia::totalesRango("{$anio}-01-01", "{$anio}-12-31");
    }

    // Barras: día a día de TODO el año en la vista de mes (esta gráfica siempre es
    // del año completo, aunque el calendario y los KPIs estén en un mes), y mes a
    // mes en la vista de año.
    private static function serieDelAmbito(int $anio, int $mes, string $vista) : array
    {
        $serie = $vista === 'mes' ? GymDia::porDiaAnio($anio) : GymDia::porMes($anio);
        $serie['diaria'] = $vista === 'mes';
        $serie['titulo'] = $vista === 'mes'
            ? 'Asistencias por día — ' . $anio
            : 'Asistencias por mes — ' . $anio;
        $serie['sub'] = $vista === 'mes'
            ? ($anio === (int) date('Y') ? 'Cada barra es un día del año, de enero a hoy' : 'Cada barra es un día del año')
            : ($anio === (int) date('Y') ? 'De enero al mes actual' : 'Los doce meses del año');
        return $serie;
    }
}
