<?php

namespace Model;

class Pelicula extends ActiveRecord {

    protected static $tabla = 'peliculas_series';
    protected static $columnasDB = ['id', 'categoria', 'titulo', 'autor', 'anio', 'duracion', 'nota', 'fecha_vista', 'poster', 'comentario'];

    // Umbral de aprobación: nota >= 6
    const UMBRAL_APROBADO = 6;

    public $id;
    public $categoria;
    public $titulo;
    public $autor;
    public $anio;
    public $duracion;
    public $nota;
    public $fecha_vista;
    public $poster;
    public $comentario;

    public function __construct($args = []) {
        $this->id          = $args['id']          ?? null;
        $this->categoria   = $args['categoria']   ?? '';
        $this->titulo      = $args['titulo']      ?? '';
        $this->autor       = $args['autor']       ?? '';
        $this->anio        = $args['anio']        ?? null;
        $this->duracion    = $args['duracion']    ?? null;
        $this->nota        = $args['nota']        ?? 0;
        $this->fecha_vista = $args['fecha_vista'] ?? null;
        $this->poster      = $args['poster']      ?? null;
        $this->comentario  = $args['comentario']  ?? null;
    }

    // Busca un título existente por nombre exacto (case-insensitive)
    public static function porTitulo(string $titulo) {
        $t = self::$db->escape_string(trim($titulo));
        $r = self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE LOWER(titulo) = LOWER('{$t}') LIMIT 1");
        return array_shift($r);
    }

    // Búsqueda para autocompletar
    public static function buscar(string $q) {
        $q = self::$db->escape_string($q);
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE titulo LIKE '%{$q}%' OR autor LIKE '%{$q}%' ORDER BY titulo ASC LIMIT 8");
    }

    // Autores/creadores distintos (autocompletar director)
    public static function buscarAutores(string $q) : array {
        $q = self::$db->escape_string($q);
        $res = self::$db->query("SELECT DISTINCT autor FROM " . static::$tabla . " WHERE autor LIKE '%{$q}%' AND autor <> '' AND autor <> '—' ORDER BY autor ASC LIMIT 8");
        $out = [];
        while ($r = $res->fetch_assoc()) { $out[] = $r['autor']; }
        return $out;
    }

    // ¿Aprobada? (nota >= umbral)
    public function estaAprobada() : bool {
        return (float) $this->nota >= self::UMBRAL_APROBADO;
    }

    // Etiqueta de la persona: "Creador" para series, "Director" para el resto
    public function personaLabel() : string {
        return $this->categoria === 'Serie' ? 'Creador' : 'Director';
    }

    public static function ordenadas() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " ORDER BY fecha_vista DESC, id DESC");
    }

    // Selección del autor: títulos con calificación perfecta (10/10)
    public static function perfectas() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE nota >= 10 ORDER BY fecha_vista DESC, id DESC");
    }

    // Distribución de 10/10 por mes (Ene→Dic) de un año dado
    public static function perfectasPorMes(int $anio) : array {
        $anio = (int) $anio;
        $res = self::$db->query("SELECT MONTH(fecha_vista) AS m, COUNT(*) AS c FROM " . static::$tabla . "
                                 WHERE nota >= 10 AND YEAR(fecha_vista) = {$anio} GROUP BY m");
        $map = [];
        while ($r = $res->fetch_assoc()) { $map[(int) $r['m']] = (int) $r['c']; }
        $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        $labels = []; $data = [];
        for ($m = 1; $m <= 12; $m++) { $labels[] = $meses[$m - 1]; $data[] = $map[$m] ?? 0; }
        return ['labels' => $labels, 'data' => $data];
    }

    // Años (desc) que tienen al menos un 10/10 con fecha
    public static function aniosConPerfectas() : array {
        $res = self::$db->query("SELECT DISTINCT YEAR(fecha_vista) AS y FROM " . static::$tabla . "
                                 WHERE nota >= 10 AND fecha_vista IS NOT NULL ORDER BY y DESC");
        $out = [];
        while ($r = $res->fetch_assoc()) { if ($r['y']) $out[] = (int) $r['y']; }
        return $out;
    }

    // Títulos vistos por mes del año actual (Ene → mes presente)
    public static function porMesAnioActual() : array {
        $anio = (int) date('Y');
        $mesActual = (int) date('n');
        $res = self::$db->query("SELECT MONTH(fecha_vista) AS m, COUNT(*) AS c FROM " . static::$tabla . "
                                 WHERE YEAR(fecha_vista) = {$anio} GROUP BY m");
        $map = [];
        while ($r = $res->fetch_assoc()) { $map[(int) $r['m']] = (int) $r['c']; }
        $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        $labels = []; $data = [];
        for ($m = 1; $m <= $mesActual; $m++) { $labels[] = $meses[$m - 1]; $data[] = $map[$m] ?? 0; }
        return ['labels' => $labels, 'data' => $data];
    }
}
