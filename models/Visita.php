<?php

namespace Model;

class Visita extends ActiveRecord {

    protected static $tabla = 'visitas';
    protected static $columnasDB = ['id', 'fecha', 'total'];

    public $id;
    public $fecha;
    public $total;

    public function __construct($args = []) {
        $this->id    = $args['id']    ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->total = $args['total'] ?? 0;
    }

    // Registra una visita del día de hoy (contador incremental)
    public static function registrarHoy() : void {
        $hoy = date('Y-m-d');
        self::$db->query("INSERT INTO " . static::$tabla . " (fecha, total) VALUES ('{$hoy}', 1)
                          ON DUPLICATE KEY UPDATE total = total + 1");
    }

    /**
     * Registra una visita a una página concreta. Escribe en las dos tablas:
     * `visitas_pagina` guarda el acumulado histórico y el título (dimensión),
     * `visitas_pagina_dia` el desglose por fecha que alimenta los periodos.
     */
    public static function registrarPagina(string $ruta, string $titulo) : void {
        $ruta   = self::$db->escape_string(mb_substr($ruta, 0, 191));
        $titulo = self::$db->escape_string(mb_substr($titulo, 0, 200));
        $hoy    = date('Y-m-d');
        self::$db->query("INSERT INTO visitas_pagina (ruta, titulo, total) VALUES ('{$ruta}', '{$titulo}', 1)
                          ON DUPLICATE KEY UPDATE total = total + 1, titulo = VALUES(titulo)");
        // Contar visitas nunca puede tumbar una página pública: si la tabla por
        // día aún no existe en el servidor (despliegue a medias), se omite.
        try {
            self::$db->query("INSERT INTO visitas_pagina_dia (ruta, fecha, total) VALUES ('{$ruta}', '{$hoy}', 1)
                              ON DUPLICATE KEY UPDATE total = total + 1");
        } catch (\mysqli_sql_exception $e) {
            // sin desglose por fecha hasta que exista la tabla
        }
    }

    /**
     * Rutas que el dashboard NO cuenta como página del sitio.
     *
     * El catálogo de cine pasó a ser una herramienta privada de admin —lo cierra
     * PortfolioController::peliculas()— y seguía apareciendo entre «las páginas
     * más visitadas» con todo el tráfico de cuando era pública, mezclado con las
     * que sí se publican. La lista de páginas del panel tiene que responder a
     * «qué está leyendo la gente», y una ruta que ya nadie de fuera puede abrir
     * no responde a eso.
     *
     * Se FILTRAN, no se borran: las filas siguen en la tabla con su histórico
     * intacto. Si el catálogo vuelve a abrirse, basta con sacarlo de aquí.
     * Si otra ruta se cierra en el futuro, este es el único sitio que tocar.
     */
    const RUTAS_PRIVADAS = ['/tekhne/peliculas'];

    // Condición SQL que deja fuera lo que no es público, para la columna dada.
    private static function soloPublicas(string $col) : string {
        $cond = [];
        foreach (self::RUTAS_PRIVADAS as $r) {
            $cond[] = "{$col} <> '" . self::$db->escape_string($r) . "'";
        }
        // Hoy nada registra visitas del panel, pero si algún día se añade a mano
        // una llamada a registrarPagina() dentro de /admin, no debe colarse.
        $cond[] = "{$col} NOT LIKE '/admin%'";
        $cond[] = "{$col} NOT LIKE '/login%'";
        return implode(' AND ', $cond);
    }

    // Todas las páginas ordenadas por visitas (desc) => array de objetos {ruta, titulo, total}
    // Es el «Todo el histórico»: incluye lo anterior al desglose por fecha.
    public static function paginasPorVisitas() : array {
        $rows = self::$db->query("SELECT ruta, titulo, total FROM visitas_pagina
                                  WHERE " . self::soloPublicas('ruta') . "
                                  ORDER BY total DESC, titulo ASC");
        $out = [];
        while ($r = $rows->fetch_object()) { $out[] = $r; }
        return $out;
    }

    /**
     * Páginas más visitadas desde una fecha (inclusive). El título se une por
     * `ruta` con la tabla acumulada para no duplicarlo un registro por día.
     */
    private static function paginasDesde(string $desde) : array {
        $desde = self::$db->escape_string($desde);
        $rows = self::$db->query("SELECT d.ruta AS ruta, COALESCE(NULLIF(p.titulo, ''), d.ruta) AS titulo, SUM(d.total) AS total
                                  FROM visitas_pagina_dia d
                                  LEFT JOIN visitas_pagina p ON p.ruta = d.ruta
                                  WHERE d.fecha >= '{$desde}'
                                    AND " . self::soloPublicas('d.ruta') . "
                                  GROUP BY d.ruta, titulo
                                  ORDER BY total DESC, titulo ASC");
        $out = [];
        while ($r = $rows->fetch_object()) { $r->total = (int) $r->total; $r->acumulado = false; $out[] = $r; }

        // Rutas visitadas en el periodo (por su última visita) que todavía no
        // tienen desglose por fecha: solo existe su total histórico. Van al final
        // marcadas como `acumulado` para no mezclarlas con visitas del periodo.
        // Desaparecen solas en cuanto la ruta acumula filas por día.
        $rows = self::$db->query("SELECT p.ruta, COALESCE(NULLIF(p.titulo, ''), p.ruta) AS titulo, p.total
                                  FROM visitas_pagina p
                                  WHERE DATE(p.actualizado) >= '{$desde}'
                                    AND " . self::soloPublicas('p.ruta') . "
                                    AND NOT EXISTS (SELECT 1 FROM visitas_pagina_dia d WHERE d.ruta = p.ruta AND d.fecha >= '{$desde}')
                                  ORDER BY p.total DESC, titulo ASC");
        while ($r = $rows->fetch_object()) { $r->total = (int) $r->total; $r->acumulado = true; $out[] = $r; }
        return $out;
    }

    // Páginas más visitadas de los últimos $dias días (mismo rango que porDia)
    public static function paginasPorDias(int $dias) : array {
        return self::paginasDesde(date('Y-m-d', strtotime("-" . ($dias - 1) . " days")));
    }

    // Páginas más visitadas de los últimos $meses meses (mismo rango que porMes)
    public static function paginasPorMeses(int $meses) : array {
        return self::paginasDesde(date('Y-m-01', strtotime("first day of -" . ($meses - 1) . " month")));
    }

    /**
     * Primer día con desglose por página, o null si la tabla está vacía.
     * La UI lo usa para avisar desde cuándo los periodos son fiables: lo
     * anterior a esa fecha solo existe como total acumulado sin fechar.
     * Inicio (`/`) no cuenta: su histórico diario se rellenó desde `visitas`.
     */
    public static function inicioDetallePagina() : ?string {
        $r = self::$db->query("SELECT MIN(fecha) AS f FROM visitas_pagina_dia WHERE ruta <> '/'")->fetch_assoc();
        return $r && $r['f'] ? $r['f'] : null;
    }

    // Total diario de los últimos $dias días => ['labels'=>[], 'data'=>[]]
    public static function porDia(int $dias) : array {
        $desde = date('Y-m-d', strtotime("-" . ($dias - 1) . " days"));
        $rows = self::consultarSQL("SELECT * FROM " . static::$tabla . " WHERE fecha >= '{$desde}'");
        $map = [];
        foreach ($rows as $r) { $map[$r->fecha] = (int) $r->total; }
        $labels = []; $data = []; $total = 0;
        for ($i = $dias - 1; $i >= 0; $i--) {
            $f = date('Y-m-d', strtotime("-{$i} days"));
            $labels[] = date('d/m', strtotime($f));
            $v = $map[$f] ?? 0; $data[] = $v; $total += $v;
        }
        return ['labels' => $labels, 'data' => $data, 'total' => $total];
    }

    // Total mensual de los últimos $meses meses => ['labels'=>[], 'data'=>[], 'total'=>N]
    public static function porMes(int $meses = 12) : array {
        $desde = (int) $meses - 1;
        $rows = self::$db->query("SELECT DATE_FORMAT(fecha,'%Y-%m') AS ym, SUM(total) AS t
                                  FROM " . static::$tabla . "
                                  WHERE fecha >= DATE_FORMAT(CURDATE() - INTERVAL {$desde} MONTH, '%Y-%m-01')
                                  GROUP BY ym");
        $map = [];
        while ($r = $rows->fetch_assoc()) { $map[$r['ym']] = (int) $r['t']; }
        $nombres = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        $conAnio = $meses > 12;                 // si cruza más de un año, «Ene 25» evita la ambigüedad
        $labels = []; $data = []; $total = 0;
        for ($i = $desde; $i >= 0; $i--) {
            $ym = date('Y-m', strtotime("first day of -{$i} month"));
            $t  = strtotime($ym . '-01');
            $labels[] = $nombres[(int) date('n', $t) - 1] . ($conAnio ? ' ' . date('y', $t) : '');
            $v = $map[$ym] ?? 0; $data[] = $v; $total += $v;
        }
        return ['labels' => $labels, 'data' => $data, 'total' => $total];
    }

    /**
     * Toda la serie: de la primera visita registrada a hoy, mes a mes.
     * Alimenta la opción «Todo el histórico» del dashboard.
     */
    public static function historico() : array {
        $r = self::$db->query("SELECT MIN(fecha) AS f FROM " . static::$tabla)->fetch_assoc();
        if (!$r || empty($r['f'])) return ['labels' => [], 'data' => [], 'total' => 0];
        $ini   = strtotime($r['f']);
        $meses = ((int) date('Y') - (int) date('Y', $ini)) * 12 + ((int) date('n') - (int) date('n', $ini)) + 1;
        return self::porMes(max(1, $meses));
    }

    public static function totalGlobal() : int {
        $r = self::$db->query("SELECT COALESCE(SUM(total),0) AS t FROM " . static::$tabla)->fetch_assoc();
        return (int) $r['t'];
    }
}
