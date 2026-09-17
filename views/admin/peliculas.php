<div class="admin-head">
    <div>
        <h1>Películas y Series</h1>
        <p>Dashboard de análisis. «Aprobado» = nota ≥ <?php echo \Model\Pelicula::UMBRAL_APROBADO; ?>.</p>
    </div>
    <a href="/admin/peliculas/gestionar" class="btn btn--primary">Gestionar / Reseñar →</a>
</div>

<div class="kpis">
    <div class="kpi k-blue"><div class="kpi-label">Total puntuadas</div><div class="kpi-value"><?php echo $stats['total']; ?></div><div class="kpi-sub"><?php echo count($stats['catLabels']); ?> categorías</div></div>
    <div class="kpi k-amber"><div class="kpi-label">Nota promedio</div><div class="kpi-value"><?php echo number_format($stats['notaPromedio'], 2); ?></div><div class="kpi-sub">sobre 10</div></div>
    <div class="kpi k-green"><div class="kpi-label">% de aprobación</div><div class="kpi-value"><?php echo $stats['pctAprobacion']; ?>%</div><div class="kpi-sub"><?php echo $stats['aprobados']; ?> aprobadas · <?php echo $stats['noAprobados']; ?> no</div></div>
    <div class="kpi k-orange"><div class="kpi-label">Duración promedio</div><div class="kpi-value"><?php echo $stats['duracionProm']; ?></div><div class="kpi-sub">minutos</div></div>
</div>

<?php
// Póster con nota del ranking. $extra va dentro del póster (el puesto y el
// movimiento).
$ao_poster = function ($p, string $extra = '') {
    $n = (float) $p->nota; $cls = $n >= 8 ? 'nota-alta' : ($n >= 5 ? 'nota-media' : 'nota-baja');
    $img = !empty($p->poster)
        ? '<img src="' . urlSubida('peliculas', $p->poster) . '" alt="" loading="lazy">'
        : '<div class="poster-ph">' . icono('film') . '</div>';
    return '<a class="pel-tira-item" href="/admin/peliculas/gestionar?id=' . (int) $p->id . '" title="Editar ' . s($p->titulo) . '">'
         . '<div class="pel-tira-poster">' . $img . $extra
         . '<span class="nota-badge ' . $cls . ' pel-tira-nota">' . number_format($n, 0) . '</span></div>'
         . '<span class="pel-tira-titulo">' . s($p->titulo) . '</span></a>';
};
?>

<!-- Últimos 5 como lista vertical junto al ranking de 2×5: las dos tarjetas
     miden lo mismo y la lista cuenta cuándo se vio cada uno. -->
<div class="pel-duo">
    <div class="card">
        <div class="card-head"><div class="card-titulo"><h2 class="h2-ico"><?php echo icono('film'); ?> Últimos registros</h2><p class="card-sub">Los 5 más recientes por fecha vista</p></div></div>
        <?php if (!empty($ultimos)) : ?>
            <ol class="pel-recientes">
                <?php foreach ($ultimos as $p) : $n = (float) $p->nota; $cls = $n >= 8 ? 'nota-alta' : ($n >= 5 ? 'nota-media' : 'nota-baja'); ?>
                    <li>
                        <a class="pel-reciente" href="/admin/peliculas/gestionar?id=<?php echo $p->id; ?>" title="Editar <?php echo s($p->titulo); ?>">
                            <span class="pel-reciente-poster">
                                <?php if (!empty($p->poster)) : ?><img src="<?php echo urlSubida('peliculas', $p->poster); ?>" alt="" loading="lazy">
                                <?php else : ?><span class="poster-ph"><?php echo icono('film'); ?></span><?php endif; ?>
                            </span>
                            <span class="pel-reciente-info">
                                <span class="pel-reciente-titulo"><?php echo s($p->titulo); ?></span>
                                <span class="pel-reciente-meta"><?php echo s(trim($p->categoriaTexto() . ($p->anio ? ' · ' . $p->anio : ''), ' ·')); ?></span>
                                <span class="pel-reciente-fecha"><?php echo icono('calendario'); ?><?php echo $p->fecha_vista ? s(fechaLarga((string) $p->fecha_vista)) : 'Sin fecha'; ?></span>
                            </span>
                            <span class="nota-badge <?php echo $cls; ?>"><?php echo number_format($n, 0); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php else : ?>
            <p style="color:var(--muted)">Aún no hay títulos registrados.</p>
        <?php endif; ?>
    </div>

    <div class="card">
        <div class="card-head"><div class="card-titulo"><h2 class="h2-ico"><?php echo icono('estrella'); ?> Mejor puntuados de <?php echo $anioActual; ?></h2><p class="card-sub">Top 10 · las flechas marcan el cambio desde el último día visto</p></div></div>
        <?php if (!empty($topAnio)) : ?>
            <div class="pel-tira pel-tira--ranking">
                <?php foreach ($topAnio as $i => $r) :
                    $mov = $r['mov'];
                    // Solo la dirección: flecha arriba (subió o entró) o abajo (bajó).
                    // Sin cambios no se pinta nada. El detalle va al lector de pantalla.
                    if ($mov === 'nuevo')  { $movCls = 'sube'; $movIco = 'arriba'; $movTxt = 'entró al ranking'; }
                    elseif ($mov > 0)      { $movCls = 'sube'; $movIco = 'arriba'; $movTxt = 'subió ' . $mov . ($mov === 1 ? ' puesto' : ' puestos'); }
                    elseif ($mov < 0)      { $movCls = 'baja'; $movIco = 'abajo';  $movTxt = 'bajó ' . (-$mov) . ($mov === -1 ? ' puesto' : ' puestos'); }
                    else                   { $movCls = '';     $movIco = '';       $movTxt = ''; }
                    $movHtml = $movCls
                        ? '<span class="pel-mov pel-mov--' . $movCls . '"><span aria-hidden="true">' . icono($movIco) . '</span><span class="oculto-visual">, ' . $movTxt . '</span></span>'
                        : '';
                    echo $ao_poster($r['peli'], '<span class="pel-tira-rank">#' . ($i + 1) . $movHtml . '</span>');
                endforeach; ?>
            </div>
        <?php else : ?>
            <p style="color:var(--muted)">Aún no hay títulos registrados en <?php echo $anioActual; ?>.</p>
        <?php endif; ?>
    </div>
</div>

<div class="card" style="margin-top:22px">
    <div class="card-head">
        <h2 class="h2-ico"><?php echo icono('estrella'); ?> Selección del Autor <span class="mini-s" style="color:var(--muted)">— curada a mano (<?php echo count($stats['watchlist']); ?>)</span></h2>
        <?php if (count($stats['watchlist']) > 5) : ?><a href="/admin/peliculas/watchlist" class="btn btn--sm">Ver completa →</a><?php endif; ?>
    </div>
    <?php if (!empty($stats['watchlist'])) : ?>
        <div class="watchlist wl-strip">
            <?php foreach (array_slice($stats['watchlist'], 0, 5) as $w) : ?>
                <div class="wl-card">
                    <div class="wl-poster">
                        <?php if (!empty($w['poster'])) : ?>
                            <img class="poster" src="<?php echo urlSubida('peliculas', $w['poster']); ?>" alt="">
                        <?php else : ?>
                            <div class="poster-ph"><?php echo icono('film'); ?></div>
                        <?php endif; ?>
                        <span class="wl-badge"><?php echo icono('estrella'); ?><?php echo number_format((float) $w['nota'], 0); ?></span>
                    </div>
                    <div class="wl-body">
                        <h4><?php echo s($w['titulo']); ?></h4>
                        <div class="wl-meta"><?php echo s($w['categoria']); ?><?php echo $w['anio'] ? ' · ' . s($w['anio']) : ''; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p style="color:var(--muted)">Aún no hay títulos en la selección. Márcalos desde <a href="/admin/peliculas/gestionar">Gestionar</a>.</p>
    <?php endif; ?>
</div>

<div class="chart-grid" style="margin-top:22px">
    <div class="chart-box span-8"><h3>Distribución de calificaciones</h3><p class="chart-sub">Cantidad de títulos por nota (1–10)</p><canvas id="chartCalif"></canvas></div>
    <div class="chart-box span-4"><h3>Aprobación</h3><p class="chart-sub">Aprobado vs. No aprobado</p><canvas id="chartAprob"></canvas></div>
    <div class="chart-box span-8"><h3>Nota promedio por año visto</h3><p class="chart-sub">Promedio de lo que califiqué cada año</p><canvas id="chartAnioProm"></canvas></div>
    <div class="chart-box span-4"><h3>Por categoría</h3><p class="chart-sub">Reparto de la colección</p><canvas id="chartCat"></canvas></div>
    <div class="chart-box span-12">
        <h3>Vistos por mes</h3>
        <p class="chart-sub">Títulos registrados en cada mes, sumando todos los años (pasa el cursor para el desglose)</p>
        <canvas id="chartVistosMes"></canvas>
    </div>
    <div class="chart-box span-12">
        <h3>Top 5 directores / creadores</h3>
        <p class="chart-sub">Por número de títulos, con todo lo que tengo registrado de cada uno</p>
        <?php if (!empty($topDirectores)) : $ao_max = max(1, $topDirectores[0]['total']); ?>
            <ol class="dir-top">
                <?php foreach ($topDirectores as $i => $d) : ?>
                    <li class="dir-top-fila">
                        <div class="dir-top-cab">
                            <span class="dir-top-pos"><?php echo sprintf('%02d', $i + 1); ?></span>
                            <span class="dir-top-nombre"><?php echo s($d['nombre']); ?></span>
                            <span class="dir-top-total"><?php echo $d['total']; ?> <?php echo $d['total'] === 1 ? 'título' : 'títulos'; ?></span>
                            <span class="dir-top-barra" aria-hidden="true"><span style="width:<?php echo round($d['total'] / $ao_max * 100, 1); ?>%"></span></span>
                        </div>
                        <ul class="dir-top-titulos">
                            <?php foreach ($d['titulos'] as $p) : $n = (float) $p->nota; $cls = $n >= 8 ? 'nota-alta' : ($n >= 5 ? 'nota-media' : 'nota-baja'); ?>
                                <li>
                                    <a href="/admin/peliculas/gestionar?id=<?php echo $p->id; ?>" title="<?php echo s($p->titulo) . ($p->anio ? ' (' . s($p->anio) . ')' : ''); ?>">
                                        <?php if (!empty($p->poster)) : ?><img src="<?php echo urlSubida('peliculas', $p->poster); ?>" alt="<?php echo s($p->titulo); ?>" loading="lazy">
                                        <?php else : ?><span class="poster-ph"><?php echo icono('film'); ?></span><?php endif; ?>
                                        <span class="nota-badge <?php echo $cls; ?>"><?php echo number_format($n, 0); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php else : ?>
            <p style="color:var(--muted)">Aún no hay directores registrados.</p>
        <?php endif; ?>
    </div>
    <div class="chart-box span-12"><h3>Vistas acumuladas</h3><p class="chart-sub">Total acumulado por año en que lo vi</p><canvas id="chartAcum"></canvas></div>
</div>

<div class="card" id="catalogo" style="margin-top:22px">
    <div class="card-head"><h2>Catálogo <span class="conteo"><?php echo (int) $stats['total']; ?></span></h2><a href="/admin/peliculas/gestionar" class="btn btn--sm btn--primary">Gestionar / Reseñar →</a></div>
    <div class="tabla-wrap tabla-wrap--cards">
        <table class="tabla tabla--cards">
            <thead><tr><th>Póster</th><th>Título</th><th>Categoría</th><th>Dir./Creador</th><th>Año</th><th>Nota</th><th>Estado</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($peliculas as $p) : $n = (float) $p->nota; $cls = $n >= 8 ? 'nota-alta' : ($n >= 5 ? 'nota-media' : 'nota-baja'); ?>
                <tr>
                    <td class="cell-poster" data-label=""><?php if (!empty($p->poster)) : ?><img class="poster-mini" src="<?php echo urlSubida('peliculas', $p->poster); ?>" alt=""><?php else : ?><div class="poster-mini" style="display:grid;place-items:center;color:var(--muted-2)"><?php echo icono('film'); ?></div><?php endif; ?></td>
                    <td class="cell-titulo" data-label="Título"><?php echo s($p->titulo); ?></td>
                    <td data-label="Categoría"><span class="badge badge--cat"><?php echo s($p->categoriaTexto()); ?></span></td>
                    <td data-label="Dir./Creador" style="color:var(--muted)"><?php echo s($p->personasTexto()); ?></td>
                    <td data-label="Año"><?php echo s($p->anio); ?></td>
                    <td data-label="Nota"><span class="nota-badge <?php echo $cls; ?>"><?php echo number_format($n, 0); ?></span></td>
                    <td data-label="Estado"><?php echo $p->estaAprobada() ? '<span class="badge badge--ok">Aprobado</span>' : '<span class="badge badge--no">No aprobado</span>'; ?></td>
                    <td class="acciones" data-label="Acciones">
                        <a href="/admin/peliculas/gestionar?id=<?php echo $p->id; ?>" class="act-btn act-edit" title="Editar"><?php echo icono('editar'); ?></a>
                        <form method="POST" action="/admin/peliculas/eliminar" data-confirm="Se eliminará este título." data-confirm-name="<?php echo s($p->titulo); ?>">
                            <input type="hidden" name="id" value="<?php echo $p->id; ?>">
                            <button class="act-btn act-del" title="Eliminar"><?php echo icono('eliminar'); ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($peliculas)) : ?><tr><td colspan="8" style="color:var(--muted)">Sin títulos.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if ($totalPag > 1) : ?>
        <div class="paginacion">
            <?php for ($i = 1; $i <= $totalPag; $i++) : ?>
                <?php if ($i === $pagina) : ?><span class="actual"><?php echo $i; ?></span>
                <?php else : ?><a href="/admin/peliculas?pagina=<?php echo $i; ?>#catalogo"><?php echo $i; ?></a><?php endif; ?>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

<script>
(function () {
    if (typeof Chart === 'undefined') return;
    var S = <?php echo json_encode($stats, JSON_UNESCAPED_UNICODE); ?>;
    var PAL = ['#F5B400','#3A86FF','#E51022','#8AC926','#AA2296','#FC6722','#46BDC6','#4267AC','#EA075A','#6A4C93','#34A853'];
    var GREEN='#34A853', RED='#E51022', AMBER='#F5B400', BLUE='#3A86FF', MAGENTA='#AA2296';
    var INK='#9a9aa4', GRID='rgba(255,255,255,.07)';
    Chart.defaults.color = INK; Chart.defaults.font.family = "'Space Grotesk', sans-serif"; Chart.defaults.borderColor = GRID;
    var axis = { y: { beginAtZero: true, grid: { color: GRID }, ticks: { precision: 0 } }, x: { grid: { display: false } } };
    var noL = { legend: { display: false } };
    function palN(n){ var a=[]; for(var i=0;i<n;i++) a.push(PAL[i%PAL.length]); return a; }
    new Chart(chartCalif, { type:'bar', data:{ labels:['1','2','3','4','5','6','7','8','9','10'], datasets:[{label:'Títulos',data:S.distNotas,backgroundColor:AMBER,borderRadius:4,borderSkipped:false}] }, options:{responsive:true,plugins:noL,scales:axis} });
    new Chart(chartAprob, { type:'doughnut', data:{ labels:['Aprobado','No aprobado'], datasets:[{data:[S.aprobados,S.noAprobados],backgroundColor:[GREEN,RED],borderColor:'#131316',borderWidth:2}] }, options:{responsive:true,cutout:'62%',plugins:{legend:{position:'bottom'}}} });
    new Chart(chartAnioProm, { type:'line', data:{ labels:S.vistoLabels, datasets:[{label:'Nota',data:S.vistoProm,borderColor:AMBER,backgroundColor:'rgba(245,180,0,.12)',borderWidth:2,fill:true,tension:.3,pointRadius:4,pointBackgroundColor:AMBER}] }, options:{responsive:true,plugins:noL,scales:{y:{min:0,max:10,grid:{color:GRID}},x:{grid:{display:false}}}} });

    // Vistos por mes: una sola barra con el total de cada mes (todos los años);
    // el desglose año por año va en el tooltip.
    var VM = <?php echo json_encode($vistosPorMes, JSON_UNESCAPED_UNICODE); ?>;
    var VM_ANIOS = <?php echo json_encode($vmAnios, JSON_UNESCAPED_UNICODE); ?>;
    new Chart(chartVistosMes, {
        type:'bar',
        data:{ labels:<?php echo json_encode($mesesLabels, JSON_UNESCAPED_UNICODE); ?>, datasets:[{label:'Títulos',data:VM['Todos'] || [],backgroundColor:MAGENTA,borderRadius:4,borderSkipped:false}] },
        options:{
            responsive:true,
            plugins:{
                legend:{ display:false },
                tooltip:{
                    callbacks:{
                        label: function (ctx) { return 'Total: ' + ctx.parsed.y; },
                        afterBody: function (items) {
                            var i = items[0].dataIndex, filas = [];
                            VM_ANIOS.forEach(function (y) {
                                var n = (VM[y] || [])[i] || 0;
                                if (n) filas.push(y + ' · ' + n);
                            });
                            return filas.length ? [''].concat(filas) : [];
                        }
                    }
                }
            },
            scales:axis
        }
    });
    new Chart(chartCat, { type:'doughnut', data:{ labels:S.catLabels, datasets:[{data:S.catCount,backgroundColor:palN(S.catLabels.length),borderColor:'#131316',borderWidth:2}] }, options:{responsive:true,cutout:'58%',plugins:{legend:{position:'bottom'}}} });
    // Acumulado por año en que lo vi (fecha_vista), no por año de estreno
    new Chart(chartAcum, { type:'line', data:{ labels:S.vistoLabels, datasets:[{label:'Acumulado',data:S.vistoAcum,borderColor:MAGENTA,backgroundColor:'rgba(170,34,150,.12)',borderWidth:2,fill:true,tension:.3,pointRadius:3}] }, options:{responsive:true,plugins:noL,scales:axis} });
})();
</script>
