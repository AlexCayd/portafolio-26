<!-- anime.js (reveals) y GSAP ya vienen de portfolio-layout.php: aquí solo la lógica.
     Las transiciones de página las hace View Transitions nativo. -->
<script>
(function () {
    // Bloqueo de scroll para capas (menú, lightbox). Con Lenis activo no basta
    // con overflow:hidden en el body: hay que parar también el bucle suave.
    function bloquearScroll(on) {
        document.body.style.overflow = on ? 'hidden' : '';
        if (window.__aoLenis) { try { on ? window.__aoLenis.stop() : window.__aoLenis.start(); } catch (e) {} }
    }

    // ---- Reveal robusto (IntersectionObserver + anime.js) ---------------
    // prefers-reduced-motion: esta entrada movía 30px, escalaba y desenfocaba
    // CADA bloque de todas las páginas internas sin consultar la preferencia —
    // en Tékhne son la mancheta, la barra, cada entrada del río y cada estante.
    // Reducido no es inmóvil: se conserva el fundido (la señal de «esto acaba
    // de aparecer») y se quitan el desplazamiento y el desenfoque, que son lo
    // que provoca el malestar. Se relee en vivo: la preferencia se cambia sin
    // recargar y el siguiente reveal ya respeta el valor nuevo.
    var mqMov = window.matchMedia ? matchMedia('(prefers-reduced-motion: reduce)') : null;
    function suave() { return !(mqMov && mqMov.matches); }

    function reveal(scope) {
        var root = scope || document;
        var els = [].slice.call(root.querySelectorAll('[data-anim]'));
        if (!els.length) return;
        var mueve = suave();
        els.forEach(function (el) {
            el.removeAttribute('data-shown');
            el.style.opacity = '0';
            // La transición NO se declara aquí: opacity y transition caerían en
            // el mismo recálculo y el navegador animaría el 1 → 0, o sea la
            // página desvaneciéndose antes de entrar. Se pone en show().
            if (!mueve) { el.style.transform = ''; el.style.filter = ''; el.style.transition = ''; return; }
            el.style.transform = 'translateY(30px) scale(.98)';
            // El blur se maneja con transición CSS aparte (anime.js no interpola bien blur()).
            el.style.filter = 'blur(7px)'; el.style.transition = 'filter .8s cubic-bezier(.16,1,.3,1)';
        });
        function clearFx(el) { el.style.filter = ''; el.style.willChange = ''; }
        function show(el, i) {
            if (el.getAttribute('data-shown')) return;
            el.setAttribute('data-shown', '1');
            if (!suave()) {
                // Solo opacidad: nada de will-change ni de capas de GPU que aquí
                // no compensan, y sin escalonado — cuarenta fundidos en cascada
                // son cuarenta cosas moviéndose, que es justo lo que se pidió no.
                el.style.transition = 'opacity .45s linear';
                el.style.opacity = '1'; el.style.transform = ''; clearFx(el);
                return;
            }
            // will-change SOLO mientras dura la entrada. Antes se ponía de golpe
            // a todos los [data-anim]: en el catálogo de películas son cientos
            // de tarjetas promovidas a capa propia —y `filter` promociona— desde
            // el primer fotograma y hasta que a cada una le toca entrar. Eso son
            // cientos de capas vivas a la vez; en un móvil es memoria de GPU que
            // no existe, y se paga en todo el scroll, no solo en la animación.
            el.style.willChange = 'opacity, transform, filter';
            el.style.filter = 'blur(0px)';                       // dispara la transición CSS del blur
            if (window.anime) anime({
                targets: el, opacity: [0, 1], translateY: [30, 0], scale: [.98, 1],
                duration: 820, delay: (i || 0) * 80, easing: 'cubicBezier(.16,1,.3,1)',
                complete: function () { clearFx(el); }
            });
            else { el.style.transition += ', opacity .6s ease, transform .6s ease'; el.style.opacity = '1'; el.style.transform = 'none'; clearFx(el); }
        }
        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.filter(function (e) { return e.isIntersecting; }).forEach(function (e, i) { io.unobserve(e.target); show(e.target, i); });
            }, { rootMargin: '0px 0px -6% 0px', threshold: 0.04 });
            els.forEach(function (el) { io.observe(el); });
        } else { els.forEach(show); }
        setTimeout(function () {
            els.forEach(function (el) { if (!el.getAttribute('data-shown')) { el.setAttribute('data-shown', '1'); el.style.opacity = '1'; el.style.transform = 'none'; clearFx(el); } });
        }, 1600);
    }

    // ---- Barra de progreso de lectura ----------------------------------
    // Indicador puro. En un artículo mide el cuerpo del texto, no el documento
    // entero: así el hero a sangre y los recursos relacionados no falsean
    // cuánto se ha leído.
    var cuerpo = document.querySelector('main.pg--article .pg-body');
    var minutos = 0;
    if (cuerpo) {
        // El dato lo escribe el servidor; raspar el texto del kicker es el respaldo
        minutos = parseInt(cuerpo.getAttribute('data-min') || '', 10) || 0;
        if (!minutos) {
            var kicker = document.querySelector('.pg-kicker');
            var mm = kicker && (kicker.textContent || '').match(/(\d+)\s*MIN/i);
            if (mm) minutos = parseInt(mm[1], 10) || 0;
        }
    }

    var bar = document.createElement('div');
    bar.className = 'pg-progress' + (cuerpo ? ' pg-progress--live' : '');
    bar.innerHTML = '<div class="pg-progress-fill"></div>';
    if (cuerpo) {
        // progressbar y no slider: la barra informa, no se opera. Un slider que
        // no responde al dedo (estaba apagado en puntero grueso) y que mide 4px
        // es una promesa falsa, y además metía una parada de tabulación que no
        // hacía nada que las flechas no hicieran ya sobre la página.
        bar.setAttribute('role', 'progressbar');
        bar.setAttribute('aria-label', 'Progreso de lectura');
        bar.setAttribute('aria-valuemin', '0');
        bar.setAttribute('aria-valuemax', '100');
    }
    // La barra se cuelga del borde inferior de la cabecera, no del borde de la
    // ventana: pegada a top:0 y por encima del header quedaba delante del nav.
    // Aquí además se lee mejor — es el subrayado de la cabecera llenándose.
    // OJO: los tokens de tema (--fg, --accent, --line…) están definidos sobre
    // #ao-app, no sobre :root. Lo que se cuelgue de <body> queda fuera de ese
    // ámbito y cada color con var() se vuelve una declaración inválida: es lo
    // que dejaba esta barra completamente incolora. Todo va dentro de #ao-app.
    var app = document.getElementById('ao-app') || document.body;
    var cabecera = document.querySelector('.pg-top');
    if (cabecera) cabecera.appendChild(bar);
    else { bar.classList.add('pg-progress--suelta'); app.appendChild(bar); }
    var fill = bar.querySelector('.pg-progress-fill');

    // Rango de scroll que corresponde al 0 % y al 100 % de lectura.
    // Se mide UNA vez y se guarda: medir dentro del listener de scroll fuerza un
    // reflujo síncrono en cada evento —medidos 519 en el catálogo de películas y
    // 85 en un artículo— y eso es justo lo que rompe la fluidez del scroll.
    // Se mide con offsetTop/offsetHeight y no con getBoundingClientRect porque
    // el reveal aplica un translateY(30px) sobre .pg-body: el rect lo incluye y
    // medir durante la entrada congelaría un rango desplazado. offset* ignora
    // los transform, así que da la posición real esté animando o no.
    var cache = null;

    function medirRango() {
        if (!cuerpo) {
            var h = document.documentElement.scrollHeight - window.innerHeight;
            return { ini: 0, fin: Math.max(1, h) };
        }
        var top = 0, el = cuerpo;
        while (el) { top += el.offsetTop; el = el.offsetParent; }
        // El artículo se da por leído cuando su final entra en el viewport
        var fin = top + cuerpo.offsetHeight - window.innerHeight * 0.9;
        return { ini: top - window.innerHeight * 0.55, fin: Math.max(top + 1, fin) };
    }

    function rango() { return cache || (cache = medirRango()); }

    function invalidar() { cache = null; updateProgress(); }

    var progreso = 0, ultimoPct = -1;

    function pintar(p) {
        progreso = Math.max(0, Math.min(1, p));
        fill.style.transform = 'scaleX(' + progreso + ')';
        if (!cuerpo) return;
        var n = Math.round(progreso * 100);
        // Solo al cambiar de entero: escribir ARIA en cada evento de scroll
        // rehace el árbol de accesibilidad cien veces por el mismo 38 %.
        if (n === ultimoPct) return;
        ultimoPct = n;
        var queda = minutos
            ? (n >= 99 ? 'terminado' : Math.max(1, Math.round(minutos * (1 - progreso))) + ' min restantes')
            : '';
        bar.setAttribute('aria-valuenow', String(n));
        // Un «38» a secas no dice nada: el lector de pantalla lee el dato útil.
        // Visualmente basta la barra, pero quien no la ve necesita el minutaje.
        bar.setAttribute('aria-valuetext', n + '% leído' + (queda ? ' · ' + queda : ''));
    }

    function updateProgress() {
        var r = rango();
        pintar((window.scrollY - r.ini) / (r.fin - r.ini));
    }
    window.addEventListener('scroll', updateProgress, { passive: true });
    window.addEventListener('resize', invalidar);
    // La altura cambia al cargar las imágenes —el catálogo de películas son
    // cientos de pósters— y con el rango guardado habría que remedirlo.
    if (window.ResizeObserver) {
        try { new ResizeObserver(invalidar).observe(cuerpo || document.documentElement); } catch (e) {}
    }

    function boot() {
        // invalidar() y no updateProgress(): boot() también corre al volver desde
        // bfcache, y ahí el rango guardado puede ser de otro tamaño de ventana.
        reveal(); invalidar();
        if (window.ScrollTrigger) ScrollTrigger.refresh();
    }
    if (document.readyState === 'complete') boot();
    else window.addEventListener('load', boot);
    // bfcache: al retroceder no se dispara 'load', así que el contenido se quedaría
    // invisible (opacity 0 del reveal). Se vuelve a lanzar al restaurar la página.
    window.addEventListener('pageshow', function (e) { if (e.persisted) boot(); });

    // ---- Lightbox de galería (imágenes horizontales) -------------------
    // El visor lo monta el JS, así que también es el JS quien marca la galería
    // como ampliable (.is-lightbox): sin él no se anuncia una lupa que no abre.
    var imgs = [].slice.call(document.querySelectorAll('[data-lightbox] img'));
    if (imgs.length) {
        document.querySelectorAll('[data-lightbox]').forEach(function (g) { g.classList.add('is-lightbox'); });
        var lb = document.createElement('div');
        lb.className = 'lightbox';
        lb.setAttribute('role', 'dialog');
        lb.setAttribute('aria-modal', 'true');
        lb.setAttribute('aria-label', 'Imagen ampliada');
        lb.innerHTML = '<button class="lb-close" aria-label="Cerrar">✕</button>' +
            '<button class="lb-nav lb-prev" aria-label="Anterior">‹</button>' +
            '<figure class="lb-stage"><img alt=""></figure>' +
            '<button class="lb-nav lb-next" aria-label="Siguiente">›</button>' +
            '<div class="lb-count"></div>';
        document.body.appendChild(lb);
        var lbImg = lb.querySelector('.lb-stage img'), lbCount = lb.querySelector('.lb-count'), idx = 0;
        var lbCerrar = lb.querySelector('.lb-close'), devolverFoco = null;
        function render() {
            lbImg.src = imgs[idx].src; lbImg.alt = imgs[idx].alt || '';
            lbCount.textContent = (idx + 1) + ' / ' + imgs.length;
        }
        function open(i) {
            idx = i; render(); lb.classList.add('open'); bloquearScroll(true);
            devolverFoco = imgs[i];
            lbCerrar.focus();
        }
        function close() {
            lb.classList.remove('open'); bloquearScroll(false);
            if (devolverFoco) { devolverFoco.focus(); devolverFoco = null; }   // el foco vuelve a la miniatura
        }
        function go(d) { idx = (idx + d + imgs.length) % imgs.length; render(); }
        imgs.forEach(function (im, i) {
            // Sin esto la galería es solo para ratón: una <img> no recibe foco
            im.tabIndex = 0;
            im.setAttribute('role', 'button');
            im.addEventListener('click', function () { open(i); });
            im.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ' || e.key === 'Spacebar') { e.preventDefault(); open(i); }
            });
        });
        lbCerrar.addEventListener('click', close);
        lb.querySelector('.lb-prev').addEventListener('click', function (e) { e.stopPropagation(); go(-1); });
        lb.querySelector('.lb-next').addEventListener('click', function (e) { e.stopPropagation(); go(1); });
        lb.addEventListener('click', function (e) { if (e.target === lb || e.target.classList.contains('lb-stage')) close(); });
        document.addEventListener('keydown', function (e) {
            if (!lb.classList.contains('open')) return;
            if (e.key === 'Escape') close();
            else if (e.key === 'ArrowLeft') go(-1);
            else if (e.key === 'ArrowRight') go(1);
            else if (e.key === 'Tab') {
                // Trampa de foco: los tres botones del visor y nada más
                var f = [].slice.call(lb.querySelectorAll('button'));
                var i = f.indexOf(document.activeElement);
                e.preventDefault();
                f[(i + (e.shiftKey ? -1 : 1) + f.length) % f.length].focus();
            }
        });
    }

    // ---- View transition: la miniatura clicada morfa hacia la página destino ----
    // Solo un elemento puede llevar un mismo view-transition-name a la vez, así que
    // se marca la miniatura de la tarjeta clicada justo antes de navegar (y se
    // limpia al volver atrás desde bfcache).
    var marcado = null;
    function limpiarMarca() {
        if (marcado) { marcado.style.viewTransitionName = ''; marcado = null; }
    }
    function morfar(selectorTarjeta, selectorMedia, nombre) {
        document.querySelectorAll(selectorTarjeta).forEach(function (card) {
            card.addEventListener('click', function () {
                limpiarMarca();
                var media = card.querySelector(selectorMedia);
                if (!media) return;
                media.style.viewTransitionName = nombre;
                marcado = media;
            });
        });
    }
    // Póster del catálogo / estanterías → ficha de película
    morfar('a.sel-card[href*="/tekhne/pelicula/"]', '.sel-poster', 'ao-poster');
    // Portada de la tarjeta de artículo → hero del artículo
    morfar('a[data-vt-cover]', '[data-vt-img]', 'ao-cover');
    window.addEventListener('pageshow', limpiarMarca);

    // ---- Modo Focus (artículo): limpia la pantalla para leer ------------
    var focusBtn = document.getElementById('pg-focus');
    if (focusBtn) {
        function setFocus(on) {
            document.documentElement.classList.toggle('is-focus', on);
            focusBtn.setAttribute('aria-pressed', on ? 'true' : 'false');
            var etiqueta = on ? 'Salir del modo lectura' : 'Modo lectura';
            focusBtn.title = etiqueta;
            focusBtn.setAttribute('aria-label', etiqueta);
            try { localStorage.setItem('ao-focus', on ? '1' : '0'); } catch (e) {}
        }
        // El chrome de la cabecera se funde con transiciones CSS, pero el ancho
        // de la columna de lectura no: animar max-width obligaría a recomponer
        // el artículo entero en cada fotograma. View Transitions resuelve el
        // reflow UNA vez y cruza el antes con el después.
        //
        // `vt-local` marca que esto es un cambio de estado y no una navegación:
        // portfolio.css tiene escrito el guion de las navegaciones (la página
        // sale hacia arriba y la nueva entra desde abajo con desenfoque) y sin
        // la marca el modo lectura lo heredaba entero. Y el nombre inline del
        // hero se retira mientras dura, o `ao-cover` abre su propio grupo de
        // morph para una imagen que no se ha movido ni un píxel.
        // La preferencia de movimiento se consulta en el clic, no al cargar:
        // se puede cambiar con la página abierta.
        var heroMedia = document.getElementById('art-hero-media');
        focusBtn.addEventListener('click', function () {
            var on = !document.documentElement.classList.contains('is-focus');
            var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (!document.startViewTransition || reduce) { setFocus(on); return; }

            var raiz = document.documentElement;
            raiz.classList.add('vt-local');
            if (heroMedia) heroMedia.style.viewTransitionName = 'none';
            var restaurar = function () {
                raiz.classList.remove('vt-local');
                if (heroMedia) heroMedia.style.viewTransitionName = 'ao-cover';
            };
            var vt = document.startViewTransition(function () { setFocus(on); });
            if (vt && vt.finished && vt.finished.then) vt.finished.then(restaurar, restaurar);
            else setTimeout(restaurar, 400);
        });
        // El estado guardado se restaura SIN transición: con startViewTransition
        // aquí, abrir la página en modo lectura enseñaba un fundido fantasma.
        try { if (localStorage.getItem('ao-focus') === '1') setFocus(true); } catch (e) {}
    }

    // ---- Espera al bundle -----------------------------------------------
    // Este script va en línea, así que corre ANTES que bundle.min.js (defer).
    // Antes se sondeaba cada 100 ms hasta cuatro segundos: aunque el bundle ya
    // estuviera listo, el gas de las tarjetas no arrancaba hasta el siguiente
    // sondeo. Ahora ao-init.js avisa con 'ao:listo' y se arranca en ese mismo
    // instante; la bandera cubre el caso de que ya haya avisado.
    function cuandoListo(fn) {
        if (window.aoListo) { fn(); return; }
        document.addEventListener('ao:listo', fn, { once: true });
    }

    // ---- Portadas por defecto: el gas interactivo del hero del home ----
    var gl = document.getElementById('art-hero-gl');
    var miniaturas = document.querySelector('canvas[data-gas]');
    if (gl || miniaturas) {
        cuandoListo(function () {
            if (!window.THREE) return;          // sin WebGL queda el degradado de respaldo
            if (gl && window.aoGas) {
                var gas = window.aoGas(gl, {
                    medir: function () {
                        var c = gl.parentElement || gl;
                        return { w: Math.max(1, c.offsetWidth), h: Math.max(1, c.offsetHeight) };
                    },
                    vigneta: 0.82       // menos viñeta: la portada es más chica que el hero
                });
                // La portada mide 100vh: en cuanto se empieza a leer queda
                // fuera y seguir pintándola cada fotograma es el gasto más
                // caro de la página a cambio de nada que nadie ve.
                var heroSec = document.getElementById('art-hero');
                if (gas && gas.activar && heroSec && window.IntersectionObserver) {
                    new IntersectionObserver(function (es) {
                        gas.activar(es[0].isIntersecting);
                    }).observe(heroSec);
                }
            }
            if (miniaturas && window.aoGasMiniaturas) window.aoGasMiniaturas();
        });
    }

    // ---- Scroll suave, el mismo del home -------------------------------
    // initLenis() vive dentro de boot(), que exige el hero y el pie del home:
    // las páginas internas se quedaban con scroll nativo mientras el home iba
    // suave. Se arranca en cuanto el bundle expone la API (respeta
    // prefers-reduced-motion por su cuenta).
    cuandoListo(function () { if (window.aoLenis) window.aoLenis(); });

    // ---- Breadcrumb: banda solo cuando está anclado --------------------
    // La barra de ruta es sticky. En una entrada nace entre el hero a sangre y
    // el primer párrafo, y ahí su velo con filete inferior partía la página en
    // dos justo donde la portada se funde con el fondo. Anclada bajo el menú sí
    // hace falta, porque flota sobre el texto.
    //
    // No hay selector CSS para «sticky pegado», así que se mide con un
    // centinela de 1px puesto delante de la barra. Un IntersectionObserver con
    // el borde superior recortado al alto de la cabecera avisa al cruzar esa
    // línea; `boundingClientRect.top` desambigua el caso que el observador solo
    // no distingue: «el centinela se fue por arriba» (anclada) frente a «el
    // centinela aún no ha llegado, está más abajo de la ventana» (suelta) —los
    // dos dan isIntersecting false. Cuesta cero por evento de scroll, que es lo
    // que importa en una página que se recorre entera leyendo.
    var centinela = document.querySelector('.pg-crumb-centinela');
    var barraRuta = document.querySelector('.pg-crumb-bar');
    if (centinela && barraRuta) {
        var cabeceraRuta = document.querySelector('.pg-top');
        var obsRuta = null;

        function pintarRuta(top) {
            var limite = cabeceraRuta ? cabeceraRuta.offsetHeight : 72;
            barraRuta.classList.toggle('is-suelta', top > limite - 1);
        }
        function montarRuta() {
            if (obsRuta) obsRuta.disconnect();
            var limite = cabeceraRuta ? cabeceraRuta.offsetHeight : 72;
            // Medición síncrona al arrancar: el observador no dispara hasta
            // después del layout y, sin esto, una entrada enseñaría la banda
            // durante un fotograma antes de quitarla.
            pintarRuta(centinela.getBoundingClientRect().top);
            obsRuta = new IntersectionObserver(function (es) {
                pintarRuta(es[0].boundingClientRect.top);
            }, { rootMargin: '-' + limite + 'px 0px 0px 0px', threshold: [0, 1] });
            obsRuta.observe(centinela);
        }
        if ('IntersectionObserver' in window) {
            montarRuta();
            // El alto de la cabecera cambia de tramo (64px bajo 560px), así que
            // el recorte del observador deja de valer y hay que rehacerlo.
            var tRuta = null;
            window.addEventListener('resize', function () {
                clearTimeout(tRuta);
                tRuta = setTimeout(montarRuta, 150);
            });
        }
    }

    // ---- Estantes horizontales (watchlist / catálogo) ------------------
    // El problema que arregla esto: el estante llevaba `data-lenis-prevent`,
    // que le dice a Lenis «no toques NINGUNA rueda que pase por aquí». Con eso
    // el gesto diagonal del trackpad dejaba de dar el tirón vertical… y también
    // dejaba de bajar la página: al pasar el puntero por encima de la fila de
    // pósters el scroll se quedaba muerto, que es justo la sensación de rotura.
    //
    // El reparto correcto no es por zona, es por gesto:
    //   · rueda vertical  → la página (Lenis), siempre, esté donde esté el ratón
    //   · gesto horizontal → el estante, y el evento no sale de aquí
    // Lenis escucha en `window`, así que basta con cortar la propagación del
    // evento en el estante para que no lo vea. `stopPropagation` no anula la
    // acción por defecto: el desplazamiento horizontal nativo sigue su curso.
    var estantes = [].slice.call(document.querySelectorAll('[data-estante]'));
    estantes.forEach(function (est) {
        function recorrido() { return est.scrollWidth - est.clientWidth; }

        est.addEventListener('wheel', function (e) {
            if (e.ctrlKey) return;                 // zoom del navegador
            if (recorrido() < 2) return;           // no hay nada que correr: manda la página

            if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) {
                e.stopPropagation();               // gesto horizontal: es del estante
                return;                            // el navegador ya lo desplaza solo
            }
            // Mayús + rueda: Firefox lo desplaza solo y Chrome lo manda como
            // deltaX. Se hace a mano en los dos para que el resultado sea el
            // mismo — y con preventDefault no hay doble movimiento.
            if (e.shiftKey) {
                e.stopPropagation();
                e.preventDefault();
                est.scrollLeft += e.deltaY;
            }
            // Rueda vertical a secas: no se toca. La página sigue bajando.
        }, { passive: false });

        // Flechas: el único acceso del ratón sin rueda horizontal. Se muestran
        // solo si de verdad hay recorrido (y en táctil no: ahí basta el dedo).
        var caja = est.closest('.sel-autor') || est.parentElement;
        var ctrl = caja && caja.querySelector('[data-estante-ctrl]');
        var prev = caja && caja.querySelector('[data-estante-prev]');
        var next = caja && caja.querySelector('[data-estante-next]');
        if (!ctrl || !prev || !next) return;

        var tactil = window.matchMedia && matchMedia('(hover: none)').matches;
        function paso() { return Math.max(200, Math.round(est.clientWidth * 0.8)); }
        function correr(d) {
            // `behavior: 'smooth'` es movimiento, y bastante: 800px de pósters
            // cruzando la pantalla. Con reduced-motion el estante salta al sitio
            // —el cambio se ve igual, sin el recorrido.
            est.scrollBy({ left: d * paso(), behavior: suave() ? 'smooth' : 'auto' });
        }
        prev.addEventListener('click', function () { correr(-1); });
        next.addEventListener('click', function () { correr(1); });

        var pedido = false;
        function pintar() {
            pedido = false;
            var hay = recorrido();
            ctrl.hidden = tactil || hay < 2;
            prev.disabled = est.scrollLeft < 4;
            next.disabled = est.scrollLeft > hay - 4;
        }
        est.addEventListener('scroll', function () {
            if (pedido) return;                    // un repintado por fotograma, no por evento
            pedido = true;
            requestAnimationFrame(pintar);
        }, { passive: true });
        window.addEventListener('resize', pintar);
        pintar();
        // Los pósters entran con loading="lazy": el recorrido real no se conoce
        // hasta que cargan, y antes de eso las flechas saldrían apagadas.
        if (window.ResizeObserver) { try { new ResizeObserver(pintar).observe(est); } catch (e) {} }
    });

    // ---- Menú de navegación de las páginas internas --------------------
    var burger = document.getElementById('pg-burger');
    var overlay = document.getElementById('pg-menu');
    if (burger && overlay) {
        var abrir = function (on) {
            overlay.classList.toggle('is-open', on);
            burger.classList.toggle('is-open', on);
            burger.setAttribute('aria-expanded', on ? 'true' : 'false');
            burger.setAttribute('aria-label', on ? 'Cerrar menú' : 'Abrir menú');
            bloquearScroll(on);
            // El foco entra al menú al abrir y vuelve a la hamburguesa al cerrar
            if (on) requestAnimationFrame(function () { var p = overlay.querySelector('a'); if (p) p.focus(); });
            else if (overlay.contains(document.activeElement)) burger.focus();
        };
        burger.addEventListener('click', function () { abrir(!overlay.classList.contains('is-open')); });
        overlay.addEventListener('click', function (e) { if (e.target.closest('a')) abrir(false); });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && overlay.classList.contains('is-open')) abrir(false);
        });
    }

    // ---- Hero del artículo con GSAP (parallax + reveal) ---------------
    var hero = document.getElementById('art-hero');
    var reduceGsap = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (hero && window.gsap && !reduceGsap) {
        var media = document.getElementById('art-hero-media');
        var els = hero.querySelectorAll('.art-hero-el');
        if (window.ScrollTrigger) gsap.registerPlugin(ScrollTrigger);

        // Entrada: la imagen escala hacia adentro y el texto sube escalonado
        gsap.fromTo(media, { scale: 1.14 }, { scale: 1, duration: 1.6, ease: 'power3.out' });
        gsap.from(els, { y: 40, opacity: 0, duration: 1, ease: 'power3.out', stagger: 0.12, delay: 0.15 });

        // Parallax al hacer scroll: la imagen se desplaza más lento y se oscurece
        if (window.ScrollTrigger) {
            gsap.to(media, { yPercent: 22, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true } });
            gsap.to('.art-hero-inner', { yPercent: -8, opacity: .35, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true } });
        }
    } else if (hero) {
        // Sin GSAP / reduced-motion: mostrar todo estático
        hero.querySelectorAll('.art-hero-el').forEach(function (e) { e.style.opacity = '1'; });
    }

    // El desenfoque de la cabecera solo significa algo mientras hay portada
    // detrás. Pasado el hero, el fondo es plano y ese backdrop-filter se
    // recompone en cada fotograma para difuminar un color liso: se apaga.
    // Vale con o sin GSAP y con reduced-motion — no es decoración, es coste.
    var cabeceraFija = document.querySelector('.pg-top');
    if (hero && cabeceraFija && window.IntersectionObserver) {
        new IntersectionObserver(function (es) {
            cabeceraFija.classList.toggle('is-plana', !es[0].isIntersecting);
        }).observe(hero);
    }
})();
</script>
