<link rel="stylesheet" href="/build/css/paginas.css">
<div id="ao-app" data-theme="dark">
<div data-barba-namespace="blog-home">
    <header class="pg-top">
        <a href="/" class="brand">Alexander <span>Oliva</span></a>
        <div class="pg-actions">
            <a class="pg-back" href="/">Inicio</a>
            <a class="pg-wa" href="<?php echo waLink('Hola Alexander, quiero platicar contigo.'); ?>" target="_blank" rel="noopener">Contáctame</a>
        </div>
    </header>

    <main class="pg pg--wide">
        <!-- Masthead editorial -->
        <div class="tk-masthead" data-anim>
            <?php
            $tk_dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
            $tk_meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
            $tk_fecha = $tk_dias[(int) date('w')] . ' · ' . (int) date('j') . ' de ' . $tk_meses[(int) date('n') - 1] . ' de ' . date('Y');
            ?>
            <div class="tk-issue">
                <span>Publicación de Alexander Oliva</span>
                <span><?php echo strtoupper($tk_fecha); ?></span>
            </div>
            <h1 class="tk-wordmark">Tékhne</h1>
            <p class="tk-tagline">Τέχνη — arte y oficio. Donde se cruzan la tecnología, la cultura, los libros, el cine y los cuentos.</p>
        </div>

        <!-- Navegación por categorías -->
        <nav class="tk-cats" data-anim aria-label="Categorías">
            <span class="tk-cat is-on">Todos</span>
            <?php foreach ($categorias as $cat) : ?>
                <a class="tk-cat" href="/tekhne/categoria/<?php echo s(generarSlug($cat)); ?>"><?php echo s($cat); ?></a>
            <?php endforeach; ?>
        </nav>

        <!-- Buscador inteligente de artículos -->
        <div class="tk-search" data-anim>
            <label class="tk-search-box">
                <svg class="tk-search-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                <input type="search" id="tk-search" placeholder="Buscar por título, tema o categoría…" autocomplete="off" aria-label="Buscar artículos">
                <button type="button" class="tk-search-clear" id="tk-search-clear" aria-label="Limpiar" hidden>&times;</button>
            </label>
            <p class="tk-search-none" id="tk-search-none" hidden>Sin resultados para «<span></span>». Prueba con otra palabra.</p>
        </div>

        <?php
        $ao_grads = [
            'repeating-linear-gradient(45deg,rgba(255,255,255,.06) 0 2px,transparent 2px 15px),linear-gradient(135deg,var(--accent) 0%,#1a0207 55%,#0b0b0c 100%)',
            'radial-gradient(rgba(255,255,255,.14) 1px,transparent 1.6px) 0 0/17px 17px,radial-gradient(130% 130% at 24% 18%,var(--accent) 0%,#1a0207 52%,#0b0b0c 100%)',
            'repeating-linear-gradient(90deg,rgba(255,255,255,.05) 0 1px,transparent 1px 13px),linear-gradient(115deg,#0b0b0c 18%,#1a0207 55%,var(--accent) 100%)',
        ];
        function tk_cover($post, $i, $grads) {
            return !empty($post->cover_img) ? "url('/build/img/blog/" . s($post->cover_img) . "') center/cover no-repeat" : $grads[$i % count($grads)];
        }
        ?>

        <!-- Artículos -->
        <div class="pg-grid" id="tk-articulos">
            <?php foreach ($posts as $ao_i => $post) : $cover = tk_cover($post, $ao_i, $ao_grads); ?>
                <a href="/tekhne/<?php echo s($post->slug ?: $post->id); ?>" data-anim data-vt-cover data-search="<?php echo s($post->titulo . ' ' . $post->descripcion . ' ' . $post->categoria); ?>" class="pg-card<?php echo $ao_i === 0 ? ' pg-card--feat' : ''; ?>">
                    <div class="pg-card-cover" data-vt-img style="background:<?php echo $cover; ?>;">
                        <span class="pg-cat"><?php echo s($post->categoria); ?></span>
                    </div>
                    <div class="pg-card-body">
                        <span class="pg-card-meta"><?php echo s($post->metaTarjeta()); ?></span>
                        <h3><?php echo s($post->titulo); ?></h3>
                        <p class="pg-card-desc"><?php echo s($post->descripcion); ?></p>
                        <span class="pg-card-read">Leer artículo →</span>
                    </div>
                </a>
            <?php endforeach; ?>
            <?php if (empty($posts)) : ?><p style="color:var(--muted)">Aún no hay entradas.</p><?php endif; ?>
        </div>

        <!-- Cuentos -->
        <section class="tk-section" data-anim id="tk-cuentos">
            <div class="tk-section-head">
                <div>
                    <span class="tk-section-kicker">/ FICCIÓN</span>
                    <h2 class="tk-section-title">Cuentos</h2>
                </div>
            </div>
            <?php if (!empty($cuentos)) : ?>
                <div class="pg-grid">
                    <?php foreach ($cuentos as $ao_i => $post) : $cover = tk_cover($post, $ao_i, $ao_grads); ?>
                        <a href="/tekhne/<?php echo s($post->slug ?: $post->id); ?>" data-vt-cover data-search="<?php echo s($post->titulo . ' ' . $post->descripcion . ' Cuentos'); ?>" class="pg-card">
                            <div class="pg-card-cover" data-vt-img style="background:<?php echo $cover; ?>;"><span class="pg-cat">Cuentos</span></div>
                            <div class="pg-card-body">
                                <span class="pg-card-meta"><?php echo s($post->metaTarjeta()); ?></span>
                                <h3><?php echo s($post->titulo); ?></h3>
                                <p class="pg-card-desc"><?php echo s($post->descripcion); ?></p>
                                <span class="pg-card-read">Leer cuento →</span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="tk-empty">Estoy escribiendo. Los primeros cuentos llegan pronto.</div>
            <?php endif; ?>
        </section>

        <!-- Películas y series (catálogo) -->
        <?php if (!empty($peliculas)) : ?>
        <section class="sel-autor sel-autor--pys" data-anim>
            <div class="sel-head">
                <div>
                    <span class="sel-kicker">/ CINE &amp; SERIES</span>
                    <h2 class="sel-title">Todo lo que he <em>visto</em></h2>
                    <p class="sel-sub">Mi bitácora completa de cine y series — <?php echo count($peliculas); ?> títulos calificados.</p>
                </div>
                <a class="sel-vertodas" href="/tekhne/peliculas">Ver catálogo <span>→</span></a>
            </div>
            <div class="sel-shelf">
                <?php foreach (array_slice($peliculas, 0, 12) as $t) : $tiene = !empty(trim((string) $t->comentario)); $n = (float) $t->nota; ?>
                    <a class="sel-card" href="/tekhne/pelicula/<?php echo generarSlug($t->titulo); ?>" title="<?php echo s($t->titulo); ?>">
                        <div class="sel-poster">
                            <?php if (!empty($t->poster)) : ?>
                                <img src="/build/img/peliculas/<?php echo s($t->poster); ?>" alt="<?php echo s($t->titulo); ?>" loading="lazy">
                            <?php else : ?>
                                <div class="sel-ph"><?php echo icono('film'); ?></div>
                            <?php endif; ?>
                            <?php if ($tiene && $n > 0) : ?><span class="sel-badge"><?php echo icono('estrella'); ?><?php echo number_format($n, 0); ?></span><?php endif; ?>
                        </div>
                        <h3 class="sel-name"><?php echo s($t->titulo); ?></h3>
                        <p class="sel-meta"><?php echo s($t->categoria); ?><?php echo $t->anio ? ' · ' . s($t->anio) : ''; ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- Recomendaciones (al final) -->
        <?php if (!empty($seleccion)) : ?>
        <section class="sel-autor" data-anim>
            <div class="sel-head">
                <div>
                    <span class="sel-kicker">/ RECOMENDACIONES</span>
                    <h2 class="sel-title">Para ver más <em>tarde…</em></h2>
                    <p class="sel-sub">Cine y series con calificación perfecta — mis 10/10 sin concesiones.</p>
                </div>
                <a class="sel-vertodas" href="/tekhne/recomendaciones">Ver todas <span>→</span></a>
            </div>
            <div class="sel-shelf">
                <?php foreach (array_slice($seleccion, 0, 8) as $t) : ?>
                    <a class="sel-card" href="/tekhne/pelicula/<?php echo generarSlug($t->titulo); ?>" title="<?php echo s($t->titulo); ?>">
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
            </div>
        </section>
        <?php endif; ?>
    </main>
</div>
</div>

<script>
(function () {
    // Buscador inteligente: normaliza acentos, empareja por tokens (AND) sobre
    // título + descripción + categoría de cada tarjeta.
    var input = document.getElementById('tk-search');
    if (!input) return;
    var clearBtn = document.getElementById('tk-search-clear');
    var noneMsg  = document.getElementById('tk-search-none');
    var cuentos  = document.getElementById('tk-cuentos');
    var shelves  = Array.prototype.slice.call(document.querySelectorAll('.sel-autor'));
    var cards    = Array.prototype.slice.call(document.querySelectorAll('[data-search]'));

    function norm(str) {
        return (str || '').normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();
    }
    function seccionVisible(sec) {
        if (!sec) return;
        var vis = sec.querySelectorAll('[data-search]:not([hidden])');
        var algun = Array.prototype.some.call(vis, function (c) { return c.style.display !== 'none'; });
        sec.style.display = algun ? '' : 'none';
    }

    function filtrar() {
        var raw = input.value.trim();
        clearBtn.hidden = raw === '';
        var q = norm(raw);

        if (q === '') {
            cards.forEach(function (c) { c.style.display = ''; });
            if (cuentos) cuentos.style.display = '';
            shelves.forEach(function (s) { s.style.display = ''; });
            noneMsg.hidden = true;
            return;
        }

        var tokens = q.split(/\s+/);
        var visibles = 0;
        cards.forEach(function (c) {
            var hay = norm(c.getAttribute('data-search'));
            var ok = tokens.every(function (t) { return hay.indexOf(t) !== -1; });
            c.style.display = ok ? '' : 'none';
            if (ok) visibles++;
        });

        shelves.forEach(function (s) { s.style.display = 'none'; });   // los estantes de pósters no se buscan
        seccionVisible(cuentos);

        noneMsg.hidden = visibles !== 0;
        if (!noneMsg.hidden) noneMsg.querySelector('span').textContent = raw;
    }

    input.addEventListener('input', filtrar);
    clearBtn.addEventListener('click', function () { input.value = ''; filtrar(); input.focus(); });
    input.addEventListener('keydown', function (e) { if (e.key === 'Escape') { input.value = ''; filtrar(); } });
})();
</script>

<?php include __DIR__ . '/../partials/paginas-foot.php'; ?>
