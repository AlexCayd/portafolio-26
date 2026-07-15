<link rel="stylesheet" href="/build/css/paginas.css">
<div id="ao-app" data-theme="dark">
<div data-barba-namespace="proyecto">
    <header class="pg-top">
        <a href="/" class="brand">Alexander <span>Oliva</span></a>
        <div class="pg-actions">
            <a class="pg-back" href="/#ao-projects">Proyectos</a>
            <a class="pg-wa" href="<?php echo waLink('Hola Alexander, vi tu proyecto «' . $proyecto->titulo . '» y me gustaría platicar.'); ?>" target="_blank" rel="noopener">Contáctame</a>
        </div>
    </header>

    <main class="pg pg--wide">
        <nav class="pg-crumb" data-anim aria-label="Ruta de navegación">
            <a href="/">Home</a><span>›</span>
            <a href="/#ao-projects">Proyectos</a><span>›</span>
            <span class="cur"><?php echo s($proyecto->titulo); ?></span>
        </nav>

        <div class="pg-kicker" data-anim><span class="acc">/ PROYECTO</span><span><?php echo s($proyecto->anio); ?></span></div>
        <h1 class="pg-title" data-anim><?php echo s($proyecto->titulo); ?></h1>

        <?php if (!empty($proyecto->descripcion)) : ?>
            <p class="pg-lead" data-anim><?php echo nl2br(s($proyecto->descripcion)); ?></p>
        <?php endif; ?>

        <img class="pg-cover" data-anim src="/build/img/proyectos/portadas/<?php echo s($proyecto->img); ?>" alt="Portada de <?php echo s($proyecto->titulo); ?>" style="view-transition-name:ao-cover" onerror="this.style.display='none'">

        <?php if (!empty($galeria)) : ?>
            <h2 class="pg-gallery-title" data-anim>Galería</h2>
            <div class="pg-gallery" data-lightbox>
                <?php foreach ($galeria as $g) : ?>
                    <figure class="pg-shot" data-anim>
                        <img src="/build/img/proyectos/galeria/<?php echo s($g->img); ?>" alt="<?php echo s($proyecto->titulo); ?>" loading="lazy">
                        <span class="pg-shot-zoom">⤢</span>
                    </figure>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="pg-cta" data-anim>
            <a class="pg-wa" href="<?php echo waLink('Hola Alexander, me interesa un proyecto como «' . $proyecto->titulo . '».'); ?>" target="_blank" rel="noopener">Quiero algo así</a>
            <a class="pg-back" href="/#ao-projects">Ver más proyectos</a>
        </div>
    </main>
</div>
</div>

<?php include __DIR__ . '/../partials/paginas-foot.php'; ?>
