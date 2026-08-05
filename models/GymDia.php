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

    const MESES = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];

    /**
     * Asistencias por mes de un año (Ene → Dic; si es el año en curso corta
     * en el mes actual para no dibujar meses que todavía no ocurren).
     */
    public static function porMes(int $anio) : array {
        $anio = (int) $anio;
        $hasta = $anio === (int) date('Y') ? (int) date('n') : 12;
        $res = self::$db->query("SELECT MONTH(fecha) AS m,
                                        SUM(asistio = 1) AS si,
                                        SUM(asistio = 0) AS no
                                 FROM " . static::$tabla . "
                                 WHERE YEAR(fecha) = {$anio} GROUP BY m");
        $si = []; $no = [];
        while ($r = $res->fetch_assoc()) { $si[(int) $r['m']] = (int) $r['si']; $no[(int) $r['m']] = (int) $r['no']; }
        $labels = []; $dSi = []; $dNo = [];
        for ($m = 1; $m <= $hasta; $m++) { $labels[] = self::MESES[$m - 1]; $dSi[] = $si[$m] ?? 0; $dNo[] = $no[$m] ?? 0; }
        return ['labels' => $labels, 'si' => $dSi, 'no' => $dNo];
    }

    // Asistencias día a día de un mes (1 → último día del mes)
    public static function porDia(int $anio, int $mes) : array {
        $inicio = sprintf('%04d-%02d-01', $anio, $mes);
        $dias   = (int) date('t', strtotime($inicio));
        $mapa   = self::delMes($anio, $mes);
        $labels = []; $si = []; $no = [];
        for ($d = 1; $d <= $dias; $d++) {
            $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, $d);
            $labels[] = (string) $d;
            $estado = $mapa[$fecha] ?? null;
            $si[] = $estado === 1 ? 1 : 0;
            $no[] = $estado === 0 ? 1 : 0;
        }
        return ['labels' => $labels, 'si' => $si, 'no' => $no];
    }

    /**
     * Asistencias día a día de TODO un año (1 ene → 31 dic; si es el año en curso
     * corta en hoy). Las etiquetas son la fecha ISO: la vista decide cómo pintarlas.
     */
    public static function porDiaAnio(int $anio) : array {
        $anio  = (int) $anio;
        $mapa  = self::delAnio($anio);
        $ini   = strtotime(sprintf('%04d-01-01', $anio));
        $fin   = $anio === (int) date('Y') ? strtotime(date('Y-m-d')) : strtotime(sprintf('%04d-12-31', $anio));
        $labels = []; $si = []; $no = [];
        for ($t = $ini; $t <= $fin; $t = strtotime('+1 day', $t)) {
            $fecha = date('Y-m-d', $t);
            $labels[] = $fecha;
            $estado = $mapa[$fecha] ?? null;
            $si[] = $estado === 1 ? 1 : 0;
            $no[] = $estado === 0 ? 1 : 0;
        }
        return ['labels' => $labels, 'si' => $si, 'no' => $no];
    }

    // Totales de un rango de fechas (inclusive): ['si'=>, 'no'=>]
    public static function totalesRango(string $desde, string $hasta) : array {
        $desde = self::$db->escape_string($desde);
        $hasta = self::$db->escape_string($hasta);
        $r = self::$db->query("SELECT SUM(asistio = 1) AS si, SUM(asistio = 0) AS no
                               FROM " . static::$tabla . "
                               WHERE fecha BETWEEN '{$desde}' AND '{$hasta}'")->fetch_assoc();
        return ['si' => (int) $r['si'], 'no' => (int) $r['no']];
    }

    // Totales globales: ['si'=>, 'no'=>]
    public static function totales() : array {
        $r = self::$db->query("SELECT SUM(asistio = 1) AS si, SUM(asistio = 0) AS no FROM " . static::$tabla)->fetch_assoc();
        return ['si' => (int) $r['si'], 'no' => (int) $r['no']];
    }
}
