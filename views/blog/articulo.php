<link rel="stylesheet" href="/build/css/paginas.css">
<?php
$ao_dom = 'https://alexanderoliva.com';
$ao_url = $ao_dom . '/tekhne/' . ($post->slug ?: $post->id);
$ao_img = $ao_dom . ($post->cover_img ? '/build/img/blog/' . $post->cover_img : '/build/img/profile.png');
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
    <header class="pg-top">
        <a href="/" class="brand">Alexander <span>Oliva</span></a>
        <div class="pg-actions">
            <button type="button" id="pg-focus" class="pg-focus-btn pg-focus-fab" aria-pressed="false" title="Modo lectura">◍ Focus</button>
            <a class="pg-back" href="/tekhne">Tékhne</a>
            <a class="pg-wa" href="<?php echo waLink('Hola Alexander, leí tu artículo «' . $post->titulo . '».'); ?>" target="_blank" rel="noopener">Contáctame</a>
        </div>
    </header>

    <?php
    $ao_grads = [
        'repeating-linear-gradient(45deg,rgba(255,255,255,.06) 0 2px,transparent 2px 15px),linear-gradient(135deg,var(--accent) 0%,#1a0207 55%,#0b0b0c 100%)',
        'radial-gradient(rgba(255,255,255,.14) 1px,transparent 1.6px) 0 0/17px 17px,radial-gradient(130% 130% at 24% 18%,var(--accent) 0%,#1a0207 52%,#0b0b0c 100%)',
        'repeating-linear-gradient(90deg,rgba(255,255,255,.05) 0 1px,transparent 1px 13px),linear-gradient(115deg,#0b0b0c 18%,#1a0207 55%,var(--accent) 100%)',
    ];
    ?>
    <!-- Hero a sangre (full-bleed) con GSAP -->
    <section class="art-hero" id="art-hero">
        <div class="art-hero-media" id="art-hero-media" style="view-transition-name:ao-cover">
            <?php if (!empty($post->cover_img)) : ?>
                <img src="/build/img/blog/<?php echo s($post->cover_img); ?>" alt="<?php echo s($post->titulo); ?>">
            <?php else : ?>
                <div class="art-hero-grad" style="background:<?php echo $ao_grads[(int) $post->id % count($ao_grads)]; ?>"></div>
            <?php endif; ?>
        </div>
        <div class="art-hero-scrim"></div>
        <div class="art-hero-inner">
            <div class="pg-kicker art-hero-el">
                <span class="acc"><?php echo s($post->categoria); ?></span>
                <span><?php echo $post->fecha_pub ? strtoupper(date('d M Y', strtotime($post->fecha_pub))) : ''; ?></span>
                <span><?php echo $post->tiempoLectura(); ?> MIN DE LECTURA</span>
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

        <article class="pg-body" data-anim>
            <?php echo $post->contenido; /* HTML saneado al guardar */ ?>
        </article>

        <?php if ($ref) : ?>
            <div class="pg-ref" data-anim>
                <?php if ($post->ref_tipo === 'pelicula') : ?>
                    <?php if (!empty($ref->poster)) : ?><img class="thumb" src="/build/img/peliculas/<?php echo s($ref->poster); ?>" alt=""><?php else : ?><div class="thumb thumb-ph"><?php echo icono('film'); ?></div><?php endif; ?>
                    <div><div class="rk">RELACIONADO</div><h3><?php echo s($ref->titulo); ?></h3><p><?php echo s($ref->categoria); ?> · <?php echo s($ref->anio); ?> · Nota <?php echo number_format((float)$ref->nota, 0); ?></p></div>
                <?php else : ?>
                    <div class="thumb thumb-ph"><?php echo icono('libros'); ?></div>
                    <div><div class="rk">RELACIONADO</div><h3><?php echo s($ref->titulo); ?></h3><p><?php echo s($ref->autor); ?></p></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>
</div>
</div>

<?php include __DIR__ . '/../partials/paginas-foot.php'; ?>
