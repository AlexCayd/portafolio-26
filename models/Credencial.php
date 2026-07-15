<?php

namespace Model;

class Credencial extends ActiveRecord {

    protected static $tabla = 'credenciales';
    protected static $columnasDB = ['id', 'logo', 'alt', 'anio', 'titulo', 'institucion', 'orden'];

    public $id;
    public $logo;
    public $alt;
    public $anio;
    public $titulo;
    public $institucion;
    public $orden;

    public function __construct($args = []) {
        $this->id          = $args['id']          ?? null;
        $this->logo        = $args['logo']        ?? '';
        $this->alt         = $args['alt']         ?? '';
        $this->anio        = $args['anio']        ?? null;
        $this->titulo      = $args['titulo']      ?? '';
        $this->institucion = $args['institucion'] ?? '';
        $this->orden       = $args['orden']       ?? 0;
    }

    public static function ordenados() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " ORDER BY orden ASC, id ASC");
    }
}
