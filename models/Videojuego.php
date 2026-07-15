<?php

namespace Model;

class Videojuego extends ActiveRecord {

    protected static $tabla = 'videojuegos';
    protected static $columnasDB = ['id', 'nombre', 'horas_iniciales', 'horas_totales', 'portada', 'orden'];

    public $id;
    public $nombre;
    public $horas_iniciales;
    public $horas_totales;
    public $portada;
    public $orden;

    public function __construct($args = []) {
        $this->id              = $args['id']              ?? null;
        $this->nombre          = $args['nombre']          ?? '';
        $this->horas_iniciales = $args['horas_iniciales'] ?? 0;
        $this->horas_totales   = $args['horas_totales']   ?? null;
        $this->portada         = $args['portada']         ?? null;
        $this->orden           = $args['orden']           ?? 0;
    }

    // Horas jugadas en 2026 = totales - iniciales (null si no hay totales)
    public function horas2026() : ?float {
        if ($this->horas_totales === null || $this->horas_totales === '') return null;
        return round((float) $this->horas_totales - (float) $this->horas_iniciales, 1);
    }

    public static function ordenados() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " ORDER BY orden ASC, id ASC");
    }
}
