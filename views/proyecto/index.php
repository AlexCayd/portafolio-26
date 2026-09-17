<link rel="stylesheet" href="/build/css/paginas.css">
<?php
// Las secciones llegan ya ordenadas desde Proyecto::bloques(): contexto,
// galería y después las secciones libres del panel.
$ao_portada = urlSubida('proyectos/portadas', $proyecto->img);
$ao_enlace  = trim((string) $proyecto->enlace);
$ao_wa      = waLink('Hola Alexander, vi tu proyecto «' . $proyecto->titulo . '» y me gustaría platicar.');
$ao_n       = 0;   // numerador de secciones (01, 02, 03…)
?>
<div id="ao-app" data-theme="dark">
<div data-barba-namespace="proyecto">
    <?php
    $ao_top_volver = ['url' => '/#ao-projects', 'texto' => 'Proyectos'];
    $ao_top_wa     = 'Hola Alexander, vi tu proyecto «' . $proyecto->titulo . '» y me gustaría platicar.';
    ?>
    <?php include __DIR__ . '/../partials/pg-top.php'; ?>

    <!-- Hero a sangre con la portada arriba: es el destino del morph `ao-cover`
         que arranca en la tarjeta del slider. Reutiliza .art-hero (el paralaje
         con GSAP vive en partials/paginas-foot.php y se engancha por id). -->
    <section class="art-hero proj-hero" id="art-hero">
        <div class="art-hero-media" id="art-hero-media" style="view-transition-name:ao-cover">
            <?php if ($ao_portada) : ?>
                <img src="<?php echo $ao_portada; ?>" alt="Portada del proyecto <?php echo s($proyecto->titulo); ?>">
            <?php else : ?>
                <div class="art-hero-grad" style="background:linear-gradient(135deg,var(--accent) 0%,#1a0207 55%,#0b0b0c 100%)"></div>
            <?php endif; ?>
        </div>
        <div class="art-hero-scrim"></div>
        <!-- Si el proyecto tiene sitio, la portada entera es el enlace. Va DESPUÉS
             del velo (que si no se come el click) y fuera de #art-hero-media, que
             el paralaje desplaza: dentro, el aviso se salía del encuadre. -->
        <?php if ($ao_enlace) : ?>
            <a class="art-hero-link" href="<?php echo s($ao_enlace); ?>" target="_blank" rel="noopener"
               aria-label="Visitar el sitio de <?php echo s($proyecto->titulo); ?> (se abre en otra pestaña)">
                <span class="art-hero-visit" aria-hidden="true">Visitar sitio <?php echo icono('externo'); ?></span>
            </a>
        <?php endif; ?>
        <div class="art-hero-inner proj-hero-inner">
            <nav class="pg-crumb art-hero-el" aria-label="Ruta de navegación">
                <a href="/">Home</a><span>›</span>
                <a href="/#ao-projects">Proyectos</a><span>›</span>
                <span class="cur"><?php echo s($proyecto->titulo); ?></span>
            </nav>
            <div class="pg-kicker art-hero-el"><span class="acc">Proyecto</span><span><?php echo s($proyecto->anio); ?></span></div>
            <h1 class="pg-title art-hero-el"><?php echo s($proyecto->titulo); ?></h1>
            <div class="proj-actions art-hero-el">
                <?php if ($ao_enlace) : ?>
                    <a class="proj-visit" href="<?php echo s($ao_enlace); ?>" target="_blank" rel="noopener">
                        Visitar sitio <?php echo icono('externo'); ?>
                    </a>
                <?php endif; ?>
                <a class="pg-wa" href="<?php echo $ao_wa; ?>" target="_blank" rel="noopener">Quiero algo así</a>
            </div>
        </div>
        <div class="art-hero-cue" id="art-hero-cue" aria-hidden="true">
            <span>Scroll</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
        </div>
    </section>

    <main class="pg pg--full">
        <?php foreach ($bloques as $ao_b) : $ao_n++; ?>
            <?php if ($ao_b['tipo'] === 'galeria') : ?>
                <!-- data-lightbox: el visor con flechas, contador y Esc lo monta paginas-foot.php.
                     La primera toma va a sangre y el resto en dos columnas. -->
                <section class="proj-sec proj-sec--galeria" data-anim>
                    <h2 class="proj-sec-h">
                        <span class="proj-sec-num"><?php echo str_pad((string) $ao_n, 2, '0', STR_PAD_LEFT); ?></span>
                        <?php echo s($ao_b['titulo']); ?>
                    </h2>
                    <div class="pg-gallery" data-lightbox>
                        <?php foreach ($galeria as $ao_i => $ao_g) : ?>
                            <figure class="pg-shot<?php echo $ao_i === 0 ? ' pg-shot--lead' : ''; ?>">
                                <img src="<?php echo urlSubida('proyectos/galeria', $ao_g->img); ?>" alt="Captura <?php echo $ao_i + 1; ?> del proyecto <?php echo s($proyecto->titulo); ?>" loading="lazy">
                                <span class="pg-shot-zoom" aria-hidden="true"><?php echo icono('expandir'); ?></span>
                            </figure>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php else : ?>
                <section class="proj-sec" data-anim>
                    <?php if ($ao_b['titulo']) : ?>
                        <h2 class="proj-sec-h">
                            <span class="proj-sec-num"><?php echo str_pad((string) $ao_n, 2, '0', STR_PAD_LEFT); ?></span>
                            <?php echo s($ao_b['titulo']); ?>
                        </h2>
                    <?php endif; ?>
                    <!-- Formato único para todas las fichas: el cuerpo es prosa,
                         un párrafo por bloque separado con línea en blanco. -->
                    <div class="proj-sec-body">
                        <?php foreach ($ao_b['piezas'] as $ao_p) : ?>
                            <p><?php echo s($ao_p['texto']); ?></p>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="pg-cta" data-anim>
            <a class="pg-wa" href="<?php echo waLink('Hola Alexander, me interesa un proyecto como «' . $proyecto->titulo . '».'); ?>" target="_blank" rel="noopener">Quiero algo así</a>
            <?php if ($ao_enlace) : ?>
                <a class="proj-visit proj-visit--ghost" href="<?php echo s($ao_enlace); ?>" target="_blank" rel="noopener">
                    Visitar sitio <?php echo icono('externo'); ?>
                </a>
            <?php endif; ?>
            <a class="pg-back" href="/#ao-projects">Ver más proyectos</a>
        </div>
    </main>
</div>
</div>

<?php include __DIR__ . '/../partials/paginas-foot.php'; ?>
