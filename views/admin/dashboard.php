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

<?php
// Resumen de vida: clase actual/próxima + lectura/visionado (año en curso) + gym + neto
function vida_delta($ahora, $prev, $anioPrev) {
    $d = $ahora - $prev;
    if ($d > 0) return '<span class="vida-delta up">▲ ' . $d . ' vs. ' . $anioPrev . ' a la fecha</span>';
    if ($d < 0) return '<span class="vida-delta down">▼ ' . abs($d) . ' vs. ' . $anioPrev . ' a la fecha</span>';
    return '<span class="vida-delta flat">= igual que ' . $anioPrev . ' a la fecha</span>';
}
function vida_delta_pct($ahora, $prev) {
    if ($prev === null) return '<span class="vida-delta flat">sin dato del mes pasado</span>';
    $d = $ahora - $prev;
    if ($d > 0) return '<span class="vida-delta up">▲ ' . $d . ' pts vs. mes pasado</span>';
    if ($d < 0) return '<span class="vida-delta down">▼ ' . abs($d) . ' pts vs. mes pasado</span>';
    return '<span class="vida-delta flat">= igual que el mes pasado</span>';
}
$cl = $vida['clase'];
$anioVida = (int) ($vida['anio'] ?? date('Y'));
$anioPrev = $anioVida - 1;
?>
<div class="vida-strip">
    <div class="vida-tile vida-tile--tint vida-tile--clase<?php echo $cl['estado'] === 'ahora' ? ' is-live' : ''; ?>" style="--m-color:<?php echo s($cl['color'] ?? 'var(--accent)'); ?>;--v-color:<?php echo s($cl['color'] ?? 'var(--accent)'); ?>">
        <div class="vida-tile-top"><span class="vida-ic"><?php echo icono('horario'); ?></span>
            <span class="vida-lbl"><?php echo $cl['estado'] === 'ahora' ? 'Ahora en clase' : ($cl['estado'] === 'proxima' ? 'Siguiente clase' : 'Sin clases'); ?></span>
        </div>
        <?php if ($cl['estado'] === 'libre') : ?>
            <div class="vida-num vida-num--sm">Día libre</div>
            <div class="vida-sub">Sin clases programadas</div>
        <?php else : ?>
            <div class="vida-num vida-num--sm"><?php echo s($cl['materia']); ?></div>
            <div class="vida-sub"><?php
                if ($cl['estado'] === 'ahora') {
                    echo 'Hasta las ' . s($cl['fin']);
                } elseif (!empty($cl['esHoy'])) {
                    echo 'A las ' . s($cl['inicio']);
                } else {
                    echo s($cl['diaLabel']) . ' · ' . s($cl['inicio']);
                }
            ?></div>
        <?php endif; ?>
    </div>
    <a class="vida-tile vida-tile--tint" href="/admin/libros" style="--v-color:var(--c-amber)">
        <div class="vida-tile-top"><span class="vida-ic"><?php echo icono('libros'); ?></span><span class="vida-lbl">Libros leídos · <?php echo $anioVida; ?></span></div>
        <div class="vida-num"><?php echo (int) $vida['librosAhora']; ?></div>
        <div class="vida-sub"><?php echo vida_delta($vida['librosAhora'], $vida['librosPrev'], $anioPrev); ?></div>
    </a>
    <a class="vida-tile vida-tile--tint" href="/admin/peliculas" style="--v-color:var(--c-pink)">
        <div class="vida-tile-top"><span class="vida-ic"><?php echo icono('peliculas'); ?></span><span class="vida-lbl">Pelis/series · <?php echo $anioVida; ?></span></div>
        <div class="vida-num"><?php echo (int) $vida['pelisAhora']; ?></div>
        <div class="vida-sub"><?php echo vida_delta($vida['pelisAhora'], $vida['pelisPrev'], $anioPrev); ?></div>
    </a>
    <a class="vida-tile vida-tile--tint" href="/admin/gym" style="--v-color:var(--c-blue)">
        <div class="vida-tile-top"><span class="vida-ic"><?php echo icono('gym'); ?></span><span class="vida-lbl">Gym · asistencia del mes</span></div>
        <?php if ($vida['gymAhora'] === null) : ?>
            <div class="vida-num vida-num--sm">—</div>
            <div class="vida-sub">Sin registros este mes</div>
        <?php else : ?>
            <div class="vida-num"><?php echo (int) $vida['gymAhora']; ?><small>%</small></div>
            <div class="vida-sub"><?php echo vida_delta_pct($vida['gymAhora'], $vida['gymPrev']); ?></div>
        <?php endif; ?>
    </a>
    <a class="vida-tile vida-tile--tint" href="/admin/finanzas" style="--v-color:var(--c-green)">
        <div class="vida-tile-top"><span class="vida-ic"><?php echo icono('finanzas'); ?></span><span class="vida-lbl">Patrimonio neto</span></div>
        <div class="vida-num vida-num--fit">$<?php echo number_format((float) $vida['neto'], 0); ?></div>
        <div class="vida-sub">activos + por cobrar − deudas</div>
    </a>
</div>

<div class="panels">
    <div class="panel">
        <h3>Últimos proyectos <a href="/admin/proyectos">Ver todos</a></h3>
        <ul class="mini-list">
            <?php foreach ($ultProyectos as $p) : ?>
                <li><img class="thumb" src="<?php echo urlSubida('proyectos/portadas', $p->img); ?>" alt="" onerror="this.style.visibility='hidden'"><div><div class="mini-t"><?php echo s($p->titulo); ?></div><div class="mini-s"><?php echo s($p->anio); ?></div></div></li>
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
                <li><img class="logo-thumb" src="<?php echo urlSubida('logos', $c->logo); ?>" alt="" onerror="this.style.visibility='hidden'"><div><div class="mini-t"><?php echo s($c->titulo); ?></div><div class="mini-s"><?php echo s($c->institucion); ?></div></div></li>
            <?php endforeach; ?>
            <?php if (empty($ultCredenciales)) : ?><li class="mini-s">Sin credenciales.</li><?php endif; ?>
        </ul>
    </div>
</div>

<div class="card" style="margin-top:24px">
    <div class="card-head">
        <div><h2 style="margin:0">Visitas del sitio</h2><span class="mini-s" style="color:var(--muted)"><b id="vis-periodo"></b> <span id="vis-periodo-txt">en los últimos 7 días</span> · <?php echo number_format($visitasTotal); ?> totales</span></div>
        <div class="range-tabs" id="range-tabs">
            <button data-range="7" class="active">7 días</button>
            <button data-range="30">30 días</button>
            <button data-range="6m">6 meses</button>
            <button data-range="12m">12 meses</button>
            <button data-range="todo">Todo el histórico</button>
        </div>
    </div>
    <canvas id="visitasChart" style="max-height:300px"></canvas>
</div>

<div class="card" style="margin-top:24px">
    <div class="card-head">
        <div><h2 style="margin:0">Páginas más visitadas</h2><span class="mini-s" style="color:var(--muted)" id="paginas-sub">Ordenadas por visitas en el periodo</span></div>
    </div>
    <div class="tabla-wrap">
        <table class="tabla tabla--paginas" id="tabla-paginas">
            <thead>
                <tr><th style="width:44px">#</th><th>Página</th><th>Ruta</th><th style="text-align:right">Visitas</th><th></th></tr>
            </thead>
            <tbody id="paginas-body"></tbody>
        </table>
    </div>
    <div class="tabla-pager" id="paginas-pager" hidden>
        <button type="button" class="btn btn--sm btn--ghost" data-dir="prev">‹ Anterior</button>
        <span class="tabla-pager-info" id="paginas-pager-info"></span>
        <button type="button" class="btn btn--sm btn--ghost" data-dir="next">Siguiente ›</button>
    </div>
    <!-- Solo se muestra si en el periodo hay rutas sin desglose por fecha -->
    <p class="mini-s pg-nota" id="paginas-nota" hidden>
        <span class="pg-acum">Acumulado</span>
        Rutas visitadas en este periodo que aún no tienen desglose por fecha<?php echo !empty($inicioDetalle) ? ' (empezó el ' . s(fechaLarga($inicioDetalle)) . ')' : ''; ?>: la cifra es su total histórico, no las visitas del periodo.
    </p>
</div>

<script>
(function () {
    if (typeof Chart === 'undefined') return;

    // Una sola fuente para las dos vistas: el selector de periodo manda sobre
    // la gráfica y sobre la tabla de páginas.
    var series  = <?php echo json_encode($visSeries, JSON_UNESCAPED_UNICODE); ?>;
    var paginas = <?php echo json_encode($paginasSeries, JSON_UNESCAPED_UNICODE); ?>;
    var ETIQUETA = { '7': 'en los últimos 7 días', '30': 'en los últimos 30 días',
                     '6m': 'en los últimos 6 meses', '12m': 'en los últimos 12 meses',
                     'todo': 'en todo el histórico' };
    var RANGO = '7';

    var RED = '#ff0a24', INK = '#9a9aa4', GRID = 'rgba(255,255,255,.07)';
    Chart.defaults.color = INK; Chart.defaults.font.family = "'Space Grotesk', sans-serif";

    var periodoEl  = document.getElementById('vis-periodo');
    var periodoTxt = document.getElementById('vis-periodo-txt');
    function fmt(n) { return n.toLocaleString('es-MX') + ' visitas'; }

    var chart = new Chart(document.getElementById('visitasChart'), {
        type: 'line',
        data: { labels: [], datasets: [{ label: 'Visitas', data: [], borderColor: RED, backgroundColor: 'rgba(255,10,36,.12)', borderWidth: 2, fill: true, tension: .32, pointRadius: 3, pointBackgroundColor: RED }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: GRID } }, x: { grid: { display: false } } } }
    });

    /* ---- Tabla de páginas: se repinta con el periodo ---- */
    var cuerpo = document.getElementById('paginas-body');
    var pager  = document.getElementById('paginas-pager');
    var info   = document.getElementById('paginas-pager-info');
    var nota   = document.getElementById('paginas-nota');
    var ICO_EXT = <?php echo json_encode(icono('externo'), JSON_HEX_TAG); ?>;
    var POR = 8, actual = 0, filas = [];

    function esc(s) {
        return String(s === null || s === undefined ? '' : s)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
    function pintarTabla() {
        var total = Math.ceil(filas.length / POR) || 1;
        if (actual >= total) actual = total - 1;
        if (!filas.length) {
            cuerpo.innerHTML = '<tr><td colspan="5" class="mini-s" style="text-align:center;padding:26px 0;color:var(--muted)">Sin visitas registradas en este periodo.</td></tr>';
            pager.hidden = true;
            return;
        }
        var ini = actual * POR;
        cuerpo.innerHTML = filas.slice(ini, ini + POR).map(function (p, i) {
            var ruta = esc(p.ruta);
            // Las acumuladas no compiten en el ranking del periodo: sin puesto
            return '<tr' + (p.acumulado ? ' class="is-acumulado"' : '') + '>' +
                '<td class="mini-s">' + (p.acumulado ? '—' : (ini + i + 1)) + '</td>' +
                '<td><span class="pg-titulo">' + esc(p.titulo || '(sin título)') + '</span></td>' +
                '<td><a class="pg-ruta" href="' + ruta + '" target="_blank" rel="noopener">' + ruta + '</a></td>' +
                '<td style="text-align:right">' + (p.acumulado ? '<span class="pg-acum" title="Total histórico: esta ruta aún no tiene visitas por fecha">Acumulado</span> ' : '') +
                    '<span class="pg-visitas">' + Number(p.total).toLocaleString('es-MX') + '</span></td>' +
                '<td class="acciones"><a class="act-btn" href="' + ruta + '" target="_blank" rel="noopener" title="Ver página pública">' + ICO_EXT + '</a></td>' +
                '</tr>';
        }).join('');

        pager.hidden = filas.length <= POR;
        info.textContent = 'Página ' + (actual + 1) + ' de ' + total;
        pager.querySelector('[data-dir="prev"]').disabled = actual === 0;
        pager.querySelector('[data-dir="next"]').disabled = actual >= total - 1;
    }
    pager.querySelector('[data-dir="prev"]').addEventListener('click', function () { if (actual > 0) { actual--; pintarTabla(); } });
    pager.querySelector('[data-dir="next"]').addEventListener('click', function () { actual++; pintarTabla(); });

    function aplicar(rango) {
        RANGO = rango;
        var s = series[rango] || { labels: [], data: [], total: 0 };
        chart.data.labels = s.labels;
        chart.data.datasets[0].data = s.data;
        chart.update();
        periodoEl.textContent = fmt(s.total);
        periodoTxt.textContent = ETIQUETA[rango] || '';

        filas = paginas[rango] || [];
        actual = 0;                                  // el periodo nuevo empieza en la página 1
        pintarTabla();
        nota.hidden = !filas.some(function (p) { return p.acumulado; });
    }

    document.querySelectorAll('#range-tabs button').forEach(function (b) {
        b.addEventListener('click', function () {
            document.querySelectorAll('#range-tabs button').forEach(function (x) { x.classList.remove('active'); });
            b.classList.add('active');
            aplicar(b.dataset.range);
        });
    });
    aplicar('7');
})();
</script>
