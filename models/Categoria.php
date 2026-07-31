<?php

namespace Model;

class Categoria extends ActiveRecord {

    protected static $tabla = 'pys_categorias';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;

    public function __construct($args = []) {
        $this->id     = $args['id']     ?? null;
        $this->nombre = $args['nombre'] ?? '';
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
