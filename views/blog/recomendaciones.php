<link rel="stylesheet" href="/build/css/paginas.css">
<div id="ao-app" data-theme="dark">
<div data-barba-namespace="blog-recomendaciones">
    <header class="pg-top">
        <a href="/" class="brand">Alexander <span>Oliva</span></a>
        <div class="pg-actions">
            <a class="pg-back" href="/tekhne">Tékhne</a>
            <a class="pg-wa" href="<?php echo waLink('Hola Alexander, quiero platicar contigo.'); ?>" target="_blank" rel="noopener">Contáctame</a>
        </div>
    </header>

    <main class="pg pg--wide">
        <nav class="pg-crumb" data-anim aria-label="Ruta de navegación">
            <a href="/">Home</a><span>›</span>
            <a href="/tekhne">Tékhne</a><span>›</span>
            <span class="cur">Para ver más tarde</span>
        </nav>

        <div class="pg-kicker" data-anim><span class="acc">/ RECOMENDACIONES</span></div>
        <h1 class="pg-title" data-anim>Para ver más <em>tarde…</em></h1>
        <p class="pg-lead" data-anim>Cine y series con calificación perfecta. Mis 10/10, sin concesiones (<?php echo count($seleccion); ?>).</p>

        <div class="rec-grid">
            <?php foreach ($seleccion as $t) : ?>
                <a class="sel-card" href="/tekhne/pelicula/<?php echo generarSlug($t->titulo); ?>" data-anim title="<?php echo s($t->titulo); ?>">
                    <div class="sel-poster">
                        <?php if (!empty($t->poster)) : ?>
                            <img src="/build/img/peliculas/<?php echo s($t->poster); ?>" alt="<?php echo s($t->titulo); ?>" loading="lazy">
                        <?php else : ?>
                            <div class="sel-ph"><?php echo icono('film'); ?></div>
                        <?php endif; ?>
                        <span class="sel-badge"><?php echo icono('estrella'); ?>10</span>
                    </div>
                    <h3 class="sel-name"><?php echo s($t->titulo); ?></h3>
                    <p class="sel-meta"><?php echo s($t->categoria); ?><?php echo $t->anio ? ' · ' . s($t->anio) : ''; ?></p>
                </a>
            <?php endforeach; ?>
            <?php if (empty($seleccion)) : ?><p style="color:var(--muted)">Aún no hay títulos con nota 10/10.</p><?php endif; ?>
        </div>
    </main>
</div>
</div>

<?php include __DIR__ . '/../partials/paginas-foot.php'; ?>
