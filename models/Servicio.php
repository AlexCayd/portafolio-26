<?php

namespace Model;

class Servicio extends ActiveRecord {

    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'num', 'titulo', 'descripcion', 'tags', 'orden'];

    public $id;
    public $num;
    public $titulo;
    public $descripcion;
    public $tags;
    public $orden;

    public function __construct($args = []) {
        $this->id          = $args['id']          ?? null;
        $this->num         = $args['num']         ?? '';
        $this->titulo      = $args['titulo']      ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->tags        = $args['tags']        ?? '';
        $this->orden       = $args['orden']       ?? 0;
    }

    public static function ordenados() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " ORDER BY orden ASC, id ASC");
    }

    // Devuelve los tags como arreglo
    public function tagsArray() : array {
        return array_filter(array_map('trim', explode(',', (string) $this->tags)));
    }
}
