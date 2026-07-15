# CLAUDE.md — Guía de mantenimiento

Portafolio + panel de administración de **Alexander Oliva**. Landing pública premium (animada) y panel en español para gestionar todo el contenido.

## Stack
- **PHP 8** con un micro-MVC estilo «DevWebCamp» (Router propio, sin framework).
- **MySQL** vía `mysqli`, patrón **ActiveRecord** (`models/ActiveRecord.php`).
- **SCSS** (Dart Sass) + **Gulp** para el bundle JS. Animación: GSAP + ScrollTrigger, Three.js, Lenis, anime.js (CDN, cargados en `views/portfolio-layout.php`).
- Dotenv (`includes/.env`) para credenciales de BD.

## Estructura
- `public/index.php` — front controller. Define rutas del `Router` (coincidencia **exacta** de `PATH_INFO`) y **pre-checks** de URLs amigables antes de `comprobarRutas()` (p. ej. `/tekhne/<slug>`, `/proyecto/<slug>`, `/sitemap.xml`, redirect 301 `/blog*`→`/tekhne*`). `.htaccess` sirve archivos reales de `/public` y enruta el resto a `index.php`.
- `controllers/` — `PortfolioController` (sitio público), `AdminController` (panel), `AuthController`, y controladores por módulo (`LibrosController`, `FinanzasController`, `HorarioController`, `CurriculumController`, `VideojuegoController`, `GymController`).
- `models/` — un modelo por tabla; heredan de `ActiveRecord` (props mágicas + `all()/find()/guardar()`; varios tienen `reordenar(array $ids)`).
- `views/` — plantillas PHP. Layouts: `portfolio-layout.php` (público), `admin-layout.php` (panel), `auth-layout.php` (login). Render vía `$router->render('carpeta/vista', [datos], 'layout')` (usa `extract()`).
- `includes/` — `app.php` (bootstrap: autoload, dotenv, `date_default_timezone_set('America/Mexico_City')`, conexión), `funciones.php` (helpers), `database.php`.
- `src/scss/` → compila a `public/build/css/`. `src/js/ao-init.js` → `public/build/js/bundle.min.js`.

## Helpers (`includes/funciones.php`)
- `s($v)` — escapa HTML (usar SIEMPRE al imprimir datos de usuario).
- `icono($nombre)` — devuelve un `<svg class="ico">` de la paleta de iconos de línea. **Añadir aquí cualquier icono nuevo.**
- `waLink($mensaje)` — enlace de WhatsApp prellenado.
- `generarSlug($txt)`, `flash()/obtenerFlash()`, `subirArchivo()`, `sanitizarHtml()`.

## JS del panel (globals en `views/admin-layout.php`)
- `window.toast(msg, tipo)` — notificación (`ok`/`editado`/`eliminado`).
- `window.confirmar(msg, nombre, {titulo, ok, danger})` — modal de confirmación (Promise).
- `[data-sortable]` — drag & drop de filas; POST a `data-orden-url`; `data-landing="N"` marca las N primeras.
- `initStars` — widget de calificación por estrellas.

## Convenciones
- **UI en español.**
- **Sin emojis en el proyecto.** Para iconografía usar `icono()` (o SVG inline). Única excepción: las **estrellas de calificación** (★ ½ ☆) de reseñas de libros/películas.
- Imágenes con variantes `avif`/`webp`/`png` en `public/build/img/`.
- Colores/estados de mapas curriculares por clase `.st-<estado>` (completado=verde, cursando=ámbar, desbloqueada=azul, bloqueada=rojo).

## Build
```bash
# CSS (los tres bundles)
./node_modules/.bin/sass \
  src/scss/admin.scss:public/build/css/admin.css \
  src/scss/paginas.scss:public/build/css/paginas.css \
  src/scss/portfolio.scss:public/build/css/portfolio.css \
  --style=compressed --no-source-map

# JS (ao-init.js → bundle.min.js)
./node_modules/.bin/gulp js
```

## Base de datos
Importar en orden: `database/ddl.sql` (esquema) y luego `database/dml.sql` (datos base: solo el usuario admin + categorías; el resto se carga desde el panel). Visitas se registran solas: `visitas` (total diario) y `visitas_pagina` (por ruta, alimenta la tabla del dashboard).

## Verificación de cambios
1. `php -l <archivo>` en lo tocado. **Ignorar** los falsos positivos del analizador del IDE: `P1008` (variables inyectadas por `render()`/`extract()`) y `P1014`/`P1132` (props mágicas de ActiveRecord).
2. Recompilar el SCSS afectado y `gulp js` si se tocó `ao-init.js`.
3. Login del panel: usuario **alex**, PIN **000000** (cambiar en producción).

## SEO
- Meta/OG/Twitter + JSON-LD en `portfolio-layout.php`; imágenes OG se vuelven absolutas automáticamente. Artículos emiten `BlogPosting` + `BreadcrumbList` (`views/blog/articulo.php`) y `og:type=article`.
- `public/robots.txt` (estático) + `/sitemap.xml` dinámico (`PortfolioController::sitemap()`).
