<?php

namespace Model;

class Proyecto extends ActiveRecord {

    protected static $tabla = 'proyectos';
    protected static $columnasDB = ['id', 'titulo', 'slug', 'anio', 'img', 'descripcion', 'orden'];

    public $id;
    public $titulo;
    public $slug;
    public $anio;
    public $img;
    public $descripcion;
    public $orden;

    public function __construct($args = []) {
        $this->id          = $args['id']          ?? null;
        $this->titulo      = $args['titulo']      ?? '';
        $this->slug        = $args['slug']        ?? '';
        $this->anio        = $args['anio']        ?? '';
        $this->img         = $args['img']         ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->orden       = $args['orden']       ?? 0;
    }

    // Todos los proyectos ordenados para el slider
    public static function ordenados() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " ORDER BY orden ASC, id ASC");
    }

    // Busca por slug (público)
    public static function porSlug(string $slug) {
        $slug = self::$db->escape_string($slug);
        $r = self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE slug = '{$slug}' LIMIT 1");
        return array_shift($r);
    }
}
