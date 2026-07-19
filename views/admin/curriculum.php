<div class="admin-head">
    <div>
        <h1><?php echo s($titulo); ?></h1>
        <p><?php echo s($sub); ?> · Haz click en una materia para cambiar su estado.</p>
    </div>
</div>

<div class="card">
    <div class="curr-legend">
        <span><span class="sw sw-completado"></span> Completado</span>
        <span><span class="sw sw-cursando"></span> Cursando</span>
        <span><span class="sw sw-desbloqueada"></span> Desbloqueada</span>
        <span><span class="sw sw-bloqueada"></span> Bloqueada</span>
    </div>

    <p class="curr-hint"><svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M8 7l-5 5 5 5M16 7l5 5-5 5"/></svg> Desliza horizontalmente para ver todos los semestres.</p>

    <div class="curr-scroll">
        <div class="curr-grid">
            <?php foreach ($grupos as $sem => $materias) : ?>
                <div class="curr-col">
                    <div class="curr-sem">Semestre <?php echo $sem; ?></div>
                    <?php foreach ($materias as $m) : ?>
                        <div class="curr-cell st-<?php echo s($m->estado); ?>" data-id="<?php echo $m->id; ?>" title="Click para cambiar estado">
                            <span class="c-nombre"><?php echo s($m->nombre); ?></span>
                            <?php if (!empty($m->codigo)) : ?><span class="c-codigo"><?php echo s($m->codigo); ?></span><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
(function () {
    var ESTADOS = ['bloqueada', 'desbloqueada', 'cursando', 'completado'];
    document.querySelectorAll('.curr-cell[data-id]').forEach(function (cell) {
        cell.addEventListener('click', function () {
            postForm('/admin/curriculum/estado', { id: cell.dataset.id }).then(function (r) {
                if (!r.ok) return;
                ESTADOS.forEach(function (e) { cell.classList.remove('st-' + e); });
                cell.classList.add('st-' + r.estado);
                toast('Estado: ' + r.estado);
            });
        });
    });
})();
</script>
