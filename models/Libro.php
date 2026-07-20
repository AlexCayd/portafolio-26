<?php

namespace Model;

class Libro extends ActiveRecord {

    protected static $tabla = 'libros';
    protected static $columnasDB = ['id', 'titulo', 'autor', 'estado', 'completado', 'posicion', 'estrellas', 'comentario', 'fecha_leido'];

    public $id;
    public $titulo;
    public $autor;
    public $estado;
    public $completado;
    public $posicion;
    public $estrellas;
    public $comentario;
    public $fecha_leido;

    public function __construct($args = []) {
        $this->id          = $args['id']          ?? null;
        $this->titulo      = $args['titulo']      ?? '';
        $this->autor       = $args['autor']       ?? '';
        $this->estado      = $args['estado']      ?? 'pendiente';
        $this->completado  = $args['completado']  ?? 0;
        $this->posicion    = $args['posicion']    ?? 0;
        $this->estrellas   = $args['estrellas']   ?? null;
        $this->comentario  = $args['comentario']  ?? null;
        $this->fecha_leido = $args['fecha_leido'] ?? null;
    }

    // Cuenta libros marcados como leídos con fecha_leido dentro de [$desde, $hasta]
    public static function contarPorRango(string $desde, string $hasta) : int {
        $desde = self::$db->escape_string($desde);
        $hasta = self::$db->escape_string($hasta);
        $r = self::$db->query("SELECT COUNT(*) AS c FROM " . static::$tabla . "
                               WHERE estado = 'leido' AND fecha_leido BETWEEN '{$desde}' AND '{$hasta}'")->fetch_assoc();
        return (int) $r['c'];
    }

    // Pendientes ordenados por posición de lectura
    public static function pendientes() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE estado = 'pendiente' ORDER BY posicion ASC, id ASC");
    }

    // Leídos (más reciente arriba por posición)
    public static function leidos() {
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE estado = 'leido' ORDER BY posicion ASC, id ASC");
    }

    // Búsqueda para autocompletar
    public static function buscar(string $q) {
        $q = self::$db->escape_string($q);
        return self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE titulo LIKE '%{$q}%' OR autor LIKE '%{$q}%' ORDER BY titulo ASC LIMIT 8");
    }

    // Posición máxima (orden de inserción global)
    public static function maxPosicion() : int {
        $r = self::$db->query("SELECT COALESCE(MAX(posicion),0) AS m FROM " . static::$tabla)->fetch_assoc();
        return (int) $r['m'];
    }

    // Promueve a "leído" los pendientes completados de forma consecutiva desde
    // el inicio de la lista: solo migran cuando el primer pendiente está
    // completado, y luego arrastra a los siguientes que también lo estén.
    // Devuelve los libros promovidos (para pedir su reseña).
    public static function promoverCompletados() : array {
        $promovidos = [];
        while (true) {
            $pendientes = self::pendientes();
            $primero = $pendientes[0] ?? null;
            if (!$primero || (int) $primero->completado !== 1) break;
            $primero->estado = 'leido';
            if (empty($primero->fecha_leido)) $primero->fecha_leido = date('Y-m-d');   // fecha de lectura por defecto
            $primero->guardar();
            $promovidos[] = $primero;
        }
        return $promovidos;
    }
}
