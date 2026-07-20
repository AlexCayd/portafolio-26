<?php

namespace Model;

class PatrimonioSnapshot extends ActiveRecord {

    protected static $tabla = 'patrimonio_snapshots';
    protected static $columnasDB = ['id', 'fecha', 'neto'];

    public $id;
    public $fecha;
    public $neto;

    public function __construct($args = []) {
        $this->id    = $args['id']    ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->neto  = $args['neto']  ?? 0;
    }

    // Guarda/actualiza el snapshot del mes actual (fechado al último día del mes)
    // con el neto vigente. Como se actualiza en cada visita, al cierre del mes
    // el punto histórico refleja el patrimonio neto de fin de mes.
    public static function registrarMes(float $neto) : void {
        $finMes  = date('Y-m-t');
        $primero = date('Y-m-01');
        $sigMes  = date('Y-m-01', strtotime('first day of next month'));
        $neto = self::$db->escape_string((string) $neto);
        // Limpia snapshots previos del mes en curso que no sean el de fin de mes
        // (compatibilidad con el esquema anterior fechado al día 1).
        self::$db->query("DELETE FROM " . static::$tabla . "
                          WHERE fecha >= '{$primero}' AND fecha < '{$sigMes}' AND fecha <> '{$finMes}'");
        self::$db->query("INSERT INTO " . static::$tabla . " (fecha, neto) VALUES ('{$finMes}', '{$neto}')
                          ON DUPLICATE KEY UPDATE neto = '{$neto}'");
    }

    // Serie de los últimos 12 meses => ['labels'=>[], 'data'=>[]]
    public static function serie() : array {
        $rows = self::consultarSQL("SELECT * FROM " . static::$tabla . " ORDER BY fecha ASC");
        $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        $labels = []; $data = [];
        foreach (array_slice($rows, -12) as $r) {
            $labels[] = $meses[(int) date('n', strtotime($r->fecha)) - 1] . ' ' . date('y', strtotime($r->fecha));
            $data[]   = (float) $r->neto;
        }
        return ['labels' => $labels, 'data' => $data];
    }
}
