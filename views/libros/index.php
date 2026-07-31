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

<div class="card">
    <h2>Buscar libro</h2>
    <p class="mini-s" style="color:var(--muted);margin:-6px 0 12px">Localiza un título en cualquier columna y descubre su posición.</p>
    <div class="libro-buscar">
        <div class="libro-buscar-field">
            <span class="libro-buscar-ic"><?php echo icono('buscar'); ?></span>
            <input type="search" id="libro-q" placeholder="Título o autor..." autocomplete="off">
        </div>
        <div class="libro-buscar-res" id="libro-q-res"></div>
    </div>
</div>

<div class="libros-cols">
    <!-- PENDIENTES -->
    <section class="libros-col">
        <h2>Pendientes <span class="conteo"><?php echo count($pendientes); ?></span></h2>
        <ul class="libro-lista" id="lista-pendientes">
            <?php foreach ($pendientes as $idx => $l) : $tienePend = $l->estrellas !== null && (float)$l->estrellas > 0; ?>
                <li class="libro libro-item is-editable<?php echo $l->completado ? ' is-completado' : ''; ?>" id="libro-<?php echo $l->id; ?>" data-id="<?php echo $l->id; ?>">
                    <span class="pos"><?php echo $idx + 1; ?></span>
                    <div class="libro-info">
                        <div class="leido-head">
                            <div class="leido-main">
                                <div class="libro-titulo"><?php echo s($l->titulo); ?></div>
                                <div class="libro-autor"><?php echo s($l->autor); ?></div>
                            </div>
                            <?php if ($l->completado && $tienePend) : ?>
                                <div class="leido-meta">
                                    <span class="leido-stars-static"><?php
                                        echo estrellasHtml((float)$l->estrellas);
                                        echo '<span class="leido-stars-num">' . number_format((float)$l->estrellas, 1) . '</span>';
                                    ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="libro-edit">
                        <div class="row">
                            <label class="campo-mini" style="flex:2"><span>Título</span><input type="text" class="edit-titulo" value="<?php echo s($l->titulo); ?>"></label>
                            <label class="campo-mini" style="flex:1.4"><span>Autor</span><input type="text" class="edit-autor" value="<?php echo s($l->autor); ?>"></label>
                        </div>
                        <?php if ($l->completado) : /* Ya completado aunque siga en pendientes: se puede calificar */ ?>
                            <div class="stars-lg" style="margin-top:10px">
                                <div class="star-rating star-rating--lg" data-max="5" data-input="#lr-<?php echo $l->id; ?>"></div>
                            </div>
                            <input type="hidden" class="leido-star-input" id="lr-<?php echo $l->id; ?>" value="<?php echo (float)$l->estrellas; ?>">
                            <label class="campo-mini" style="margin-top:8px"><span>Fecha de completado</span><input type="text" class="edit-fechaleido" inputmode="numeric" maxlength="10" placeholder="dd/mm/aaaa" value="<?php echo $l->fecha_leido ? date('d/m/Y', strtotime($l->fecha_leido)) : ''; ?>"></label>
                            <textarea class="edit-opinion" placeholder="Tu opinión..." style="width:100%;margin-top:8px;background:var(--surface-2);border:1px solid var(--line-2);color:var(--text);border-radius:10px;padding:11px;font:inherit;font-size:.9rem;min-height:70px;"><?php echo s($l->comentario); ?></textarea>
                        <?php endif; ?>
                        <label class="alfinal-toggle" style="margin-top:10px">
                            <input type="checkbox" class="edit-alfinal">
                            <span class="alfinal-box"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M19 12l-7 7-7-7"/></svg></span>
                            <span class="alfinal-txt">Enviar al final de la lista</span>
                        </label>
                        <label class="campo-mini" style="margin-top:10px;max-width:180px"><span>Mover a la posición #</span><input type="number" class="edit-pos" min="1" placeholder="<?php echo $idx + 1; ?>"></label>
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
    <section class="libros-col" id="col-leidos">
        <h2>Leídos <span class="conteo"><?php echo $totalLeidos; ?></span></h2>
        <ul class="libro-lista" id="lista-leidos">
            <?php foreach ($leidos as $idx => $l) : $tiene = $l->estrellas !== null && (float)$l->estrellas > 0; ?>
                <li class="libro libro-item leido is-editable" id="libro-<?php echo $l->id; ?>" data-id="<?php echo $l->id; ?>">
                    <span class="pos"><?php echo $inicioLeido + $idx + 1; ?></span>
                    <div class="libro-info">
                        <div class="leido-head">
                            <div class="leido-main">
                                <div class="libro-titulo"><?php echo s($l->titulo); ?></div>
                                <div class="libro-autor"><?php echo s($l->autor); ?></div>
                            </div>
                            <div class="leido-meta">
                                <?php if ($tiene) : ?>
                                    <span class="leido-stars-static"><?php
                                        echo estrellasHtml((float)$l->estrellas);
                                        echo '<span class="leido-stars-num">' . number_format((float)$l->estrellas, 1) . '</span>';
                                    ?></span>
                                <?php else : ?><span class="sin-resena">Sin reseña</span><?php endif; ?>
                                <span class="leido-fecha"><?php echo icono('calendario'); ?><?php echo $l->fecha_leido ? date('d/m/Y', strtotime($l->fecha_leido)) : 'Sin fecha'; ?></span>
                            </div>
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
                        <label class="campo-mini" style="margin-top:8px"><span>Fecha de completado</span><input type="text" class="edit-fechaleido" inputmode="numeric" maxlength="10" placeholder="dd/mm/aaaa" value="<?php echo $l->fecha_leido ? date('d/m/Y', strtotime($l->fecha_leido)) : ''; ?>"></label>
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
        <?php if ($totalPag > 1) : ?>
            <div class="paginacion">
                <?php for ($i = 1; $i <= $totalPag; $i++) : ?>
                    <?php if ($i === $pag) : ?><span class="actual"><?php echo $i; ?></span>
                    <?php else : ?><a href="/admin/libros?pag=<?php echo $i; ?>#col-leidos"><?php echo $i; ?></a><?php endif; ?>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<script>
(function () {
    function post(url, data, cb) {
        var body = Object.keys(data).map(function (k) { return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]); }).join('&');
        fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: body })
            .then(function (r) { return r.json(); }).then(cb).catch(function () { alert('Error'); });
    }

    // Máscara dd/mm/aaaa (la conversión a ISO la hace window.fechaISO, global).
    // Si el layout fuera una versión anterior sin estos helpers, la página sigue
    // funcionando: solo se queda sin máscara y sin campo de fecha en el guardado.
    if (window.mascaraFechaDmy) {
        document.querySelectorAll('.edit-fechaleido').forEach(function (inp) { window.mascaraFechaDmy(inp); });
    }

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
            var np = libro.querySelector('.edit-pos'); if (np && np.value.trim() !== '') data.nueva_pos = np.value.trim();
            var fl = libro.querySelector('.edit-fechaleido');
            if (fl && window.fechaISO) {
                var iso = window.fechaISO(fl.value);
                if (iso === null) { (window.toast ? toast('Fecha inválida: usa dd/mm/aaaa', 'eliminado') : alert('Fecha inválida: usa dd/mm/aaaa')); return; }
                data.fecha_leido = iso;
            }
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

<script>
// Buscador: localiza un libro y su posición en cada columna
(function () {
    var q = document.getElementById('libro-q'), box = document.getElementById('libro-q-res');
    if (!q) return;
    var pagActual = <?php echo (int) $pag; ?>, timer = null;

    function saltar(id, columna, pagina) {
        // Leídos en otra página: recargar en esa página y anclar al libro
        if (columna === 'Leídos' && pagina && pagina !== pagActual) {
            location.href = '/admin/libros?pag=' + pagina + '#libro-' + id;
            return;
        }
        var el = document.getElementById('libro-' + id);
        if (!el) return;
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        el.classList.add('is-hit');
        setTimeout(function () { el.classList.remove('is-hit'); }, 1600);
    }

    function render(items) {
        if (!items.length) { box.innerHTML = '<div class="libro-buscar-vacio">Sin coincidencias.</div>'; box.classList.add('is-open'); return; }
        box.innerHTML = items.map(function (it) {
            var pag = it.columna === 'Leídos' && it.pagina ? ' · pág. ' + it.pagina : '';
            return '<button type="button" class="libro-buscar-item" data-id="' + it.id + '" data-col="' + it.columna + '" data-pag="' + (it.pagina || '') + '">' +
                '<span class="lb-tit">' + it.titulo.replace(/</g, '&lt;') + '</span>' +
                '<span class="lb-meta"><span class="lb-col lb-col--' + (it.columna === 'Leídos' ? 'leido' : 'pend') + '">' + it.columna + '</span> · posición #' + it.posicion + pag + '</span>' +
                '</button>';
        }).join('');
        box.classList.add('is-open');
        box.querySelectorAll('.libro-buscar-item').forEach(function (b) {
            b.addEventListener('click', function () { saltar(+b.dataset.id, b.dataset.col, b.dataset.pag ? +b.dataset.pag : null); });
        });
    }

    q.addEventListener('input', function () {
        clearTimeout(timer);
        var val = q.value.trim();
        if (!val) { box.classList.remove('is-open'); box.innerHTML = ''; return; }
        timer = setTimeout(function () {
            fetch('/admin/libros/buscar?q=' + encodeURIComponent(val))
                .then(function (r) { return r.json(); })
                .then(function (d) { if (d.ok) render(d.resultados); })
                .catch(function () {});
        }, 220);
    });
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.libro-buscar')) box.classList.remove('is-open');
    });
})();
</script>
