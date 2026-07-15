<?php

namespace Model;

class Blog extends ActiveRecord {

    protected static $tabla = 'blog';
    protected static $columnasDB = ['id', 'titulo', 'slug', 'estado', 'categoria', 'fecha_pub', 'descripcion', 'contenido', 'cover_img', 'ref_tipo', 'ref_id', 'visitas', 'orden'];

    const CATEGORIAS = ['Tecnología', 'Cultura', 'Actualidad', 'Cuentos'];

    public $id;
    public $titulo;
    public $slug;
    public $estado;
    public $categoria;
    public $fecha_pub;
    public $descripcion;
    public $contenido;
    public $cover_img;
    public $ref_tipo;
    public $ref_id;
    public $visitas;
    public $orden;

    public function __construct($args = []) {
        $this->id          = $args['id']          ?? null;
        $this->titulo      = $args['titulo']      ?? '';
        $this->slug        = $args['slug']        ?? '';
        $this->estado      = $args['estado']      ?? 'publicado';
        $this->categoria   = $args['categoria']   ?? '';
        $this->fecha_pub   = $args['fecha_pub']   ?? null;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->contenido   = $args['contenido']   ?? '';
        $this->cover_img   = $args['cover_img']   ?? null;
        $this->ref_tipo    = $args['ref_tipo']    ?? null;
        $this->ref_id      = $args['ref_id']      ?? null;
        $this->visitas     = $args['visitas']     ?? 0;
        $this->orden       = $args['orden']       ?? 0;
    }

    // Todos (admin)
    public static function ordenados() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " ORDER BY orden ASC, id ASC");
    }

    // Solo publicados (público)
    public static function publicados() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE estado = 'publicado' ORDER BY orden ASC, id ASC");
    }

    // Busca por slug (público, publicado)
    public static function porSlug(string $slug) {
        $slug = self::$db->escape_string($slug);
        $r = self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE slug = '{$slug}' LIMIT 1");
        return array_shift($r);
    }

    // Publicados de una categoría (por slug de categoría, sin acentos)
    public static function publicadosPorCategoria(string $catSlug) : array {
        $todos = self::publicados();
        return array_values(array_filter($todos, function ($p) use ($catSlug) {
            return generarSlug($p->categoria) === $catSlug;
        }));
    }

    // Incrementa el contador de visitas del artículo
    public static function registrarVisita(int $id) : void {
        $id = (int) $id;
        self::$db->query("UPDATE " . static::$tabla . " SET visitas = visitas + 1 WHERE id = {$id}");
    }

    // Top de artículos por visitas (para la gráfica del admin)
    public static function masVistos(int $limite = 8) : array {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " ORDER BY visitas DESC, id ASC LIMIT " . (int) $limite);
    }

    // Minutos de lectura estimados (~200 palabras/min) sobre el cuerpo
    public function tiempoLectura() : int {
        $texto = (string) $this->contenido;
        $texto = preg_replace('/!\[[^\]]*\]\([^)]*\)/', '', $texto);  // marcadores de imagen
        $texto = trim(strip_tags($texto));
        if ($texto === '') return 1;
        return max(1, (int) ceil(str_word_count($texto) / 200));
    }

    // Fecha legible para las tarjetas (ej. "JUN · 4 MIN")
    public function metaTarjeta() : string {
        $meses = ['ENE','FEB','MAR','ABR','MAY','JUN','JUL','AGO','SEP','OCT','NOV','DIC'];
        $mes = $this->fecha_pub ? $meses[(int) date('n', strtotime($this->fecha_pub)) - 1] : '';
        return trim($mes . ' · ' . $this->tiempoLectura() . ' MIN', ' ·');
    }
}
