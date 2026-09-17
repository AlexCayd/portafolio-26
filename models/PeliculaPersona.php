<?php

namespace Model;

class PeliculaPersona extends ActiveRecord {

    protected static $tabla = 'pelicula_personas';
    protected static $columnasDB = ['id', 'pelicula_id', 'nombre', 'orden'];

    // Valor que se guarda cuando no se conoce al director / creador.
    const DESCONOCIDO = 'Desconocido';

    public $id;
    public $pelicula_id;
    public $nombre;
    public $orden;

    public function __construct($args = []) {
        $this->id          = $args['id']          ?? null;
        $this->pelicula_id = $args['pelicula_id'] ?? null;
        $this->nombre      = $args['nombre']      ?? '';
        $this->orden       = $args['orden']       ?? 0;
    }

    /**
     * Nombres de TODAS las películas de una sola consulta: [pelicula_id => ['A','B']].
     * Evita el N+1 del catálogo (más de mil títulos).
     */
    public static function mapa() : array {
        $res = self::$db->query("SELECT pelicula_id, nombre FROM " . static::$tabla . " ORDER BY pelicula_id ASC, orden ASC, id ASC");
        $out = [];
        while ($r = $res->fetch_assoc()) {
            $out[(int) $r['pelicula_id']][] = $r['nombre'];
        }
        $res->free();
        return $out;
    }

    // Nombres de un solo título
    public static function porPelicula(int $peliculaId) : array {
        $res = self::$db->query("SELECT nombre FROM " . static::$tabla . " WHERE pelicula_id = {$peliculaId} ORDER BY orden ASC, id ASC");
        $out = [];
        while ($r = $res->fetch_assoc()) { $out[] = $r['nombre']; }
        $res->free();
        return $out;
    }

    /**
     * Reemplaza los directores de un título. Normaliza: recorta, descarta
     * centinelas ('?', '—', 'N/A'…), deduplica sin distinguir mayúsculas y, si
     * no queda nadie, guarda una sola fila «Desconocido».
     */
    public static function reemplazar(int $peliculaId, array $nombres) : void {
        self::$db->query("DELETE FROM " . static::$tabla . " WHERE pelicula_id = {$peliculaId}");
        $limpios = self::normalizar($nombres);
        $orden = 0;
        foreach ($limpios as $nombre) {
            (new self(['pelicula_id' => $peliculaId, 'nombre' => $nombre, 'orden' => ++$orden]))->guardar();
        }
    }

    /**
     * Limpia una lista de nombres. Devuelve al menos ['Desconocido'].
     * Acepta también una cadena con varios nombres separados por , ; / & o « y ».
     */
    public static function normalizar(array $nombres) : array {
        $planos = [];
        foreach ($nombres as $n) {
            foreach (self::partir((string) $n) as $parte) $planos[] = $parte;
        }
        $out = [];
        foreach ($planos as $n) {
            if ($n === '' || in_array(mb_strtolower($n), ['?', '—', '-', 'n/a', 'na', 'sin director'], true)) continue;
            if (!isset($out[mb_strtolower($n)])) $out[mb_strtolower($n)] = $n;
        }
        return $out ? array_values($out) : [self::DESCONOCIDO];
    }

    /**
     * Parte una cadena con varios nombres y repone el apellido compartido del
     * modismo familiar: «Lana & Lilly Wachowski» son dos Wachowski, no una
     * «Lana» suelta. Se aplica a cualquier parte que quede en una sola palabra.
     */
    public static function partir(string $texto) : array {
        $partes = array_values(array_filter(array_map('trim',
            preg_split('#\s*(?:,|;|/|&|\sy\s)\s*#iu', $texto)
        ), fn($p) => $p !== ''));
        if (count($partes) < 2) return $partes;

        $ultimo = preg_split('/\s+/u', end($partes));
        if (count($ultimo) < 2) return $partes;
        $apellido = end($ultimo);

        foreach ($partes as $i => $p) {
            if ($i < count($partes) - 1 && !preg_match('/\s/u', $p)) $partes[$i] = $p . ' ' . $apellido;
        }
        return $partes;
    }
}
