<?php

namespace Model;

class Pelicula extends ActiveRecord {

    protected static $tabla = 'peliculas_series';
    protected static $columnasDB = ['id', 'categoria', 'titulo', 'autor', 'anio', 'duracion', 'nota', 'fecha_vista', 'poster', 'comentario', 'seleccion'];

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
    public $seleccion;

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
        $this->seleccion   = $args['seleccion']   ?? 0;
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

    // Ficha pública por slug del título (no hay columna slug: se compara generado)
    public static function porSlug(string $slug) {
        foreach (self::ordenadas() as $p) {
            if (generarSlug($p->titulo) === $slug) return $p;
        }
        return null;
    }

    // Cuenta títulos con fecha_vista dentro de [$desde, $hasta]
    public static function contarPorRango(string $desde, string $hasta) : int {
        $desde = self::$db->escape_string($desde);
        $hasta = self::$db->escape_string($hasta);
        $r = self::$db->query("SELECT COUNT(*) AS c FROM " . static::$tabla . "
                               WHERE fecha_vista BETWEEN '{$desde}' AND '{$hasta}'")->fetch_assoc();
        return (int) $r['c'];
    }

    // Etiquetas de meses reutilizadas por las gráficas del panel
    const MESES = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];

    // Selección del autor: títulos marcados a mano desde el panel
    public static function perfectas() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE seleccion = 1 ORDER BY fecha_vista DESC, id DESC");
    }

    // Distribución de la selección por mes (Ene→Dic) de un año dado
    public static function perfectasPorMes(int $anio) : array {
        $anio = (int) $anio;
        $res = self::$db->query("SELECT MONTH(fecha_vista) AS m, COUNT(*) AS c FROM " . static::$tabla . "
                                 WHERE seleccion = 1 AND YEAR(fecha_vista) = {$anio} GROUP BY m");
        $map = [];
        while ($r = $res->fetch_assoc()) { $map[(int) $r['m']] = (int) $r['c']; }
        $labels = []; $data = [];
        for ($m = 1; $m <= 12; $m++) { $labels[] = self::MESES[$m - 1]; $data[] = $map[$m] ?? 0; }
        return ['labels' => $labels, 'data' => $data];
    }

    // Años (desc) que tienen al menos un título de la selección con fecha
    public static function aniosConPerfectas() : array {
        $res = self::$db->query("SELECT DISTINCT YEAR(fecha_vista) AS y FROM " . static::$tabla . "
                                 WHERE seleccion = 1 AND fecha_vista IS NOT NULL ORDER BY y DESC");
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
        $labels = []; $data = [];
        for ($m = 1; $m <= $mesActual; $m++) { $labels[] = self::MESES[$m - 1]; $data[] = $map[$m] ?? 0; }
        return ['labels' => $labels, 'data' => $data];
    }

    /**
     * Vistos por mes agrupados por año de la fecha_vista.
     * Devuelve ['2025' => [12 enteros], …, 'Todos' => [12 enteros sumados]].
     * Alimenta la gráfica con selector de año del dashboard.
     */
    public static function vistosPorMesPorAnio() : array {
        $res = self::$db->query("SELECT YEAR(fecha_vista) AS y, MONTH(fecha_vista) AS m, COUNT(*) AS c
                                 FROM " . static::$tabla . "
                                 WHERE fecha_vista IS NOT NULL
                                 GROUP BY y, m ORDER BY y DESC");
        $out = [];
        $todos = array_fill(0, 12, 0);
        while ($r = $res->fetch_assoc()) {
            $y = (string) (int) $r['y'];
            $m = (int) $r['m'];
            if (!$y || !$m) continue;
            if (!isset($out[$y])) $out[$y] = array_fill(0, 12, 0);
            $out[$y][$m - 1] += (int) $r['c'];
            $todos[$m - 1]   += (int) $r['c'];
        }
        $out['Todos'] = $todos;
        return $out;
    }
}
