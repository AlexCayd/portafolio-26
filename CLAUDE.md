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
- `public/build/` — **assets del repo** (CSS, JS, fuentes, imágenes de diseño). Se reemplaza entera en cada despliegue.
- `public/uploads/` — **archivos subidos desde el panel** (portadas, pósters, logos de credenciales, galerías, `cv.pdf`). **Nunca se sube ni se reemplaza al desplegar**; se respalda aparte. Subcarpetas: `blog/`, `logos/`, `peliculas/`, `videojuegos/`, `proyectos/portadas/`, `proyectos/galeria/`.

## Helpers (`includes/funciones.php`)
- `s($v)` — escapa HTML (usar SIEMPRE al imprimir datos de usuario).
- `icono($nombre)` — devuelve un `<svg class="ico">` de la paleta de iconos de línea. **Añadir aquí cualquier icono nuevo.**
- `waLink($mensaje)` — enlace de WhatsApp prellenado.
- `rutaSubidas($rel)` — ruta física dentro de `public/uploads/` (destino de `subirArchivo()`).
- `urlSubida($carpeta, $archivo)` — URL pública **ya escapada** de un archivo subido (`''` si no hay archivo). **Único lugar donde se escribe `/uploads`**: nunca armar esas rutas a mano en las vistas.
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

## Todo cambio visual pasa por el subagente `ux-ui`

**Obligatorio**, no opcional: antes de dar por terminado cualquier trabajo que cree o modifique un archivo de `src/scss/`, un JS con animación, scroll o interacción, o el markup de una vista con implicación visual, hay que invocar el subagente **`ux-ui`** (`~/.claude/agents/ux-ui.md`, nivel de usuario: sirve a todos los proyectos) con la lista de archivos tocados y qué debía conseguir la pantalla. Juzga concepto, jerarquía, tipografía, color, movimiento y accesibilidad, y decide si entra tal cual.

Ahí vive el criterio de diseño; aquí, la mecánica de este proyecto. El agente lee este archivo primero, así que las convenciones de arriba —UI en español, **sin emojis**, iconografía por `icono()`, los tres bundles de CSS— mandan sobre cualquier preferencia suya.

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

## Despliegue
Se suben el código y `public/build` (recompilado). **`public/uploads` no se sube nunca**: vive solo en el servidor y ahí están las imágenes y el CV cargados desde el panel. Antes de cada despliegue conviene descargar esa carpeta como respaldo. Las vistas y los controladores tienen que subirse **juntos** con `views/admin-layout.php` e `includes/funciones.php`: los helpers globales (`window.fechaISO`, `icono()`, `urlSubida()`) viven ahí y una subida parcial rompe el panel.

## Base de datos
En `/database` viven **tres archivos de SQL**: `local.sql` (esquema + datos de este proyecto), `u277274915_a_oliva.sql` (la última copia de producción descargada de phpMyAdmin, que es el respaldo y **nunca se edita**) y `drops.sql` (**solo `DROP TABLE IF EXISTS`** de las tablas de este proyecto). Para trabajar en local basta con importar `local.sql`, que trae sus propios `DROP`: **no hay que tocar producción**. El mismo `local.sql` es el que se corre en producción para desplegar el esquema (ver `database/CLAUDE.md`: antes hay que pasarle los datos del volcado más reciente, porque recrea las tablas). El esquema que el código espera vive ahí, y hoy va por delante del servidor. Visitas se registran solas: `visitas` (total diario), `visitas_pagina` (acumulado por ruta) y `visitas_pagina_dia` (desglose por fecha).

**En `/database` solo hay tablas y datos del portafolio**: cada volcado que se descarga se recorta a esas tablas antes de guardarlo. **Nada de migraciones**: el esquema se cambia en `local.sql`. Reglas completas en [`database/CLAUDE.md`](database/CLAUDE.md).

## Verificación de cambios
1. `php -l <archivo>` en lo tocado. **Ignorar** los falsos positivos del analizador del IDE: `P1008` (variables inyectadas por `render()`/`extract()`) y `P1014`/`P1132` (props mágicas de ActiveRecord).
2. Recompilar el SCSS afectado y `gulp js` si se tocó `ao-init.js`.
3. Login del panel: usuario **alex**, con el **mismo PIN que producción** (la base local se importa del volcado, así que el usuario es el real). Para trabajar con otro PIN en local, cambiarlo desde `/admin/cuenta`.

## SEO
- Meta/OG/Twitter + JSON-LD en `portfolio-layout.php`; imágenes OG se vuelven absolutas automáticamente. Artículos emiten `BlogPosting` + `BreadcrumbList` (`views/blog/articulo.php`) y `og:type=article`.
- `public/robots.txt` (estático) + `/sitemap.xml` dinámico (`PortfolioController::sitemap()`).
