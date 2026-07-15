<div class="admin-head">
    <div>
        <h1>Gestionar Películas y Series</h1>
        <p>Alta, edición y reseñas. Si el título ya existe, se actualiza ese registro.</p>
    </div>
    <a href="/admin/peliculas" class="btn btn--ghost">← Volver al dashboard</a>
</div>

<div class="card">
    <h2><?php echo $editando ? 'Editar título' : 'Nuevo título'; ?></h2>

    <form method="POST" action="/admin/peliculas/guardar" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $editando->id ?? ''; ?>">
        <div class="pel-form-grid">
            <!-- Póster vertical -->
            <div class="campo">
                <span>Póster</span>
                <div class="upload upload--stack" style="max-width:220px">
                    <div class="upload-preview" id="prev-poster" style="width:100%;aspect-ratio:2/3;height:auto">
                        <?php if (!empty($editando->poster)) : ?><img src="/build/img/peliculas/<?php echo s($editando->poster); ?>" alt="" style="object-fit:cover"><?php else : ?><span class="poster-ph" style="border:none"><?php echo icono('film'); ?></span><?php endif; ?>
                    </div>
                    <label class="upload-drop"><b>Elige</b> o arrastra el póster<br><small>JPG, PNG, WEBP</small><input type="file" name="poster_file" accept="image/*" data-preview="#prev-poster"></label>
                </div>
            </div>

            <div class="form-grid">
                <div class="campo full autocomplete" data-autocomplete data-endpoint="/admin/buscar?tipo=pelicula" data-onpick="pelPick">
                    <span>Título <small style="color:var(--muted-2)">— escribe para buscar un título existente; al elegirlo se carga su ficha</small></span>
                    <input type="text" name="titulo" class="ac-input" value="<?php echo s($editando->titulo ?? ''); ?>" placeholder="Interstellar…" autocomplete="off" required>
                    <div class="ac-results"></div>
                </div>
                <div class="campo full">
                    <span>Categoría</span>
                    <div class="tabs" id="cat-tabs">
                        <?php foreach ($categorias as $cat) : ?>
                            <span class="tab <?php echo (!empty($editando) && $editando->categoria === $cat->nombre) ? 'sel' : ''; ?>" data-val="<?php echo s($cat->nombre); ?>"><?php echo s($cat->nombre); ?></span>
                        <?php endforeach; ?>
                        <span class="tab" data-val="__nueva__">＋ Nueva</span>
                    </div>
                    <input type="hidden" name="categoria" id="cat-input" value="<?php echo s($editando->categoria ?? (!empty($categorias) ? $categorias[0]->nombre : '')); ?>">
                </div>
                <label class="campo full" id="nueva-cat" style="display:none">
                    <span>Nueva categoría</span>
                    <input type="text" name="categoria_nueva" placeholder="Miniserie, Anime…">
                </label>
                <div class="campo autocomplete" data-autocomplete data-endpoint="/admin/buscar?tipo=autor" data-onpick="autorPick">
                    <span>Director / Creador</span>
                    <input type="text" name="autor" class="ac-input" value="<?php echo s($editando->autor ?? ''); ?>" placeholder="Christopher Nolan" autocomplete="off">
                    <div class="ac-results"></div>
                </div>
                <label class="campo">
                    <span>Fecha vista</span>
                    <input type="date" name="fecha_vista" value="<?php echo s($editando->fecha_vista ?? ''); ?>">
                </label>
                <label class="campo">
                    <span>Año</span>
                    <input type="number" name="anio" value="<?php echo s($editando->anio ?? ''); ?>" placeholder="2025">
                </label>
                <label class="campo">
                    <span>Duración (min)</span>
                    <input type="number" name="duracion" value="<?php echo s($editando->duracion ?? ''); ?>">
                </label>
                <div class="campo full">
                    <span style="text-align:center">Nota</span>
                    <div class="score-wrap">
                        <div class="star-rating star-rating--xl star-rating--wide" data-max="10" data-step="1" data-input="#nota-input" data-onhover="pelScore"></div>
                        <span class="score-label" id="score-label"></span>
                    </div>
                    <input type="hidden" name="nota" id="nota-input" value="<?php echo s($editando->nota ?? '0'); ?>">
                </div>
                <label class="campo full">
                    <span>Reseña / comentario</span>
                    <textarea name="comentario"><?php echo s($editando->comentario ?? ''); ?></textarea>
                </label>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn--primary"><?php echo $editando ? 'Guardar cambios' : 'Agregar'; ?></button>
            <?php if ($editando) : ?><a href="/admin/peliculas/gestionar" class="btn btn--ghost">Cancelar</a><?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-head" style="flex-wrap:wrap;gap:12px">
        <h2>Catálogo</h2>
        <input type="search" id="cat-search" class="tabla-search" placeholder="Buscar por título, categoría o director…" autocomplete="off">
    </div>
    <div class="tabla-wrap">
        <table class="tabla tabla--sort" id="cat-tabla">
            <thead><tr>
                <th>Póster</th>
                <th class="th-sort" data-sort="text">Título</th>
                <th class="th-sort" data-sort="text">Categoría</th>
                <th class="th-sort" data-sort="text">Dir./Creador</th>
                <th class="th-sort" data-sort="num">Año</th>
                <th class="th-sort" data-sort="date">Vista</th>
                <th class="th-sort" data-sort="num">Nota</th>
                <th class="th-sort" data-sort="text">Estado</th>
                <th>Acciones</th>
            </tr></thead>
            <tbody>
            <?php foreach ($peliculas as $p) : $n = (float) $p->nota; $cls = $n >= 8 ? 'nota-alta' : ($n >= 5 ? 'nota-media' : 'nota-baja'); ?>
                <tr>
                    <td><?php if (!empty($p->poster)) : ?><img class="poster-mini" src="/build/img/peliculas/<?php echo s($p->poster); ?>" alt=""><?php else : ?><div class="poster-mini" style="display:grid;place-items:center;color:var(--muted-2)"><?php echo icono('film'); ?></div><?php endif; ?></td>
                    <td data-v="<?php echo s($p->titulo); ?>"><?php echo s($p->titulo); ?></td>
                    <td data-v="<?php echo s($p->categoria); ?>"><span class="badge badge--cat"><?php echo s($p->categoria); ?></span></td>
                    <td data-v="<?php echo s($p->autor); ?>" style="color:var(--muted)"><?php echo s($p->autor); ?></td>
                    <td data-v="<?php echo s($p->anio); ?>"><?php echo s($p->anio); ?></td>
                    <td data-v="<?php echo s($p->fecha_vista ?? ''); ?>" style="color:var(--muted)"><?php echo $p->fecha_vista ? date('d/m/Y', strtotime($p->fecha_vista)) : '—'; ?></td>
                    <td data-v="<?php echo $n; ?>"><span class="nota-badge <?php echo $cls; ?>"><?php echo number_format($n, 0); ?></span></td>
                    <td data-v="<?php echo $p->estaAprobada() ? '1' : '0'; ?>"><?php echo $p->estaAprobada() ? '<span class="badge badge--ok">Aprobado</span>' : '<span class="badge badge--no">No aprobado</span>'; ?></td>
                    <td class="acciones">
                        <a href="/admin/peliculas/gestionar?id=<?php echo $p->id; ?>" class="act-btn act-edit" title="Editar"><?php echo icono('editar'); ?></a>
                        <form method="POST" action="/admin/peliculas/eliminar" data-confirm="Se eliminará este título." data-confirm-name="<?php echo s($p->titulo); ?>">
                            <input type="hidden" name="id" value="<?php echo $p->id; ?>">
                            <button class="act-btn act-del" title="Eliminar"><?php echo icono('eliminar'); ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($peliculas)) : ?><tr><td colspan="9" style="color:var(--muted)">Sin títulos todavía.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
window.pelPick = function (item) { location.href = '/admin/peliculas/gestionar?id=' + item.id; };
window.autorPick = function (item, box) { box.querySelector('.ac-input').value = item.titulo; };
(function () {
    // Categoría por tabs
    var tabs = document.getElementById('cat-tabs'), catInput = document.getElementById('cat-input'), nueva = document.getElementById('nueva-cat');
    tabs.querySelectorAll('.tab').forEach(function (t) {
        t.addEventListener('click', function () {
            tabs.querySelectorAll('.tab').forEach(function (x) { x.classList.remove('sel'); });
            t.classList.add('sel'); catInput.value = t.dataset.val;
            nueva.style.display = t.dataset.val === '__nueva__' ? 'flex' : 'none';
        });
    });

    // Etiqueta de puntaje por nota (1–10) con color — se pinta en hover y al elegir
    var LABELS = {
        1: ['De lo peor que hay', '#ff6b73'], 2: ['Muy mala', '#ff8a5c'], 3: ['Mala', '#FC6722'],
        4: ['Floja', '#f5a300'], 5: ['Regular', '#F5B400'], 6: ['Pasable', '#c9c433'],
        7: ['Buena', '#8AC926'], 8: ['Muy buena', '#57d97b'], 9: ['Excelente', '#34A853'], 10: ['Obra maestra', '#F5B400']
    };
    var label = document.getElementById('score-label');
    window.pelScore = function (v) {
        var n = Math.round(parseFloat(v || 0));
        if (n >= 1 && LABELS[n]) { label.textContent = LABELS[n][0] + ' · ' + n + '/10'; label.style.color = LABELS[n][1]; }
        else { label.textContent = 'Sin calificar'; label.style.color = 'var(--muted)'; }
    };
    window.pelScore(document.getElementById('nota-input').value);

    // Buscador inteligente del catálogo: tolera acentos y coincidencia por
    // subsecuencia difusa (p. ej. "intstlr" encuentra "Interstellar").
    function norm(s) { return (s || '').toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, ''); }
    function fuzzy(q, t) {
        if (t.indexOf(q) >= 0) return true;
        var i = 0; for (var j = 0; j < t.length && i < q.length; j++) if (t[j] === q[i]) i++;
        return i === q.length;
    }
    var search = document.getElementById('cat-search');
    if (search) search.addEventListener('input', function () {
        var q = norm(search.value.trim());
        document.querySelectorAll('#cat-tabla tbody tr').forEach(function (tr) {
            tr.style.display = (!q || fuzzy(q, norm(tr.textContent))) ? '' : 'none';
        });
    });

    // Orden por columna (click en encabezados .th-sort)
    var tabla = document.getElementById('cat-tabla');
    if (tabla) tabla.querySelectorAll('th.th-sort').forEach(function (th, colIndex) {
        // índice real de la columna dentro de la fila
        var idx = Array.prototype.indexOf.call(th.parentNode.children, th);
        th.addEventListener('click', function () {
            var tbody = tabla.tBodies[0], rows = Array.prototype.slice.call(tbody.rows).filter(function (r) { return r.cells.length > 1; });
            var asc = th.dataset.dir !== 'asc';
            tabla.querySelectorAll('th.th-sort').forEach(function (h) { h.removeAttribute('data-dir'); });
            th.dataset.dir = asc ? 'asc' : 'desc';
            var type = th.dataset.sort;
            rows.sort(function (a, b) {
                var cA = a.cells[idx], cB = b.cells[idx];
                var vA = (cA.dataset.v != null ? cA.dataset.v : cA.textContent).trim();
                var vB = (cB.dataset.v != null ? cB.dataset.v : cB.textContent).trim();
                var r;
                if (type === 'num') r = (parseFloat(vA) || 0) - (parseFloat(vB) || 0);
                else r = vA.localeCompare(vB, 'es', { numeric: true });
                return asc ? r : -r;
            });
            rows.forEach(function (r) { tbody.appendChild(r); });
        });
    });
})();
</script>
