<?php

namespace Model;

class Categoria extends ActiveRecord {

    protected static $tabla = 'pys_categorias';
    protected static $columnasDB = ['id', 'nombre', 'admite_serie'];

    // La categoría que por sí misma es formato serie
    const SERIE = 'Serie';

    public $id;
    public $nombre;
    public $admite_serie;   // 1 = sus títulos pueden ser serie (docuserie, reality…)

    public function __construct($args = []) {
        $this->id           = $args['id']           ?? null;
        $this->nombre       = $args['nombre']       ?? '';
        $this->admite_serie = $args['admite_serie'] ?? 0;
    }

    // ¿Un título de esta categoría puede marcarse como serie?
    public static function admiteSerie(string $nombre) : bool {
        $n = self::$db->escape_string($nombre);
        $r = self::$db->query("SELECT admite_serie FROM " . static::$tabla . " WHERE nombre = '{$n}' LIMIT 1")->fetch_assoc();
        return $r && (int) $r['admite_serie'] === 1;
    }

    public static function todas() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " ORDER BY nombre ASC");
    }

    // Categorías fijadas al frente del selector; el resto va alfabético
    const PRIORIDAD = ['Película', 'Serie'];

    /**
     * Orden del panel: Película, Serie y después el resto alfabéticamente.
     * Se ordena en PHP para no complicar el SQL con un CASE.
     */
    public static function ordenadas() : array {
        $todas = self::todas();
        usort($todas, function ($a, $b) {
            $ia = array_search($a->nombre, self::PRIORIDAD, true);
            $ib = array_search($b->nombre, self::PRIORIDAD, true);
            $ia = $ia === false ? PHP_INT_MAX : $ia;
            $ib = $ib === false ? PHP_INT_MAX : $ib;
            if ($ia !== $ib) return $ia <=> $ib;
            // Se comparan los slugs para que los acentos no alteren el alfabético
            return strcmp(generarSlug($a->nombre), generarSlug($b->nombre));
        });
        return $todas;
    }

    // Nombre que debe salir preseleccionado en el formulario
    public static function porDefecto(array $categorias) : string {
        foreach (self::PRIORIDAD as $preferida) {
            foreach ($categorias as $c) { if ($c->nombre === $preferida) return $c->nombre; }
        }
        return $categorias[0]->nombre ?? '';
    }
}
