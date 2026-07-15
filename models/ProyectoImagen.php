<?php

namespace Model;

class ProyectoImagen extends ActiveRecord {

    protected static $tabla = 'proyecto_imagenes';
    protected static $columnasDB = ['id', 'proyecto_id', 'img', 'orden'];

    public $id;
    public $proyecto_id;
    public $img;
    public $orden;

    public function __construct($args = []) {
        $this->id          = $args['id']          ?? null;
        $this->proyecto_id = $args['proyecto_id'] ?? null;
        $this->img         = $args['img']         ?? '';
        $this->orden       = $args['orden']       ?? 0;
    }

    // Imágenes de un proyecto
    public static function porProyecto(int $proyectoId) : array {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE proyecto_id = {$proyectoId} ORDER BY orden ASC, id ASC");
    }
}
