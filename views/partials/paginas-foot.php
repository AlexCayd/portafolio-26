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
            el.style.opacity = '0'; el.style.transform = 'translateY(26px)'; el.style.willChange = 'opacity, transform';
        });
        function show(el, i) {
            if (el.getAttribute('data-shown')) return;
            el.setAttribute('data-shown', '1');
            if (window.anime) anime({ targets: el, opacity: [0, 1], translateY: [26, 0], duration: 720, delay: (i || 0) * 65, easing: 'cubicBezier(.16,1,.3,1)' });
            else { el.style.transition = 'opacity .6s ease, transform .6s ease'; el.style.opacity = '1'; el.style.transform = 'none'; }
        }
        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.filter(function (e) { return e.isIntersecting; }).forEach(function (e, i) { io.unobserve(e.target); show(e.target, i); });
            }, { rootMargin: '0px 0px -6% 0px', threshold: 0.04 });
            els.forEach(function (el) { io.observe(el); });
        } else { els.forEach(show); }
        setTimeout(function () {
            els.forEach(function (el) { if (!el.getAttribute('data-shown')) { el.setAttribute('data-shown', '1'); el.style.opacity = '1'; el.style.transform = 'none'; } });
        }, 1600);
    }

    // ---- Barra de progreso de lectura ----------------------------------
    var bar = document.createElement('div');
    bar.className = 'pg-progress';
    document.body.appendChild(bar);
    function updateProgress() {
        var h = document.documentElement.scrollHeight - window.innerHeight;
        bar.style.transform = 'scaleX(' + (h > 0 ? Math.min(1, window.scrollY / h) : 0) + ')';
    }
    window.addEventListener('scroll', updateProgress, { passive: true });
    window.addEventListener('resize', updateProgress);
    window.addEventListener('load', function () { reveal(); updateProgress(); });

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
