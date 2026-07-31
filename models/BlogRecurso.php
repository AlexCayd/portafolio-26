<?php

namespace Model;

/**
 * Recursos asociados a una entrada de Tékhne (libros / películas).
 * Sustituye a las columnas blog.ref_tipo / blog.ref_id, que solo admitían uno.
 */
class BlogRecurso extends ActiveRecord {

    protected static $tabla = 'blog_recursos';
    protected static $columnasDB = ['id', 'blog_id', 'ref_tipo', 'ref_id', 'orden'];

    const TIPOS = ['libro', 'pelicula'];

    public $id;
    public $blog_id;
    public $ref_tipo;
    public $ref_id;
    public $orden;

    public function __construct($args = []) {
        $this->id       = $args['id']       ?? null;
        $this->blog_id  = $args['blog_id']  ?? null;
        $this->ref_tipo = $args['ref_tipo'] ?? '';
        $this->ref_id   = $args['ref_id']   ?? null;
        $this->orden    = $args['orden']    ?? 0;
    }

    // Filas de una entrada, en el orden en que se asociaron
    public static function deEntrada(int $blogId) : array {
        $blogId = (int) $blogId;
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE blog_id = {$blogId} ORDER BY orden ASC, id ASC");
    }

    /**
     * Reemplaza la lista completa de recursos de una entrada.
     * $pares: [['tipo' => 'libro'|'pelicula', 'id' => int], …]
     */
    public static function guardarLista(int $blogId, array $pares) : void {
        $blogId = (int) $blogId;
        if (!$blogId) return;

        self::$db->query("DELETE FROM " . static::$tabla . " WHERE blog_id = {$blogId}");

        $orden = 0;
        $vistos = [];
        foreach ($pares as $par) {
            $tipo = trim((string) ($par['tipo'] ?? ''));
            $id   = (int) ($par['id'] ?? 0);
            if (!in_array($tipo, self::TIPOS, true) || $id <= 0) continue;

            $clave = $tipo . ':' . $id;
            if (isset($vistos[$clave])) continue;      // la tabla tiene UNIQUE (blog_id, tipo, id)
            $vistos[$clave] = true;

            (new self([
                'blog_id'  => $blogId,
                'ref_tipo' => $tipo,
                'ref_id'   => $id,
                'orden'    => $orden++,
            ]))->guardar();
        }
    }

    /**
     * Convierte las filas en los objetos reales, descartando huérfanos
     * (el libro/película pudo borrarse). Devuelve [['tipo' => …, 'obj' => …], …].
     */
    public static function resolver(array $filas) : array {
        $out = [];
        foreach ($filas as $fila) {
            $obj = $fila->ref_tipo === 'libro'
                ? Libro::find((int) $fila->ref_id)
                : ($fila->ref_tipo === 'pelicula' ? Pelicula::find((int) $fila->ref_id) : null);
            if ($obj) $out[] = ['tipo' => $fila->ref_tipo, 'obj' => $obj];
        }
        return $out;
    }
}
