<link rel="stylesheet" href="/build/css/paginas.css">
<div id="ao-app" data-theme="dark">
<div data-barba-namespace="pelicula">
    <?php include __DIR__ . '/../partials/pg-top.php'; ?>

    <?php
        $tiene_comentario = !empty(trim((string) $film->comentario));
        $nota = (float) $film->nota;
        $poster_url = urlSubida('peliculas', $film->poster);

        $ao_crumb = [
            ['url' => '/',                 'texto' => 'Home'],
            ['url' => '/tekhne',           'texto' => 'Tékhne'],
            ['url' => '/tekhne/peliculas', 'texto' => 'Películas'],
            ['texto' => $film->titulo],
        ];
        include __DIR__ . '/../partials/pg-crumb.php';
    ?>

    <main class="pg pg--wide film-page">

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

                <!-- Watchlist: entrar a la selección desde cualquier ficha y, si
                     este título forma parte de ella, saltar al anterior/siguiente.
                     El catálogo completo solo se ofrece con sesión de admin: para
                     el resto es una ruta que no existe. -->
                <div class="pg-cta film-cta" data-anim>
                    <?php if (!empty($esAdmin)) : ?>
                        <a class="pg-back" href="/tekhne/peliculas">Ver el catálogo</a>
                    <?php else : ?>
                        <a class="pg-back" href="/tekhne">Tékhne</a>
                    <?php endif; ?>
                    <a class="film-watchlist-cta" href="/tekhne/recomendaciones">
                        <?php echo icono('estrella'); ?>
                        <?php echo $watchlist['pos'] !== null ? 'Ver la watchlist' : 'Ver la watchlist completa'; ?>
                    </a>
                </div>

                <?php if ($watchlist['pos'] !== null) : ?>
                    <nav class="film-watchlist" data-anim aria-label="Watchlist">
                        <span class="film-watchlist-pos">
                            Watchlist <?php echo $watchlist['pos'] + 1; ?> de <?php echo $watchlist['total']; ?>
                        </span>
                        <?php if ($watchlist['anterior']) : ?>
                            <div class="film-watchlist-nav">
                                <a class="film-watchlist-link film-watchlist-link--prev" href="/tekhne/pelicula/<?php echo generarSlug($watchlist['anterior']->titulo); ?>">
                                    <span class="film-watchlist-dir">Anterior</span>
                                    <span class="film-watchlist-tit"><?php echo s($watchlist['anterior']->titulo); ?></span>
                                </a>
                                <a class="film-watchlist-link film-watchlist-link--next" href="/tekhne/pelicula/<?php echo generarSlug($watchlist['siguiente']->titulo); ?>">
                                    <span class="film-watchlist-dir">Siguiente</span>
                                    <span class="film-watchlist-tit"><?php echo s($watchlist['siguiente']->titulo); ?></span>
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
