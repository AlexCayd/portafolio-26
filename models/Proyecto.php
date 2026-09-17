<?php

namespace Model;

class Proyecto extends ActiveRecord {

    protected static $tabla = 'proyectos';
    protected static $columnasDB = ['id', 'titulo', 'slug', 'anio', 'img', 'resumen',
                                    'contexto', 'enlace', 'orden'];

    // Encabezados de los dos bloques fijos de la ficha
    const T_CONTEXTO = 'Contexto';
    const T_GALERIA  = 'Galería';

    public $id;
    public $titulo;
    public $slug;
    public $anio;
    public $img;
    public $resumen;
    public $contexto;
    public $enlace;
    public $orden;

    public function __construct($args = []) {
        $this->id       = $args['id']       ?? null;
        $this->titulo   = $args['titulo']   ?? '';
        $this->slug     = $args['slug']     ?? '';
        $this->anio     = $args['anio']     ?? '';
        $this->img      = $args['img']      ?? '';
        $this->resumen  = $args['resumen']  ?? '';
        $this->contexto = $args['contexto'] ?? '';
        $this->enlace   = $args['enlace']   ?? '';
        $this->orden    = $args['orden']    ?? 0;
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

    /**
     * Secciones de la ficha pública, ya en el orden en que se pintan:
     *   01 Contexto  ·  02 Galería  ·  03..N las secciones del panel.
     * Cada bloque: ['tipo' => 'texto'|'galeria', 'titulo', 'piezas'].
     */
    public function bloques(array $secciones = [], bool $hayGaleria = false) : array {
        $out = [];
        if (trim((string) $this->contexto) !== '') {
            $out[] = ['tipo' => 'texto', 'titulo' => self::T_CONTEXTO, 'piezas' => self::piezas($this->contexto)];
        }
        if ($hayGaleria) {
            $out[] = ['tipo' => 'galeria', 'titulo' => self::T_GALERIA, 'piezas' => []];
        }
        foreach ($secciones as $s) {
            $out[] = ['tipo' => 'texto', 'titulo' => (string) $s->titulo, 'piezas' => self::piezas($s->cuerpo)];
        }
        return $out;
    }

    // Resumen para la meta description: el explícito o el primer párrafo útil
    public function resumenMeta() : string {
        if (trim((string) $this->resumen) !== '') return $this->resumen;
        foreach (self::piezas($this->contexto) as $p) {
            if ($p['tipo'] === 'parrafo') return $p['texto'];
        }
        return '';
    }

    /**
     * Cuerpo libre de una sección → párrafos en el orden en que se escribieron:
     *   ['tipo' => 'parrafo', 'texto' => …]
     *
     * Los párrafos se separan con una línea en blanco; los saltos simples dentro
     * de un bloque se unen con un espacio. No hay otro formato: todas las
     * fichas se pintan igual, aunque el texto traiga líneas «Etiqueta: texto».
     */
    public static function piezas(?string $texto) : array {
        $texto = trim(str_replace(["\r\n", "\r"], "\n", (string) $texto));
        if ($texto === '') return [];

        $out = [];
        foreach (preg_split('/\n\s*\n/', $texto) as $bloque) {
            $lineas = array_filter(array_map('trim', explode("\n", $bloque)), fn($l) => $l !== '');
            if ($lineas) $out[] = ['tipo' => 'parrafo', 'texto' => implode(' ', $lineas)];
        }
        return $out;
    }
}
