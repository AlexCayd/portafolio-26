<?php

namespace Controllers;

use MVC\Router;
use Model\Proyecto;
use Model\ProyectoImagen;
use Model\ProyectoSeccion;
use Model\Servicio;
use Model\Credencial;
use Model\Blog;
use Model\BlogRecurso;
use Model\Libro;
use Model\Pelicula;
use Model\Visita;

class PortfolioController
{
    public static function index(Router $router)
    {
        Visita::registrarHoy();
        Visita::registrarPagina('/', 'Inicio');

        // --- Contenido administrable desde /admin (MySQL) ---
        $servicios    = Servicio::ordenados();
        $credenciales = Credencial::ordenados();
        $proyectos    = Proyecto::ordenados();

        // Proyectos para el slider (inyectados como JSON en la vista)
        $proyectosJs = array_map(function($p) {
            return ['id' => $p->id, 'slug' => $p->slug, 'img' => $p->img, 'title' => $p->titulo, 'year' => $p->anio];
        }, $proyectos);

        // --- Instituciones (marquee): derivadas de las credenciales, únicas y en orden ---
        $instituciones = array_values(array_unique(array_filter(array_map(
            fn($c) => trim((string) $c->institucion), $credenciales
        ))));

        // --- Cursos (docencia) ---
        $cursos = [
            [
                'num'       => '01',
                'img'       => 'word.jpg',
                'alt'       => 'Curso de Microsoft Word',
                'categoria' => 'OFIMÁTICA · CURSO',
                'titulo'    => 'Microsoft Word',
                'desc'      => 'De cero a experto en documentos profesionales: estilos, plantillas, tablas y combinación de correspondencia.',
                'href'      => 'https://www.udemy.com/course/microsoft-office-word-de-0-a-experto/?referralCode=CB4E993CF67872D20056',
            ],
            [
                'num'       => '02',
                'img'       => 'excel.jpg',
                'alt'       => 'Curso de Microsoft Excel',
                'categoria' => 'DATOS · CURSO',
                'titulo'    => 'Microsoft Excel',
                'desc'      => 'Ejercicios del mundo real: fórmulas, funciones, tablas dinámicas y análisis de datos aplicado a casos concretos.',
                'href'      => 'https://www.udemy.com/course/excel-completo-aprende-con-ejercicios-reales/?referralCode=78B6DE3ED2E62F7E49B8',
            ],
        ];

        // --- Blog: los 6 primeros publicados por orden (se eligen con drag en /admin/blog) ---
        $posts = array_slice(Blog::publicados(), 0, 6);

        $router->render('portfolio/index', [
            'titulo'        => 'Alexander Oliva - Desarrollador de Software & Diseñador UX/UI en CDMX',
            'servicios'     => $servicios,
            'credenciales'  => $credenciales,
            'proyectosJs'   => $proyectosJs,
            'instituciones' => $instituciones,
            'cursos'        => $cursos,
            'posts'         => $posts,
        ], 'portfolio-layout');
    }

    // Página interna de un proyecto: /proyecto?id=<id>
    public static function proyecto(Router $router)
    {
        $slug = trim($_GET['slug'] ?? '');
        $id   = (int) ($_GET['id'] ?? 0);
        $proyecto = $slug !== '' ? Proyecto::porSlug($slug) : ($id ? Proyecto::find($id) : null);
        if (!$proyecto) { header('Location: /'); exit; }

        Visita::registrarPagina('/proyecto/' . $proyecto->slug, $proyecto->titulo);

        $galeria = ProyectoImagen::porProyecto((int) $proyecto->id);

        $router->render('proyecto/index', [
            'titulo'   => $proyecto->titulo . ' - Alexander Oliva',
            'metaDescripcion' => mb_substr($proyecto->resumenMeta(), 0, 160),
            'ogImagen' => urlSubida('proyectos/portadas', $proyecto->img),
            'canonical' => 'https://alexanderoliva.com/proyecto/' . $proyecto->slug,
            'proyecto' => $proyecto,
            'galeria'  => $galeria,
            // La ficha se arma siempre igual: contexto, galería y después las
            // secciones que traiga el proyecto (ver Proyecto::bloques()).
            'bloques'  => $proyecto->bloques(
                ProyectoSeccion::porProyecto((int) $proyecto->id),
                !empty($galeria)
            ),
        ], 'portfolio-layout');
    }

    // Home público del blog: /blog
    public static function blog(Router $router)
    {
        Visita::registrarPagina('/tekhne', 'Tékhne');

        $publicados = Blog::publicados();
        // La portada es cronológica, no curada: `publicados()` viene ordenado por
        // `orden` —la columna que el panel arrastra para elegir las 3 entradas de
        // la landing— y con eso la entrada más nueva podía caer en mitad de la
        // página. Aquí manda la fecha: el primer elemento ES el más reciente, que
        // es justo lo que la portada destaca. El `orden` del panel sigue mandando
        // donde tiene sentido (la landing).
        usort($publicados, function ($a, $b) {
            $fa = $a->fecha_pub ? strtotime($a->fecha_pub) : 0;
            $fb = $b->fecha_pub ? strtotime($b->fecha_pub) : 0;
            return $fb <=> $fa ?: ((int) $b->id <=> (int) $a->id);
        });

        // La destacada es la entrada más nueva SEA DE LA SECCIÓN QUE SEA: se
        // saca de su bucket antes de repartir. Si no, una racha de cuentos —que
        // van en su propia sección— dejaba la portada con un cartel de «no hay
        // nada» mientras debajo había cuatro entradas recientes.
        $portada = array_shift($publicados);

        // Los cuentos, en su propia sección
        $cuentos = array_values(array_filter($publicados, fn($p) => generarSlug($p->categoria) === 'cuentos'));
        $articulos = array_values(array_filter($publicados, fn($p) => generarSlug($p->categoria) !== 'cuentos'));

        $router->render('blog/index', [
            'titulo' => 'Tékhne - La publicación de Alexander Oliva',
            'metaDescripcion' => 'Tékhne: tecnología, cultura, libros, cine y cuentos. La publicación de Alexander Oliva sobre las ideas que conectan disciplinas.',
            'canonical' => 'https://alexanderoliva.com/tekhne',
            'portada' => $portada,
            'posts'  => $articulos,
            'cuentos' => $cuentos,
            'categorias' => Blog::CATEGORIAS,
            'seleccion' => Pelicula::perfectas(),
            // El catálogo completo es una herramienta privada: ni se consulta si
            // quien mira no es admin (ver peliculas(), que cierra la ruta).
            'peliculas'  => esAdmin() ? Pelicula::ordenadas() : [],
            'esAdmin'    => esAdmin(),
        ], 'portfolio-layout');
    }

    // Todas las recomendaciones (selección curada): /blog/recomendaciones
    public static function recomendaciones(Router $router)
    {
        Visita::registrarPagina('/tekhne/recomendaciones', 'Recomendaciones - Tékhne');
        $router->render('blog/recomendaciones', [
            'titulo' => 'Watchlist - Tékhne · Alexander Oliva',
            'metaDescripcion' => 'Mi watchlist: la selección personal de cine y series, lo mejor que he visto.',
            'canonical' => 'https://alexanderoliva.com/tekhne/recomendaciones',
            'seleccion' => Pelicula::perfectas(),
        ], 'portfolio-layout');
    }

    // Artículo público del blog: /blog/<slug> (o ?id=)
    public static function articulo(Router $router)
    {
        $slug = trim($_GET['slug'] ?? '');
        $id   = (int) ($_GET['id'] ?? 0);
        $post = $slug !== '' ? Blog::porSlug($slug) : ($id ? Blog::find($id) : null);
        if (!$post || $post->estado !== 'publicado') { header('Location: /tekhne'); exit; }

        Blog::registrarVisita((int) $post->id);   // contador de visitas del artículo
        Visita::registrarPagina('/tekhne/' . ($post->slug ?: $post->id), $post->titulo);

        // Recursos asociados (libros / películas), varios por entrada
        $recursos = BlogRecurso::resolver(BlogRecurso::deEntrada((int) $post->id));

        $router->render('blog/articulo', [
            'titulo' => $post->titulo . ' - Tékhne · Alexander Oliva',
            'metaDescripcion' => $post->descripcion,
            'ogTitulo' => $post->titulo,
            'ogImagen' => $post->cover_img ? urlSubida('blog', $post->cover_img) : '/build/img/og-default.jpg',
            'ogTipo'   => 'article',
            'ogFecha'  => $post->fecha_pub ?: null,
            'canonical' => 'https://alexanderoliva.com/tekhne/' . ($post->slug ?: $post->id),
            'post'     => $post,
            'recursos' => $recursos,
        ], 'portfolio-layout');
    }

    // Catálogo completo de películas y series: /tekhne/peliculas
    // Es una herramienta privada —la bitácora de todo lo visto, sin curar—, no
    // una página del medio: fuera de sesión de admin no existe. Lo público es la
    // watchlist (/tekhne/recomendaciones), que sí está seleccionada.
    public static function peliculas(Router $router)
    {
        if (!esAdmin()) { header('Location: /tekhne/recomendaciones'); exit; }

        Visita::registrarPagina('/tekhne/peliculas', 'Películas y series - Tékhne');
        $router->render('pelicula/lista', [
            'titulo' => 'Catálogo - Tékhne · Alexander Oliva',
            'metaDescripcion' => 'Todo lo que he visto: cine y series calificadas por Alexander Oliva, con buscador.',
            'canonical' => 'https://alexanderoliva.com/tekhne/peliculas',
            'robots'    => 'noindex, nofollow',
            'peliculas' => Pelicula::ordenadas(),
        ], 'portfolio-layout');
    }

    // Ficha pública de una película/serie: /tekhne/pelicula/<slug>
    public static function pelicula(Router $router)
    {
        $slug = trim($_GET['slug'] ?? '');
        $film = $slug !== '' ? Pelicula::porSlug($slug) : null;
        if (!$film) { header('Location: /tekhne/peliculas'); exit; }

        $url = '/tekhne/pelicula/' . generarSlug($film->titulo);
        Visita::registrarPagina($url, $film->titulo);

        // Watchlist: desde cualquier ficha se puede entrar a la selección, y si
        // el título forma parte de ella se navega con anterior/siguiente sin
        // volver al listado.
        $seleccion = Pelicula::perfectas();
        $pos = null;
        foreach ($seleccion as $i => $t) {
            if ((int) $t->id === (int) $film->id) { $pos = $i; break; }
        }
        $total = count($seleccion);
        $watchlist = [
            'total'    => $total,
            'pos'      => $pos,
            'anterior' => $pos !== null && $total > 1 ? $seleccion[($pos - 1 + $total) % $total] : null,
            'siguiente'=> $pos !== null && $total > 1 ? $seleccion[($pos + 1) % $total] : null,
        ];

        $router->render('pelicula/index', [
            'titulo' => $film->titulo . ' - Tékhne · Alexander Oliva',
            'metaDescripcion' => $film->comentario
                ? mb_substr(strip_tags($film->comentario), 0, 160)
                : trim(($film->categoriaTexto() ?: '') . ($film->personaConocida() ? ' de ' . $film->personasTexto() : '') . ($film->anio ? ' (' . $film->anio . ')' : '')),
            'ogTitulo' => $film->titulo,
            'ogImagen' => $film->poster ? urlSubida('peliculas', $film->poster) : '/build/img/og-default.jpg',
            'ogTipo'   => 'article',
            'canonical' => 'https://alexanderoliva.com' . $url,
            'film'      => $film,
            'watchlist' => $watchlist,
            'esAdmin'   => esAdmin(),
        ], 'portfolio-layout');
    }

    // Listado del blog por categoría: /blog/categoria/<slug>
    public static function categoria(Router $router)
    {
        $catSlug = trim($_GET['cat'] ?? '');
        $posts = Blog::publicadosPorCategoria($catSlug);
        // Nombre legible: tomar el de la primera entrada o el slug capitalizado
        $nombre = !empty($posts) ? $posts[0]->categoria : ucfirst(str_replace('-', ' ', $catSlug));

        Visita::registrarPagina('/tekhne/categoria/' . $catSlug, $nombre . ' - Tékhne');

        $router->render('blog/categoria', [
            'titulo' => $nombre . ' - Tékhne · Alexander Oliva',
            'metaDescripcion' => 'Artículos de la categoría ' . $nombre . ' en Tékhne, la publicación de Alexander Oliva.',
            'canonical' => 'https://alexanderoliva.com/tekhne/categoria/' . $catSlug,
            'categoriaNombre' => $nombre,
            'categoriaSlug' => $catSlug,
            'categorias' => Blog::CATEGORIAS,
            'posts' => $posts,
        ], 'portfolio-layout');
    }

    // Sitemap dinámico: /sitemap.xml
    public static function sitemap()
    {
        $base = 'https://alexanderoliva.com';
        $urls = [
            ['loc' => $base . '/',                        'freq' => 'weekly',  'prio' => '1.0'],
            ['loc' => $base . '/tekhne',                  'freq' => 'weekly',  'prio' => '0.8'],
            // /tekhne/peliculas NO va aquí: el catálogo es privado (solo admin) y
            // anunciar una ruta que redirige es pedirle a Google que rastree un 302.
            ['loc' => $base . '/tekhne/recomendaciones',  'freq' => 'monthly', 'prio' => '0.6'],
        ];
        foreach (Proyecto::ordenados() as $p) {
            $urls[] = ['loc' => $base . '/proyecto/' . $p->slug, 'freq' => 'yearly', 'prio' => '0.7'];
        }
        foreach (Blog::CATEGORIAS as $cat) {
            $urls[] = ['loc' => $base . '/tekhne/categoria/' . generarSlug($cat), 'freq' => 'weekly', 'prio' => '0.5'];
        }
        foreach (Blog::publicados() as $post) {
            $urls[] = [
                'loc'     => $base . '/tekhne/' . ($post->slug ?: $post->id),
                'freq'    => 'monthly',
                'prio'    => '0.6',
                'lastmod' => $post->fecha_pub ?: null,
            ];
        }
        foreach (Pelicula::ordenadas() as $film) {
            $slug = generarSlug($film->titulo);
            if ($slug === '') continue;
            $urls[] = [
                'loc'  => $base . '/tekhne/pelicula/' . $slug,
                'freq' => 'monthly',
                'prio' => '0.5',
            ];
        }

        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            echo "  <url>\n    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
            if (!empty($u['lastmod'])) echo "    <lastmod>" . htmlspecialchars($u['lastmod']) . "</lastmod>\n";
            echo "    <changefreq>" . $u['freq'] . "</changefreq>\n    <priority>" . $u['prio'] . "</priority>\n  </url>\n";
        }
        echo '</urlset>';
        exit;
    }
}
