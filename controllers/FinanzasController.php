<?php

namespace Controllers;

use MVC\Router;
use Model\Activo;
use Model\Deuda;
use Model\CuentaPorCobrar;
use Model\PatrimonioSnapshot;

class FinanzasController
{
    // tipo => [modelo, campo-nombre]
    private static function mapa() : array
    {
        return [
            'activo' => [Activo::class, 'nombre'],
            'deuda'  => [Deuda::class, 'nombre'],
            'cobrar' => [CuentaPorCobrar::class, 'nombre'],
        ];
    }

    public static function index(Router $router)
    {
        protegerAdmin();
        $totActivos = Activo::total();
        $totDeudas  = Deuda::total();
        $totCobrar  = CuentaPorCobrar::total();
        $neto = $totActivos + $totCobrar - $totDeudas;

        // Guardar/actualizar el snapshot del mes actual con el neto vigente
        PatrimonioSnapshot::registrarMes($neto);

        $router->render('admin/finanzas', [
            'titulo' => 'Finanzas', 'modulo' => 'finanzas', 'usaCharts' => true,
            'activos'  => Activo::ordenados(),
            'deudas'   => Deuda::ordenados(),
            'cobrar'   => CuentaPorCobrar::ordenados(),
            'totActivos' => $totActivos,
            'totDeudas'  => $totDeudas,
            'totCobrar'  => $totCobrar,
            'neto'       => $neto,
            'historial'  => PatrimonioSnapshot::serie(),
        ], 'admin-layout');
    }

    public static function guardar()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mapa = self::mapa();
            $tipo = $_POST['tipo'] ?? '';
            if (isset($mapa[$tipo])) {
                [$modelo, $campo] = $mapa[$tipo];
                $obj = new $modelo([
                    $campo  => trim($_POST['nombre'] ?? ''),
                    'monto' => (float) ($_POST['monto'] ?? 0),
                ]);
                $obj->orden = count($modelo::all()) + 1;
                if (trim($_POST['nombre'] ?? '') !== '') { $obj->guardar(); flash('Registro agregado', 'ok'); }
            }
        }
        header('Location: /admin/finanzas'); exit;
    }

    public static function actualizar()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mapa = self::mapa();
            $tipo = $_POST['tipo'] ?? '';
            if (isset($mapa[$tipo]) && !empty($_POST['id'])) {
                [$modelo, $campo] = $mapa[$tipo];
                $obj = $modelo::find((int) $_POST['id']);
                if ($obj) {
                    $nombre = trim($_POST['nombre'] ?? '');
                    if ($nombre !== '') $obj->$campo = $nombre;
                    $obj->monto = (float) ($_POST['monto'] ?? 0);
                    $obj->guardar();
                    flash('Registro actualizado', 'editado');
                }
            }
        }
        header('Location: /admin/finanzas'); exit;
    }

    public static function eliminar()
    {
        protegerAdmin();
        $mapa = self::mapa();
        $tipo = $_POST['tipo'] ?? '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($mapa[$tipo]) && !empty($_POST['id'])) {
            $modelo = $mapa[$tipo][0];
            $obj = $modelo::find((int) $_POST['id']);
            if ($obj) { $obj->eliminar(); flash('Registro eliminado', 'eliminado'); }
        }
        header('Location: /admin/finanzas'); exit;
    }
}
