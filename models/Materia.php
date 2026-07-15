<?php

namespace Model;

class Materia extends ActiveRecord {

    protected static $tabla = 'materias';
    protected static $columnasDB = ['id', 'nombre', 'profesor', 'nrc', 'creditos', 'color', 'orden'];

    public $id;
    public $nombre;
    public $profesor;
    public $nrc;
    public $creditos;
    public $color;
    public $orden;

    public function __construct($args = []) {
        $this->id       = $args['id']       ?? null;
        $this->nombre   = $args['nombre']   ?? '';
        $this->profesor = $args['profesor'] ?? '';
        $this->nrc      = $args['nrc']      ?? '';
        $this->creditos = $args['creditos'] ?? 0;
        $this->color    = $args['color']    ?? '#4267AC';
        $this->orden    = $args['orden']    ?? 0;
    }

    public static function ordenados() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " ORDER BY orden ASC, id ASC");
    }

    public static function totalCreditos() : float {
        $r = self::$db->query("SELECT COALESCE(SUM(creditos),0) AS t FROM " . static::$tabla)->fetch_assoc();
        return (float) $r['t'];
    }
}
