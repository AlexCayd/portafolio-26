<div class="admin-head">
    <div>
        <h1 class="h1-ico"><?php echo icono('estrella'); ?> Selección del Autor</h1>
        <p>Mis obras maestras: los títulos que me merecieron un 10/10 perfecto (<?php echo count($watchlist); ?>).</p>
    </div>
    <a href="/admin/peliculas" class="btn btn--ghost">← Volver al dashboard</a>
</div>

<div class="card">
    <?php if (!empty($watchlist)) : ?>
        <div class="watchlist">
            <?php foreach ($watchlist as $w) : ?>
                <div class="wl-card">
                    <div class="wl-poster">
                        <?php if (!empty($w['poster'])) : ?>
                            <img class="poster" src="/build/img/peliculas/<?php echo s($w['poster']); ?>" alt="">
                        <?php else : ?>
                            <div class="poster-ph"><?php echo icono('film'); ?></div>
                        <?php endif; ?>
                        <span class="wl-badge"><?php echo icono('estrella'); ?>10</span>
                    </div>
                    <div class="wl-body">
                        <h4><?php echo s($w['titulo']); ?></h4>
                        <div class="wl-meta"><?php echo s($w['categoria']); ?><?php echo $w['autor'] ? ' · ' . s($w['autor']) : ''; ?><?php echo $w['anio'] ? ' · ' . s($w['anio']) : ''; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p style="color:var(--muted)">Aún no hay títulos con nota 10/10.</p>
    <?php endif; ?>
</div>

<div class="card" style="margin-top:22px">
    <div class="card-head">
        <div><h3 style="margin:0 0 4px">Obras maestras 10/10 por mes</h3><p class="chart-sub" style="margin:0">Distribución de películas y series con nota perfecta</p></div>
        <label class="campo" style="margin:0;flex-direction:row;align-items:center;gap:8px">
            <span style="margin:0">Año</span>
            <select id="wl-anio" style="background:var(--surface-2);border:1px solid var(--line-2);color:var(--text);border-radius:8px;padding:8px 12px;font:inherit">
                <?php foreach ($anios as $y) : ?><option value="<?php echo $y; ?>" <?php echo $y === $anioSel ? 'selected' : ''; ?>><?php echo $y; ?></option><?php endforeach; ?>
            </select>
        </label>
    </div>
    <canvas id="chartMes" style="max-height:280px"></canvas>
</div>

<script>
(function () {
    if (typeof Chart === 'undefined') return;
    var POR_ANIO = <?php echo json_encode($porAnio, JSON_UNESCAPED_UNICODE); ?>;
    var sel = document.getElementById('wl-anio');
    var GRID = 'rgba(255,255,255,.07)';
    Chart.defaults.color = '#9a9aa4'; Chart.defaults.font.family = "'Space Grotesk', sans-serif";
    var first = POR_ANIO[sel.value] || { labels: [], data: [] };
    var chart = new Chart(document.getElementById('chartMes'), {
        type: 'bar',
        data: { labels: first.labels, datasets: [{ label: '10/10', data: first.data, backgroundColor: '#F5B400', borderRadius: 5, borderSkipped: false }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: GRID }, ticks: { precision: 0 } }, x: { grid: { display: false } } } }
    });
    sel.addEventListener('change', function () {
        var d = POR_ANIO[sel.value] || { labels: [], data: [] };
        chart.data.labels = d.labels; chart.data.datasets[0].data = d.data; chart.update();
    });
})();
</script>
