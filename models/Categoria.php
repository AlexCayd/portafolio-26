<?php

namespace Model;

class Categoria extends ActiveRecord {

    protected static $tabla = 'pys_categorias';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;

    public function __construct($args = []) {
        $this->id     = $args['id']     ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }

    public static function todas() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " ORDER BY nombre ASC");
    }
}
