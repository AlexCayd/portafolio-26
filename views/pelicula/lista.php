<link rel="stylesheet" href="/build/css/paginas.css">
<div id="ao-app" data-theme="dark">
<div data-barba-namespace="peliculas-lista">
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
            <span class="cur">Películas y series</span>
        </nav>

        <div class="pg-kicker" data-anim><span class="acc">/ CINE &amp; SERIES</span><span><?php echo count($peliculas); ?> títulos</span></div>
        <h1 class="pg-title" data-anim>Todo lo que he <em>visto</em></h1>
        <p class="pg-lead" data-anim>Mi bitácora de cine y series. Busca por título, categoría, director o año.</p>

        <!-- Buscador inteligente -->
        <div class="tk-search" data-anim>
            <label class="tk-search-box">
                <svg class="tk-search-ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                <input type="search" id="pel-search" placeholder="Buscar por título, categoría, director o año…" autocomplete="off" aria-label="Buscar títulos">
                <button type="button" class="tk-search-clear" id="pel-search-clear" aria-label="Limpiar" hidden>&times;</button>
            </label>
            <p class="tk-search-none" id="pel-search-none" hidden>Sin resultados para «<span></span>». Prueba con otra palabra.</p>
        </div>

        <div class="rec-grid" id="pel-grid">
            <?php foreach ($peliculas as $p) : $n = (float) $p->nota; $tiene = !empty(trim((string) $p->comentario)); ?>
                <a class="sel-card" href="/tekhne/pelicula/<?php echo generarSlug($p->titulo); ?>" data-anim title="<?php echo s($p->titulo); ?>"
                   data-search="<?php echo s($p->titulo . ' ' . $p->categoria . ' ' . $p->autor . ' ' . $p->anio); ?>">
                    <div class="sel-poster">
                        <?php if (!empty($p->poster)) : ?>
                            <img src="/build/img/peliculas/<?php echo s($p->poster); ?>" alt="<?php echo s($p->titulo); ?>" loading="lazy">
                        <?php else : ?>
                            <div class="sel-ph"><?php echo icono('film'); ?></div>
                        <?php endif; ?>
                        <?php if ($tiene && $n > 0) : ?><span class="sel-badge"><?php echo icono('estrella'); ?><?php echo number_format($n, 0); ?></span><?php endif; ?>
                    </div>
                    <h3 class="sel-name"><?php echo s($p->titulo); ?></h3>
                    <p class="sel-meta"><?php echo s($p->categoria); ?><?php echo $p->anio ? ' · ' . s($p->anio) : ''; ?></p>
                </a>
            <?php endforeach; ?>
            <?php if (empty($peliculas)) : ?><p style="color:var(--muted)">Aún no hay títulos registrados.</p><?php endif; ?>
        </div>
    </main>
</div>
</div>

<script>
(function () {
    // Buscador inteligente: normaliza acentos y empareja por tokens (AND).
    var input = document.getElementById('pel-search');
    if (!input) return;
    var clearBtn = document.getElementById('pel-search-clear');
    var noneMsg  = document.getElementById('pel-search-none');
    var cards    = Array.prototype.slice.call(document.querySelectorAll('#pel-grid [data-search]'));

    function norm(str) { return (str || '').normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase(); }

    function filtrar() {
        var raw = input.value.trim();
        clearBtn.hidden = raw === '';
        var q = norm(raw);
        if (q === '') {
            cards.forEach(function (c) { c.style.display = ''; });
            noneMsg.hidden = true;
            return;
        }
        var tokens = q.split(/\s+/), visibles = 0;
        cards.forEach(function (c) {
            var hay = norm(c.getAttribute('data-search'));
            var ok = tokens.every(function (t) { return hay.indexOf(t) !== -1; });
            c.style.display = ok ? '' : 'none';
            if (ok) visibles++;
        });
        noneMsg.hidden = visibles !== 0;
        if (!noneMsg.hidden) noneMsg.querySelector('span').textContent = raw;
    }

    input.addEventListener('input', filtrar);
    clearBtn.addEventListener('click', function () { input.value = ''; filtrar(); input.focus(); });
    input.addEventListener('keydown', function (e) { if (e.key === 'Escape') { input.value = ''; filtrar(); } });
})();
</script>

<?php include __DIR__ . '/../partials/paginas-foot.php'; ?>
