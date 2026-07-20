<link rel="stylesheet" href="/build/css/paginas.css">
<div id="ao-app" data-theme="dark">
<div data-barba-namespace="pelicula">
    <header class="pg-top">
        <a href="/" class="brand">Alexander <span>Oliva</span></a>
        <div class="pg-actions">
            <a class="pg-back" href="/tekhne/peliculas">Películas</a>
            <a class="pg-wa" href="<?php echo waLink('Hola Alexander, quiero platicar contigo.'); ?>" target="_blank" rel="noopener">Contáctame</a>
        </div>
    </header>

    <?php
        $tiene_comentario = !empty(trim((string) $film->comentario));
        $nota = (float) $film->nota;
        $poster_url = !empty($film->poster) ? '/build/img/peliculas/' . s($film->poster) : '';
    ?>

    <!-- Hero: portada + título grande. Al hacer scroll el título se centra y crece,
         la portada se extiende a pantalla completa y al final se degrada con la ficha. -->
    <section class="film-scroll" id="film-scroll">
        <div class="film-stage">
            <div class="film-poster-full" id="film-poster">
                <?php if ($poster_url) : ?>
                    <img src="<?php echo $poster_url; ?>" alt="Póster de <?php echo s($film->titulo); ?>">
                <?php else : ?>
                    <div class="film-poster-ph"><?php echo icono('film'); ?></div>
                <?php endif; ?>
            </div>
            <div class="film-tint" id="film-tint"></div>
            <div class="film-stage-head" id="film-title">
                <div class="pg-kicker">
                    <span class="acc">/ <?php echo mb_strtoupper(s($film->categoria ?: 'Título')); ?></span>
                    <?php if ($film->anio) : ?><span><?php echo s($film->anio); ?></span><?php endif; ?>
                </div>
                <h1 class="film-hero-title"><?php echo s($film->titulo); ?></h1>
                <?php if (!empty($film->autor) && $film->autor !== '—') : ?>
                    <p class="film-hero-dir"><?php echo s($film->personaLabel()); ?>: <strong><?php echo s($film->autor); ?></strong></p>
                <?php endif; ?>
                <?php if ($tiene_comentario && $nota > 0) : ?>
                    <div class="film-score" title="<?php echo number_format($nota, 1); ?>/10">
                        <span class="film-score-stars">
                            <?php for ($i = 1; $i <= 10; $i++) echo '<b class="' . ($nota >= $i ? 'on' : '') . '">★</b>'; ?>
                        </span>
                        <span class="film-score-num"><?php echo number_format($nota, 0); ?><small>/10</small></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="film-cue" id="film-cue"><span></span></div>
        </div>
    </section>

    <main class="pg pg--wide film-main" id="film-content">
        <nav class="pg-crumb" data-anim aria-label="Ruta de navegación">
            <a href="/">Home</a><span>›</span>
            <a href="/tekhne">Tékhne</a><span>›</span>
            <a href="/tekhne/peliculas">Películas</a><span>›</span>
            <span class="cur"><?php echo s($film->titulo); ?></span>
        </nav>

        <!-- El título se reacomoda aquí al terminar la coreografía del hero -->
        <header class="film-lead" id="film-lead">
            <span class="film-lead-kicker">
                <?php echo mb_strtoupper(s($film->categoria ?: 'Título')); ?><?php echo $film->anio ? ' · ' . s($film->anio) : ''; ?>
            </span>
            <h2 class="film-lead-title"><?php echo s($film->titulo); ?></h2>
            <?php if (!empty($film->autor) && $film->autor !== '—') : ?>
                <p class="film-lead-dir"><?php echo s($film->personaLabel()); ?>: <strong><?php echo s($film->autor); ?></strong></p>
            <?php endif; ?>
        </header>

        <!-- Ficha técnica en cards -->
        <div class="film-sheet" data-anim>
            <?php if ($film->categoria) : ?>
                <div class="film-fact"><dt>Categoría</dt><dd><?php echo s($film->categoria); ?></dd></div>
            <?php endif; ?>
            <?php if (!empty($film->autor) && $film->autor !== '—') : ?>
                <div class="film-fact"><dt><?php echo s($film->personaLabel()); ?></dt><dd><?php echo s($film->autor); ?></dd></div>
            <?php endif; ?>
            <?php if ($film->anio) : ?>
                <div class="film-fact"><dt>Año</dt><dd><?php echo s($film->anio); ?></dd></div>
            <?php endif; ?>
            <?php if ($film->duracion) : $d = max(0, (int) $film->duracion); ?>
                <div class="film-fact"><dt>Duración</dt><dd><?php echo $d >= 60 ? intdiv($d, 60) . ' h' . ($d % 60 ? ' ' . ($d % 60) . ' min' : '') : $d . ' min'; ?></dd></div>
            <?php endif; ?>
        </div>

        <?php if ($tiene_comentario) : ?>
            <div class="film-note" data-anim>
                <h2 class="film-note-title">Reseña</h2>
                <div class="film-note-body"><?php echo nl2br(s($film->comentario)); ?></div>
            </div>
        <?php endif; ?>

        <div class="pg-cta film-cta" data-anim>
            <a class="pg-back" href="/tekhne/peliculas">Ver más títulos</a>
        </div>
    </main>
</div>
</div>

<script>
(function () {
    var scroll = document.getElementById('film-scroll');
    if (!scroll) return;
    var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
    var poster = document.getElementById('film-poster');
    var tint   = document.getElementById('film-tint');
    var title  = document.getElementById('film-title');
    var cue    = document.getElementById('film-cue');

    if (!window.gsap || reduce) return;   // sin GSAP: hero estático (CSS), contenido visible

    // Tarjeta de portada con proporción real 2:3, centrada y en la mitad superior.
    function cardClip() {
        var vw = innerWidth, vh = innerHeight;
        var h = Math.min(vh * 0.52, 470);
        var w = h * 2 / 3;
        var top = vh * 0.06, left = (vw - w) / 2;
        return 'inset(' + (top / vh * 100).toFixed(2) + '% ' + (left / vw * 100).toFixed(2) + '% ' +
               ((vh - top - h) / vh * 100).toFixed(2) + '% ' + (left / vw * 100).toFixed(2) + '% round 20px)';
    }
    var FULL = 'inset(0% 0% 0% 0% round 0px)';   // portada a pantalla completa

    // Estado inicial + entrada
    gsap.set(poster, { clipPath: cardClip(), webkitClipPath: cardClip() });
    gsap.set(title, { xPercent: -50, yPercent: -50, y: '24vh', scale: 1, transformOrigin: '50% 50%' });
    gsap.set(tint, { opacity: .12 });
    gsap.timeline()
        .from(poster, { opacity: 0, duration: 1, ease: 'power3.out' })
        .from(title.children, { opacity: 0, y: 26, duration: .8, ease: 'power3.out', stagger: .1 }, '-=.55');

    if (window.ScrollTrigger) {
        gsap.registerPlugin(ScrollTrigger);
        var tl = gsap.timeline({ scrollTrigger: { trigger: scroll, start: 'top top', end: 'bottom bottom', scrub: .4 } });
        // La portada se extiende a pantalla completa.
        tl.fromTo(poster, { clipPath: cardClip(), webkitClipPath: cardClip() },
                          { clipPath: FULL, webkitClipPath: FULL, ease: 'none' }, 0)
          .to(poster.querySelector('img, .film-poster-ph'), { scale: 1.08, ease: 'none' }, 0)
          // El rojo toma protagonismo.
          .to(tint, { opacity: .72, ease: 'none' }, 0)
          // El título se centra y se hace más grande.
          .to(title, { y: '0vh', scale: 1.45, ease: 'none' }, 0)
          // Al final se degrada hacia la ficha técnica.
          .to(title, { opacity: 0, y: '-6vh', ease: 'none' }, .86)
          .to(tint, { opacity: .92, ease: 'none' }, .86);
        if (cue) gsap.to(cue, { opacity: 0, ease: 'none', scrollTrigger: { trigger: scroll, start: 'top top', end: '12% top', scrub: true } });

        // El título "aterriza" en la ficha técnica justo cuando el del hero se va.
        var lead = document.getElementById('film-lead');
        if (lead) gsap.fromTo(lead, { opacity: 0, y: 48, scale: .96 }, {
            opacity: 1, y: 0, scale: 1, ease: 'none',
            scrollTrigger: { trigger: scroll, start: '76% top', end: 'bottom bottom', scrub: .4 }
        });

        // Recalcula la geometría de la tarjeta al cambiar el tamaño de la ventana.
        var rt; addEventListener('resize', function () {
            clearTimeout(rt);
            rt = setTimeout(function () { ScrollTrigger.refresh(); }, 180);
        });
    }
})();
</script>

<?php include __DIR__ . '/../partials/paginas-foot.php'; ?>
