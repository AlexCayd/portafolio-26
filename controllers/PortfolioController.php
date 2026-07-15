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

        // --- Blog: los 3 primeros publicados por orden (se eligen con drag en /admin/blog) ---
        $posts = array_slice(Blog::publicados(), 0, 3);

        $router->render('portfolio/index', [
            'titulo'        => 'Alexander Oliva — Desarrollador de Software & Diseñador UX/UI en CDMX',
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

        $router->render('proyecto/index', [
            'titulo'   => $proyecto->titulo . ' — Alexander Oliva',
            'metaDescripcion' => mb_substr(strip_tags($proyecto->descripcion), 0, 160),
            'ogImagen' => '/build/img/proyectos/portadas/' . $proyecto->img,
            'canonical' => 'https://alexanderoliva.com/proyecto/' . $proyecto->slug,
            'proyecto' => $proyecto,
            'galeria'  => ProyectoImagen::porProyecto((int) $proyecto->id),
        ], 'portfolio-layout');
    }

    // Home público del blog: /blog
    public static function blog(Router $router)
    {
        Visita::registrarPagina('/tekhne', 'Tékhne');

        $publicados = Blog::publicados();
        // Separar los cuentos en su propia sección
        $cuentos = array_values(array_filter($publicados, fn($p) => generarSlug($p->categoria) === 'cuentos'));
        $articulos = array_values(array_filter($publicados, fn($p) => generarSlug($p->categoria) !== 'cuentos'));

        $router->render('blog/index', [
            'titulo' => 'Tékhne — La publicación de Alexander Oliva',
            'metaDescripcion' => 'Tékhne: tecnología, cultura, libros, cine y cuentos. La publicación de Alexander Oliva sobre las ideas que conectan disciplinas.',
            'canonical' => 'https://alexanderoliva.com/tekhne',
            'posts'  => $articulos,
            'cuentos' => $cuentos,
            'categorias' => Blog::CATEGORIAS,
            'seleccion' => Pelicula::perfectas(),
        ], 'portfolio-layout');
    }

    // Todas las recomendaciones (10/10): /blog/recomendaciones
    public static function recomendaciones(Router $router)
    {
        Visita::registrarPagina('/tekhne/recomendaciones', 'Recomendaciones — Tékhne');
        $router->render('blog/recomendaciones', [
            'titulo' => 'Para ver más tarde — Tékhne · Alexander Oliva',
            'metaDescripcion' => 'Mi selección de cine y series con calificación perfecta 10/10.',
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

        // Recurso asociado (libro / película) si existe
        $ref = null;
        if ($post->ref_tipo === 'libro' && $post->ref_id) {
            $ref = Libro::find((int) $post->ref_id);
        } elseif ($post->ref_tipo === 'pelicula' && $post->ref_id) {
            $ref = Pelicula::find((int) $post->ref_id);
        }

        $router->render('blog/articulo', [
            'titulo' => $post->titulo . ' — Tékhne · Alexander Oliva',
            'metaDescripcion' => $post->descripcion,
            'ogTitulo' => $post->titulo,
            'ogImagen' => $post->cover_img ? '/build/img/blog/' . $post->cover_img : '/build/img/profile.png',
            'ogTipo'   => 'article',
            'ogFecha'  => $post->fecha_pub ?: null,
            'canonical' => 'https://alexanderoliva.com/tekhne/' . ($post->slug ?: $post->id),
            'post'   => $post,
            'ref'    => $ref,
        ], 'portfolio-layout');
    }

    // Listado del blog por categoría: /blog/categoria/<slug>
    public static function categoria(Router $router)
    {
        $catSlug = trim($_GET['cat'] ?? '');
        $posts = Blog::publicadosPorCategoria($catSlug);
        // Nombre legible: tomar el de la primera entrada o el slug capitalizado
        $nombre = !empty($posts) ? $posts[0]->categoria : ucfirst(str_replace('-', ' ', $catSlug));

        Visita::registrarPagina('/tekhne/categoria/' . $catSlug, $nombre . ' — Tékhne');

        $router->render('blog/categoria', [
            'titulo' => $nombre . ' — Tékhne · Alexander Oliva',
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
            ['loc' => $base . '/tekhne/recomendaciones',  'freq' => 'monthly', 'prio' => '0.5'],
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
