<?php

namespace Model;

class BlogCategoria extends ActiveRecord {

    protected static $tabla = 'blog_categorias';
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
