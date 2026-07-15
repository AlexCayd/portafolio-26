<?php

namespace Model;

class HorarioBloque extends ActiveRecord {

    protected static $tabla = 'horario_bloques';
    protected static $columnasDB = ['id', 'materia_id', 'dia', 'hora_inicio', 'hora_fin'];

    public $id;
    public $materia_id;
    public $dia;
    public $hora_inicio;
    public $hora_fin;

    public function __construct($args = []) {
        $this->id          = $args['id']          ?? null;
        $this->materia_id  = $args['materia_id']  ?? null;
        $this->dia         = $args['dia']         ?? 'lun';
        $this->hora_inicio = $args['hora_inicio'] ?? '07:00';
        $this->hora_fin    = $args['hora_fin']    ?? '08:30';
    }

    // Bloques unidos a su materia (color/nombre)
    public static function conMateria() : array {
        $sql = "SELECT b.*, m.nombre AS m_nombre, m.color AS m_color
                FROM horario_bloques b JOIN materias m ON m.id = b.materia_id";
        $resultado = self::$db->query($sql);
        $out = [];
        while ($r = $resultado->fetch_assoc()) { $out[] = $r; }
        return $out;
    }
}
