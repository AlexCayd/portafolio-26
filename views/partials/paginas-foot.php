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
    function reveal(scope) {
        var root = scope || document;
        var els = [].slice.call(root.querySelectorAll('[data-anim]'));
        if (!els.length) return;
        els.forEach(function (el) {
            el.removeAttribute('data-shown');
            el.style.opacity = '0'; el.style.transform = 'translateY(30px) scale(.98)';
            // El blur se maneja con transición CSS aparte (anime.js no interpola bien blur()).
            el.style.filter = 'blur(7px)'; el.style.transition = 'filter .8s cubic-bezier(.16,1,.3,1)';
        });
        function clearFx(el) { el.style.filter = ''; el.style.willChange = ''; }
        function show(el, i) {
            if (el.getAttribute('data-shown')) return;
            el.setAttribute('data-shown', '1');
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
            focusBtn.title = on ? 'Salir del modo lectura' : 'Modo lectura';
            try { localStorage.setItem('ao-focus', on ? '1' : '0'); } catch (e) {}
        }
        focusBtn.addEventListener('click', function () { setFocus(!document.documentElement.classList.contains('is-focus')); });
        try { if (localStorage.getItem('ao-focus') === '1') setFocus(true); } catch (e) {}
    }

    // ---- Portadas por defecto: el gas interactivo del hero del home ----
    // El bundle se carga con defer, así que se espera a que exponga las APIs.
    // Si no llegan en 4 s se abandona y queda el degradado de respaldo.
    var gl = document.getElementById('art-hero-gl');
    var miniaturas = document.querySelector('canvas[data-gas]');
    if (gl || miniaturas) {
        var intentos = 0;
        (function montar() {
            if (window.THREE && window.aoGas && window.aoGasMiniaturas) {
                if (gl) {
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
                if (miniaturas) window.aoGasMiniaturas();
                return;
            }
            if (++intentos < 40) setTimeout(montar, 100);
        })();
    }

    // ---- Scroll suave, el mismo del home -------------------------------
    // initLenis() vive dentro de boot(), que exige el hero y el pie del home:
    // las páginas internas se quedaban con scroll nativo mientras el home iba
    // suave. Se arranca en cuanto el bundle expone la API (respeta
    // prefers-reduced-motion por su cuenta).
    var intentosLenis = 0;
    (function suave() {
        if (window.aoLenis) { window.aoLenis(); return; }
        if (++intentosLenis < 40) setTimeout(suave, 100);
    })();

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
            var cue = document.getElementById('art-hero-cue');
            if (cue) gsap.to(cue, { opacity: 0, ease: 'none', scrollTrigger: { trigger: hero, start: 'top top', end: '18% top', scrub: true } });
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
