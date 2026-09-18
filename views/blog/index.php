<link rel="stylesheet" href="/build/css/paginas.css">
<div id="ao-app" data-theme="dark">
<div data-barba-namespace="blog-home">
    <?php /* Sin barra de breadcrumb: la portada de Tékhne es la raíz de la
             sección (su único padre es el home, y a eso ya lleva la marca de la
             cabecera) y el hueco pegajoso bajo el menú lo ocupa .tk-bar, que
             aquí sí hace falta mientras se recorre la portada. */ ?>
    <?php include __DIR__ . '/../partials/pg-top.php'; ?>

    <?php
    // ---------------------------------------------------------------------
    // Utilidades de la portada. El controlador ya ordenó todo por fecha y
    // apartó `$portada` —la entrada más nueva, de la sección que sea—, que es
    // la que abre el río. `$posts` y `$cuentos` traen el resto.
    // ---------------------------------------------------------------------
    $tk_dias  = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];
    $tk_meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
    $tk_hoy   = $tk_dias[(int) date('w')] . ' ' . (int) date('j') . ' de ' . $tk_meses[(int) date('n') - 1] . ' de ' . date('Y');
    $tk_total = count($posts) + count($cuentos) + (!empty($portada) ? 1 : 0);

    // Degradados de respaldo para las entradas sin portada subida.
    $ao_grads = [
        'repeating-linear-gradient(45deg,rgba(255,255,255,.06) 0 2px,transparent 2px 15px),linear-gradient(135deg,var(--accent) 0%,#1a0207 55%,#0b0b0c 100%)',
        'radial-gradient(rgba(255,255,255,.14) 1px,transparent 1.6px) 0 0/17px 17px,radial-gradient(130% 130% at 24% 18%,var(--accent) 0%,#1a0207 52%,#0b0b0c 100%)',
        'repeating-linear-gradient(90deg,rgba(255,255,255,.05) 0 1px,transparent 1px 13px),linear-gradient(115deg,#0b0b0c 18%,#1a0207 55%,var(--accent) 100%)',
    ];
    function tk_cover($post, $i, $grads) {
        return !empty($post->cover_img) ? "url('" . urlSubida('blog', $post->cover_img) . "') center/cover no-repeat" : $grads[$i % count($grads)];
    }
    // Sin portada subida manda el gas (el mismo shader del hero). El canvas
    // va encima del degradado, que se queda de respaldo si no hay WebGL.
    function tk_gas($post) {
        return !empty($post->cover_img) ? '' : '<canvas class="ao-gas" data-gas aria-hidden="true"></canvas>';
    }
    /**
     * Firma de la entrada: fecha de publicación + minutos de lectura.
     *
     * Van en DOS niveles y no en una línea corrida separada por un punto.
     * Son datos de naturaleza distinta y estaban pesando lo mismo: la fecha es
     * un hecho —cuándo se publicó, lo que sitúa la entrada en el tiempo de la
     * publicación— y el tiempo de lectura es una promesa sobre el esfuerzo que
     * pide. La fecha manda (peso, color de texto, cifras tabulares para que la
     * columna de tarjetas alinee) y el minutaje queda en gris detrás de un
     * filete. metaTarjeta() no sirve aquí: da solo el mes ('JUN · 4 MIN') y en
     * una portada la fecha exacta es parte del contrato de un medio.
     *
     * La fecha sale en <time datetime>: es dato legible por máquina, no
     * decoración, y acompaña al BlogPosting que ya emite la ficha del artículo.
     */
    function tk_firma($post) {
        $abr = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        $t = $post->fecha_pub ? strtotime($post->fecha_pub) : 0;
        $out = '';
        if ($t) {
            // Taco de calendario: mes arriba, día grande debajo. El <time> es el
            // componente entero, con la fecha completa legible por máquina en
            // datetime — lo que se ve troceado sigue siendo un solo dato.
            $out .= '<time class="tk-cal" datetime="' . s(date('Y-m-d', $t)) . '">'
                  . '<span class="tk-cal-mes">' . $abr[(int) date('n', $t) - 1] . '</span>'
                  . '<span class="tk-cal-dia">' . (int) date('j', $t) . '</span>'
                  . '</time>';
        }
        $out .= '<span class="tk-art-datos">'
              . ($t ? '<span class="tk-art-anio">' . date('Y', $t) . '</span>' : '')
              . '<span class="tk-art-min">' . $post->tiempoLectura() . ' min de lectura</span>'
              . '</span>';
        return $out;
    }

    /**
     * Una entrada de la portada. Todas las piezas del río comparten molde: lo
     * único que cambia entre la destacada, las dos secundarias y el resto es
     * la clase de jerarquía.
     *
     * La reparte el servidor por posición —$posts ya viene por fecha— y el JS
     * solo la recalcula al filtrar, para que cada sección tenga su propia
     * entrada destacada. Hacerlo aquí y no solo en el cliente es lo que evita
     * que la portada se pinte plana durante un fotograma… y lo que la deja
     * bien jerarquizada también sin JS.
     */
    function tk_pieza($post, $i, $grads, $leer = 'Leer la entrada', $jerarquia = true) {
        $slug  = $post->slug ?: $post->id;
        $cat   = $post->categoria;
        $busca = $post->titulo . ' ' . $post->descripcion . ' ' . $cat;
        $nivel = '';
        if ($jerarquia) $nivel = $i === 0 ? ' tk-art--lead' : ($i <= 2 ? ' tk-art--sub' : '');
        ob_start(); ?>
        <a class="tk-art<?php echo $nivel; ?>" data-anim data-vt-cover
           data-cat="<?php echo s(generarSlug($cat)); ?>"
           data-search="<?php echo s($busca); ?>"
           href="/tekhne/<?php echo s($slug); ?>">
            <div class="tk-art-media" data-vt-img style="background:<?php echo tk_cover($post, $i, $grads); ?>;">
                <?php echo tk_gas($post); ?>
                <span class="tk-art-cat"><?php echo s($cat); ?></span>
            </div>
            <div class="tk-art-body">
                <span class="tk-art-firma"><?php echo tk_firma($post); ?></span>
                <h3 class="tk-art-tit"><?php echo s($post->titulo); ?></h3>
                <p class="tk-art-desc"><?php echo s($post->descripcion); ?></p>
                <span class="tk-art-leer"><?php echo s($leer); ?></span>
            </div>
        </a>
        <?php return ob_get_clean();
    }
    ?>

    <main class="pg pg--wide pg--tekhne">
        <!-- ============================ CABECERO ============================
             El cabecero de un diario: identificación a la izquierda, mancheta
             al centro, fecha y edición a la derecha, todo cerrado por el doble
             filete. No es decoración: es lo que convierte una lista de posts
             en una publicación con voz y periodicidad. -->
        <header class="tk-flag" data-anim>
            <div class="tk-flag-rail">
                <span>Publicación de Alexander Oliva</span>
                <span><?php echo $tk_total; ?> entradas publicadas</span>
            </div>
            <h1 class="tk-wordmark">Tékhne</h1>
            <div class="tk-flag-rail tk-flag-rail--fin">
                <span><?php echo s($tk_hoy); ?></span>
                <span>Ciudad de México</span>
            </div>
        </header>

        <p class="tk-lema" data-anim>
            <em>Τέχνη</em> — arte y oficio. Donde se cruzan la tecnología, la cultura,
            los libros, el cine y los cuentos.
        </p>

        <!-- ======================= BARRA DE SECCIONES =======================
             Secciones y buscador en la misma barra, pegada bajo la cabecera:
             el filtro viaja contigo mientras lees la portada, que es cuando
             hace falta. Las pestañas siguen siendo enlaces reales a las
             páginas de categoría (SEO y sin JS); con JS filtran en el sitio,
             que es más rápido y no pierde el scroll. -->
        <div class="tk-bar" id="tk-bar">
            <nav class="tk-tabs" id="tk-tabs" aria-label="Secciones de Tékhne">
                <a class="tk-tab is-on" href="/tekhne" data-cat="todos" aria-current="page">Portada</a>
                <?php foreach ($categorias as $cat) : ?>
                    <a class="tk-tab" href="/tekhne/categoria/<?php echo s(generarSlug($cat)); ?>" data-cat="<?php echo s(generarSlug($cat)); ?>"><?php echo s($cat); ?></a>
                <?php endforeach; ?>
            </nav>
            <?php /* Nace oculto y lo destapa el script de abajo. Las pestañas
                     degradan solas (son enlaces reales), pero este buscador no
                     tiene ruta en el servidor: sin JS sería un campo que acepta
                     texto y no hace nada, que es peor que no estar. El script va
                     al final del body, así que lo destapa en la misma pasada de
                     análisis y no hay parpadeo. */ ?>
            <label class="tk-search-box tk-bar-search" id="tk-search-box" hidden>
                <svg class="tk-search-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                <input type="search" id="tk-search" placeholder="Buscar en Tékhne…" autocomplete="off" aria-label="Buscar entradas">
                <button type="button" class="tk-search-clear" id="tk-search-clear" aria-label="Limpiar búsqueda" hidden>&times;</button>
            </label>
        </div>

        <p class="tk-recuento" id="tk-recuento" aria-live="polite">
            <span class="tk-recuento-n"><?php echo $tk_total; ?></span>
            <span id="tk-recuento-txt">entradas en portada</span>
        </p>

        <p class="tk-search-none" id="tk-search-none" hidden>Nada coincide con «<span></span>». Prueba con otra palabra o vuelve a la portada.</p>

        <!-- ============================= EL RÍO =============================
             Una sola rejilla: abre la entrada más nueva (venga de la sección
             que venga — la saca el controlador antes de repartir por bucket) y
             la siguen los artículos. La jerarquía la ponen las clases, no el
             orden del HTML, así que al filtrar el JS la reparte de nuevo sobre
             lo que queda visible: cada sección estrena su propia destacada y
             ninguna entrada aparece dos veces. -->
        <?php $tk_rio = !empty($portada) ? array_merge([$portada], $posts) : $posts; ?>
        <?php if (!empty($tk_rio)) : ?>
            <div class="tk-rio" id="tk-rio">
                <?php foreach ($tk_rio as $ao_i => $post) echo tk_pieza($post, $ao_i, $ao_grads); ?>
            </div>
        <?php else : ?>
            <div class="tk-empty" data-anim>Todavía no hay entradas publicadas. La primera edición llega pronto.</div>
        <?php endif; ?>

        <!-- ============================ CUENTOS ============================= -->
        <section class="tk-seccion" data-anim id="tk-cuentos">
            <div class="tk-seccion-head">
                <div>
                    <span class="tk-seccion-kicker">/ Ficción</span>
                    <h2 class="tk-seccion-title">Cuentos</h2>
                </div>
                <p class="tk-seccion-sub">Narrativa breve. Se lee de una sentada.</p>
            </div>
            <?php if (!empty($cuentos)) : ?>
                <div class="tk-rio tk-rio--parejo">
                    <?php foreach ($cuentos as $ao_i => $post) echo tk_pieza($post, $ao_i, $ao_grads, 'Leer el cuento', false); ?>
                </div>
            <?php else : ?>
                <div class="tk-empty">Estoy escribiendo. Los primeros cuentos llegan pronto.</div>
            <?php endif; ?>
        </section>

        <!-- ====================== WATCHLIST (selección) =====================
             Va antes del catálogo: lo curado manda sobre lo exhaustivo. -->
        <?php if (!empty($seleccion)) : ?>
        <section class="sel-autor" data-anim>
            <div class="sel-head">
                <div>
                    <span class="sel-kicker">/ Watchlist</span>
                    <h2 class="sel-title">Para ver más <em>tarde…</em></h2>
                    <p class="sel-sub">Lo mejor que he visto: mi selección personal de cine y series.</p>
                </div>
                <div class="sel-head-acc">
                    <div class="sel-ctrl" data-estante-ctrl hidden>
                        <button type="button" class="sel-nav" data-estante-prev aria-label="Ver títulos anteriores"><?php echo icono('izquierda'); ?></button>
                        <button type="button" class="sel-nav" data-estante-next aria-label="Ver más títulos"><?php echo icono('derecha'); ?></button>
                    </div>
                    <a class="sel-vertodas" href="/tekhne/recomendaciones">Ver la watchlist <?php echo icono('derecha'); ?></a>
                </div>
            </div>
            <div class="sel-shelf" data-estante role="group" aria-label="Watchlist de cine y series">
                <?php foreach (array_slice($seleccion, 0, 12) as $t) : ?>
                    <a class="sel-card" href="/tekhne/pelicula/<?php echo generarSlug($t->titulo); ?>" title="<?php echo s($t->titulo); ?>">
                        <div class="sel-poster">
                            <?php if (!empty($t->poster)) : ?>
                                <img src="<?php echo urlSubida('peliculas', $t->poster); ?>" alt="<?php echo s($t->titulo); ?>" loading="lazy" draggable="false">
                            <?php else : ?>
                                <div class="sel-ph"><?php echo icono('film'); ?></div>
                            <?php endif; ?>
                            <span class="sel-badge sel-badge--pick" title="Selección del autor"><?php echo icono('estrella'); ?></span>
                        </div>
                        <h3 class="sel-name"><?php echo s($t->titulo); ?></h3>
                        <p class="sel-meta"><?php echo s($t->categoria); ?><?php echo $t->anio ? ' · ' . s($t->anio) : ''; ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- ====================== CATÁLOGO (solo admin) =====================
             La bitácora completa es una herramienta de trabajo, no una sección
             del medio: solo existe con sesión de admin (la ruta también lo
             comprueba, ver PortfolioController::peliculas). -->
        <?php if (!empty($esAdmin) && !empty($peliculas)) : ?>
        <section class="sel-autor sel-autor--privado" data-anim>
            <div class="sel-head">
                <div>
                    <span class="sel-kicker">/ Catálogo <span class="sel-privado"><?php echo icono('candado'); ?>Solo admin</span></span>
                    <h2 class="sel-title">Todo lo que he <em>visto</em></h2>
                    <p class="sel-sub">La bitácora completa, sin curar — <?php echo count($peliculas); ?> títulos calificados.</p>
                </div>
                <div class="sel-head-acc">
                    <div class="sel-ctrl" data-estante-ctrl hidden>
                        <button type="button" class="sel-nav" data-estante-prev aria-label="Ver títulos anteriores"><?php echo icono('izquierda'); ?></button>
                        <button type="button" class="sel-nav" data-estante-next aria-label="Ver más títulos"><?php echo icono('derecha'); ?></button>
                    </div>
                    <a class="sel-vertodas" href="/tekhne/peliculas">Abrir catálogo <?php echo icono('derecha'); ?></a>
                </div>
            </div>
            <div class="sel-shelf" data-estante role="group" aria-label="Catálogo de cine y series">
                <?php foreach (array_slice($peliculas, 0, 12) as $t) : $tiene = !empty(trim((string) $t->comentario)); $n = (float) $t->nota; ?>
                    <a class="sel-card" href="/tekhne/pelicula/<?php echo generarSlug($t->titulo); ?>" title="<?php echo s($t->titulo); ?>">
                        <div class="sel-poster">
                            <?php if (!empty($t->poster)) : ?>
                                <img src="<?php echo urlSubida('peliculas', $t->poster); ?>" alt="<?php echo s($t->titulo); ?>" loading="lazy" draggable="false">
                            <?php else : ?>
                                <div class="sel-ph"><?php echo icono('film'); ?></div>
                            <?php endif; ?>
                            <?php if ($tiene && $n > 0) : ?><span class="sel-badge"><?php echo icono('estrella'); ?><?php echo number_format($n, 0); ?></span><?php endif; ?>
                        </div>
                        <h3 class="sel-name"><?php echo s($t->titulo); ?></h3>
                        <p class="sel-meta"><?php echo s($t->categoria); ?><?php echo $t->anio ? ' · ' . s($t->anio) : ''; ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <?php if (!empty($peliculas) || !empty($seleccion)) echo creditoImdb(); ?>
    </main>
</div>
</div>

<script>
(function () {
    var rio      = document.getElementById('tk-rio');
    var tabs     = document.getElementById('tk-tabs');
    var input    = document.getElementById('tk-search');
    if (!tabs || !input) return;

    // Hay JS: el buscador ya puede hacer lo que promete. (La vista lo entrega
    // con [hidden] para no enseñar un campo muerto cuando no hay JS.)
    var caja = document.getElementById('tk-search-box');
    if (caja) caja.hidden = false;

    var clearBtn = document.getElementById('tk-search-clear');
    var noneMsg  = document.getElementById('tk-search-none');
    var recuento = document.getElementById('tk-recuento');
    var recTxt   = document.getElementById('tk-recuento-txt');
    var recN     = recuento ? recuento.querySelector('.tk-recuento-n') : null;
    var cuentos  = document.getElementById('tk-cuentos');
    var estantes = [].slice.call(document.querySelectorAll('.sel-autor'));
    var piezas   = [].slice.call(document.querySelectorAll('.tk-art'));
    var botones  = [].slice.call(tabs.querySelectorAll('.tk-tab'));

    var cat = 'todos', q = '';

    // GSAP Flip: al filtrar, lo que se queda se RECOLOCA en vez de saltar. Es
    // el mismo tratamiento del catálogo (pelicula/lista.php), así el gesto de
    // filtrar se siente igual en todo el sitio.
    var usaFlip = !!(window.gsap && window.Flip) &&
        !(window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches);
    if (usaFlip) gsap.registerPlugin(Flip);

    function norm(s) { return (s || '').normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase(); }

    // Cada pieza guarda su texto normalizado una sola vez: normalizar 40 cadenas
    // en cada pulsación de tecla es trabajo que no cambia nunca de resultado.
    piezas.forEach(function (p) { p.__txt = norm(p.getAttribute('data-search')); });

    function coincide(p) {
        if (cat !== 'todos' && p.getAttribute('data-cat') !== cat) return false;
        if (q === '') return true;
        return q.split(/\s+/).every(function (t) { return p.__txt.indexOf(t) !== -1; });
    }

    // La jerarquía de portada se reparte sobre lo VISIBLE, no sobre el orden
    // del HTML: filtrando por «Cultura» la primera de Cultura pasa a ser la
    // destacada. Sin esto, una sección podía quedarse sin cabeza de portada.
    function jerarquia() {
        if (!rio) return;
        var vivas = [].slice.call(rio.querySelectorAll('.tk-art')).filter(function (p) { return p.style.display !== 'none'; });
        vivas.forEach(function (p, i) {
            p.classList.toggle('tk-art--lead', i === 0);
            p.classList.toggle('tk-art--sub', i === 1 || i === 2);
        });
    }

    function seccionVisible(sec) {
        if (!sec) return 0;
        var vis = [].slice.call(sec.querySelectorAll('.tk-art')).filter(function (c) { return c.style.display !== 'none'; });
        sec.style.display = vis.length ? '' : 'none';
        return vis.length;
    }

    function aplicar() {
        var estado = usaFlip ? Flip.getState(piezas) : null;

        var n = 0, nRio = 0;
        piezas.forEach(function (p) {
            var ok = coincide(p);
            p.style.display = ok ? '' : 'none';
            if (!ok) return;
            n++;
            if (rio && rio.contains(p)) nRio++;
        });
        jerarquia();
        // Un contenedor vacío sigue ocupando sus márgenes: filtrando por
        // «Cuentos», el río quedaba como un hueco mudo entre la barra y el
        // título de la sección. Se retira el que no tenga nada que enseñar.
        if (rio) rio.style.display = nRio ? '' : 'none';
        seccionVisible(cuentos);

        // Los estantes de cine no son entradas: no se buscan ni se filtran por
        // sección, se retiran mientras haya un filtro puesto.
        var limpio = (cat === 'todos' && q === '');
        estantes.forEach(function (s) { s.style.display = limpio ? '' : 'none'; });

        if (estado) Flip.from(estado, {
            duration: .5, ease: 'power2.inOut', absolute: true, stagger: { amount: .3 },
            onEnter: function (els) { return gsap.fromTo(els, { opacity: 0, scale: .94 }, { opacity: 1, scale: 1, duration: .4, ease: 'power2.out' }); },
            onLeave: function (els) { return gsap.to(els, { opacity: 0, scale: .94, duration: .24, ease: 'power2.in' }); }
        });

        noneMsg.hidden = n !== 0;
        if (!noneMsg.hidden) noneMsg.querySelector('span').textContent = input.value.trim();

        if (recN) recN.textContent = n;
        if (recTxt) {
            var etiqueta = botones.filter(function (b) { return b.dataset.cat === cat; })[0];
            var nombre = etiqueta ? etiqueta.textContent.trim() : 'Portada';
            recTxt.textContent = (n === 1 ? 'entrada' : 'entradas') +
                (q !== '' ? ' para «' + input.value.trim() + '»' : (cat === 'todos' ? ' en portada' : ' en ' + nombre));
        }
    }

    // ---- Pestañas de sección -------------------------------------------
    // Siguen siendo enlaces: sin JS, con clic central o con Ctrl abren la
    // página de categoría de verdad. El filtro en el sitio solo se queda el
    // clic simple, que es el que se beneficia de no recargar.
    tabs.addEventListener('click', function (e) {
        var tab = e.target.closest('.tk-tab');
        if (!tab || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;
        e.preventDefault();
        cat = tab.dataset.cat || 'todos';
        botones.forEach(function (b) {
            var on = b === tab;
            b.classList.toggle('is-on', on);
            // 'true' y no 'page': con JS no se navega a ningún sitio, se filtra
            // aquí mismo. Decir «page» describiría una página que no ha cambiado.
            if (on) b.setAttribute('aria-current', 'true'); else b.removeAttribute('aria-current');
        });
        aplicar();
    });

    // ---- Buscador -------------------------------------------------------
    // Se espera a que la persona pare de teclear: cada pasada mide todas las
    // piezas dos veces (Flip) y eso no puede correr por pulsación.
    var t = null;
    input.addEventListener('input', function () {
        clearBtn.hidden = input.value.trim() === '';
        clearTimeout(t);
        t = setTimeout(function () { q = norm(input.value.trim()); aplicar(); }, 140);
    });
    function limpiar() { clearTimeout(t); input.value = ''; clearBtn.hidden = true; q = ''; aplicar(); }
    clearBtn.addEventListener('click', function () { limpiar(); input.focus(); });
    input.addEventListener('keydown', function (e) { if (e.key === 'Escape') limpiar(); });

    // «/» enfoca el buscador, como en cualquier medio con archivo grande.
    document.addEventListener('keydown', function (e) {
        if (e.key !== '/' || e.metaKey || e.ctrlKey || e.altKey) return;
        var a = document.activeElement;
        if (a && (a.tagName === 'INPUT' || a.tagName === 'TEXTAREA' || a.isContentEditable)) return;
        e.preventDefault();
        input.focus();
        input.select();
    });

    jerarquia();
})();
</script>

<?php include __DIR__ . '/../partials/paginas-foot.php'; ?>
