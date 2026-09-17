<?php

namespace Model;

class ProyectoSeccion extends ActiveRecord {

    protected static $tabla = 'proyecto_secciones';
    protected static $columnasDB = ['id', 'proyecto_id', 'titulo', 'cuerpo', 'orden'];

    public $id;
    public $proyecto_id;
    public $titulo;
    public $cuerpo;
    public $orden;

    public function __construct($args = []) {
        $this->id          = $args['id']          ?? null;
        $this->proyecto_id = $args['proyecto_id'] ?? null;
        $this->titulo      = $args['titulo']      ?? '';
        $this->cuerpo      = $args['cuerpo']      ?? '';
        $this->orden       = $args['orden']       ?? 0;
    }

    // Secciones de la ficha, en el orden en que se pintan (tras la galería)
    public static function porProyecto(int $proyectoId) : array {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE proyecto_id = {$proyectoId} ORDER BY orden ASC, id ASC");
    }

    // Reemplaza las secciones completas (el form las manda todas, ya ordenadas)
    public static function reemplazar(int $proyectoId, array $secciones) : void {
        self::$db->query("DELETE FROM " . static::$tabla . " WHERE proyecto_id = {$proyectoId}");
        $orden = 0;
        foreach ($secciones as $sec) {
            $titulo = trim((string) ($sec['titulo'] ?? ''));
            $cuerpo = trim((string) ($sec['cuerpo'] ?? ''));
            if ($titulo === '' && $cuerpo === '') continue;
            (new self([
                'proyecto_id' => $proyectoId,
                // Sin título la sección sale sin encabezado (la vista lo omite)
                'titulo'      => $titulo,
                'cuerpo'      => $cuerpo,
                'orden'       => ++$orden,
            ]))->guardar();
        }
    }
}
