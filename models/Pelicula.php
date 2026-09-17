<?php

namespace Model;

class Pelicula extends ActiveRecord {

    protected static $tabla = 'peliculas_series';
    protected static $columnasDB = ['id', 'categoria', 'es_serie', 'titulo', 'anio', 'duracion', 'nota', 'fecha_vista', 'poster', 'comentario', 'seleccion'];

    // Umbral de aprobación: nota >= 6
    const UMBRAL_APROBADO = 6;

    public $id;
    public $categoria;
    public $es_serie;       // 1 = formato serie (también un documental o reality que es serie)
    public $titulo;
    public $anio;
    public $duracion;
    public $nota;
    public $fecha_vista;
    public $poster;
    public $comentario;
    public $seleccion;

    // Directores / creadores. No es columna: vive en `pelicula_personas` y se
    // rellena con hidratarPersonas() o personas().
    public $personas = null;

    public function __construct($args = []) {
        $this->id          = $args['id']          ?? null;
        $this->categoria   = $args['categoria']   ?? '';
        $this->es_serie    = $args['es_serie']    ?? 0;
        $this->titulo      = $args['titulo']      ?? '';
        $this->anio        = $args['anio']        ?? null;
        $this->duracion    = $args['duracion']    ?? null;
        $this->nota        = $args['nota']        ?? 0;
        $this->fecha_vista = $args['fecha_vista'] ?? null;
        $this->poster      = $args['poster']      ?? null;
        $this->comentario  = $args['comentario']  ?? null;
        $this->seleccion   = $args['seleccion']   ?? 0;
    }

    /* ------------------------------------------------- Directores / creadores */

    // Nombres de este título (consulta perezosa; para listas usa hidratarPersonas)
    public function personas() : array {
        if ($this->personas === null) {
            $this->personas = $this->id ? PeliculaPersona::porPelicula((int) $this->id) : [];
        }
        return $this->personas;
    }

    // «A», «A y B», «A, B y C»
    public function personasTexto() : string {
        $n = $this->personas();
        if (!$n) return '';
        if (count($n) === 1) return $n[0];
        $ultimo = array_pop($n);
        return implode(', ', $n) . ' y ' . $ultimo;
    }

    // ¿Se conoce al director/creador?
    public function personaConocida() : bool {
        $n = $this->personas();
        return $n && $n[0] !== PeliculaPersona::DESCONOCIDO;
    }

    /**
     * Rellena `personas` de una lista completa con UNA sola consulta.
     * Obligatorio en catálogos y tablas: evita mil consultas sueltas.
     */
    public static function hidratarPersonas(array $peliculas) : array {
        if (!$peliculas) return $peliculas;
        $mapa = PeliculaPersona::mapa();
        foreach ($peliculas as $p) {
            $p->personas = $mapa[(int) $p->id] ?? [];
        }
        return $peliculas;
    }

    /**
     * Top N del año (estrenado Y visto en $anio) con su movimiento.
     *
     * El «antes» es el ranking de lo visto hasta el día anterior al último día
     * con fecha vista: todo lo visto ese día cuenta junto. Si ese día no movió
     * nada, el ranking entero sale sin cambios.
     *
     * Devuelve [['peli' => Pelicula, 'mov' => 'nuevo'|int], …] donde int > 0 es
     * que subió esos puestos, < 0 que bajó y 0 que no se movió.
     */
    public static function rankingAnio(array $todas, int $anio, int $n = 10) : array {
        $delAnio = array_values(array_filter($todas, fn($p) =>
            !empty($p->fecha_vista)
            && (int) date('Y', strtotime((string) $p->fecha_vista)) === $anio
            && (int) $p->anio === $anio
        ));

        // Un solo criterio para el ranking actual y los intermedios: nota, y a
        // igualdad, lo visto más recientemente primero.
        $orden = fn($a, $b) => [(float) $b->nota, (string) $b->fecha_vista, (int) $b->id]
                           <=> [(float) $a->nota, (string) $a->fecha_vista, (int) $a->id];
        $top = function (array $lista) use ($orden, $n) {
            usort($lista, $orden);
            return array_map(fn($p) => (int) $p->id, array_slice($lista, 0, $n));
        };

        $ultimoDia = $delAnio ? max(array_map(fn($p) => (string) $p->fecha_vista, $delAnio)) : '';
        $antes = $top(array_filter($delAnio, fn($p) => (string) $p->fecha_vista < $ultimoDia));

        $actual = $delAnio;
        usort($actual, $orden);
        $posAntes = array_flip($antes);
        $out = [];
        foreach (array_slice($actual, 0, $n) as $i => $p) {
            $id = (int) $p->id;
            $out[] = ['peli' => $p, 'mov' => isset($posAntes[$id]) ? $posAntes[$id] - $i : 'nuevo'];
        }
        return $out;
    }

    /**
     * Todos los registros con ese título exacto (sin distinguir mayúsculas).
     * Puede haber varios: remakes, series y películas homónimas. El formulario
     * los ofrece en «¿Te estás refiriendo a…?» antes de crear uno nuevo.
     */
    public static function porTituloTodos(string $titulo) : array {
        $t = self::$db->escape_string(trim($titulo));
        return self::hidratarPersonas(
            self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE LOWER(titulo) = LOWER('{$t}') ORDER BY anio DESC, fecha_vista DESC, id DESC")
        );
    }

    // Búsqueda para autocompletar (por título o por director/creador)
    public static function buscar(string $q) {
        $q = self::$db->escape_string($q);
        return self::consultarSQL("SELECT * FROM " . static::$tabla . "
                                   WHERE titulo LIKE '%{$q}%'
                                      OR id IN (SELECT pelicula_id FROM pelicula_personas WHERE nombre LIKE '%{$q}%')
                                   ORDER BY titulo ASC LIMIT 8");
    }

    // Autores/creadores distintos (autocompletar director)
    public static function buscarAutores(string $q) : array {
        $q = self::$db->escape_string($q);
        $desconocido = PeliculaPersona::DESCONOCIDO;
        $res = self::$db->query("SELECT DISTINCT nombre FROM pelicula_personas
                                 WHERE nombre LIKE '%{$q}%' AND nombre <> '{$desconocido}'
                                 ORDER BY nombre ASC LIMIT 8");
        $out = [];
        while ($r = $res->fetch_assoc()) { $out[] = $r['nombre']; }
        $res->free();
        return $out;
    }

    // ¿Aprobada? (nota >= umbral)
    public function estaAprobada() : bool {
        return (float) $this->nota >= self::UMBRAL_APROBADO;
    }

    /* ------------------------------------------------- Categoría y formato */

    /**
     * ¿Es serie? La categoría «Serie» siempre lo es; el resto solo si se marcó
     * (un documental o un reality en formato serie). Las series no llevan
     * duración y su persona es «Creador».
     */
    public function esSerie() : bool {
        return $this->categoria === Categoria::SERIE || (int) $this->es_serie === 1;
    }

    // «Documental · Serie» cuando la categoría se combina con serie; si no, la categoría sola
    public function categoriaTexto() : string {
        $cat = (string) $this->categoria;
        if ($cat !== Categoria::SERIE && (int) $this->es_serie === 1) return trim($cat . ' · Serie', ' ·');
        return $cat;
    }

    // Etiqueta de la persona: "Creador" para series, "Director" para el resto.
    // Se pluraliza sola cuando el título tiene más de una.
    public function personaLabel() : string {
        $plural = count($this->personas()) > 1;
        if ($this->esSerie()) return $plural ? 'Creadores' : 'Creador';
        return $plural ? 'Directores' : 'Director';
    }

    // Listas completas: se hidratan los directores de una sola consulta
    public static function ordenadas() {
        return self::hidratarPersonas(
            self::consultarSQL("SELECT * FROM " . static::$tabla . " ORDER BY fecha_vista DESC, id DESC")
        );
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
        return self::hidratarPersonas(
            self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE seleccion = 1 ORDER BY fecha_vista DESC, id DESC")
        );
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
