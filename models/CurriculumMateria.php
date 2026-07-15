<?php

namespace Model;

class CurriculumMateria extends ActiveRecord {

    protected static $tabla = 'curriculum_materias';
    protected static $columnasDB = ['id', 'mapa', 'semestre', 'fila', 'codigo', 'nombre', 'estado'];

    const ESTADOS = ['bloqueada', 'desbloqueada', 'cursando', 'completado'];

    public $id;
    public $mapa;
    public $semestre;
    public $fila;
    public $codigo;
    public $nombre;
    public $estado;

    public function __construct($args = []) {
        $this->id       = $args['id']       ?? null;
        $this->mapa     = $args['mapa']     ?? 'anahuac';
        $this->semestre = $args['semestre'] ?? 1;
        $this->fila     = $args['fila']     ?? 0;
        $this->codigo   = $args['codigo']   ?? null;
        $this->nombre   = $args['nombre']   ?? '';
        $this->estado   = $args['estado']   ?? 'bloqueada';
    }

    // Materias de un mapa agrupadas por semestre
    public static function porMapa(string $mapa) : array {
        $mapa = self::$db->escape_string($mapa);
        $rows = self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE mapa = '{$mapa}' ORDER BY semestre ASC, fila ASC");
        $grupos = [];
        foreach ($rows as $r) { $grupos[(int) $r->semestre][] = $r; }
        ksort($grupos);
        return $grupos;
    }

    // Siguiente estado en el ciclo
    public function siguienteEstado() : string {
        $i = array_search($this->estado, self::ESTADOS, true);
        if ($i === false) $i = 0;
        return self::ESTADOS[($i + 1) % count(self::ESTADOS)];
    }
}
