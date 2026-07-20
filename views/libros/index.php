<div class="admin-head">
    <div>
        <h1>Libros</h1>
        <p><strong>Un click</strong> marca completado · <strong>doble click</strong> edita. Los libros pasan a leídos cuando completas el <strong>primero</strong> de la lista.</p>
    </div>
</div>

<div class="card">
    <h2>Agregar libro pendiente</h2>
    <form method="POST" action="/admin/libros/crear">
        <div class="form-grid">
            <label class="campo"><span>Título</span><input type="text" name="titulo" required></label>
            <label class="campo"><span>Autor</span><input type="text" name="autor"></label>
        </div>
        <div class="form-actions"><button class="btn btn--primary">Agregar a pendientes</button></div>
    </form>
</div>

<div class="libros-cols">
    <!-- PENDIENTES -->
    <section class="libros-col">
        <h2>Pendientes <span class="conteo"><?php echo count($pendientes); ?></span></h2>
        <ul class="libro-lista" id="lista-pendientes">
            <?php foreach ($pendientes as $idx => $l) : ?>
                <li class="libro libro-item is-editable<?php echo $l->completado ? ' is-completado' : ''; ?>" data-id="<?php echo $l->id; ?>">
                    <span class="pos"><?php echo $idx + 1; ?></span>
                    <div class="libro-info">
                        <div class="libro-titulo"><?php echo s($l->titulo); ?></div>
                        <div class="libro-autor"><?php echo s($l->autor); ?></div>
                    </div>
                    <div class="libro-edit">
                        <div class="row">
                            <label class="campo-mini" style="flex:2"><span>Título</span><input type="text" class="edit-titulo" value="<?php echo s($l->titulo); ?>"></label>
                            <label class="campo-mini" style="flex:1.4"><span>Autor</span><input type="text" class="edit-autor" value="<?php echo s($l->autor); ?>"></label>
                        </div>
                        <label class="alfinal-toggle" style="margin-top:10px">
                            <input type="checkbox" class="edit-alfinal">
                            <span class="alfinal-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M19 12l-7 7-7-7"/></svg></span>
                            <span class="alfinal-txt">Enviar al final de la lista</span>
                        </label>
                        <div class="row" style="margin-top:10px">
                            <button class="btn btn--sm btn--primary btn-guardar">Guardar</button>
                            <button class="btn btn--sm btn--ghost btn-cancelar">Cancelar</button>
                            <button type="button" class="btn btn--sm btn--danger btn-eliminar" data-titulo="<?php echo s($l->titulo); ?>" style="margin-left:auto">Eliminar</button>
                        </div>
                    </div>
                    <span class="check"><?php echo icono('ok'); ?></span>
                </li>
            <?php endforeach; ?>
            <?php if (empty($pendientes)) : ?><li style="color:var(--muted)">Sin pendientes.</li><?php endif; ?>
        </ul>
    </section>

    <!-- LEÍDOS -->
    <section class="libros-col">
        <h2>Leídos <span class="conteo"><?php echo count($leidos); ?></span></h2>
        <ul class="libro-lista" id="lista-leidos">
            <?php foreach ($leidos as $l) : $tiene = $l->estrellas !== null && (float)$l->estrellas > 0; ?>
                <li class="libro libro-item leido is-editable" data-id="<?php echo $l->id; ?>">
                    <div class="libro-info" style="flex:1;min-width:0">
                        <div class="leido-head" style="display:flex;justify-content:space-between;gap:12px;align-items:flex-start">
                            <div style="min-width:0">
                                <div class="libro-titulo"><?php echo s($l->titulo); ?></div>
                                <div class="libro-autor"><?php echo s($l->autor); ?></div>
                            </div>
                            <?php if ($tiene) : ?>
                                <span class="leido-stars-static" style="color:var(--c-amber);white-space:nowrap"><?php
                                    $e = (float)$l->estrellas;
                                    for ($i = 1; $i <= 5; $i++) echo $e >= $i ? '★' : ($e >= $i - 0.5 ? '⯨' : '☆');
                                    echo ' <span style="font-family:var(--mono);font-size:.78rem;color:var(--muted)">' . number_format($e,1) . '</span>';
                                ?></span>
                            <?php else : ?><span class="sin-resena" style="font-size:.78rem;color:var(--muted-2)">Sin reseña</span><?php endif; ?>
                        </div>
                    </div>
                    <div class="libro-edit">
                        <div class="row">
                            <label class="campo-mini" style="flex:2"><span>Título</span><input type="text" class="edit-titulo" value="<?php echo s($l->titulo); ?>"></label>
                            <label class="campo-mini" style="flex:1.4"><span>Autor</span><input type="text" class="edit-autor" value="<?php echo s($l->autor); ?>"></label>
                        </div>
                        <div class="stars-lg" style="margin-top:8px">
                            <div class="star-rating star-rating--lg" data-max="5" data-input="#lr-<?php echo $l->id; ?>"></div>
                        </div>
                        <input type="hidden" class="leido-star-input" id="lr-<?php echo $l->id; ?>" value="<?php echo (float)$l->estrellas; ?>">
                        <label class="campo-mini" style="margin-top:8px"><span>Fecha de lectura</span><input type="date" class="edit-fechaleido" value="<?php echo s($l->fecha_leido ?? ''); ?>"></label>
                        <textarea class="edit-opinion" placeholder="Tu opinión..." style="width:100%;margin-top:8px;background:var(--surface-2);border:1px solid var(--line-2);color:var(--text);border-radius:10px;padding:11px;font:inherit;font-size:.9rem;min-height:70px;"><?php echo s($l->comentario); ?></textarea>
                        <div class="row" style="margin-top:8px">
                            <button class="btn btn--sm btn--primary btn-guardar">Guardar</button>
                            <button class="btn btn--sm btn--ghost btn-cancelar">Cancelar</button>
                            <button type="button" class="btn btn--sm btn--ghost btn-rependiente" style="margin-left:auto">↩ A pendientes</button>
                            <button type="button" class="btn btn--sm btn--danger btn-eliminar" data-titulo="<?php echo s($l->titulo); ?>">Eliminar</button>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
            <?php if (empty($leidos)) : ?><li style="color:var(--muted)">Aún no hay libros leídos.</li><?php endif; ?>
        </ul>
    </section>
</div>

<!-- Modal de calificación (al marcar completado) -->
<div class="modal-backdrop" id="modal-resena">
    <div class="modal" style="max-width:480px;text-align:center">
        <h3>Libro completado</h3>
        <p id="resena-titulo" style="margin-bottom:22px">¿Cuántas estrellas le das?</p>
        <div class="stars-lg" style="justify-content:center">
            <div class="star-rating star-rating--xl" id="resena-stars" data-max="5" data-input="#resena-val"></div>
        </div>
        <input type="hidden" id="resena-val" value="0">
        <p class="mini-s" style="color:var(--muted-2);margin-top:16px">El comentario lo puedes agregar después editando la tarjeta en «Leídos».</p>
        <div class="modal-actions" style="margin-top:18px;justify-content:center">
            <button class="btn btn--ghost" id="resena-skip">Más tarde</button>
            <button class="btn btn--primary" id="resena-guardar">Guardar</button>
        </div>
    </div>
</div>

<script>
(function () {
    function post(url, data, cb) {
        var body = Object.keys(data).map(function (k) { return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]); }).join('&');
        fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: body })
            .then(function (r) { return r.json(); }).then(cb).catch(function () { alert('Error'); });
    }

    var mResena = document.getElementById('modal-resena'), resenaId = null, resVal = document.getElementById('resena-val');

    // Al marcar «completado» se pide solo la calificación del libro clicado.
    function pedirEstrellas(id, titulo) {
        resenaId = id; resVal.value = 0;
        document.querySelectorAll('#resena-stars .star').forEach(function (s) { s.classList.remove('full', 'half-on'); });
        document.getElementById('resena-titulo').textContent = '«' + titulo + '» — ¿cuántas estrellas le das?';
        mResena.classList.add('is-open');
    }

    document.getElementById('resena-skip').addEventListener('click', function () { location.reload(); });
    document.getElementById('resena-guardar').addEventListener('click', function () {
        post('/admin/libros/resenar', { id: resenaId, estrellas: resVal.value }, function () { location.reload(); });
    });
    mResena.addEventListener('click', function (e) { if (e.target === mResena) location.reload(); });

    document.querySelectorAll('.libro-item').forEach(function (libro) {
        var timer = null;
        var esLeido = libro.classList.contains('leido');
        libro.addEventListener('click', function (e) {
            if (e.target.closest('.libro-edit') || libro.classList.contains('is-editing') || timer) return;
            // Leídos: un click abre la reseña/puntaje (no regresa a pendientes)
            if (esLeido) {
                libro.classList.add('is-editing');
                var inp = libro.querySelector('.edit-titulo'); if (inp) inp.focus();
                return;
            }
            // Pendientes: un click completa (timer para distinguir del doble click).
            // La reseña/puntaje NO se pide aquí; solo se edita desde la columna Leídos.
            timer = setTimeout(function () {
                timer = null;
                function completar() {
                    post('/admin/libros/estado', { id: libro.dataset.id }, function (r) {
                        if (r.ok) location.reload();
                    });
                }
                // Si es el PRIMERO de pendientes, completarlo lo pasa a Leídos → confirmar.
                var lista = document.getElementById('lista-pendientes');
                var esPrimero = lista && lista.querySelector('.libro-item') === libro;
                if (esPrimero && !libro.classList.contains('is-completado')) {
                    var t = libro.querySelector('.libro-titulo') ? libro.querySelector('.libro-titulo').textContent : 'Este libro';
                    confirmar('«' + t + '» es el primero de tu lista: al marcarlo como leído pasará a la columna de Leídos.', null, { titulo: 'Pasar a Leídos', ok: 'Sí, marcar leído', danger: false }).then(function (v) { if (v) completar(); });
                } else {
                    completar();
                }
            }, 250);
        });
        libro.addEventListener('dblclick', function (e) {
            if (e.target.closest('.libro-edit')) return;
            clearTimeout(timer); timer = null;
            libro.classList.add('is-editing');
            var inp = libro.querySelector('.edit-titulo'); if (inp) inp.focus();
        });
        var g = libro.querySelector('.btn-guardar');
        if (g) g.addEventListener('click', function (e) {
            e.stopPropagation();
            var data = { id: libro.dataset.id, titulo: libro.querySelector('.edit-titulo').value, autor: libro.querySelector('.edit-autor').value };
            var af = libro.querySelector('.edit-alfinal'); if (af && af.checked) data.al_final = 1;
            var fl = libro.querySelector('.edit-fechaleido'); if (fl) data.fecha_leido = fl.value;
            post('/admin/libros/editar', data, function () {
                var sv = libro.querySelector('.leido-star-input');
                if (sv) post('/admin/libros/resenar', { id: libro.dataset.id, estrellas: sv.value, comentario: libro.querySelector('.edit-opinion').value }, function () { location.reload(); });
                else location.reload();
            });
        });
        var c = libro.querySelector('.btn-cancelar');
        if (c) c.addEventListener('click', function (e) { e.stopPropagation(); libro.classList.remove('is-editing'); });
        var rp = libro.querySelector('.btn-rependiente');
        if (rp) rp.addEventListener('click', function (e) {
            e.stopPropagation();
            post('/admin/libros/estado', { id: libro.dataset.id }, function () { location.reload(); });
        });
        var el = libro.querySelector('.btn-eliminar');
        if (el) el.addEventListener('click', function (e) {
            e.stopPropagation();
            var titulo = el.dataset.titulo || '';
            confirmar('Se eliminará este libro de forma permanente. Escribe su título para confirmar.', titulo).then(function (v) {
                if (!v) return;
                var f = document.createElement('form');
                f.method = 'POST'; f.action = '/admin/libros/eliminar';
                f.innerHTML = '<input type="hidden" name="id" value="' + libro.dataset.id + '">';
                document.body.appendChild(f); f.submit();
            });
        });
    });
})();
</script>
