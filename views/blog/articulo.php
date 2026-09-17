<link rel="stylesheet" href="/build/css/paginas.css">
<?php
$ao_dom = 'https://alexanderoliva.com';
$ao_url = $ao_dom . '/tekhne/' . ($post->slug ?: $post->id);
$ao_img = $ao_dom . ($post->cover_img ? urlSubida('blog', $post->cover_img) : '/build/img/og-default.jpg');
$ao_ld = [
    '@context' => 'https://schema.org',
    '@type'    => 'BlogPosting',
    'headline' => $post->titulo,
    'description' => $post->descripcion,
    'image'    => $ao_img,
    'datePublished' => $post->fecha_pub ?: null,
    'author'   => ['@type' => 'Person', 'name' => 'Alexander Oliva', 'url' => $ao_dom . '/'],
    'publisher'=> ['@type' => 'Person', 'name' => 'Alexander Oliva'],
    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $ao_url],
    'articleSection' => $post->categoria,
];
$ao_bc = [
    '@context' => 'https://schema.org',
    '@type'    => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Inicio', 'item' => $ao_dom . '/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Tékhne', 'item' => $ao_dom . '/tekhne'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $post->categoria, 'item' => $ao_dom . '/tekhne/categoria/' . generarSlug($post->categoria)],
        ['@type' => 'ListItem', 'position' => 4, 'name' => $post->titulo, 'item' => $ao_url],
    ],
];
?>
<script type="application/ld+json"><?php echo json_encode(array_filter($ao_ld), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>
<script type="application/ld+json"><?php echo json_encode($ao_bc, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>
<div id="ao-app" data-theme="dark">
<div data-barba-namespace="blog-articulo">
    <?php
    $ao_top_volver = ['url' => '/tekhne', 'texto' => 'Tékhne'];
    $ao_top_wa     = 'Hola Alexander, leí tu artículo «' . $post->titulo . '».';
    $ao_top_extra  = '<button type="button" id="pg-focus" class="pg-focus-btn pg-focus-fab" aria-pressed="false" title="Modo lectura">'
                   . icono('focus') . ' Focus</button>';
    ?>
    <?php include __DIR__ . '/../partials/pg-top.php'; ?>

    <!-- Hero a sangre (full-bleed) con GSAP -->
    <section class="art-hero" id="art-hero">
        <div class="art-hero-media" id="art-hero-media" style="view-transition-name:ao-cover">
            <?php if (!empty($post->cover_img)) : ?>
                <img src="<?php echo urlSubida('blog', $post->cover_img); ?>" alt="<?php echo s($post->titulo); ?>">
            <?php else : ?>
                <!-- Sin portada: el mismo gas interactivo del hero del home.
                     paginas-foot.php lo monta con window.aoGas. -->
                <canvas class="art-hero-gl" id="art-hero-gl" aria-hidden="true"></canvas>
                <div class="art-hero-grad art-hero-grad--fallback" style="background:linear-gradient(135deg,var(--accent) 0%,#1a0207 55%,#0b0b0c 100%)"></div>
            <?php endif; ?>
        </div>
        <div class="art-hero-scrim"></div>
        <div class="art-hero-inner">
            <div class="pg-kicker art-hero-el">
                <span class="acc"><?php echo s($post->categoria); ?></span>
                <?php if ($post->fecha_pub) : ?><span><?php echo s(fechaLarga($post->fecha_pub)); ?></span><?php endif; ?>
                <span><?php echo $post->tiempoLectura(); ?> min de lectura</span>
            </div>
            <h1 class="pg-title art-hero-el"><?php echo s($post->titulo); ?></h1>
            <?php if (!empty($post->descripcion)) : ?><p class="pg-lead art-hero-el"><?php echo s($post->descripcion); ?></p><?php endif; ?>
        </div>
        <div class="art-hero-cue" id="art-hero-cue" aria-hidden="true">
            <span>Scroll</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
        </div>
    </section>

    <main class="pg pg--article">
        <nav class="pg-crumb" data-anim aria-label="Ruta de navegación">
            <a href="/">Home</a><span>›</span>
            <a href="/tekhne">Tékhne</a><span>›</span>
            <a href="/tekhne/categoria/<?php echo s(generarSlug($post->categoria)); ?>"><?php echo s($post->categoria); ?></a><span>›</span>
            <span class="cur"><?php echo s($post->titulo); ?></span>
        </nav>

        <article class="pg-body" data-anim data-min="<?php echo (int) $post->tiempoLectura(); ?>">
            <?php echo $post->contenido; /* HTML saneado al guardar */ ?>
        </article>

        <?php if (!empty($recursos)) : ?>
            <div class="pg-refs" data-anim>
                <?php foreach ($recursos as $ao_r) : $ref = $ao_r['obj']; ?>
                    <?php if ($ao_r['tipo'] === 'pelicula') : ?>
                        <a class="pg-ref" href="/tekhne/pelicula/<?php echo generarSlug($ref->titulo); ?>">
                            <?php if (!empty($ref->poster)) : ?><img class="thumb" src="<?php echo urlSubida('peliculas', $ref->poster); ?>" alt=""><?php else : ?><div class="thumb thumb-ph"><?php echo icono('film'); ?></div><?php endif; ?>
                            <div><div class="rk">RELACIONADO</div><h3><?php echo s($ref->titulo); ?></h3><p><?php echo s($ref->categoria); ?> · <?php echo s($ref->anio); ?> · Nota <?php echo number_format((float)$ref->nota, 0); ?></p></div>
                        </a>
                    <?php elseif ($ao_r['tipo'] === 'videojuego') : /* el título vive en `nombre` */ ?>
                        <div class="pg-ref">
                            <?php if (!empty($ref->portada)) : ?><img class="thumb" src="<?php echo urlSubida('videojuegos', $ref->portada); ?>" alt=""><?php else : ?><div class="thumb thumb-ph"><?php echo icono('videojuegos'); ?></div><?php endif; ?>
                            <div><div class="rk">RELACIONADO</div><h3><?php echo s($ref->nombre); ?></h3><p>Videojuego<?php echo $ref->horas2026() !== null ? ' · ' . number_format($ref->horas2026(), 0) . ' h jugadas' : ''; ?></p></div>
                        </div>
                    <?php else : ?>
                        <div class="pg-ref">
                            <div class="thumb thumb-ph"><?php echo icono('libros'); ?></div>
                            <div><div class="rk">RELACIONADO</div><h3><?php echo s($ref->titulo); ?></h3><p><?php echo s($ref->autor); ?></p></div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>
</div>

<?php include __DIR__ . '/../partials/paginas-foot.php'; ?>
