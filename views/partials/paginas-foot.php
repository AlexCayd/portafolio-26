<!-- anime.js: reveals + lightbox de galería (las transiciones de página las hace View Transitions nativo) -->
<script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
<script>
(function () {
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
            el.style.willChange = 'opacity, transform, filter';
        });
        function clearFx(el) { el.style.filter = ''; el.style.willChange = 'auto'; }
        function show(el, i) {
            if (el.getAttribute('data-shown')) return;
            el.setAttribute('data-shown', '1');
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
    // En un artículo es interactiva (se puede arrastrar para navegar el texto) y
    // mide el cuerpo del artículo, no el documento entero: así el hero a sangre y
    // los recursos relacionados no falsean cuánto se ha leído.
    var cuerpo = document.querySelector('main.pg--article .pg-body');
    var minutos = 0;
    var kicker = document.querySelector('.pg-kicker');
    if (kicker) {
        var mm = (kicker.textContent || '').match(/(\d+)\s*MIN/i);
        if (mm) minutos = parseInt(mm[1], 10) || 0;
    }

    var bar = document.createElement('div');
    bar.className = 'pg-progress' + (cuerpo ? ' pg-progress--live' : '');
    bar.innerHTML = '<div class="pg-progress-fill"></div>' +
        (cuerpo ? '<div class="pg-progress-knob"></div><div class="pg-progress-pct"><b>0%</b><span></span></div>' : '');
    if (cuerpo) {
        bar.setAttribute('role', 'slider');
        bar.setAttribute('aria-label', 'Progreso de lectura');
        bar.setAttribute('aria-valuemin', '0');
        bar.setAttribute('aria-valuemax', '100');
        bar.tabIndex = 0;
    }
    document.body.appendChild(bar);
    var fill = bar.querySelector('.pg-progress-fill');
    var knob = bar.querySelector('.pg-progress-knob');
    var pct  = bar.querySelector('.pg-progress-pct');

    // Rango de scroll que corresponde al 0 % y al 100 % de lectura
    function rango() {
        if (!cuerpo) {
            var h = document.documentElement.scrollHeight - window.innerHeight;
            return { ini: 0, fin: Math.max(1, h) };
        }
        var r = cuerpo.getBoundingClientRect();
        var top = r.top + window.scrollY;
        // El artículo se da por leído cuando su final entra en el viewport
        var fin = top + r.height - window.innerHeight * 0.9;
        return { ini: top - window.innerHeight * 0.55, fin: Math.max(top + 1, fin) };
    }

    var progreso = 0, arrastrando = false;

    function pintar(p) {
        progreso = Math.max(0, Math.min(1, p));
        fill.style.transform = 'scaleX(' + progreso + ')';
        if (!cuerpo) return;
        var n = Math.round(progreso * 100);
        knob.style.left = progreso * 100 + '%';
        pct.style.left = progreso * 100 + '%';
        pct.querySelector('b').textContent = n + '%';
        pct.querySelector('span').textContent = minutos
            ? (n >= 99 ? 'terminado' : Math.max(1, Math.round(minutos * (1 - progreso))) + ' min restantes')
            : '';
        bar.setAttribute('aria-valuenow', String(n));
    }

    function updateProgress() {
        if (arrastrando) return;                       // durante el arrastre manda el puntero
        var r = rango();
        pintar((window.scrollY - r.ini) / (r.fin - r.ini));
    }
    window.addEventListener('scroll', updateProgress, { passive: true });
    window.addEventListener('resize', updateProgress);

    if (cuerpo) {
        // Ir a una posición concreta del artículo (Lenis si está activo)
        function irA(p) {
            var r = rango();
            var y = r.ini + Math.max(0, Math.min(1, p)) * (r.fin - r.ini);
            if (window.__aoLenis) { try { window.__aoLenis.scrollTo(y); return; } catch (e) {} }
            window.scrollTo({ top: y, behavior: arrastrando ? 'auto' : 'smooth' });
        }
        function pDelEvento(e) {
            var r = bar.getBoundingClientRect();
            return (e.clientX - r.left) / r.width;
        }
        bar.addEventListener('pointerdown', function (e) {
            arrastrando = true;
            bar.classList.add('is-drag');
            bar.setPointerCapture(e.pointerId);
            var p = pDelEvento(e); pintar(p); irA(p);
        });
        bar.addEventListener('pointermove', function (e) {
            if (!arrastrando) return;
            var p = pDelEvento(e); pintar(p); irA(p);
        });
        function soltar(e) {
            if (!arrastrando) return;
            arrastrando = false;
            bar.classList.remove('is-drag');
            try { bar.releasePointerCapture(e.pointerId); } catch (er) {}
            updateProgress();
        }
        bar.addEventListener('pointerup', soltar);
        bar.addEventListener('pointercancel', soltar);
        bar.addEventListener('keydown', function (e) {
            var p = null;
            if (e.key === 'ArrowRight') p = progreso + 0.05;
            else if (e.key === 'ArrowLeft') p = progreso - 0.05;
            else if (e.key === 'Home') p = 0;
            else if (e.key === 'End') p = 1;
            if (p === null) return;
            e.preventDefault(); pintar(p); irA(p);
        });
    }
    function boot() {
        reveal(); updateProgress();
        if (window.ScrollTrigger) ScrollTrigger.refresh();
    }
    if (document.readyState === 'complete') boot();
    else window.addEventListener('load', boot);
    // bfcache: al retroceder no se dispara 'load', así que el contenido se quedaría
    // invisible (opacity 0 del reveal). Se vuelve a lanzar al restaurar la página.
    window.addEventListener('pageshow', function (e) { if (e.persisted) boot(); });

    // ---- Lightbox de galería (imágenes horizontales) -------------------
    var imgs = [].slice.call(document.querySelectorAll('[data-lightbox] img'));
    if (imgs.length) {
        var lb = document.createElement('div');
        lb.className = 'lightbox';
        lb.innerHTML = '<button class="lb-close" aria-label="Cerrar">✕</button>' +
            '<button class="lb-nav lb-prev" aria-label="Anterior">‹</button>' +
            '<figure class="lb-stage"><img alt=""></figure>' +
            '<button class="lb-nav lb-next" aria-label="Siguiente">›</button>' +
            '<div class="lb-count"></div>';
        document.body.appendChild(lb);
        var lbImg = lb.querySelector('.lb-stage img'), lbCount = lb.querySelector('.lb-count'), idx = 0;
        function render() {
            lbImg.src = imgs[idx].src; lbImg.alt = imgs[idx].alt || '';
            lbCount.textContent = (idx + 1) + ' / ' + imgs.length;
        }
        function open(i) { idx = i; render(); lb.classList.add('open'); document.body.style.overflow = 'hidden'; }
        function close() { lb.classList.remove('open'); document.body.style.overflow = ''; }
        function go(d) { idx = (idx + d + imgs.length) % imgs.length; render(); }
        imgs.forEach(function (im, i) { im.style.cursor = 'zoom-in'; im.addEventListener('click', function () { open(i); }); });
        lb.querySelector('.lb-close').addEventListener('click', close);
        lb.querySelector('.lb-prev').addEventListener('click', function (e) { e.stopPropagation(); go(-1); });
        lb.querySelector('.lb-next').addEventListener('click', function (e) { e.stopPropagation(); go(1); });
        lb.addEventListener('click', function (e) { if (e.target === lb || e.target.classList.contains('lb-stage')) close(); });
        document.addEventListener('keydown', function (e) {
            if (!lb.classList.contains('open')) return;
            if (e.key === 'Escape') close(); else if (e.key === 'ArrowLeft') go(-1); else if (e.key === 'ArrowRight') go(1);
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
})();
</script>
