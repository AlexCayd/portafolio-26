<?php

namespace Model;

class Visita extends ActiveRecord {

    protected static $tabla = 'visitas';
    protected static $columnasDB = ['id', 'fecha', 'total'];

    public $id;
    public $fecha;
    public $total;

    public function __construct($args = []) {
        $this->id    = $args['id']    ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->total = $args['total'] ?? 0;
    }

    // Registra una visita del día de hoy (contador incremental)
    public static function registrarHoy() : void {
        $hoy = date('Y-m-d');
        self::$db->query("INSERT INTO " . static::$tabla . " (fecha, total) VALUES ('{$hoy}', 1)
                          ON DUPLICATE KEY UPDATE total = total + 1");
    }

    // Registra una visita a una página concreta (contador por ruta)
    public static function registrarPagina(string $ruta, string $titulo) : void {
        $ruta   = self::$db->escape_string(mb_substr($ruta, 0, 191));
        $titulo = self::$db->escape_string(mb_substr($titulo, 0, 200));
        self::$db->query("INSERT INTO visitas_pagina (ruta, titulo, total) VALUES ('{$ruta}', '{$titulo}', 1)
                          ON DUPLICATE KEY UPDATE total = total + 1, titulo = VALUES(titulo)");
    }

    // Todas las páginas ordenadas por visitas (desc) => array de objetos {ruta, titulo, total}
    public static function paginasPorVisitas() : array {
        $rows = self::$db->query("SELECT ruta, titulo, total FROM visitas_pagina ORDER BY total DESC, titulo ASC");
        $out = [];
        while ($r = $rows->fetch_object()) { $out[] = $r; }
        return $out;
    }

    // Total diario de los últimos $dias días => ['labels'=>[], 'data'=>[]]
    public static function porDia(int $dias) : array {
        $desde = date('Y-m-d', strtotime("-" . ($dias - 1) . " days"));
        $rows = self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE fecha >= '{$desde}'");
        $map = [];
        foreach ($rows as $r) { $map[$r->fecha] = (int) $r->total; }
        $labels = []; $data = []; $total = 0;
        for ($i = $dias - 1; $i >= 0; $i--) {
            $f = date('Y-m-d', strtotime("-{$i} days"));
            $labels[] = date('d/m', strtotime($f));
            $v = $map[$f] ?? 0; $data[] = $v; $total += $v;
        }
        return ['labels' => $labels, 'data' => $data, 'total' => $total];
    }

    // Total mensual de los últimos $meses meses => ['labels'=>[], 'data'=>[], 'total'=>N]
    public static function porMes(int $meses = 12) : array {
        $desde = (int) $meses - 1;
        $rows = self::$db->query("SELECT DATE_FORMAT(fecha,'%Y-%m') AS ym, SUM(total) AS t
                                  FROM " . static::$tabla . "
                                  WHERE fecha >= DATE_FORMAT(CURDATE() - INTERVAL {$desde} MONTH, '%Y-%m-01')
                                  GROUP BY ym");
        $map = [];
        while ($r = $rows->fetch_assoc()) { $map[$r['ym']] = (int) $r['t']; }
        $nombres = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        $labels = []; $data = []; $total = 0;
        for ($i = $desde; $i >= 0; $i--) {
            $ym = date('Y-m', strtotime("first day of -{$i} month"));
            $labels[] = $nombres[(int) date('n', strtotime($ym . '-01')) - 1];
            $v = $map[$ym] ?? 0; $data[] = $v; $total += $v;
        }
        return ['labels' => $labels, 'data' => $data, 'total' => $total];
    }

    public static function totalGlobal() : int {
        $r = self::$db->query("SELECT COALESCE(SUM(total),0) AS t FROM " . static::$tabla)->fetch_assoc();
        return (int) $r['t'];
    }
}
