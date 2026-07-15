<?php

namespace Controllers;

use MVC\Router;
use Model\Proyecto;
use Model\ProyectoImagen;
use Model\Servicio;
use Model\Credencial;
use Model\Blog;
use Model\Libro;
use Model\Pelicula;
use Model\Categoria;
use Model\BlogCategoria;
use Model\Visita;
use Model\Usuario;

class AdminController
{
    /* =============================================================== Dashboard */
    public static function dashboard(Router $router)
    {
        protegerAdmin();

        $proyectos    = Proyecto::ordenados();
        $servicios    = Servicio::ordenados();      // ascendente
        $credenciales = Credencial::all();

        $router->render('admin/dashboard', [
            'titulo'   => 'Dashboard', 'modulo' => 'dashboard', 'usaCharts' => true,
            'resumen'  => [
                'proyectos'    => count(Proyecto::all()),
                'servicios'    => count($servicios),
                'credenciales' => count($credenciales),
                'blog'         => count(Blog::all()),
                'libros'       => count(Libro::all()),
                'peliculas'    => count(Pelicula::all()),
            ],
            'ultProyectos'    => array_slice(Proyecto::all(), 0, 5),
            'servicios'       => $servicios,
            'ultCredenciales' => array_slice($credenciales, 0, 5),
            'paginas'         => Visita::paginasPorVisitas(),
            'visitasTotal'    => Visita::totalGlobal(),
            'vis7'   => Visita::porDia(7),
            'vis30'  => Visita::porDia(30),
            'vis6m'  => Visita::porMes(6),
            'vis12m' => Visita::porMes(12),
        ], 'admin-layout');
    }

    /* =============================================================== Búsqueda (autocompletar) */
    public static function buscar()
    {
        protegerAdmin();
        header('Content-Type: application/json');
        $q = trim($_GET['q'] ?? '');
        $tipo = $_GET['tipo'] ?? 'ref';
        if (mb_strlen($q) < 2) { echo '[]'; exit; }

        $out = [];
        if ($tipo === 'ref' || $tipo === 'libro') {
            foreach (Libro::buscar($q) as $l) {
                $out[] = ['tipo' => 'libro', 'id' => $l->id, 'titulo' => $l->titulo, 'sub' => $l->autor];
            }
        }
        if ($tipo === 'ref' || $tipo === 'pelicula') {
            foreach (Pelicula::buscar($q) as $p) {
                $out[] = [
                    'tipo' => 'pelicula', 'id' => $p->id, 'titulo' => $p->titulo,
                    'sub' => trim(($p->categoria ?: '') . ' · ' . ($p->anio ?: ''), ' ·'),
                    'poster' => $p->poster ? '/build/img/peliculas/' . $p->poster : null,
                ];
            }
        }
        if ($tipo === 'autor') {
            foreach (Pelicula::buscarAutores($q) as $a) {
                $out[] = ['tipo' => 'autor', 'id' => 0, 'titulo' => $a, 'sub' => 'Director / Creador'];
            }
        }
        echo json_encode($out);
        exit;
    }

    /* =============================================================== Mi cuenta (cambiar PIN) */
    public static function cuenta(Router $router)
    {
        protegerAdmin();
        $router->render('admin/cuenta', [
            'titulo' => 'Mi cuenta', 'modulo' => 'cuenta',
            'msg' => $_GET['msg'] ?? '',
        ], 'admin-layout');
    }

    public static function cuentaGuardar()
    {
        protegerAdmin();
        $msg = 'err';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $actual    = $_POST['actual'] ?? '';
            $nuevo     = $_POST['nuevo'] ?? '';
            $confirmar = $_POST['confirmar'] ?? '';
            if ($nuevo !== $confirmar) {
                $msg = 'nomatch';
            } else {
                $u = Usuario::find((int) ($_SESSION['id'] ?? 0));
                if ($u && password_verify($actual, $u->password) && preg_match('/^\d{6}$/', $nuevo)) {
                    $u->password = password_hash($nuevo, PASSWORD_BCRYPT);
                    unset($u->password2);
                    $u->guardar();
                    $msg = 'ok';
                }
            }
        }
        header('Location: /admin/cuenta?msg=' . $msg); exit;
    }

    /* =============================================================== Proyectos */
    public static function proyectos(Router $router)
    {
        protegerAdmin();
        $editando = isset($_GET['id']) ? Proyecto::find((int) $_GET['id']) : null;
        $router->render('admin/proyectos', [
            'titulo' => 'Proyectos', 'modulo' => 'proyectos',
            'proyectos' => Proyecto::ordenados(),
            'editando'  => $editando,
            'galeria'   => $editando ? ProyectoImagen::porProyecto((int) $editando->id) : [],
        ], 'admin-layout');
    }

    public static function proyectoImagenSubir()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['proyecto_id'])) {
            $pid = (int) $_POST['proyecto_id'];
            $img = subirArchivo('galeria_file', rutaBuild('img/proyectos/galeria'), 'gal', ['png','jpg','jpeg','webp','avif']);
            if ($img) {
                $n = count(ProyectoImagen::porProyecto($pid));
                (new ProyectoImagen(['proyecto_id' => $pid, 'img' => $img, 'orden' => $n + 1]))->guardar();
            }
            header('Location: /admin/proyectos?id=' . $pid); exit;
        }
        header('Location: /admin/proyectos'); exit;
    }

    public static function proyectoImagenEliminar()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $img = ProyectoImagen::find((int) $_POST['id']);
            $pid = $img->proyecto_id ?? 0;
            if ($img) { $img->eliminar(); flash('Imagen eliminada', 'eliminado'); }
            header('Location: /admin/proyectos?id=' . $pid); exit;
        }
        header('Location: /admin/proyectos'); exit;
    }

    public static function proyectoImagenOrden()   { protegerAdmin(); ProyectoImagen::reordenar($_POST['ids'] ?? []); self::jsonOk(); }

    public static function proyectoGuardar()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $editando = !empty($_POST['id']) ? Proyecto::find((int) $_POST['id']) : null;
            $proyecto = new Proyecto($_POST);
            $proyecto->id = $editando->id ?? null;
            $proyecto->slug = generarSlug($proyecto->titulo);
            $img = subirArchivo('img_file', rutaBuild('img/proyectos/portadas'), 'proyecto', ['png','jpg','jpeg','webp','avif']);
            if ($img) $proyecto->img = $img; elseif ($editando) $proyecto->img = $editando->img;
            if (!$proyecto->id) $proyecto->orden = count(Proyecto::all()) + 1;
            $res = $proyecto->guardar();
            $pid = $proyecto->id ?: ($res['id'] ?? null);

            // Galería: subir múltiples imágenes (disponible en creación y edición)
            if ($pid && !empty($_FILES['galeria_files']) && is_array($_FILES['galeria_files']['name'])) {
                $dir = rutaBuild('img/proyectos/galeria');
                if (!is_dir($dir)) mkdir($dir, 0775, true);
                $n = count(ProyectoImagen::porProyecto((int) $pid));
                foreach ($_FILES['galeria_files']['name'] as $i => $nombre) {
                    if ($_FILES['galeria_files']['error'][$i] !== UPLOAD_ERR_OK) continue;
                    $ext = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));
                    if (!in_array($ext, ['png','jpg','jpeg','webp','avif'], true)) continue;
                    $fn = 'gal-' . time() . '-' . bin2hex(random_bytes(3)) . '.' . $ext;
                    if (move_uploaded_file($_FILES['galeria_files']['tmp_name'][$i], $dir . DIRECTORY_SEPARATOR . $fn)) {
                        (new ProyectoImagen(['proyecto_id' => (int) $pid, 'img' => $fn, 'orden' => ++$n]))->guardar();
                    }
                }
            }
            flash($editando ? 'Proyecto actualizado' : 'Proyecto creado', $editando ? 'editado' : 'ok');
        }
        header('Location: /admin/proyectos'); exit;
    }

    public static function proyectoEliminar() { protegerAdmin(); self::eliminar(Proyecto::class, '/admin/proyectos'); }
    public static function proyectosOrden()   { protegerAdmin(); Proyecto::reordenar($_POST['ids'] ?? []); self::jsonOk(); }

    /* =============================================================== Servicios */
    public static function servicios(Router $router)
    {
        protegerAdmin();
        $router->render('admin/servicios', [
            'titulo' => 'Servicios', 'modulo' => 'servicios',
            'servicios' => Servicio::ordenados(),
            'editando'  => isset($_GET['id']) ? Servicio::find((int) $_GET['id']) : null,
        ], 'admin-layout');
    }

    public static function servicioGuardar()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio = new Servicio($_POST);
            $servicio->id = !empty($_POST['id']) ? (int) $_POST['id'] : null;
            if (!$servicio->id) {
                $servicio->orden = count(Servicio::all()) + 1;   // al final
            }
            // El número se deriva de la posición; se guarda por compatibilidad
            $servicio->num = str_pad((string) $servicio->orden, 2, '0', STR_PAD_LEFT);
            $servicio->guardar();
            flash(!empty($_POST['id']) ? 'Servicio actualizado' : 'Servicio creado', !empty($_POST['id']) ? 'editado' : 'ok');
        }
        header('Location: /admin/servicios'); exit;
    }

    public static function servicioEliminar() { protegerAdmin(); self::eliminar(Servicio::class, '/admin/servicios'); }
    public static function serviciosOrden()   { protegerAdmin(); Servicio::reordenar($_POST['ids'] ?? []); self::jsonOk(); }

    /* =============================================================== Credenciales */
    public static function credenciales(Router $router)
    {
        protegerAdmin();
        $router->render('admin/credenciales', [
            'titulo' => 'Credenciales', 'modulo' => 'credenciales',
            'credenciales' => Credencial::ordenados(),
            'editando'     => isset($_GET['id']) ? Credencial::find((int) $_GET['id']) : null,
        ], 'admin-layout');
    }

    public static function credencialGuardar()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $editando = !empty($_POST['id']) ? Credencial::find((int) $_POST['id']) : null;
            $cred = new Credencial($_POST);
            $cred->id = $editando->id ?? null;
            $cred->anio = ($_POST['anio'] ?? '') !== '' ? (int) $_POST['anio'] : null;
            $logo = subirArchivo('logo_file', rutaBuild('img/logos'), 'logo', ['png','jpg','jpeg','webp','svg']);
            if ($logo) $cred->logo = $logo; elseif ($editando) $cred->logo = $editando->logo;
            if (!$cred->id) $cred->orden = count(Credencial::all()) + 1;
            $cred->guardar();
            flash($editando ? 'Credencial actualizada' : 'Credencial creada', $editando ? 'editado' : 'ok');
        }
        header('Location: /admin/credenciales'); exit;
    }

    public static function credencialEliminar() { protegerAdmin(); self::eliminar(Credencial::class, '/admin/credenciales'); }
    public static function credencialesOrden()  { protegerAdmin(); Credencial::reordenar($_POST['ids'] ?? []); self::jsonOk(); }

    public static function credencialesOrdenAlfa()
    {
        protegerAdmin();
        $items = Credencial::ordenados();
        usort($items, fn($a, $b) => strcasecmp($a->titulo, $b->titulo));
        Credencial::reordenar(array_map(fn($c) => $c->id, $items));
        header('Location: /admin/credenciales'); exit;
    }

    public static function credencialesOrdenCrono()
    {
        protegerAdmin();
        $items = Credencial::ordenados();
        usort($items, fn($a, $b) => (int) $b->anio <=> (int) $a->anio);  // más reciente primero
        Credencial::reordenar(array_map(fn($c) => $c->id, $items));
        header('Location: /admin/credenciales'); exit;
    }

    /* =============================================================== Blog */
    public static function blog(Router $router)
    {
        protegerAdmin();
        $masVistos = Blog::masVistos(8);
        $router->render('admin/blog', [
            'titulo' => 'Blog', 'modulo' => 'blog', 'usaCharts' => true,
            'posts'      => Blog::ordenados(),
            'categorias' => BlogCategoria::todas(),
            'editando'   => isset($_GET['id']) ? Blog::find((int) $_GET['id']) : null,
            'chartVisitas' => [
                'labels' => array_map(fn($p) => $p->titulo, $masVistos),
                'data'   => array_map(fn($p) => (int) $p->visitas, $masVistos),
            ],
        ], 'admin-layout');
    }

    public static function blogGuardar()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $editando = !empty($_POST['id']) ? Blog::find((int) $_POST['id']) : null;
            $post = new Blog($_POST);
            $post->id = $editando->id ?? null;
            $post->contenido = sanitizarHtml($_POST['contenido'] ?? '');   // WYSIWYG → HTML saneado
            $post->visitas = $editando->visitas ?? 0;

            // Categoría: puede ser nueva
            $categoria = trim($_POST['categoria'] ?? '');
            if ($categoria === '__nueva__') {
                $categoria = trim($_POST['categoria_nueva'] ?? '');
                if ($categoria !== '' && !BlogCategoria::where('nombre', $categoria)) {
                    (new BlogCategoria(['nombre' => $categoria]))->guardar();
                }
            }
            $post->categoria = $categoria;
            $post->fecha_pub = !empty($_POST['fecha_pub']) ? $_POST['fecha_pub'] : null;
            $post->ref_tipo  = !empty($_POST['ref_tipo']) ? $_POST['ref_tipo'] : null;
            $post->ref_id    = !empty($_POST['ref_id']) ? (int) $_POST['ref_id'] : null;
            // Estado: publicar o guardar como borrador
            $post->estado = ($_POST['accion'] ?? '') === 'borrador' ? 'borrador' : 'publicado';
            // Slug: manual o derivado del título (SEO)
            $post->slug = !empty(trim($_POST['slug'] ?? '')) ? generarSlug($_POST['slug']) : generarSlug($post->titulo);
            $cover = subirArchivo('cover_file', rutaBuild('img/blog'), 'blog', ['png','jpg','jpeg','webp','avif']);
            if ($cover) $post->cover_img = $cover; elseif ($editando) $post->cover_img = $editando->cover_img;
            if (!$post->id) $post->orden = count(Blog::all()) + 1;
            $post->guardar();
            flash($editando ? 'Entrada actualizada' : ($post->estado === 'borrador' ? 'Borrador guardado' : 'Entrada publicada'), $editando ? 'editado' : 'ok');
        }
        header('Location: /admin/blog'); exit;
    }

    public static function blogEliminar() { protegerAdmin(); self::eliminar(Blog::class, '/admin/blog'); }
    public static function blogOrden()    { protegerAdmin(); Blog::reordenar($_POST['ids'] ?? []); self::jsonOk(); }

    // Sube una imagen para el cuerpo del artículo; devuelve la URL
    public static function blogSubirImagen()
    {
        protegerAdmin();
        header('Content-Type: application/json');
        $img = subirArchivo('imagen', rutaBuild('img/blog'), 'body', ['png','jpg','jpeg','webp','gif','avif']);
        echo json_encode($img ? ['ok' => true, 'url' => '/build/img/blog/' . $img] : ['ok' => false]);
        exit;
    }

    /* =============================================================== CV */
    public static function cv(Router $router)
    {
        protegerAdmin();
        $ruta = rutaBuild('pdf/cv.pdf');
        $router->render('admin/cv', [
            'titulo' => 'CV', 'modulo' => 'cv',
            'existe' => file_exists($ruta),
            'modificado' => file_exists($ruta) ? date('d/m/Y H:i', filemtime($ruta)) : null,
        ], 'admin-layout');
    }

    public static function cvSubir()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES['cv_file']) && $_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
            if (strtolower(pathinfo($_FILES['cv_file']['name'], PATHINFO_EXTENSION)) === 'pdf') {
                $dir = rutaBuild('pdf');
                if (!is_dir($dir)) mkdir($dir, 0775, true);
                move_uploaded_file($_FILES['cv_file']['tmp_name'], $dir . DIRECTORY_SEPARATOR . 'cv.pdf');
            }
        }
        header('Location: /admin/cv'); exit;
    }

    /* =============================================================== Películas y Series */
    // Dashboard (análisis + tabla paginada)
    public static function peliculas(Router $router)
    {
        protegerAdmin();
        $todas = Pelicula::ordenadas();
        $porPagina = 12;
        $totalPag = max(1, (int) ceil(count($todas) / $porPagina));
        $pagina = max(1, min($totalPag, (int) ($_GET['pagina'] ?? 1)));

        $router->render('admin/peliculas', [
            'titulo' => 'Películas y Series', 'modulo' => 'peliculas',
            'stats'      => self::estadisticasPeliculas($todas),
            'peliculas'  => array_slice($todas, ($pagina - 1) * $porPagina, $porPagina),
            'pagina'     => $pagina, 'totalPag' => $totalPag,
            'usaCharts'  => true,
        ], 'admin-layout');
    }

    // Watchlist Premium completa
    public static function peliculasWatchlist(Router $router)
    {
        protegerAdmin();
        $stats = self::estadisticasPeliculas(Pelicula::ordenadas());
        // Distribución de 10/10 por mes, por año (con selector; default = año actual)
        $anios = Pelicula::aniosConPerfectas();
        $anioActual = (int) date('Y');
        if (!in_array($anioActual, $anios, true) && !empty($anios)) $anioActual = $anios[0];
        $porAnio = [];
        foreach ($anios as $y) { $porAnio[$y] = Pelicula::perfectasPorMes($y); }
        if (empty($porAnio)) $porAnio[$anioActual] = Pelicula::perfectasPorMes($anioActual);
        $router->render('admin/peliculas-watchlist', [
            'titulo' => 'Selección del Autor', 'modulo' => 'peliculas', 'usaCharts' => true,
            'watchlist' => $stats['watchlist'],
            'anios'     => array_keys($porAnio),
            'anioSel'   => $anioActual,
            'porAnio'   => $porAnio,
        ], 'admin-layout');
    }

    // Gestión: formulario + catálogo paginado
    public static function peliculasGestionar(Router $router)
    {
        protegerAdmin();
        // Se muestran todos para que el buscador y el orden de la tabla operen
        // sobre el catálogo completo (client-side).
        $router->render('admin/peliculas-gestionar', [
            'titulo' => 'Gestionar Películas', 'modulo' => 'peliculas',
            'peliculas'  => Pelicula::ordenadas(),
            'categorias' => Categoria::todas(),
            'editando'   => isset($_GET['id']) ? Pelicula::find((int) $_GET['id']) : null,
        ], 'admin-layout');
    }

    public static function peliculaGuardar()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoria = trim($_POST['categoria'] ?? '');
            if ($categoria === '__nueva__') {
                $categoria = trim($_POST['categoria_nueva'] ?? '');
                if ($categoria !== '' && !Categoria::where('nombre', $categoria)) {
                    (new Categoria(['nombre' => $categoria]))->guardar();
                }
            }

            // Nuevo vs revisitado: si el título ya existe, se actualiza ese registro
            $id = !empty($_POST['id']) ? (int) $_POST['id'] : null;
            if (!$id) {
                $existente = Pelicula::porTitulo($_POST['titulo'] ?? '');
                if ($existente) $id = (int) $existente->id;
            }

            $editando = $id ? Pelicula::find($id) : null;
            $pelicula = new Pelicula($_POST);
            $pelicula->id = $id;
            $pelicula->categoria   = $categoria;
            $pelicula->anio        = ($_POST['anio'] ?? '') !== '' ? (int) $_POST['anio'] : null;
            $pelicula->duracion    = ($_POST['duracion'] ?? '') !== '' ? (int) $_POST['duracion'] : null;
            $pelicula->fecha_vista = !empty($_POST['fecha_vista']) ? $_POST['fecha_vista'] : null;
            $pelicula->nota        = (float) ($_POST['nota'] ?? 0);
            $poster = subirArchivo('poster_file', rutaBuild('img/peliculas'), 'poster', ['png','jpg','jpeg','webp','avif']);
            if ($poster) $pelicula->poster = $poster; elseif ($editando) $pelicula->poster = $editando->poster;
            $pelicula->guardar();
            flash($editando ? 'Título actualizado' : 'Título agregado', $editando ? 'editado' : 'ok');
        }
        header('Location: /admin/peliculas/gestionar'); exit;
    }

    public static function peliculaEliminar() { protegerAdmin(); self::eliminar(Pelicula::class, '/admin/peliculas/gestionar'); }

    private static function estadisticasPeliculas(array $peliculas) : array
    {
        $total = count($peliculas);
        $sumaNota = 0; $sumaDur = 0; $countDur = 0; $aprobados = 0;
        $distNotas = array_fill(1, 10, 0);
        $porAnio = []; $cat = []; $catNota = []; $catAprob = []; $catNo = []; $autores = []; $watchlist = [];

        foreach ($peliculas as $p) {
            $nota = (float) $p->nota; $sumaNota += $nota;
            $aprob = $nota >= Pelicula::UMBRAL_APROBADO;
            if ($aprob) $aprobados++;
            $distNotas[max(1, min(10, (int) round($nota)))]++;

            $anio = (int) $p->anio;
            if ($anio) { $porAnio[$anio]['count'] = ($porAnio[$anio]['count'] ?? 0) + 1; $porAnio[$anio]['suma'] = ($porAnio[$anio]['suma'] ?? 0) + $nota; }

            $c = $p->categoria ?: 'Sin categoría';
            $cat[$c] = ($cat[$c] ?? 0) + 1; $catNota[$c][] = $nota;
            $catAprob[$c] = ($catAprob[$c] ?? 0) + ($aprob ? 1 : 0);
            $catNo[$c] = ($catNo[$c] ?? 0) + ($aprob ? 0 : 1);
            if ($p->duracion) { $sumaDur += (int) $p->duracion; $countDur++; }
            if (!empty($p->autor) && $p->autor !== '—') $autores[$p->autor] = ($autores[$p->autor] ?? 0) + 1;
            if ($nota >= 10) $watchlist[] = ['titulo' => $p->titulo, 'categoria' => $c, 'autor' => $p->autor, 'anio' => $p->anio, 'poster' => $p->poster];
        }

        ksort($porAnio); arsort($cat); arsort($autores);
        $autores = array_slice($autores, 0, 8, true);
        $aniosLabels = array_map('strval', array_keys($porAnio));
        $aniosCount  = array_map(fn($x) => $x['count'], array_values($porAnio));
        $aniosProm   = array_map(fn($x) => round($x['suma'] / max(1, $x['count']), 2), array_values($porAnio));
        $acum = []; $run = 0; foreach ($aniosCount as $c2) { $run += $c2; $acum[] = $run; }
        $catLabels = array_keys($cat);

        return [
            'total' => $total, 'notaPromedio' => $total ? round($sumaNota / $total, 2) : 0,
            'duracionProm' => $countDur ? round($sumaDur / $countDur) : 0,
            'aprobados' => $aprobados, 'noAprobados' => $total - $aprobados,
            'pctAprobacion' => $total ? round($aprobados / $total * 100, 1) : 0,
            'distNotas' => array_values($distNotas),
            'aniosLabels' => $aniosLabels, 'aniosCount' => $aniosCount, 'aniosProm' => $aniosProm, 'acumulado' => $acum,
            'catLabels' => $catLabels, 'catCount' => array_values($cat),
            'catNotaProm' => array_map(fn($c) => round(array_sum($catNota[$c]) / max(1, count($catNota[$c])), 2), $catLabels),
            'catAprob' => array_map(fn($c) => $catAprob[$c], $catLabels),
            'catNo'    => array_map(fn($c) => $catNo[$c], $catLabels),
            'autoresLabels' => array_keys($autores), 'autoresCount' => array_values($autores),
            'watchlist' => $watchlist,
        ];
    }

    /* =============================================================== Helpers */
    private static function eliminar(string $modelo, string $redir) : void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $obj = $modelo::find((int) $_POST['id']);
            if ($obj) { $obj->eliminar(); flash('Registro eliminado', 'eliminado'); }
        }
        header("Location: {$redir}"); exit;
    }

    private static function jsonOk() : void
    {
        header('Content-Type: application/json');
        echo json_encode(['ok' => true]);
        exit;
    }
}
