<div class="admin-head">
    <div>
        <h1>Panel de administración</h1>
        <p>Bienvenido, <?php echo s($_SESSION['nombre'] ?? 'Alex'); ?>. Gestiona el contenido del sitio.</p>
    </div>
    <a href="/" class="btn btn--ghost" target="_blank">Ver sitio ↗</a>
</div>

<div class="stat-strip">
    <a class="stat-item s-red" href="/admin/proyectos"><span class="st-ic"><?php echo icono('proyectos'); ?></span><div class="st-txt"><div class="st-num"><?php echo $resumen['proyectos']; ?></div><div class="st-lbl">Proyectos</div></div><span class="st-go">→</span></a>
    <a class="stat-item s-orange" href="/admin/servicios"><span class="st-ic"><?php echo icono('servicios'); ?></span><div class="st-txt"><div class="st-num"><?php echo $resumen['servicios']; ?></div><div class="st-lbl">Servicios</div></div><span class="st-go">→</span></a>
    <a class="stat-item s-blue" href="/admin/credenciales"><span class="st-ic"><?php echo icono('credenciales'); ?></span><div class="st-txt"><div class="st-num"><?php echo $resumen['credenciales']; ?></div><div class="st-lbl">Credenciales</div></div><span class="st-go">→</span></a>
    <a class="stat-item s-amber" href="/admin/blog"><span class="st-ic"><?php echo icono('blog'); ?></span><div class="st-txt"><div class="st-num"><?php echo $resumen['blog']; ?></div><div class="st-lbl">Tékhne</div></div><span class="st-go">→</span></a>
    <a class="stat-item s-green" href="/admin/libros"><span class="st-ic"><?php echo icono('libros'); ?></span><div class="st-txt"><div class="st-num"><?php echo $resumen['libros']; ?></div><div class="st-lbl">Libros</div></div><span class="st-go">→</span></a>
    <a class="stat-item s-pink" href="/admin/peliculas"><span class="st-ic"><?php echo icono('peliculas'); ?></span><div class="st-txt"><div class="st-num"><?php echo $resumen['peliculas']; ?></div><div class="st-lbl">Pelis/Series</div></div><span class="st-go">→</span></a>
</div>

<div class="panels">
    <div class="panel">
        <h3>Últimos proyectos <a href="/admin/proyectos">Ver todos</a></h3>
        <ul class="mini-list">
            <?php foreach ($ultProyectos as $p) : ?>
                <li><img class="thumb" src="/build/img/proyectos/portadas/<?php echo s($p->img); ?>" alt="" onerror="this.style.visibility='hidden'"><div><div class="mini-t"><?php echo s($p->titulo); ?></div><div class="mini-s"><?php echo s($p->anio); ?></div></div></li>
            <?php endforeach; ?>
            <?php if (empty($ultProyectos)) : ?><li class="mini-s">Sin proyectos.</li><?php endif; ?>
        </ul>
    </div>
    <div class="panel">
        <h3>Servicios <a href="/admin/servicios">Ver todos</a></h3>
        <ul class="mini-list">
            <?php foreach ($servicios as $i => $sv) : ?>
                <li><div style="width:34px;height:34px;border-radius:8px;background:var(--surface-3);display:grid;place-items:center;font-family:var(--mono);color:var(--muted);flex:none"><?php echo sprintf('%02d', $i + 1); ?></div><div><div class="mini-t"><?php echo s($sv->titulo); ?></div><div class="mini-s"><?php echo s(str_replace(',', ', ', $sv->tags)); ?></div></div></li>
            <?php endforeach; ?>
            <?php if (empty($servicios)) : ?><li class="mini-s">Sin servicios.</li><?php endif; ?>
        </ul>
    </div>
    <div class="panel">
        <h3>Últimas credenciales <a href="/admin/credenciales">Ver todas</a></h3>
        <ul class="mini-list">
            <?php foreach ($ultCredenciales as $c) : ?>
                <li><img class="logo-thumb" src="/build/img/logos/<?php echo s($c->logo); ?>" alt="" onerror="this.style.visibility='hidden'"><div><div class="mini-t"><?php echo s($c->titulo); ?></div><div class="mini-s"><?php echo s($c->institucion); ?></div></div></li>
            <?php endforeach; ?>
            <?php if (empty($ultCredenciales)) : ?><li class="mini-s">Sin credenciales.</li><?php endif; ?>
        </ul>
    </div>
</div>

<div class="card" style="margin-top:24px">
    <div class="card-head">
        <div><h2 style="margin:0">Visitas del sitio</h2><span class="mini-s" style="color:var(--muted)"><b id="vis-periodo"></b> en el periodo · <?php echo number_format($visitasTotal); ?> totales</span></div>
        <div class="range-tabs" id="range-tabs">
            <button data-range="7" class="active">7 días</button>
            <button data-range="30">30 días</button>
            <button data-range="6m">6 meses</button>
            <button data-range="12m">12 meses</button>
        </div>
    </div>
    <canvas id="visitasChart" style="max-height:300px"></canvas>
</div>

<div class="card" style="margin-top:24px">
    <div class="card-head">
        <div><h2 style="margin:0">Páginas más visitadas</h2><span class="mini-s" style="color:var(--muted)">Todas las páginas del sitio, ordenadas por visitas</span></div>
    </div>
    <div class="tabla-wrap">
        <table class="tabla tabla--paginas" id="tabla-paginas">
            <thead>
                <tr><th style="width:44px">#</th><th>Página</th><th>Ruta</th><th style="text-align:right">Visitas</th><th></th></tr>
            </thead>
            <tbody>
                <?php foreach ($paginas as $ao_i => $pag) : ?>
                    <tr>
                        <td class="mini-s"><?php echo $ao_i + 1; ?></td>
                        <td><span class="pg-titulo"><?php echo s($pag->titulo ?: '(sin título)'); ?></span></td>
                        <td><a class="pg-ruta" href="<?php echo s($pag->ruta); ?>" target="_blank" rel="noopener"><?php echo s($pag->ruta); ?></a></td>
                        <td style="text-align:right"><span class="pg-visitas"><?php echo number_format((int) $pag->total); ?></span></td>
                        <td class="acciones"><a class="act-btn" href="<?php echo s($pag->ruta); ?>" target="_blank" rel="noopener" title="Ver página pública"><?php echo icono('externo'); ?></a></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($paginas)) : ?>
                    <tr><td colspan="5" class="mini-s" style="text-align:center;padding:26px 0;color:var(--muted)">Aún no se registran visitas por página.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="tabla-pager" id="paginas-pager" hidden>
        <button type="button" class="btn btn--sm btn--ghost" data-dir="prev">‹ Anterior</button>
        <span class="tabla-pager-info" id="paginas-pager-info"></span>
        <button type="button" class="btn btn--sm btn--ghost" data-dir="next">Siguiente ›</button>
    </div>
</div>

<script>
(function () {
    // Paginación en cliente de la tabla de páginas (8 filas por página).
    var tabla = document.getElementById('tabla-paginas');
    if (!tabla) return;
    var filas = Array.prototype.slice.call(tabla.querySelectorAll('tbody tr')).filter(function (tr) { return tr.querySelector('.pg-ruta'); });
    var pager = document.getElementById('paginas-pager');
    var info  = document.getElementById('paginas-pager-info');
    var POR = 8, actual = 0, total = Math.ceil(filas.length / POR);
    if (filas.length <= POR) return;              // sin paginación si cabe todo
    pager.hidden = false;

    function render() {
        var ini = actual * POR, fin = ini + POR;
        filas.forEach(function (tr, i) { tr.style.display = (i >= ini && i < fin) ? '' : 'none'; });
        info.textContent = 'Página ' + (actual + 1) + ' de ' + total;
        pager.querySelector('[data-dir="prev"]').disabled = actual === 0;
        pager.querySelector('[data-dir="next"]').disabled = actual >= total - 1;
    }
    pager.querySelector('[data-dir="prev"]').addEventListener('click', function () { if (actual > 0) { actual--; render(); } });
    pager.querySelector('[data-dir="next"]').addEventListener('click', function () { if (actual < total - 1) { actual++; render(); } });
    render();
})();
</script>

<script>
(function () {
    if (typeof Chart === 'undefined') return;
    var series = {
        '7':   <?php echo json_encode($vis7, JSON_UNESCAPED_UNICODE); ?>,
        '30':  <?php echo json_encode($vis30, JSON_UNESCAPED_UNICODE); ?>,
        '6m':  <?php echo json_encode($vis6m, JSON_UNESCAPED_UNICODE); ?>,
        '12m': <?php echo json_encode($vis12m, JSON_UNESCAPED_UNICODE); ?>
    };
    var RED = '#ff0a24', INK = '#9a9aa4', GRID = 'rgba(255,255,255,.07)';
    Chart.defaults.color = INK; Chart.defaults.font.family = "'Space Grotesk', sans-serif";
    var periodoEl = document.getElementById('vis-periodo');
    function fmt(n) { return n.toLocaleString('es-MX') + ' visitas'; }
    periodoEl.textContent = fmt(series['7'].total);
    var chart = new Chart(document.getElementById('visitasChart'), {
        type: 'line',
        data: { labels: series['7'].labels, datasets: [{ label: 'Visitas', data: series['7'].data, borderColor: RED, backgroundColor: 'rgba(255,10,36,.12)', borderWidth: 2, fill: true, tension: .32, pointRadius: 3, pointBackgroundColor: RED }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: GRID } }, x: { grid: { display: false } } } }
    });
    document.querySelectorAll('#range-tabs button').forEach(function (b) {
        b.addEventListener('click', function () {
            document.querySelectorAll('#range-tabs button').forEach(function (x) { x.classList.remove('active'); });
            b.classList.add('active');
            var s = series[b.dataset.range];
            chart.data.labels = s.labels; chart.data.datasets[0].data = s.data; chart.update();
            periodoEl.textContent = fmt(s.total);
        });
    });
})();
</script>
