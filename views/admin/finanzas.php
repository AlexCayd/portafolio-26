<?php
function fin_bloque($titulo, $tipo, $items, $campo, $total) { ?>
    <div class="card">
        <h2><?php echo $titulo; ?></h2>
        <ul class="fin-list">
            <?php foreach ($items as $it) : ?>
                <li class="fin-item">
                    <span class="fin-nombre"><?php echo s($it->$campo); ?></span>
                    <span class="fin-monto">$<?php echo number_format((float)$it->monto, 2); ?></span>
                    <div class="acciones">
                        <button type="button" class="act-btn act-edit fin-edit-btn" title="Editar"
                            data-tipo="<?php echo $tipo; ?>" data-id="<?php echo $it->id; ?>"
                            data-nombre="<?php echo s($it->$campo); ?>" data-monto="<?php echo (float)$it->monto; ?>"><?php echo icono('editar'); ?></button>
                        <form method="POST" action="/admin/finanzas/eliminar" data-confirm="Se eliminará este registro." data-confirm-name="<?php echo s($it->$campo); ?>">
                            <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
                            <input type="hidden" name="id" value="<?php echo $it->id; ?>">
                            <button class="act-btn act-del" title="Eliminar"><?php echo icono('eliminar'); ?></button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
            <?php if (empty($items)) : ?><li class="mini-s" style="color:var(--muted)">Sin registros.</li><?php endif; ?>
        </ul>
        <div class="fin-total"><span>Total</span><span class="fin-monto">$<?php echo number_format($total, 2); ?></span></div>
        <form method="POST" action="/admin/finanzas/guardar" class="fin-add">
            <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <div class="input-money monto"><span class="im-sign">$</span><input type="number" step="0.01" name="monto" placeholder="0.00" required></div>
            <button class="btn btn--sm btn--primary">＋</button>
        </form>
    </div>
<?php } ?>

<div class="admin-head">
    <div>
        <h1>Finanzas</h1>
        <p>Activos, deudas y cuentas por cobrar (lo que me deben cuenta como activo).</p>
    </div>
</div>

<div class="kpis">
    <div class="kpi kpi--fin k-green"><div class="kpi-label">Total activos</div><div class="kpi-value">$<?php echo number_format($totActivos, 2); ?></div></div>
    <div class="kpi kpi--fin k-teal"><div class="kpi-label">Por cobrar</div><div class="kpi-value">$<?php echo number_format($totCobrar, 2); ?></div></div>
    <div class="kpi kpi--fin k-red"><div class="kpi-label">Total deudas</div><div class="kpi-value">$<?php echo number_format($totDeudas, 2); ?></div></div>
    <div class="kpi kpi--fin <?php echo $neto >= 0 ? 'k-blue' : 'k-red'; ?>"><div class="kpi-label">Patrimonio neto</div><div class="kpi-value">$<?php echo number_format($neto, 2); ?></div></div>
</div>

<div class="fin-cols">
    <?php fin_bloque('Activos', 'activo', $activos, 'nombre', $totActivos); ?>
    <?php fin_bloque('Cuentas por cobrar', 'cobrar', $cobrar, 'nombre', $totCobrar); ?>
    <?php fin_bloque('Deudas', 'deuda', $deudas, 'nombre', $totDeudas); ?>
</div>

<div class="chart-grid" style="margin-top:22px">
    <div class="chart-box span-12"><h3>Patrimonio neto a lo largo del tiempo</h3><p class="chart-sub">Últimos 12 meses</p><canvas id="chartNeto"></canvas></div>
    <div class="chart-box span-6"><h3>Distribución de activos</h3><p class="chart-sub">Peso de cada activo</p><canvas id="chartActivos"></canvas></div>
    <div class="chart-box span-6"><h3>Comparativo</h3><p class="chart-sub">Activos + por cobrar vs. deudas</p><canvas id="chartComp"></canvas></div>
</div>

<!-- Modal de edición de registro -->
<div class="modal-backdrop" id="fin-modal">
    <div class="modal" style="max-width:420px">
        <h3 id="fin-modal-title">Editar registro</h3>
        <form method="POST" action="/admin/finanzas/actualizar">
            <input type="hidden" name="tipo" id="fin-m-tipo">
            <input type="hidden" name="id" id="fin-m-id">
            <label class="campo full"><span id="fin-m-label">Nombre</span><input type="text" name="nombre" id="fin-m-nombre" required></label>
            <label class="campo full" style="margin-top:12px"><span>Monto</span><div class="input-money"><span class="im-sign">$</span><input type="number" step="0.01" name="monto" id="fin-m-monto" required></div></label>
            <div class="modal-actions" style="margin-top:20px">
                <button type="button" class="btn btn--ghost" id="fin-m-cancel">Cancelar</button>
                <button type="submit" class="btn btn--primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>

<script>
// Edición de registros de finanzas vía modal
(function () {
    var m = document.getElementById('fin-modal');
    var LBL = { activo: 'Nombre del activo', cobrar: 'Nombre de la cuenta', deuda: 'Nombre de la deuda' };
    document.querySelectorAll('.fin-edit-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('fin-m-tipo').value = btn.dataset.tipo;
            document.getElementById('fin-m-id').value = btn.dataset.id;
            document.getElementById('fin-m-label').textContent = LBL[btn.dataset.tipo] || 'Nombre';
            var nombre = document.getElementById('fin-m-nombre'); nombre.value = btn.dataset.nombre;
            document.getElementById('fin-m-monto').value = btn.dataset.monto;
            m.classList.add('is-open');
            setTimeout(function () { nombre.focus(); nombre.select(); }, 60);
        });
    });
    document.getElementById('fin-m-cancel').addEventListener('click', function () { m.classList.remove('is-open'); });
    m.addEventListener('click', function (e) { if (e.target === m) m.classList.remove('is-open'); });
})();
</script>

<script>
(function () {
    if (typeof Chart === 'undefined') return;
    var PAL = ['#F5B400','#3A86FF','#E51022','#8AC926','#AA2296','#FC6722','#4267AC','#EA075A','#6A4C93','#34A853'];
    var INK = '#9a9aa4', GRID = 'rgba(255,255,255,.07)', BLUE = '#3A86FF';
    Chart.defaults.color = INK; Chart.defaults.font.family = "'Space Grotesk', sans-serif"; Chart.defaults.borderColor = GRID;

    var hist = <?php echo json_encode($historial, JSON_UNESCAPED_UNICODE); ?>;
    new Chart(document.getElementById('chartNeto'), {
        type: 'line',
        data: { labels: hist.labels, datasets: [{ label: 'Neto', data: hist.data, borderColor: BLUE, backgroundColor: 'rgba(58,134,255,.12)', borderWidth: 2, fill: true, tension: .32, pointRadius: 3, pointBackgroundColor: BLUE }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { grid: { color: GRID } }, x: { grid: { display: false } } } }
    });

    var actLabels = <?php echo json_encode(array_map(fn($a) => $a->nombre, $activos), JSON_UNESCAPED_UNICODE); ?>;
    var actData = <?php echo json_encode(array_map(fn($a) => (float)$a->monto, $activos)); ?>;
    if (actData.length) new Chart(document.getElementById('chartActivos'), {
        type: 'doughnut',
        data: { labels: actLabels, datasets: [{ data: actData, backgroundColor: PAL, borderColor: '#131316', borderWidth: 2 }] },
        options: { responsive: true, cutout: '58%', plugins: { legend: { position: 'bottom' } } }
    });

    new Chart(document.getElementById('chartComp'), {
        type: 'bar',
        data: { labels: ['Activos', 'Por cobrar', 'Deudas'], datasets: [{ label: 'MXN', data: [<?php echo $totActivos; ?>, <?php echo $totCobrar; ?>, <?php echo $totDeudas; ?>], backgroundColor: ['#34A853', '#8AC926', '#E51022'], borderRadius: 4, borderSkipped: false }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: GRID } }, x: { grid: { display: false } } } }
    });
})();
</script>
