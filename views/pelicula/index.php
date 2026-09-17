<link rel="stylesheet" href="/build/css/paginas.css">
<div id="ao-app" data-theme="dark">
<div data-barba-namespace="pelicula">
    <?php $ao_top_volver = ['url' => '/tekhne/peliculas', 'texto' => 'Películas']; ?>
    <?php include __DIR__ . '/../partials/pg-top.php'; ?>

    <?php
        $tiene_comentario = !empty(trim((string) $film->comentario));
        $nota = (float) $film->nota;
        $poster_url = urlSubida('peliculas', $film->poster);
    ?>

    <main class="pg pg--wide film-page">
        <nav class="pg-crumb" data-anim aria-label="Ruta de navegación">
            <a href="/">Home</a><span>›</span>
            <a href="/tekhne">Tékhne</a><span>›</span>
            <a href="/tekhne/peliculas">Películas</a><span>›</span>
            <span class="cur"><?php echo s($film->titulo); ?></span>
        </nav>

        <!-- Póster a la izquierda, ficha técnica a la derecha. El póster lleva
             view-transition-name para continuar la animación desde el catálogo. -->
        <div class="film-cols">
            <aside class="film-poster-col">
                <div class="film-poster-card" style="view-transition-name:ao-poster">
                    <?php if ($poster_url) : ?>
                        <img src="<?php echo $poster_url; ?>" alt="Póster de <?php echo s($film->titulo); ?>">
                    <?php else : ?>
                        <div class="film-poster-ph"><?php echo icono('film'); ?></div>
                    <?php endif; ?>
                </div>
                <?php if ($tiene_comentario && $nota > 0) : ?>
                    <div class="film-score" title="<?php echo number_format($nota, 1); ?>/10">
                        <span class="film-score-stars">
                            <?php for ($i = 1; $i <= 10; $i++) echo '<b class="' . ($nota >= $i ? 'on' : '') . '">★</b>'; ?>
                        </span>
                        <span class="film-score-num"><?php echo number_format($nota, 0); ?><small>/10</small></span>
                    </div>
                <?php endif; ?>
            </aside>

            <div class="film-info">
                <header class="film-lead" data-anim>
                    <span class="film-lead-kicker">
                        <?php echo mb_strtoupper(s($film->categoriaTexto() ?: 'Título')); ?><?php echo $film->anio ? ' · ' . s($film->anio) : ''; ?>
                    </span>
                    <h1 class="film-lead-title"><?php echo s($film->titulo); ?></h1>
                    <?php if ($film->personaConocida()) : ?>
                        <p class="film-lead-dir"><?php echo s($film->personaLabel()); ?>: <strong><?php echo s($film->personasTexto()); ?></strong></p>
                    <?php endif; ?>
                </header>

                <!-- Ficha técnica en cards -->
                <div class="film-sheet" data-anim>
                    <?php if ($film->categoria) : ?>
                        <div class="film-fact"><dt>Categoría</dt><dd><?php echo s($film->categoriaTexto()); ?></dd></div>
                    <?php endif; ?>
                    <?php if ($film->personaConocida()) : ?>
                        <div class="film-fact"><dt><?php echo s($film->personaLabel()); ?></dt><dd><?php echo s($film->personasTexto()); ?></dd></div>
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

                <!-- Playlist: entrar a la selección desde cualquier ficha y, si
                     este título forma parte de ella, saltar al anterior/siguiente. -->
                <div class="pg-cta film-cta" data-anim>
                    <a class="pg-back" href="/tekhne/peliculas">Ver más títulos</a>
                    <a class="film-playlist-cta" href="/tekhne/recomendaciones">
                        <?php echo icono('estrella'); ?>
                        <?php echo $playlist['pos'] !== null ? 'Ver la playlist' : 'Ver recomendaciones'; ?>
                    </a>
                </div>

                <?php if ($playlist['pos'] !== null) : ?>
                    <nav class="film-playlist" data-anim aria-label="Playlist de recomendaciones">
                        <span class="film-playlist-pos">
                            Recomendación <?php echo $playlist['pos'] + 1; ?> de <?php echo $playlist['total']; ?>
                        </span>
                        <?php if ($playlist['anterior']) : ?>
                            <div class="film-playlist-nav">
                                <a class="film-playlist-link film-playlist-link--prev" href="/tekhne/pelicula/<?php echo generarSlug($playlist['anterior']->titulo); ?>">
                                    <span class="film-playlist-dir">Anterior</span>
                                    <span class="film-playlist-tit"><?php echo s($playlist['anterior']->titulo); ?></span>
                                </a>
                                <a class="film-playlist-link film-playlist-link--next" href="/tekhne/pelicula/<?php echo generarSlug($playlist['siguiente']->titulo); ?>">
                                    <span class="film-playlist-dir">Siguiente</span>
                                    <span class="film-playlist-tit"><?php echo s($playlist['siguiente']->titulo); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </nav>
                <?php endif; ?>

                <?php echo creditoImdb(); ?>
            </div>
        </div>
    </main>
</div>
</div>

<?php include __DIR__ . '/../partials/paginas-foot.php'; ?>
