<div class="admin-head">
    <div>
        <h1>Gestionar Películas y Series</h1>
        <p>Alta, edición y reseñas. Si ya hay un título con ese nombre, antes de crear otro se pregunta si te refieres a él.</p>
    </div>
    <a href="/admin/peliculas" class="btn btn--ghost">← Volver al dashboard</a>
</div>

<div class="card">
    <h2><?php echo $editando ? 'Editar título' : 'Nuevo título'; ?></h2>

    <?php
        // Película va primero y sale preseleccionada; Serie después y el resto alfabético
        $catActual = $editando->categoria ?? \Model\Categoria::porDefecto($categorias);
        $dur = (int) ($editando->duracion ?? 0);
    ?>
    <form method="POST" action="/admin/peliculas/guardar" enctype="multipart/form-data" id="form-pelicula">
        <input type="hidden" name="id" value="<?php echo $editando->id ?? ''; ?>">
        <div class="pel-form-grid">
            <!-- Póster vertical -->
            <div class="campo campo-poster">
                <span>Póster</span>
                <div class="upload upload--stack upload--poster">
                    <div class="upload-preview" id="prev-poster" style="width:100%;aspect-ratio:2/3;height:auto">
                        <?php if (!empty($editando->poster)) : ?><img src="<?php echo urlSubida('peliculas', $editando->poster); ?>" alt="" style="object-fit:cover"><?php else : ?><span class="poster-ph" style="border:none"><?php echo icono('film'); ?></span><?php endif; ?>
                    </div>
                    <label class="upload-drop"><b>Elige</b> o arrastra el póster<br><small>JPG, PNG, WEBP</small><input type="file" name="poster_file" accept="image/*" data-preview="#prev-poster"></label>
                </div>
            </div>

            <div class="form-grid">
                <div class="campo full autocomplete" data-autocomplete data-endpoint="/admin/buscar?tipo=pelicula" data-onpick="pelPick">
                    <span>Título <small style="color:var(--muted-2)">— escribe para buscar un título existente; al elegirlo se abre su ficha</small></span>
                    <input type="text" name="titulo" class="ac-input" value="<?php echo s($editando->titulo ?? ''); ?>" autocomplete="off" required>
                    <div class="ac-results"></div>
                </div>
                <div class="campo full">
                    <span>Categoría</span>
                    <div class="tabs" id="cat-tabs">
                        <?php foreach ($categorias as $cat) : ?>
                            <span class="tab <?php echo $catActual === $cat->nombre ? 'sel' : ''; ?>" data-val="<?php echo s($cat->nombre); ?>" data-admite-serie="<?php echo (int) $cat->admite_serie; ?>"><?php echo s($cat->nombre); ?></span>
                        <?php endforeach; ?>
                        <span class="tab" data-val="__nueva__">＋ Nueva</span>
                    </div>
                    <input type="hidden" name="categoria" id="cat-input" value="<?php echo s($catActual); ?>">
                    <!-- Formato serie: solo en categorías que lo admiten (docuserie,
                         reality…). «Serie» ya lo es por sí misma. -->
                    <label class="alfinal-toggle cat-serie" id="cat-serie" hidden>
                        <input type="checkbox" name="es_serie" value="1" id="es-serie" <?php echo !empty($editando->es_serie) ? 'checked' : ''; ?>>
                        <span class="alfinal-box"><?php echo icono('ok'); ?></span>
                        <span class="alfinal-txt">Es <strong>serie</strong> <small style="color:var(--muted-2)">— sin duración y con «Creador»</small></span>
                    </label>
                </div>
                <div class="campo full nueva-cat" id="nueva-cat" style="display:none">
                    <label class="campo">
                        <span>Nueva categoría</span>
                        <input type="text" name="categoria_nueva" placeholder="Miniserie, Anime…">
                    </label>
                    <label class="alfinal-toggle">
                        <input type="checkbox" name="categoria_admite_serie" value="1" id="nueva-admite-serie">
                        <span class="alfinal-box"><?php echo icono('ok'); ?></span>
                        <span class="alfinal-txt">Sus títulos pueden ser <strong>serie</strong></span>
                    </label>
                </div>
                <?php
                // Un título puede tener varios directores / creadores: se
                // capturan en filas, una por persona. Vacío = «Desconocido».
                $ao_dirs = $editando ? $editando->personas() : [];
                $ao_dirs = array_values(array_filter($ao_dirs, fn($n) => $n !== \Model\PeliculaPersona::DESCONOCIDO));
                if (!$ao_dirs) $ao_dirs = [''];
                ?>
                <div class="campo full" id="campo-autores">
                    <span>Director / Creador</span>
                    <div class="autores-lista" id="autores-lista">
                        <?php foreach ($ao_dirs as $ao_d) : ?>
                            <div class="autor-fila">
                                <div class="autocomplete" data-autocomplete data-endpoint="/admin/buscar?tipo=autor" data-onpick="autorPick">
                                    <input type="text" name="autores[]" class="ac-input" value="<?php echo s($ao_d); ?>" autocomplete="off" placeholder="Nombre y apellido">
                                    <div class="ac-results"></div>
                                </div>
                                <button type="button" class="btn btn--sm btn--ghost autor-quitar" aria-label="Quitar director"><?php echo icono('trash'); ?></button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn--sm btn--ghost" id="autor-agregar">+ Añadir otro</button>
                </div>
                <?php echo campoFechaDmy('fecha_vista', $editando->fecha_vista ?? '', 'Fecha vista', 'campo', true); ?>
                <label class="campo">
                    <span>Año</span>
                    <input type="number" name="anio" min="0" step="1" value="<?php echo s($editando->anio ?? ''); ?>" placeholder="<?php echo date('Y'); ?>">
                </label>
                <div class="campo" id="campo-duracion">
                    <span>Duración <small style="color:var(--muted-2)" id="dur-nota"></small></span>
                    <div class="dur-inputs">
                        <label><input type="number" name="duracion_h" id="dur-h" min="0" max="99" step="1" placeholder="0" value="<?php echo $dur ? intdiv($dur, 60) : ''; ?>"><span>h</span></label>
                        <label><input type="number" name="duracion_m" id="dur-m" min="0" max="59" step="1" placeholder="0" value="<?php echo $dur ? $dur % 60 : ''; ?>"><span>min</span></label>
                    </div>
                </div>
                <!-- Junto a Duración y con la misma altura que un campo: así la
                     fila queda pareja en vez de dejar media fila vacía. -->
                <div class="campo">
                    <span>Selección del Autor</span>
                    <label class="alfinal-toggle campo-toggle">
                        <input type="checkbox" name="seleccion" value="1" <?php echo !empty($editando->seleccion) ? 'checked' : ''; ?>>
                        <span class="alfinal-box"><?php echo icono('ok'); ?></span>
                        <span class="alfinal-txt">Incluir <small>— aparece en /tekhne/recomendaciones</small></span>
                    </label>
                </div>
                <div class="campo full">
                    <span>Nota</span>
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
        <h2>Catálogo <span class="conteo"><?php echo count($peliculas); ?></span></h2>
        <input type="search" id="cat-search" class="tabla-search" placeholder="Buscar por título, categoría o director…" autocomplete="off">
    </div>
    <div class="tabla-wrap tabla-wrap--cards">
        <table class="tabla tabla--sort tabla--cards" id="cat-tabla">
            <thead><tr>
                <th>Póster</th>
                <th class="th-sort" data-sort="text">Título</th>
                <th class="th-sort" data-sort="text">Categoría</th>
                <th class="th-sort" data-sort="text">Dir./Creador</th>
                <th class="th-sort" data-sort="num">Año</th>
                <th class="th-sort" data-sort="date">Vista</th>
                <th class="th-sort" data-sort="num">Nota</th>
                <th class="th-sort" data-sort="text">Estado</th>
                <th class="th-sort" data-sort="num" title="Selección del Autor">Sel.</th>
                <th>Acciones</th>
            </tr></thead>
            <tbody>
            <?php foreach ($peliculas as $p) : $n = (float) $p->nota; $cls = $n >= 8 ? 'nota-alta' : ($n >= 5 ? 'nota-media' : 'nota-baja'); ?>
                <tr>
                    <td class="cell-poster" data-label=""><?php if (!empty($p->poster)) : ?><img class="poster-mini" src="<?php echo urlSubida('peliculas', $p->poster); ?>" alt=""><?php else : ?><div class="poster-mini" style="display:grid;place-items:center;color:var(--muted-2)"><?php echo icono('film'); ?></div><?php endif; ?></td>
                    <td class="cell-titulo" data-label="Título" data-v="<?php echo s($p->titulo); ?>"><?php echo s($p->titulo); ?></td>
                    <td data-label="Categoría" data-v="<?php echo s($p->categoriaTexto()); ?>"><span class="badge badge--cat"><?php echo s($p->categoriaTexto()); ?></span></td>
                    <td data-label="Dir./Creador" data-v="<?php echo s($p->personasTexto()); ?>" style="color:var(--muted)"><?php echo s($p->personasTexto()); ?></td>
                    <td data-label="Año" data-v="<?php echo s($p->anio); ?>"><?php echo s($p->anio); ?></td>
                    <td data-label="Vista" data-v="<?php echo s($p->fecha_vista ?? ''); ?>" style="color:var(--muted)"><?php echo $p->fecha_vista ? date('d/m/Y', strtotime($p->fecha_vista)) : '—'; ?></td>
                    <td data-label="Nota" data-v="<?php echo $n; ?>"><span class="nota-badge <?php echo $cls; ?>"><?php echo number_format($n, 0); ?></span></td>
                    <td data-label="Estado" data-v="<?php echo $p->estaAprobada() ? '1' : '0'; ?>"><?php echo $p->estaAprobada() ? '<span class="badge badge--ok">Aprobado</span>' : '<span class="badge badge--no">No aprobado</span>'; ?></td>
                    <td data-label="Selección" data-v="<?php echo !empty($p->seleccion) ? '1' : '0'; ?>"><?php echo !empty($p->seleccion) ? '<span class="sel-marca" title="En la Selección del Autor">' . icono('estrella') . '</span>' : '<span style="color:var(--muted-2)">—</span>'; ?></td>
                    <td class="acciones" data-label="Acciones">
                        <a href="/admin/peliculas/gestionar?id=<?php echo $p->id; ?>" class="act-btn act-edit" title="Editar"><?php echo icono('editar'); ?></a>
                        <form method="POST" action="/admin/peliculas/eliminar" data-confirm="Se eliminará este título." data-confirm-name="<?php echo s($p->titulo); ?>">
                            <input type="hidden" name="id" value="<?php echo $p->id; ?>">
                            <button class="act-btn act-del" title="Eliminar"><?php echo icono('eliminar'); ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($peliculas)) : ?><tr><td colspan="10" style="color:var(--muted)">Sin títulos todavía.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- «¿Te estás refiriendo a…?»: al crear un título cuyo nombre ya existe.
     Elegir uno abre su ficha; «Es otro título» crea el registro nuevo. -->
<div class="modal-backdrop" id="homonimos-modal">
    <div class="modal modal--homonimos" role="dialog" aria-modal="true" aria-labelledby="hom-h" aria-describedby="hom-txt">
        <span class="modal-kicker">Ya existe ese título</span>
        <h3 id="hom-h">¿Te estás refiriendo a…?</h3>
        <p class="hom-txt" id="hom-txt"></p>
        <ul class="hom-lista" id="hom-lista"></ul>
        <div class="modal-actions">
            <button type="button" class="btn btn--sm btn--ghost" id="hom-cancelar">Cancelar</button>
            <button type="button" class="btn btn--sm btn--primary" id="hom-nuevo">No, es otro: crear nuevo</button>
        </div>
    </div>
</div>

<script>
window.pelPick = function (item) { location.href = '/admin/peliculas/gestionar?id=' + item.id; };
window.autorPick = function (item, box) { box.querySelector('.ac-input').value = item.titulo; };
(function () {
    // Directores / creadores: filas que se añaden y se quitan
    var lista = document.getElementById('autores-lista');
    if (lista) {
        var plantilla = lista.querySelector('.autor-fila');
        document.getElementById('autor-agregar').addEventListener('click', function () {
            var fila = plantilla.cloneNode(true);
            var caja = fila.querySelector('[data-autocomplete]');
            caja.removeAttribute('data-ac-built');           // el clon necesita sus propios oyentes
            fila.querySelector('.ac-input').value = '';
            fila.querySelector('.ac-results').innerHTML = '';
            lista.appendChild(fila);
            if (window.initAutocomplete) initAutocomplete(fila);
            fila.querySelector('.ac-input').focus();
        });
        lista.addEventListener('click', function (e) {
            if (!e.target.closest('.autor-quitar')) return;
            var filas = lista.querySelectorAll('.autor-fila');
            if (filas.length > 1) e.target.closest('.autor-fila').remove();
            else filas[0].querySelector('.ac-input').value = '';   // la última se vacía, no se borra
        });
    }

    // Formato serie: «Serie» siempre lo es; las categorías que lo admiten
    // (Documental, Reality…) muestran la casilla. Una serie no lleva duración.
    var campoDur = document.getElementById('campo-duracion'), durNota = document.getElementById('dur-nota');
    var durH = document.getElementById('dur-h'), durM = document.getElementById('dur-m');
    var tabs = document.getElementById('cat-tabs'), catInput = document.getElementById('cat-input'), nueva = document.getElementById('nueva-cat');
    var catSerie = document.getElementById('cat-serie'), esSerieChk = document.getElementById('es-serie');
    var nuevaAdmite = document.getElementById('nueva-admite-serie');
    var durGuardada = [durH.value, durM.value];     // se repone si se desmarca serie sin guardar

    function aplicarFormato() {
        var t = tabs.querySelector('.tab.sel'), cat = catInput.value;
        var admite = cat === '__nueva__' ? nuevaAdmite.checked : !!(t && t.dataset.admiteSerie === '1');
        catSerie.hidden = !admite;
        if (!admite) esSerieChk.checked = false;
        var esSerie = cat === 'Serie' || (admite && esSerieChk.checked);
        campoDur.classList.toggle('is-locked', esSerie);
        durH.disabled = durM.disabled = esSerie;
        durNota.textContent = esSerie ? '— no aplica en series' : '';
        if (esSerie) { durH.value = ''; durM.value = ''; }
        else if (!durH.value && !durM.value) { durH.value = durGuardada[0]; durM.value = durGuardada[1]; }
    }

    tabs.querySelectorAll('.tab').forEach(function (t) {
        t.addEventListener('click', function () {
            tabs.querySelectorAll('.tab').forEach(function (x) { x.classList.remove('sel'); });
            t.classList.add('sel'); catInput.value = t.dataset.val;
            nueva.style.display = t.dataset.val === '__nueva__' ? 'grid' : 'none';
            aplicarFormato();
        });
    });
    esSerieChk.addEventListener('change', aplicarFormato);
    nuevaAdmite.addEventListener('change', aplicarFormato);
    aplicarFormato();   // estado inicial (también al editar)

    /* ---- Homónimos: «¿Te estás refiriendo a…?» antes de crear ---- */
    var form = document.getElementById('form-pelicula');
    var homModal = document.getElementById('homonimos-modal'), homLista = document.getElementById('hom-lista');
    var homTxt = document.getElementById('hom-txt'), homNuevo = document.getElementById('hom-nuevo');
    var ICO_FILM = <?php echo json_encode(icono('film'), JSON_HEX_TAG); ?>;
    var confirmadoNuevo = false, ultimoFoco = null;
    function escH(v) { return String(v == null ? '' : v).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'); }
    function enviar() { confirmadoNuevo = true; if (form.requestSubmit) form.requestSubmit(); else form.submit(); }
    function abrirHom() {
        homModal.classList.add('is-open'); document.body.style.overflow = 'hidden';
        document.addEventListener('keydown', teclaHom, true);
    }
    function cerrarHom(devolverFoco) {
        homModal.classList.remove('is-open'); document.body.style.overflow = '';
        document.removeEventListener('keydown', teclaHom, true);
        if (devolverFoco && ultimoFoco) ultimoFoco.focus();
    }
    function teclaHom(e) {
        if (e.key === 'Escape') { e.preventDefault(); cerrarHom(true); return; }
        // aria-modal no retiene el foco por sí solo: Tab da la vuelta dentro de la modal
        if (e.key !== 'Tab') return;
        var foc = homModal.querySelectorAll('a[href], button:not([disabled])');
        if (!foc.length) return;
        var pri = foc[0], ult = foc[foc.length - 1];
        if (e.shiftKey && (document.activeElement === pri || !homModal.contains(document.activeElement))) { e.preventDefault(); ult.focus(); }
        else if (!e.shiftKey && (document.activeElement === ult || !homModal.contains(document.activeElement))) { e.preventDefault(); pri.focus(); }
    }

    form.addEventListener('submit', function (e) {
        if (confirmadoNuevo || form.querySelector('[name="id"]').value) return;   // edición o ya confirmado
        var titulo = form.querySelector('[name="titulo"]').value.trim();
        if (!titulo) return;
        e.preventDefault();
        var boton = e.submitter || form.querySelector('[type="submit"]');
        boton.disabled = true;
        fetch('/admin/buscar?tipo=pelicula&exacto=1&q=' + encodeURIComponent(titulo))
            .then(function (r) { return r.json(); })
            .then(function (items) {
                boton.disabled = false;
                if (!items || !items.length) { enviar(); return; }
                homTxt.textContent = items.length === 1
                    ? 'Ya tienes un registro llamado «' + titulo + '». Si es ese, abre su ficha para editarlo; si es otro (un remake, la serie, otra versión), crea uno nuevo.'
                    : 'Ya tienes ' + items.length + ' registros llamados «' + titulo + '». Abre el que quieres editar o crea uno nuevo.';
                homLista.innerHTML = items.map(function (it) {
                    var extra = [it.personas, it.fecha ? 'Visto el ' + it.fecha : ''].filter(Boolean).join(' · ');
                    return '<li><a class="hom-item" href="/admin/peliculas/gestionar?id=' + encodeURIComponent(it.id) + '">' +
                        '<span class="hom-poster">' + (it.poster ? '<img src="' + it.poster + '" alt="">'   /* urlSubida() ya la escapa */ : ICO_FILM) + '</span>' +
                        '<span class="hom-info"><span class="hom-t">' + escH(it.titulo) + '</span>' +
                        '<span class="hom-s">' + escH(it.sub) + '</span>' +
                        (extra ? '<span class="hom-s">' + escH(extra) + '</span>' : '') + '</span>' +
                        '<span class="hom-accion">Sí, abrir su ficha</span></a></li>';
                }).join('');
                ultimoFoco = boton;
                abrirHom();
                var primero = homLista.querySelector('a'); if (primero) primero.focus();
            })
            // Si la comprobación falla no se bloquea el alta
            .catch(function () { boton.disabled = false; enviar(); });
    });
    homNuevo.addEventListener('click', function () { cerrarHom(false); enviar(); });
    document.getElementById('hom-cancelar').addEventListener('click', function () { cerrarHom(true); });
    homModal.addEventListener('click', function (e) { if (e.target === homModal) cerrarHom(true); });

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
