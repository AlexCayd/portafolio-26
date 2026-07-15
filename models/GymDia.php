<?php

namespace Model;

class GymDia extends ActiveRecord {

    protected static $tabla = 'gym_dias';
    protected static $columnasDB = ['id', 'fecha', 'asistio'];

    public $id;
    public $fecha;
    public $asistio;

    public function __construct($args = []) {
        $this->id      = $args['id']      ?? null;
        $this->fecha   = $args['fecha']   ?? null;
        $this->asistio = $args['asistio'] ?? 0;
    }

    // Mapa fecha(Y-m-d) => asistio para un mes dado
    public static function delMes(int $anio, int $mes) : array {
        $inicio = sprintf('%04d-%02d-01', $anio, $mes);
        $fin    = date('Y-m-t', strtotime($inicio));
        $rows = self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE fecha BETWEEN '{$inicio}' AND '{$fin}'");
        $map = [];
        foreach ($rows as $r) { $map[$r->fecha] = (int) $r->asistio; }
        return $map;
    }

    // Mapa fecha => asistio para todo un año
    public static function delAnio(int $anio) : array {
        $rows = self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE YEAR(fecha) = {$anio}");
        $map = [];
        foreach ($rows as $r) { $map[$r->fecha] = (int) $r->asistio; }
        return $map;
    }

    // Asistencias (Sí) por mes del año actual (Ene → mes presente)
    public static function porMesAnioActual() : array {
        $anio = (int) date('Y');
        $mesActual = (int) date('n');
        $res = self::$db->query("SELECT MONTH(fecha) AS m, SUM(asistio) AS s FROM " . static::$tabla . "
                                 WHERE YEAR(fecha) = {$anio} GROUP BY m");
        $map = [];
        while ($r = $res->fetch_assoc()) { $map[(int) $r['m']] = (int) $r['s']; }
        $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        $labels = []; $data = [];
        for ($m = 1; $m <= $mesActual; $m++) { $labels[] = $meses[$m - 1]; $data[] = $map[$m] ?? 0; }
        return ['labels' => $labels, 'data' => $data];
    }

    // Totales globales: ['si'=>, 'no'=>]
    public static function totales() : array {
        $rows = self::all();
        $si = 0; $no = 0;
        foreach ($rows as $r) { ((int)$r->asistio === 1) ? $si++ : $no++; }
        return ['si' => $si, 'no' => $no];
    }
}
