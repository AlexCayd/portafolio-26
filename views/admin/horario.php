<?php
$slots = [
    ['07:00','08:30'], ['08:30','10:00'], ['10:00','11:30'], ['11:30','13:00'], ['13:00','14:30'],
    ['14:30','16:00'], ['16:00','17:30'], ['17:30','19:00'], ['19:00','20:30'], ['20:30','22:00'],
];
$diasLbl = ['lun' => 'Lunes', 'mar' => 'Martes', 'mie' => 'Miércoles', 'jue' => 'Jueves', 'vie' => 'Viernes'];
$diasAbbr = ['lun' => 'LUN', 'mar' => 'MAR', 'mie' => 'MIÉ', 'jue' => 'JUE', 'vie' => 'VIE'];
$mapaBloques = [];
foreach ($bloques as $b) { $mapaBloques[$b['dia']][substr($b['hora_inicio'], 0, 5)] = $b; }

// Resumen: primero por créditos (desc), luego alfabético
$resumenMaterias = $materias;
usort($resumenMaterias, function ($a, $b) {
    return ((float) $b->creditos <=> (float) $a->creditos) ?: strcasecmp($a->nombre, $b->nombre);
});
?>
<div class="admin-head">
    <div>
        <h1>Horario</h1>
        <p>Cuadrícula semanal. Total de créditos: <strong><?php echo rtrim(rtrim(number_format($totalCreditos, 1), '0'), '.'); ?></strong>. Click en una materia para ver su detalle.</p>
    </div>
</div>

<div class="horario-toolbar">
    <button class="btn btn--sm" id="btn-expandir">⤢ Expandir</button>
    <button class="btn btn--sm btn--primary" id="btn-pdf"><?php echo icono('descargar'); ?> Exportar PDF</button>
</div>

<!-- Barra de asignación (no se incluye en el PDF) -->
<div class="assign-bar" id="assign-bar">
    <span class="assign-hint">Materia activa: <b id="mat-sel-name" class="assign-mat">elige una en el resumen →</b><span class="assign-sub"> · click en celdas vacías para asignar bloques</span></span>
    <form method="POST" action="/admin/horario/bloque/guardar" id="form-bloques" class="assign-save">
        <input type="hidden" name="materia_id" id="materia-input" value="">
        <span id="bloques-hidden"></span>
        <span class="mini-s"><b id="pick-count">0</b> marcados</span>
        <button class="btn btn--sm btn--primary" id="btn-save-bloques" disabled>Guardar bloques</button>
    </form>
</div>

<div class="horario-wrap" id="horario-wrap">
    <div class="card" id="horario-capture" style="overflow-x:auto">
        <table class="horario-grid" id="horario-grid">
            <thead>
                <tr><th class="hora-col">Hora</th><?php foreach ($diasLbl as $k => $lbl) : ?><th><span class="d-full"><?php echo $lbl; ?></span><span class="d-abbr"><?php echo $diasAbbr[$k]; ?></span></th><?php endforeach; ?></tr>
            </thead>
            <tbody>
                <?php foreach ($slots as $slot) : ?>
                    <tr>
                        <td class="hora-col"><?php echo $slot[0]; ?><br>–<br><?php echo $slot[1]; ?></td>
                        <?php foreach ($diasLbl as $dia => $lbl) : $b = $mapaBloques[$dia][$slot[0]] ?? null; ?>
                            <?php if ($b) : ?>
                                <td><div class="bloque" style="background:<?php echo s($b['m_color']); ?>" data-materia="<?php echo $b['materia_id']; ?>" data-bloque="<?php echo $b['id']; ?>"><?php echo s($b['m_nombre']); ?></div></td>
                            <?php else : ?>
                                <td class="hslot" data-dia="<?php echo $dia; ?>" data-hi="<?php echo $slot[0]; ?>" data-hf="<?php echo $slot[1]; ?>"></td>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="card horario-resumen">
        <div class="card-head"><h2>Materias</h2><span class="mini-s" style="color:var(--muted)"><?php echo rtrim(rtrim(number_format($totalCreditos, 1), '0'), '.'); ?> cr</span></div>
        <p class="mini-s" style="color:var(--muted-2);margin:0 0 10px">Selecciona una materia para asignarle bloques en la cuadrícula.</p>
        <div class="resumen-list">
            <?php foreach ($resumenMaterias as $m) : ?>
                <div class="resumen-row mat-select" data-id="<?php echo $m->id; ?>" data-color="<?php echo s($m->color); ?>" data-nombre="<?php echo s($m->nombre); ?>" style="--m-color:<?php echo s($m->color); ?>">
                    <div class="r-info">
                        <div class="r-nombre"><?php echo s($m->nombre); ?></div>
                        <div class="r-meta"><?php echo s($m->profesor ?: '—'); ?><?php echo $m->nrc ? ' · <span class="r-nrc">NRC ' . s($m->nrc) . '</span>' : ''; ?></div>
                    </div>
                    <span class="r-cr"><b><?php echo rtrim(rtrim(number_format((float)$m->creditos, 1), '0'), '.'); ?></b><small>cr</small></span>
                    <div class="r-actions acciones">
                        <a href="/admin/horario?id=<?php echo $m->id; ?>" class="act-btn act-edit" title="Editar"><?php echo icono('editar'); ?></a>
                        <form method="POST" action="/admin/horario/materia/eliminar" data-confirm="Se eliminará la materia y todos sus bloques." data-confirm-name="<?php echo s($m->nombre); ?>">
                            <input type="hidden" name="id" value="<?php echo $m->id; ?>">
                            <button class="act-btn act-del" title="Eliminar"><?php echo icono('eliminar'); ?></button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($materias)) : ?><p style="color:var(--muted)">Sin materias.</p><?php endif; ?>
        </div>
    </div>
</div>

<!-- Popover de materia (con eliminar bloque) -->
<div class="materia-pop" id="materia-pop">
    <h4><span class="swatch" id="pop-sw"></span><span id="pop-nombre"></span></h4>
    <p><strong>Profesor:</strong> <span id="pop-prof"></span></p>
    <p><strong>NRC:</strong> <span id="pop-nrc"></span></p>
    <p><strong>Créditos:</strong> <span id="pop-cr"></span></p>
    <form method="POST" action="/admin/horario/bloque/eliminar" id="pop-del-form" data-confirm="¿Eliminar este bloque del horario?" style="margin-top:10px">
        <input type="hidden" name="id" id="pop-bloque-id" value="">
        <button class="btn btn--sm btn--danger" style="width:100%">Eliminar este bloque</button>
    </form>
</div>

<!-- CARD 1: Nueva materia -->
<div class="card" style="margin-top:22px">
    <h2><?php echo $editando ? 'Editar materia' : 'Nueva materia'; ?></h2>
    <form method="POST" action="/admin/horario/materia/guardar">
        <input type="hidden" name="id" value="<?php echo $editando->id ?? ''; ?>">
        <div class="form-grid">
            <label class="campo full"><span>Nombre</span><input type="text" name="nombre" value="<?php echo s($editando->nombre ?? ''); ?>" required></label>
            <div class="campo full tri">
                <label class="campo"><span>Profesor</span><input type="text" name="profesor" value="<?php echo s($editando->profesor ?? ''); ?>"></label>
                <label class="campo"><span>NRC</span><input type="text" name="nrc" value="<?php echo s($editando->nrc ?? ''); ?>"></label>
                <label class="campo"><span>Créditos</span><input type="number" step="0.5" name="creditos" value="<?php echo s($editando->creditos ?? '0'); ?>"></label>
            </div>
            <div class="campo full">
                <span>Color</span>
                <div class="color-swatches" id="color-swatches"></div>
                <input type="hidden" name="color" id="color-input" value="<?php echo s($editando->color ?? '#4267AC'); ?>">
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn--primary"><?php echo $editando ? 'Guardar' : 'Agregar materia'; ?></button>
            <?php if ($editando) : ?><a href="/admin/horario" class="btn btn--ghost">Cancelar</a><?php endif; ?>
        </div>
    </form>
</div>

<script>
(function () {
    // ---- Asignar bloques: grilla interactiva ----
    // ---- Asignación sobre la cuadrícula real ----
    var grid = document.getElementById('horario-grid'), matInput = document.getElementById('materia-input');
    var hiddenBox = document.getElementById('bloques-hidden'), saveBtn = document.getElementById('btn-save-bloques'), countEl = document.getElementById('pick-count');
    var selName = document.getElementById('mat-sel-name'), assignBar = document.getElementById('assign-bar');
    var activo = null;  // materia activa

    function rebuild() {
        if (!grid) return;
        var picked = grid.querySelectorAll('.hslot.picked');
        countEl.textContent = picked.length;
        saveBtn.disabled = picked.length === 0 || !activo;
        hiddenBox.innerHTML = Array.prototype.map.call(picked, function (c) {
            return '<input type="hidden" name="dia[]" value="' + c.dataset.dia + '">' +
                   '<input type="hidden" name="hora_inicio[]" value="' + c.dataset.hi + '">' +
                   '<input type="hidden" name="hora_fin[]" value="' + c.dataset.hf + '">';
        }).join('');
    }
    function clearPicks() { if (grid) grid.querySelectorAll('.hslot.picked').forEach(function (c) { c.classList.remove('picked'); }); rebuild(); }

    // Selección de materia desde el resumen
    document.querySelectorAll('.resumen-row.mat-select').forEach(function (row) {
        row.addEventListener('click', function (e) {
            if (e.target.closest('.r-actions')) return;   // no interferir con editar/eliminar
            document.querySelectorAll('.resumen-row.mat-select').forEach(function (x) { x.classList.remove('is-active'); });
            row.classList.add('is-active');
            activo = { id: row.dataset.id, color: row.dataset.color, nombre: row.dataset.nombre };
            matInput.value = activo.id;
            selName.textContent = activo.nombre;
            selName.style.color = activo.color;
            if (assignBar) assignBar.classList.add('ready');
            if (grid) grid.style.setProperty('--sel', activo.color);
            clearPicks();  // los bloques marcados pertenecen a la materia elegida
        });
    });

    // Marcar celdas vacías de la cuadrícula real
    if (grid) grid.addEventListener('click', function (e) {
        var cell = e.target.closest('.hslot'); if (!cell) return;
        if (!activo) { if (window.toast) toast('Primero elige una materia en el resumen', 'editado'); return; }
        cell.classList.toggle('picked'); rebuild();
    });

    // Selector de color por swatches (paleta ordenada cromáticamente)
    var PALETA = ['#E51022','#FC6722','#F5B400','#8AC926','#34A853','#3A86FF','#4267AC','#6A4C93','#AA2296','#EA075A'];
    var cont = document.getElementById('color-swatches'), colorInput = document.getElementById('color-input');
    if (cont) {
        PALETA.forEach(function (c) {
            var sw = document.createElement('span');
            sw.className = 'swatch-opt' + (c.toLowerCase() === (colorInput.value || '').toLowerCase() ? ' sel' : '');
            sw.style.background = c; sw.dataset.color = c;
            sw.addEventListener('click', function () {
                cont.querySelectorAll('.swatch-opt').forEach(function (x) { x.classList.remove('sel'); });
                sw.classList.add('sel'); colorInput.value = c;
            });
            cont.appendChild(sw);
        });
    }

    // Expandir
    document.getElementById('btn-expandir').addEventListener('click', function () {
        document.getElementById('horario-wrap').classList.toggle('expandido');
        this.textContent = document.getElementById('horario-wrap').classList.contains('expandido') ? '⤡ Reducir' : '⤢ Expandir';
    });

    // Popover de materia
    var MAT = {};
    <?php foreach ($materias as $m) : ?>
    MAT[<?php echo $m->id; ?>] = { nombre: <?php echo json_encode($m->nombre, JSON_UNESCAPED_UNICODE); ?>, prof: <?php echo json_encode($m->profesor, JSON_UNESCAPED_UNICODE); ?>, nrc: <?php echo json_encode($m->nrc); ?>, cr: <?php echo json_encode($m->creditos); ?>, color: <?php echo json_encode($m->color); ?> };
    <?php endforeach; ?>
    var pop = document.getElementById('materia-pop');
    var popDelId = document.getElementById('pop-bloque-id');
    document.querySelectorAll('.bloque[data-materia]').forEach(function (bl) {
        bl.addEventListener('click', function (e) {
            var m = MAT[bl.dataset.materia]; if (!m) return;
            document.getElementById('pop-nombre').textContent = m.nombre;
            document.getElementById('pop-prof').textContent = m.prof || '—';
            document.getElementById('pop-nrc').textContent = m.nrc || '—';
            document.getElementById('pop-cr').textContent = m.cr;
            document.getElementById('pop-sw').style.background = m.color;
            if (popDelId) popDelId.value = bl.dataset.bloque || '';
            var x = Math.min(e.clientX, window.innerWidth - 300), y = Math.min(e.clientY, window.innerHeight - 220);
            pop.style.left = x + 'px'; pop.style.top = y + 'px'; pop.classList.add('show');
            e.stopPropagation();
        });
    });
    // No cerrar el popover al hacer click dentro (para poder usar el botón eliminar)
    pop.addEventListener('click', function (e) { e.stopPropagation(); });
    document.addEventListener('click', function () { pop.classList.remove('show'); });

    // Exportar PDF (captura completa, ajustada a la página)
    document.getElementById('btn-pdf').addEventListener('click', function () {
        if (typeof html2canvas === 'undefined' || !window.jspdf) { toast('Cargando librerías…'); return; }
        var el = document.getElementById('horario-capture');
        var prevOv = el.style.overflow, prevW = el.style.width;
        el.style.overflow = 'visible'; el.style.width = el.scrollWidth + 'px';
        html2canvas(el, { backgroundColor: '#0a0a0b', scale: 2, width: el.scrollWidth, height: el.scrollHeight, windowWidth: el.scrollWidth, windowHeight: el.scrollHeight }).then(function (canvas) {
            el.style.overflow = prevOv; el.style.width = prevW;
            var pdf = new window.jspdf.jsPDF({ orientation: 'landscape', unit: 'pt', format: 'a4' });
            var pw = pdf.internal.pageSize.getWidth(), ph = pdf.internal.pageSize.getHeight();
            var ratio = Math.min((pw - 40) / canvas.width, (ph - 40) / canvas.height);
            var w = canvas.width * ratio, h = canvas.height * ratio;
            pdf.addImage(canvas.toDataURL('image/png'), 'PNG', (pw - w) / 2, (ph - h) / 2, w, h);
            pdf.save('horario.pdf'); toast('PDF descargado');
        }).catch(function () { el.style.overflow = prevOv; el.style.width = prevW; });
    });
})();
</script>
