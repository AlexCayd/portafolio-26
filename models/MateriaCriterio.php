<?php

namespace Model;

class MateriaCriterio extends ActiveRecord {

    protected static $tabla = 'materia_criterios';
    protected static $columnasDB = ['id', 'materia_id', 'nombre', 'peso', 'calificacion', 'orden'];

    public $id;
    public $materia_id;
    public $nombre;
    public $peso;
    public $calificacion;
    public $orden;

    public function __construct($args = []) {
        $this->id           = $args['id']           ?? null;
        $this->materia_id   = $args['materia_id']   ?? null;
        $this->nombre       = $args['nombre']       ?? '';
        $this->peso         = $args['peso']         ?? 0;
        $this->calificacion = $args['calificacion'] ?? 0;
        $this->orden        = $args['orden']        ?? 0;
    }

    // Criterios de una materia, en orden
    public static function porMateria(int $materiaId) : array {
        $materiaId = (int) $materiaId;
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE materia_id = {$materiaId} ORDER BY orden ASC, id ASC");
    }

    // Borra todos los criterios de una materia (para reemplazar el set)
    public static function eliminarPorMateria(int $materiaId) : void {
        $materiaId = (int) $materiaId;
        self::$db->query("DELETE FROM " . static::$tabla . " WHERE materia_id = {$materiaId}");
    }
}
