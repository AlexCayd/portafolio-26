<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\PortfolioController;
use Controllers\AdminController;
use Controllers\LibrosController;
use Controllers\VideojuegoController;
use Controllers\GymController;
use Controllers\FinanzasController;
use Controllers\HorarioController;
use Controllers\CurriculumController;

$router = new Router();

// URLs amigables (SEO): pre-check antes del router de coincidencia exacta
$ao_path = $_SERVER['PATH_INFO'] ?? '/';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Sitemap dinámico (SEO)
    if ($ao_path === '/sitemap.xml') {
        PortfolioController::sitemap();
        exit;
    }
    // Compatibilidad: /blog… (antiguo) → 301 a /tekhne…
    if ($ao_path === '/blog' || strpos($ao_path, '/blog/') === 0) {
        header('Location: ' . preg_replace('#^/blog#', '/tekhne', $ao_path), true, 301);
        exit;
    }
    // /tekhne/recomendaciones  →  todas las 10/10
    if ($ao_path === '/tekhne/recomendaciones') {
        PortfolioController::recomendaciones($router);
        exit;
    }
    // /tekhne/categoria/<slug>  →  listado por categoría
    if (preg_match('#^/tekhne/categoria/([a-z0-9-]+)$#', $ao_path, $ao_m)) {
        $_GET['cat'] = $ao_m[1];
        PortfolioController::categoria($router);
        exit;
    }
    // /tekhne/peliculas  →  catálogo público de películas y series
    if ($ao_path === '/tekhne/peliculas') {
        PortfolioController::peliculas($router);
        exit;
    }
    // /tekhne/pelicula/<slug>  →  ficha pública de película/serie
    if (preg_match('#^/tekhne/pelicula/([a-z0-9-]+)$#', $ao_path, $ao_m)) {
        $_GET['slug'] = $ao_m[1];
        PortfolioController::pelicula($router);
        exit;
    }
    // /tekhne/<slug>  →  artículo público
    if (preg_match('#^/tekhne/([a-z0-9-]+)$#', $ao_path, $ao_m) && !in_array($ao_m[1], ['entrada', 'categoria', 'recomendaciones', 'pelicula', 'peliculas'], true)) {
        $_GET['slug'] = $ao_m[1];
        PortfolioController::articulo($router);
        exit;
    }
    // /proyecto/<slug>  →  proyecto público
    if (preg_match('#^/proyecto/([a-z0-9-]+)$#', $ao_path, $ao_m)) {
        $_GET['slug'] = $ao_m[1];
        PortfolioController::proyecto($router);
        exit;
    }
}

// ------------------------------------------------------------ Sitio público
$router->get('/', [PortfolioController::class, 'index']);
$router->get('/proyecto', [PortfolioController::class, 'proyecto']);
$router->get('/tekhne', [PortfolioController::class, 'blog']);
$router->get('/tekhne/entrada', [PortfolioController::class, 'articulo']);

// ------------------------------------------------------------ Autenticación
$router->get('/login',  [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// ------------------------------------------------------------ Panel /admin
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/buscar', [AdminController::class, 'buscar']);
$router->get('/admin/cuenta', [AdminController::class, 'cuenta']);
$router->post('/admin/cuenta/guardar', [AdminController::class, 'cuentaGuardar']);

// Proyectos
$router->get('/admin/proyectos',          [AdminController::class, 'proyectos']);
$router->post('/admin/proyectos/guardar', [AdminController::class, 'proyectoGuardar']);
$router->post('/admin/proyectos/eliminar',[AdminController::class, 'proyectoEliminar']);
$router->post('/admin/proyectos/orden',   [AdminController::class, 'proyectosOrden']);
$router->post('/admin/proyectos/imagen/subir',    [AdminController::class, 'proyectoImagenSubir']);
$router->post('/admin/proyectos/imagen/eliminar', [AdminController::class, 'proyectoImagenEliminar']);
$router->post('/admin/proyectos/imagen/orden',    [AdminController::class, 'proyectoImagenOrden']);

// Servicios
$router->get('/admin/servicios',          [AdminController::class, 'servicios']);
$router->post('/admin/servicios/guardar', [AdminController::class, 'servicioGuardar']);
$router->post('/admin/servicios/eliminar',[AdminController::class, 'servicioEliminar']);
$router->post('/admin/servicios/orden',   [AdminController::class, 'serviciosOrden']);

// Credenciales
$router->get('/admin/credenciales',          [AdminController::class, 'credenciales']);
$router->post('/admin/credenciales/guardar', [AdminController::class, 'credencialGuardar']);
$router->post('/admin/credenciales/eliminar',[AdminController::class, 'credencialEliminar']);
$router->post('/admin/credenciales/orden',   [AdminController::class, 'credencialesOrden']);
$router->post('/admin/credenciales/orden-alfa',  [AdminController::class, 'credencialesOrdenAlfa']);
$router->post('/admin/credenciales/orden-crono', [AdminController::class, 'credencialesOrdenCrono']);

// Blog
$router->get('/admin/blog',          [AdminController::class, 'blog']);
$router->post('/admin/blog/guardar', [AdminController::class, 'blogGuardar']);
$router->post('/admin/blog/eliminar',[AdminController::class, 'blogEliminar']);
$router->post('/admin/blog/orden',   [AdminController::class, 'blogOrden']);
$router->post('/admin/blog/subir-imagen', [AdminController::class, 'blogSubirImagen']);

// CV
$router->get('/admin/cv',       [AdminController::class, 'cv']);
$router->post('/admin/cv/subir',[AdminController::class, 'cvSubir']);

// Libros (solo admin)
$router->get('/admin/libros',           [LibrosController::class, 'index']);
$router->post('/admin/libros/crear',    [LibrosController::class, 'crear']);
$router->post('/admin/libros/editar',   [LibrosController::class, 'editar']);
$router->post('/admin/libros/estado',   [LibrosController::class, 'estado']);
$router->post('/admin/libros/resenar',  [LibrosController::class, 'resenar']);
$router->post('/admin/libros/eliminar', [LibrosController::class, 'eliminar']);

// Películas y Series
$router->get('/admin/peliculas',           [AdminController::class, 'peliculas']);
$router->get('/admin/peliculas/watchlist', [AdminController::class, 'peliculasWatchlist']);
$router->get('/admin/peliculas/gestionar', [AdminController::class, 'peliculasGestionar']);
$router->post('/admin/peliculas/guardar',  [AdminController::class, 'peliculaGuardar']);
$router->post('/admin/peliculas/eliminar',[AdminController::class, 'peliculaEliminar']);

// Videojuegos
$router->get('/admin/videojuegos',          [VideojuegoController::class, 'index']);
$router->post('/admin/videojuegos/guardar', [VideojuegoController::class, 'guardar']);
$router->post('/admin/videojuegos/eliminar',[VideojuegoController::class, 'eliminar']);
$router->post('/admin/videojuegos/orden',   [VideojuegoController::class, 'orden']);

// Gym
$router->get('/admin/gym',        [GymController::class, 'index']);
$router->post('/admin/gym/toggle',[GymController::class, 'toggle']);

// Finanzas
$router->get('/admin/finanzas',          [FinanzasController::class, 'index']);
$router->post('/admin/finanzas/guardar', [FinanzasController::class, 'guardar']);
$router->post('/admin/finanzas/actualizar',[FinanzasController::class, 'actualizar']);
$router->post('/admin/finanzas/eliminar',[FinanzasController::class, 'eliminar']);

// Horario
$router->get('/admin/horario',                  [HorarioController::class, 'index']);
$router->post('/admin/horario/materia/guardar', [HorarioController::class, 'guardarMateria']);
$router->post('/admin/horario/materia/eliminar',[HorarioController::class, 'eliminarMateria']);
$router->post('/admin/horario/bloque/guardar',  [HorarioController::class, 'guardarBloque']);
$router->post('/admin/horario/bloque/eliminar', [HorarioController::class, 'eliminarBloque']);
$router->post('/admin/horario/criterios/guardar', [HorarioController::class, 'guardarCriterios']);

// Mapas curriculares
$router->get('/admin/anahuac', [CurriculumController::class, 'anahuac']);
$router->get('/admin/unam',    [CurriculumController::class, 'unam']);
$router->post('/admin/curriculum/estado', [CurriculumController::class, 'estado']);

$router->comprobarRutas();
