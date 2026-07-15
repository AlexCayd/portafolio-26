<?php

namespace Model;

class Deuda extends ActiveRecord {

    protected static $tabla = 'deudas';
    protected static $columnasDB = ['id', 'nombre', 'monto', 'orden'];

    public $id;
    public $nombre;
    public $monto;
    public $orden;

    public function __construct($args = []) {
        $this->id     = $args['id']     ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->monto  = $args['monto']  ?? 0;
        $this->orden  = $args['orden']  ?? 0;
    }

    public static function ordenados() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " ORDER BY orden ASC, id ASC");
    }

    public static function total() : float {
        $r = self::$db->query("SELECT COALESCE(SUM(monto),0) AS t FROM " . static::$tabla)->fetch_assoc();
        return (float) $r['t'];
    }
}
