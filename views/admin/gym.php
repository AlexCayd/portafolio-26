<?php
$meses = [1=>'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
$hoy = date('Y-m-d');
$cumplido = $totales['si'] + $totales['no'];
$pct = $cumplido ? round($totales['si'] / $cumplido * 100, 2) : 0;

function mini_mes(int $anio, int $mes, array $dias) : void {
    $primero = (int) date('w', strtotime(sprintf('%04d-%02d-01', $anio, $mes)));
    $ndias = (int) date('t', strtotime(sprintf('%04d-%02d-01', $anio, $mes)));
    echo '<div class="mini-cal">';
    for ($i = 0; $i < $primero; $i++) echo '<div class="mini-day empty"></div>';
    for ($d = 1; $d <= $ndias; $d++) {
        $f = sprintf('%04d-%02d-%02d', $anio, $mes, $d);
        $st = isset($dias[$f]) ? ((int)$dias[$f] === 1 ? 'si' : 'no') : '';
        echo '<div class="mini-day ' . $st . '" data-fecha="' . $f . '">' . $d . '</div>';
    }
    echo '</div>';
}
?>
<div class="admin-head">
    <div>
        <h1>Gym</h1>
        <p>Presiona un día: sin marca → <strong>Sí</strong> → <strong>No</strong> → sin marca.</p>
    </div>
    <?php if ($vista === 'mes') : ?>
        <a class="btn btn--ghost" href="/admin/gym?vista=anio&anio=<?php echo $anio; ?>">Ver año <?php echo $anio; ?></a>
    <?php else : ?>
        <a class="btn btn--ghost" href="/admin/gym?anio=<?php echo $anio; ?>&mes=<?php echo (int)date('n'); ?>">Ver mes</a>
    <?php endif; ?>
</div>

<div class="gym-wrap">
    <div class="card">
        <?php if ($vista === 'mes') :
            $primerDiaSemana = (int) date('w', strtotime(sprintf('%04d-%02d-01', $anio, $mes)));
            $diasEnMes = (int) date('t', strtotime(sprintf('%04d-%02d-01', $anio, $mes)));
            $prevMes = $mes == 1 ? 12 : $mes - 1; $prevAnio = $mes == 1 ? $anio - 1 : $anio;
            $nextMes = $mes == 12 ? 1 : $mes + 1; $nextAnio = $mes == 12 ? $anio + 1 : $anio;
        ?>
            <div class="cal-head">
                <h2><?php echo $meses[$mes] . ' ' . $anio; ?></h2>
                <div class="cal-nav">
                    <a class="btn btn--sm btn--ghost" href="/admin/gym?anio=<?php echo $prevAnio; ?>&mes=<?php echo $prevMes; ?>">←</a>
                    <a class="btn btn--sm btn--ghost" href="/admin/gym?anio=<?php echo date('Y'); ?>&mes=<?php echo date('n'); ?>">Hoy</a>
                    <a class="btn btn--sm btn--ghost" href="/admin/gym?anio=<?php echo $nextAnio; ?>&mes=<?php echo $nextMes; ?>">→</a>
                </div>
            </div>
            <div class="cal-grid">
                <?php foreach (['do','lu','ma','mi','ju','vi','sa'] as $d) : ?><div class="cal-dow"><?php echo $d; ?></div><?php endforeach; ?>
                <?php for ($i = 0; $i < $primerDiaSemana; $i++) : ?><div class="cal-cell empty"></div><?php endfor; ?>
                <?php for ($d = 1; $d <= $diasEnMes; $d++) :
                    $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, $d);
                    $estado = isset($dias[$fecha]) ? ((int)$dias[$fecha] === 1 ? 'si' : 'no') : '';
                ?>
                    <div class="cal-cell <?php echo $estado; ?> <?php echo $fecha === $hoy ? 'today' : ''; ?>" data-fecha="<?php echo $fecha; ?>"><?php echo $d; ?></div>
                <?php endfor; ?>
            </div>
            <div class="gym-legend">
                <span><span class="sw sw-si"></span> Fui</span>
                <span><span class="sw sw-no"></span> No fui</span>
                <span><span class="sw" style="background:var(--surface-3)"></span> Sin registro</span>
            </div>
        <?php else : ?>
            <div class="cal-head">
                <h2>Año <?php echo $anio; ?></h2>
                <div class="cal-nav">
                    <a class="btn btn--sm btn--ghost" href="/admin/gym?vista=anio&anio=<?php echo $anio - 1; ?>">←</a>
                    <a class="btn btn--sm btn--ghost" href="/admin/gym?vista=anio&anio=<?php echo $anio + 1; ?>">→</a>
                </div>
            </div>
            <div class="year-grid">
                <?php for ($m = 1; $m <= 12; $m++) : ?>
                    <div class="mini-month">
                        <h4><?php echo $meses[$m]; ?></h4>
                        <?php mini_mes($anio, $m, $dias); ?>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card">
        <h2>Resumen · <?php echo s($ambito); ?></h2>
        <div class="kpis" style="grid-template-columns:1fr 1fr;margin-bottom:18px">
            <div class="kpi k-green"><div class="kpi-label">Sí</div><div class="kpi-value" id="t-si"><?php echo $totales['si']; ?></div></div>
            <div class="kpi k-red"><div class="kpi-label">No</div><div class="kpi-value" id="t-no"><?php echo $totales['no']; ?></div></div>
            <div class="kpi k-blue"><div class="kpi-label">Cumplido</div><div class="kpi-value" id="t-cumplido"><?php echo $cumplido; ?></div></div>
            <div class="kpi k-amber"><div class="kpi-label">% Visitas</div><div class="kpi-value" id="t-pct"><?php echo $pct; ?>%</div></div>
        </div>
        <canvas id="gymChart" style="max-height:220px"></canvas>
    </div>
</div>

<div class="card" style="margin-top:22px">
    <h3 style="margin:0 0 4px" id="gym-serie-titulo"><?php echo s($serie['titulo']); ?></h3>
    <p class="chart-sub" style="margin:0 0 16px" id="gym-serie-sub"><?php echo s($serie['sub']); ?></p>
    <canvas id="gymMesChart" style="max-height:260px"></canvas>
</div>

<script>
(function () {
    // El ámbito que se está viendo: se reenvía en cada toggle para que el
    // refresco sin recarga no se salga del mes/año seleccionado.
    var AMBITO = {
        anio:  <?php echo (int) $anio; ?>,
        mes:   <?php echo (int) $mes; ?>,
        vista: '<?php echo $vista; ?>'
    };

    // Los clicks del calendario no dependen de Chart.js: se registran siempre.
    document.querySelectorAll('[data-fecha]').forEach(function (cell) {
        cell.addEventListener('click', function () {
            var datos = { fecha: cell.dataset.fecha, anio: AMBITO.anio, mes: AMBITO.mes, vista: AMBITO.vista };
            postForm('/admin/gym/toggle', datos).then(function (r) {
                if (!r.ok) return;
                cell.classList.remove('si', 'no');
                if (r.estado === 'si') cell.classList.add('si'); else if (r.estado === 'no') cell.classList.add('no');
                if (window.gymRefrescar) window.gymRefrescar(r);
            });
        });
    });

    if (typeof Chart === 'undefined') return;
    var GREEN = '#34A853', RED = '#E51022', GRID = 'rgba(255,255,255,.07)';

    // Barras del ámbito: por día si la vista es de mes, por mes si es de año
    var S = <?php echo json_encode($serie, JSON_UNESCAPED_UNICODE); ?>;
    var serieChart = new Chart(document.getElementById('gymMesChart'), {
        type: 'bar',
        data: {
            labels: S.labels,
            datasets: [
                { label: 'Fui',    data: S.si, backgroundColor: GREEN, borderRadius: 5, borderSkipped: false },
                { label: 'No fui', data: S.no, backgroundColor: RED,   borderRadius: 5, borderSkipped: false }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { color: '#9a9aa4' } } },
            scales: {
                y: { beginAtZero: true, stacked: true, grid: { color: GRID }, ticks: { precision: 0 } },
                x: { stacked: true, grid: { display: false } }
            }
        }
    });

    // Dona del ámbito
    var T = <?php echo json_encode($totales, JSON_UNESCAPED_UNICODE); ?>;
    var chart = new Chart(document.getElementById('gymChart'), {
        type: 'doughnut',
        data: { labels: ['Fui', 'No fui'], datasets: [{ data: [T.si, T.no], backgroundColor: [GREEN, RED], borderColor: '#131316', borderWidth: 2 }] },
        options: { responsive: true, cutout: '64%', plugins: { legend: { position: 'bottom', labels: { color: '#9a9aa4' } } } }
    });

    window.gymRefrescar = function (r) {
        var t = r.totales, cumplido = t.si + t.no, pct = cumplido ? Math.round(t.si / cumplido * 10000) / 100 : 0;
        document.getElementById('t-si').textContent = t.si;
        document.getElementById('t-no').textContent = t.no;
        document.getElementById('t-cumplido').textContent = cumplido;
        document.getElementById('t-pct').textContent = pct + '%';
        chart.data.datasets[0].data = [t.si, t.no]; chart.update();

        if (!r.serie) return;
        serieChart.data.labels = r.serie.labels;
        serieChart.data.datasets[0].data = r.serie.si;
        serieChart.data.datasets[1].data = r.serie.no;
        serieChart.update();
    };
})();
</script>
