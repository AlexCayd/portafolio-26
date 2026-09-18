<?php

namespace Controllers;

use MVC\Router;
use Model\Proyecto;
use Model\ProyectoImagen;
use Model\ProyectoSeccion;
use Model\PeliculaPersona;
use Model\Servicio;
use Model\Credencial;
use Model\Blog;
use Model\BlogRecurso;
use Model\Libro;
use Model\Pelicula;
use Model\Videojuego;
use Model\Categoria;
use Model\BlogCategoria;
use Model\Visita;
use Model\Usuario;
use Model\Materia;
use Model\HorarioBloque;
use Model\Activo;
use Model\Deuda;
use Model\CuentaPorCobrar;
use Model\GymDia;

class AdminController
{
    /* =============================================================== Dashboard */
    public static function dashboard(Router $router)
    {
        protegerAdmin();

        $proyectos    = Proyecto::ordenados();
        $servicios    = Servicio::ordenados();      // ascendente
        $credenciales = Credencial::all();

        // --- Widgets multi-módulo (resumen de vida) ---
        // Clase actual / próxima según día y hora
        $clase = self::claseActualProxima();

        // Lectura/visionado: año en curso vs. el mismo tramo del año anterior
        // (comparar contra el año completo dejaría el delta en negativo todo enero).
        $hoy         = date('Y-m-d');
        $anioEnCurso = (int) date('Y');
        $inicioAnio  = $anioEnCurso . '-01-01';
        $inicioPrev  = ($anioEnCurso - 1) . '-01-01';
        $mismoDiaPrev = date('Y-m-d', strtotime('-1 year', strtotime($hoy)));
        $librosAhora = Libro::contarPorRango($inicioAnio, $hoy);
        $librosPrev  = Libro::contarPorRango($inicioPrev, $mismoDiaPrev);
        $pelisAhora  = Pelicula::contarPorRango($inicioAnio, $hoy);
        $pelisPrev   = Pelicula::contarPorRango($inicioPrev, $mismoDiaPrev);

        $netoActual = Activo::total() + CuentaPorCobrar::total() - Deuda::total();

        // Tasa de asistencia al gym: mes actual vs. mes anterior (% de días con «Sí»)
        $tasaGym = function (array $map) : ?int {
            $tot = count($map);
            if ($tot === 0) return null;
            $si = count(array_filter($map, fn($v) => (int) $v === 1));
            return (int) round($si / $tot * 100);
        };
        $prevTs  = strtotime('first day of last month');
        $gymAhora = $tasaGym(GymDia::delMes((int) date('Y'), (int) date('n')));
        $gymPrev  = $tasaGym(GymDia::delMes((int) date('Y', $prevTs), (int) date('n', $prevTs)));

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
            'vida' => [
                'clase'       => $clase,
                'anio'        => $anioEnCurso,
                'librosAhora' => $librosAhora, 'librosPrev' => $librosPrev,
                'pelisAhora'  => $pelisAhora,  'pelisPrev'  => $pelisPrev,
                'gymAhora'    => $gymAhora,    'gymPrev'    => $gymPrev,
                'neto'        => $netoActual,
            ],
            'ultProyectos'    => array_slice(Proyecto::all(), 0, 5),
            'servicios'       => $servicios,
            'ultCredenciales' => array_slice($credenciales, 0, 5),
            'visitasTotal'    => Visita::totalGlobal(),
            // Gráfica y tabla comparten selector de periodo, así que las dos
            // series se precargan con las mismas claves y el mismo rango.
            'visSeries' => [
                '7'    => Visita::porDia(7),
                '30'   => Visita::porDia(30),
                '6m'   => Visita::porMes(6),
                '12m'  => Visita::porMes(12),
                'todo' => Visita::historico(),
            ],
            'paginasSeries' => [
                '7'    => Visita::paginasPorDias(7),
                '30'   => Visita::paginasPorDias(30),
                '6m'   => Visita::paginasPorMeses(6),
                '12m'  => Visita::paginasPorMeses(12),
                'todo' => Visita::paginasPorVisitas(),
            ],
            // Desde cuándo hay desglose por fecha: lo anterior solo existe como
            // acumulado por ruta, y la tabla tiene que decirlo.
            'inicioDetalle' => Visita::inicioDetallePagina(),
        ], 'admin-layout');
    }

    /* =============================================================== Búsqueda (autocompletar) */
    public static function buscar()
    {
        protegerAdmin();
        header('Content-Type: application/json');
        $q = trim($_GET['q'] ?? '');
        $tipo = $_GET['tipo'] ?? 'ref';
        // El aviso de homónimos busca el título exacto, así que acepta títulos de una letra
        if (mb_strlen($q) < (!empty($_GET['exacto']) ? 1 : 2)) { echo '[]'; exit; }

        $out = [];
        if ($tipo === 'ref' || $tipo === 'libro') {
            foreach (Libro::buscar($q) as $l) {
                $out[] = ['tipo' => 'libro', 'id' => $l->id, 'titulo' => $l->titulo, 'sub' => $l->autor];
            }
        }
        if ($tipo === 'ref' || $tipo === 'pelicula') {
            // exacto=1: solo los homónimos del título (aviso «¿Te estás refiriendo a…?»)
            $lista = !empty($_GET['exacto']) ? Pelicula::porTituloTodos($q) : Pelicula::buscar($q);
            foreach ($lista as $p) {
                $out[] = [
                    'tipo' => 'pelicula', 'id' => $p->id, 'titulo' => $p->titulo,
                    'sub' => trim($p->categoriaTexto() . ' · ' . ($p->anio ?: ''), ' ·'),
                    'personas' => !empty($_GET['exacto']) ? $p->personasTexto() : '',
                    'fecha' => !empty($_GET['exacto']) && $p->fecha_vista ? date('d/m/Y', strtotime((string) $p->fecha_vista)) : '',
                    'poster' => $p->poster ? urlSubida('peliculas', $p->poster) : null,
                ];
            }
        }
        if ($tipo === 'ref' || $tipo === 'videojuego') {
            // La columna del título es `nombre`: se normaliza a `titulo` para
            // que el autocompletar genérico del panel no necesite un caso aparte.
            foreach (Videojuego::buscar($q) as $v) {
                $out[] = [
                    'tipo' => 'videojuego', 'id' => $v->id, 'titulo' => $v->nombre,
                    'sub' => 'Videojuego',
                    'poster' => $v->portada ? urlSubida('videojuegos', $v->portada) : null,
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
            'secciones' => $editando ? ProyectoSeccion::porProyecto((int) $editando->id) : [],
        ], 'admin-layout');
    }

    public static function proyectoImagenSubir()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['proyecto_id'])) {
            $pid = (int) $_POST['proyecto_id'];
            $img = subirArchivo('galeria_file', rutaSubidas('proyectos/galeria'), 'gal', ['png','jpg','jpeg','webp','avif']);
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
            $subidas  = false;
            $proyecto = new Proyecto($_POST);
            $proyecto->id = $editando->id ?? null;
            $proyecto->slug = generarSlug($proyecto->titulo);
            $img = subirArchivo('img_file', rutaSubidas('proyectos/portadas'), 'proyecto', ['png','jpg','jpeg','webp','avif']);
            if ($img) $proyecto->img = $img; elseif ($editando) $proyecto->img = $editando->img;
            if (!$proyecto->id) $proyecto->orden = count(Proyecto::all()) + 1;
            $res = $proyecto->guardar();
            $pid = $proyecto->id ?: ($res['id'] ?? null);

            // Galería: subir múltiples imágenes (disponible en creación y edición)
            if ($pid && !empty($_FILES['galeria_files']) && is_array($_FILES['galeria_files']['name'])) {
                $dir = rutaSubidas('proyectos/galeria');
                if (!is_dir($dir)) mkdir($dir, 0775, true);
                $n = count(ProyectoImagen::porProyecto((int) $pid));
                foreach ($_FILES['galeria_files']['name'] as $i => $nombre) {
                    if ($_FILES['galeria_files']['error'][$i] !== UPLOAD_ERR_OK) continue;
                    $ext = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));
                    if (!in_array($ext, ['png','jpg','jpeg','webp','avif'], true)) continue;
                    $fn = 'gal-' . time() . '-' . bin2hex(random_bytes(3)) . '.' . $ext;
                    if (move_uploaded_file($_FILES['galeria_files']['tmp_name'][$i], $dir . DIRECTORY_SEPARATOR . $fn)) {
                        (new ProyectoImagen(['proyecto_id' => (int) $pid, 'img' => $fn, 'orden' => ++$n]))->guardar();
                        $subidas = true;
                    }
                }
            }

            // Las secciones llegan como arreglos paralelos desde las filas
            // repetibles del formulario, ya en su orden; se reemplazan enteras.
            if ($pid) {
                $secTit = (array) ($_POST['sec_titulo'] ?? []);
                $secCue = (array) ($_POST['sec_cuerpo'] ?? []);
                $secs   = [];
                foreach ($secTit as $i => $tt) $secs[] = ['titulo' => $tt, 'cuerpo' => $secCue[$i] ?? ''];
                ProyectoSeccion::reemplazar((int) $pid, $secs);
            }

            flash($editando ? 'Proyecto actualizado' : 'Proyecto creado', $editando ? 'editado' : 'ok');
            // Si se crea el proyecto o entran imágenes nuevas se vuelve a la
            // ficha, que es donde se pueden arrastrar para ordenar la galería.
            if ($pid && (!$editando || $subidas)) { header('Location: /admin/proyectos?id=' . $pid); exit; }
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
            $logo = subirArchivo('logo_file', rutaSubidas('logos'), 'logo', ['png','jpg','jpeg','webp','svg']);
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
        $editando = isset($_GET['id']) ? Blog::find((int) $_GET['id']) : null;
        $router->render('admin/blog', [
            'titulo' => 'Blog', 'modulo' => 'blog', 'usaCharts' => true,
            'posts'      => Blog::ordenados(),
            'categorias' => BlogCategoria::todas(),
            'editando'   => $editando,
            // Recursos ya asociados, resueltos para poder mostrar su título
            'recursos'   => $editando ? BlogRecurso::resolver(BlogRecurso::deEntrada((int) $editando->id)) : [],
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
            // Estado: publicar o guardar como borrador
            $post->estado = ($_POST['accion'] ?? '') === 'borrador' ? 'borrador' : 'publicado';
            // Slug: manual o derivado del título (SEO)
            $post->slug = !empty(trim($_POST['slug'] ?? '')) ? generarSlug($_POST['slug']) : generarSlug($post->titulo);
            $cover = subirArchivo('cover_file', rutaSubidas('blog'), 'blog', ['png','jpg','jpeg','webp','avif']);
            if ($cover) $post->cover_img = $cover; elseif ($editando) $post->cover_img = $editando->cover_img;
            if (!$post->id) $post->orden = count(Blog::all()) + 1;
            $resultado = $post->guardar();

            // Recursos asociados (varios): llegan como JSON [{tipo, id}, …]
            $blogId = (int) ($post->id ?: ($resultado['id'] ?? 0));
            $recursos = json_decode($_POST['recursos'] ?? '[]', true);
            BlogRecurso::guardarLista($blogId, is_array($recursos) ? $recursos : []);

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
        $img = subirArchivo('imagen', rutaSubidas('blog'), 'body', ['png','jpg','jpeg','webp','gif','avif']);
        echo json_encode($img ? ['ok' => true, 'url' => urlSubida('blog', $img)] : ['ok' => false]);
        exit;
    }

    /* =============================================================== CV */
    public static function cv(Router $router)
    {
        protegerAdmin();
        $ruta = rutaSubidas('cv.pdf');
        $router->render('admin/cv', [
            'titulo' => 'CV', 'modulo' => 'cv',
            'existe' => file_exists($ruta),
            'modificado' => file_exists($ruta) ? date('d/m/Y H:i', filemtime($ruta)) : null,
        ], 'admin-layout');
    }

    /**
     * Publica un CV nuevo en public/uploads/cv.pdf.
     *
     * Antes esto era un move_uploaded_file a pelo y sin mirar el resultado: si
     * fallaba —permisos, PDF demasiado grande para la configuración de PHP, el
     * archivo abierto por el visor de la propia página— el viejo se quedaba en
     * su sitio y el panel redirigía igual, sin decir nada. Subir el CV y ver el
     * de antes era indistinguible de subirlo bien.
     *
     * El nuevo llega primero a un archivo aparte y solo cuando ya está en disco
     * se borra el anterior y se pone el nuevo en su lugar: así no hay ningún
     * momento en el que la landing se quede sin CV que descargar, ni se
     * destruye el que había si la subida no llega a completarse.
     */
    public static function cvSubir()
    {
        protegerAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /admin/cv'); exit; }

        $f = $_FILES['cv_file'] ?? null;
        $err = $f['error'] ?? UPLOAD_ERR_NO_FILE;
        if (!$f || $err !== UPLOAD_ERR_OK) {
            flash($err === UPLOAD_ERR_INI_SIZE || $err === UPLOAD_ERR_FORM_SIZE
                ? 'El PDF pesa más de lo que admite el servidor.'
                : 'No llegó ningún archivo. Vuelve a intentarlo.', 'eliminado');
            header('Location: /admin/cv'); exit;
        }
        if (strtolower(pathinfo($f['name'], PATHINFO_EXTENSION)) !== 'pdf') {
            flash('El CV tiene que ser un PDF.', 'eliminado');
            header('Location: /admin/cv'); exit;
        }
        // La extensión la pone quien sube; la firma la pone el archivo. Esto se
        // publica en abierto, así que se comprueba lo segundo.
        if (@file_get_contents($f['tmp_name'], false, null, 0, 5) !== '%PDF-') {
            flash('Ese archivo no es un PDF válido.', 'eliminado');
            header('Location: /admin/cv'); exit;
        }

        $dir = rutaSubidas();
        if (!is_dir($dir)) mkdir($dir, 0775, true);
        $destino = rutaSubidas('cv.pdf');
        $entrante = $dir . DIRECTORY_SEPARATOR . 'cv-entrante.pdf';

        if (!move_uploaded_file($f['tmp_name'], $entrante)) {
            flash('No se pudo guardar el CV. Revisa los permisos de /uploads.', 'eliminado');
            header('Location: /admin/cv'); exit;
        }

        // El nuevo ya está en disco: ahora sí se retira el anterior. En Windows
        // rename() no sobrescribe, así que hay que borrar antes.
        if (is_file($destino)) @unlink($destino);
        if (!@rename($entrante, $destino)) {
            @unlink($entrante);
            flash('No se pudo reemplazar el CV anterior.', 'eliminado');
            header('Location: /admin/cv'); exit;
        }
        @chmod($destino, 0644);
        // filemtime() está cacheado por petición y la vista lo usa para la marca
        // de tiempo y para romper la caché del navegador: sin esto enseñaría la
        // fecha del CV viejo justo después de reemplazarlo.
        clearstatcache(true, $destino);

        flash('CV actualizado', 'editado');
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

        // Últimos 5 registros (más recientes por fecha de visto)
        $ultimos = array_slice($todas, 0, 5);

        // Los 10 mejor puntuados de este año (estrenados Y vistos este año), con
        // el movimiento de cada uno desde el último cambio del ranking.
        $anioActual = (int) date('Y');
        $topAnio = Pelicula::rankingAnio($todas, $anioActual, 10);

        // Top 5 directores / creadores con sus títulos. Sale de $todas, que ya
        // trae las personas hidratadas: sin consultas extra. «Desconocido» no
        // es un director, así que no compite.
        $porDirector = [];
        foreach ($todas as $p) {
            foreach ($p->personas() as $nombre) {
                if ($nombre === PeliculaPersona::DESCONOCIDO) continue;
                $porDirector[$nombre][] = $p;
            }
        }
        uksort($porDirector, fn($a, $b) => [count($porDirector[$b]), $a] <=> [count($porDirector[$a]), $b]);
        $topDirectores = [];
        foreach (array_slice($porDirector, 0, 5, true) as $nombre => $titulos) {
            usort($titulos, fn($a, $b) => (float) $b->nota <=> (float) $a->nota);
            $topDirectores[] = ['nombre' => $nombre, 'total' => count($titulos), 'titulos' => $titulos];
        }

        // Vistos por mes: los 12 meses sumando todos los años. Cada año se sigue
        // pasando aparte porque el tooltip muestra el desglose año por año.
        $vistosPorMes = Pelicula::vistosPorMesPorAnio();
        $vmAnios = array_values(array_filter(array_keys($vistosPorMes), fn($k) => $k !== 'Todos'));
        rsort($vmAnios);                                  // del más reciente al más antiguo

        $router->render('admin/peliculas', [
            'titulo' => 'Películas y Series', 'modulo' => 'peliculas',
            'stats'      => self::estadisticasPeliculas($todas),
            'mesesLabels'  => Pelicula::MESES,
            'vistosPorMes' => $vistosPorMes,
            'vmAnios'      => $vmAnios,
            'peliculas'  => array_slice($todas, ($pagina - 1) * $porPagina, $porPagina),
            'ultimos'    => $ultimos,
            'topAnio'    => $topAnio,
            'topDirectores' => $topDirectores,
            'anioActual' => $anioActual,
            'pagina'     => $pagina, 'totalPag' => $totalPag,
            'usaCharts'  => true,
        ], 'admin-layout');
    }

    // Watchlist Premium completa
    public static function peliculasWatchlist(Router $router)
    {
        protegerAdmin();
        $stats = self::estadisticasPeliculas(Pelicula::ordenadas());
        // Distribución de la selección por mes, por año (con selector; default = año actual)
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
            'categorias' => Categoria::ordenadas(),
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
                    (new Categoria(['nombre' => $categoria, 'admite_serie' => !empty($_POST['categoria_admite_serie']) ? 1 : 0]))->guardar();
                }
            }

            // Sin id siempre es un registro nuevo: puede haber títulos homónimos.
            // Si ya existía uno con ese nombre, el formulario lo preguntó antes
            // («¿Te estás refiriendo a…?») y el usuario eligió crear otro.
            $id = !empty($_POST['id']) ? (int) $_POST['id'] : null;

            $editando = $id ? Pelicula::find($id) : null;
            $pelicula = new Pelicula($_POST);
            $pelicula->id = $id;
            $pelicula->categoria   = $categoria;
            // «Serie» siempre es serie; otra categoría solo si la admite y se marcó
            $pelicula->es_serie    = ($categoria === Categoria::SERIE
                                      || (!empty($_POST['es_serie']) && Categoria::admiteSerie($categoria))) ? 1 : 0;
            $pelicula->anio        = ($_POST['anio'] ?? '') !== '' ? max(0, (int) $_POST['anio']) : null;

            // La duración se captura en horas + minutos y se guarda en minutos totales.
            // Las series (de cualquier categoría) no tienen duración: el formulario bloquea los campos.
            $horas   = max(0, (int) ($_POST['duracion_h'] ?? 0));
            $minutos = max(0, min(59, (int) ($_POST['duracion_m'] ?? 0)));
            $total   = $horas * 60 + $minutos;
            $pelicula->duracion    = ($pelicula->esSerie() || $total === 0) ? null : $total;

            $pelicula->fecha_vista = !empty($_POST['fecha_vista']) ? $_POST['fecha_vista'] : null;
            $pelicula->nota        = max(0, min(10, (float) ($_POST['nota'] ?? 0)));
            $pelicula->seleccion   = !empty($_POST['seleccion']) ? 1 : 0;
            $poster = subirArchivo('poster_file', rutaSubidas('peliculas'), 'poster', ['png','jpg','jpeg','webp','avif']);
            if ($poster) $pelicula->poster = $poster; elseif ($editando) $pelicula->poster = $editando->poster;
            // crear() no rellena $this->id: devuelve el insert_id en el arreglo
            $res = $pelicula->guardar();
            $idGuardado = $id ?: (int) ($res['id'] ?? 0);

            // Directores / creadores: el formulario manda una fila por persona.
            // Sin ninguno, PeliculaPersona guarda «Desconocido».
            if ($idGuardado) {
                PeliculaPersona::reemplazar($idGuardado, (array) ($_POST['autores'] ?? []));
            }

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
        $porAnioVisto = []; $cat = []; $watchlist = [];

        foreach ($peliculas as $p) {
            $nota = (float) $p->nota; $sumaNota += $nota;
            $aprob = $nota >= Pelicula::UMBRAL_APROBADO;
            if ($aprob) $aprobados++;
            $distNotas[max(1, min(10, (int) round($nota)))]++;

            // Año en que se vio: alimenta "Nota promedio por año visto"
            $anioVisto = $p->fecha_vista ? (int) date('Y', strtotime((string) $p->fecha_vista)) : 0;
            if ($anioVisto) {
                $porAnioVisto[$anioVisto]['count'] = ($porAnioVisto[$anioVisto]['count'] ?? 0) + 1;
                $porAnioVisto[$anioVisto]['suma']  = ($porAnioVisto[$anioVisto]['suma'] ?? 0) + $nota;
            }

            $c = $p->categoria ?: 'Sin categoría';
            $cat[$c] = ($cat[$c] ?? 0) + 1;
            if ($p->duracion) { $sumaDur += (int) $p->duracion; $countDur++; }
            if ((int) $p->seleccion === 1) $watchlist[] = ['titulo' => $p->titulo, 'categoria' => $p->categoriaTexto() ?: $c, 'autor' => $p->personasTexto(), 'anio' => $p->anio, 'poster' => $p->poster, 'nota' => $nota];
        }

        ksort($porAnioVisto); arsort($cat);
        $vistoLabels = array_map('strval', array_keys($porAnioVisto));
        $vistoProm   = array_map(fn($x) => round($x['suma'] / max(1, $x['count']), 2), array_values($porAnioVisto));
        // Acumulado por año en que se vio (no por año de estreno)
        $vistoCount = array_map(fn($x) => $x['count'], array_values($porAnioVisto));
        $vistoAcum = []; $runVisto = 0; foreach ($vistoCount as $c3) { $runVisto += $c3; $vistoAcum[] = $runVisto; }
        $catLabels = array_keys($cat);

        return [
            'total' => $total, 'notaPromedio' => $total ? round($sumaNota / $total, 2) : 0,
            'duracionProm' => $countDur ? round($sumaDur / $countDur) : 0,
            'aprobados' => $aprobados, 'noAprobados' => $total - $aprobados,
            'pctAprobacion' => $total ? round($aprobados / $total * 100, 1) : 0,
            'distNotas' => array_values($distNotas),
            'vistoLabels' => $vistoLabels, 'vistoProm' => $vistoProm,
            'vistoCount' => $vistoCount, 'vistoAcum' => $vistoAcum,
            'catLabels' => $catLabels, 'catCount' => array_values($cat),
            'watchlist' => $watchlist,
        ];
    }

    /* =============================================================== Helpers */
    // Determina la clase en curso o la siguiente. Si hoy no quedan clases (día
    // libre o fin de semana), busca hacia adelante en la semana y devuelve la
    // próxima aunque sea otro día.
    // Devuelve ['estado'=>'ahora'|'proxima'|'libre', 'materia'=>?, 'color'=>?,
    //           'inicio'=>?, 'fin'=>?, 'esHoy'=>bool, 'diaLabel'=>?]
    private static function claseActualProxima() : array
    {
        $dias    = [1 => 'lun', 2 => 'mar', 3 => 'mie', 4 => 'jue', 5 => 'vie'];
        $nombres = ['lun' => 'Lunes', 'mar' => 'Martes', 'mie' => 'Miércoles', 'jue' => 'Jueves', 'vie' => 'Viernes'];

        $bloques = HorarioBloque::conMateria();
        if (empty($bloques)) return ['estado' => 'libre'];

        $hoyN  = (int) date('N');   // 1 (lun) … 7 (dom)
        $ahora = date('H:i:s');

        // Agrupar los bloques por día y ordenarlos por hora de inicio
        $porDia = [];
        foreach ($bloques as $b) $porDia[$b['dia']][] = $b;
        foreach ($porDia as &$lista) usort($lista, fn($a, $b) => strcmp($a['hora_inicio'], $b['hora_inicio']));
        unset($lista);

        // 1) ¿Hay una clase en curso hoy?
        if (isset($dias[$hoyN])) {
            foreach ($porDia[$dias[$hoyN]] ?? [] as $b) {
                if ($ahora >= $b['hora_inicio'] && $ahora < $b['hora_fin']) {
                    return ['estado' => 'ahora', 'materia' => $b['m_nombre'], 'color' => $b['m_color'],
                            'inicio' => substr($b['hora_inicio'], 0, 5), 'fin' => substr($b['hora_fin'], 0, 5),
                            'esHoy' => true, 'diaLabel' => 'Hoy'];
                }
            }
        }

        // 2) Próxima clase: recorre hasta 7 días hacia adelante (incluye otros días)
        for ($off = 0; $off <= 7; $off++) {
            $n = (($hoyN - 1 + $off) % 7) + 1;
            if (!isset($dias[$n])) continue;   // fin de semana: sin clases
            foreach ($porDia[$dias[$n]] ?? [] as $b) {
                if ($off === 0 && $ahora >= $b['hora_inicio']) continue;   // hoy: solo las que faltan
                $label = $off === 0 ? 'Hoy' : ($off === 1 ? 'Mañana' : $nombres[$dias[$n]]);
                return ['estado' => 'proxima', 'materia' => $b['m_nombre'], 'color' => $b['m_color'],
                        'inicio' => substr($b['hora_inicio'], 0, 5), 'fin' => substr($b['hora_fin'], 0, 5),
                        'esHoy' => ($off === 0), 'diaLabel' => $label];
            }
        }

        return ['estado' => 'libre'];
    }

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
