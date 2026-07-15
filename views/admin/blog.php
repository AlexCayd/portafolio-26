<div class="admin-head">
    <div>
        <h1>Tékhne</h1>
        <p>Entradas de «Ideas en voz alta». El tiempo de lectura se calcula solo. Arrastra para reordenar.</p>
    </div>
    <a href="/#ao-blog" target="_blank" class="btn btn--ghost">Ver en el sitio ↗</a>
</div>

<div class="card">
    <h2><?php echo $editando ? 'Editar entrada' : 'Nueva entrada'; ?></h2>
    <form method="POST" action="/admin/blog/guardar" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $editando->id ?? ''; ?>">
        <?php $catActual = $editando->categoria ?? (!empty($categorias) ? $categorias[0]->nombre : ''); ?>
        <div class="pel-form-grid" style="grid-template-columns:300px 1fr;margin-bottom:18px">
            <div class="campo">
                <span>Portada <small style="color:var(--muted-2)">— opcional</small></span>
                <div class="upload upload--stack">
                    <div class="upload-preview" id="prev-cover" style="width:100%;aspect-ratio:16/9;height:auto">
                        <?php if (!empty($editando->cover_img)) : ?><img src="/build/img/blog/<?php echo s($editando->cover_img); ?>" alt="" style="object-fit:cover"><?php else : ?>Degradado<?php endif; ?>
                    </div>
                    <label class="upload-drop">
                        <b>Elige</b> o arrastra<br><small>PNG, JPG, WEBP</small>
                        <input type="file" name="cover_file" accept="image/*" data-preview="#prev-cover">
                    </label>
                </div>
            </div>
            <div class="form-grid" style="align-content:start">
                <label class="campo full">
                    <span>Título</span>
                    <input type="text" name="titulo" id="blog-titulo" value="<?php echo s($editando->titulo ?? ''); ?>" required>
                </label>
                <label class="campo">
                    <span>Slug (URL) <small style="color:var(--muted-2)">— automático</small></span>
                    <input type="text" name="slug" id="blog-slug" value="<?php echo s($editando->slug ?? ''); ?>" placeholder="mi-articulo">
                    <span class="mini-s" style="color:var(--muted-2);margin-top:4px">/tekhne/<span id="slug-preview" style="color:#ff5364"><?php echo s($editando->slug ?? ''); ?></span></span>
                </label>
                <label class="campo">
                    <span>Fecha de publicación</span>
                    <input type="date" name="fecha_pub" value="<?php echo s($editando->fecha_pub ?? date('Y-m-d')); ?>">
                </label>
                <div class="campo full">
                    <span>Categoría</span>
                    <div class="tabs tabs--grid" id="cat-tabs-blog">
                        <?php foreach ($categorias as $cat) : ?>
                            <span class="tab <?php echo $catActual === $cat->nombre ? 'sel' : ''; ?>" data-val="<?php echo s($cat->nombre); ?>"><?php echo s($cat->nombre); ?></span>
                        <?php endforeach; ?>
                        <span class="tab" data-val="__nueva__">＋ Nueva</span>
                    </div>
                    <input type="hidden" name="categoria" id="cat-input-blog" value="<?php echo s($catActual); ?>">
                </div>
                <label class="campo full" id="nueva-cat-blog" style="display:none">
                    <span>Nombre de la nueva categoría</span>
                    <input type="text" name="categoria_nueva" placeholder="TUTORIAL, ENSAYO…">
                </label>
            </div>
        </div>
        <div class="form-grid">
            <label class="campo full">
                <span>Extracto (tarjeta)</span>
                <textarea name="descripcion" style="min-height:70px"><?php echo s($editando->descripcion ?? ''); ?></textarea>
            </label>
            <div class="campo full">
                <span style="display:flex;justify-content:space-between;align-items:center">
                    <span>Cuerpo del artículo</span>
                    <span style="display:flex;gap:10px;align-items:center">
                        <span class="mini-s" style="color:var(--muted-2)"><b id="rt-count">1</b> min de lectura</span>
                        <button type="button" class="btn btn--sm editor-tool" id="btn-heading" title="Formatear como título (Ctrl+1)"><span class="et-ic">H</span> Título</button>
                        <button type="button" class="btn btn--sm editor-tool" id="btn-img" title="Insertar imagen"><span class="et-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></span> Imagen</button>
                    </span>
                </span>
                <div class="blog-editor" id="body-editor" contenteditable="true"><?php echo $editando->contenido ?? ''; ?></div>
                <input type="hidden" name="contenido" id="body-hidden" value="">
                <input type="file" id="body-img" accept="image/*" style="display:none">
            </div>

            <div class="campo full autocomplete" data-autocomplete data-endpoint="/admin/buscar?tipo=ref" data-onpick="blogPick">
                <span>Asociar a un recurso (libro / película / serie) — opcional</span>
                <input type="text" class="ac-input" placeholder="Busca un título…">
                <div class="ac-results"></div>
                <div class="ac-chosen <?php echo (!empty($editando) && $editando->ref_id) ? 'show' : ''; ?>" id="ref-chosen">
                    <span class="ref-label"><?php echo (!empty($editando) && $editando->ref_id) ? s(ucfirst($editando->ref_tipo) . ' #' . $editando->ref_id) : ''; ?></span>
                    <b id="ref-clear">Quitar ✕</b>
                </div>
                <input type="hidden" name="ref_tipo" id="ref_tipo" value="<?php echo s($editando->ref_tipo ?? ''); ?>">
                <input type="hidden" name="ref_id" id="ref_id" value="<?php echo s($editando->ref_id ?? ''); ?>">
            </div>

        </div>
        <input type="hidden" name="accion" id="blog-accion" value="publicar">
        <div class="form-actions">
            <button type="submit" class="btn btn--primary" onclick="document.getElementById('blog-accion').value='publicar'"><?php echo (!empty($editando) && $editando->estado === 'publicado') ? 'Actualizar' : 'Publicar'; ?></button>
            <button type="submit" class="btn btn--ghost" onclick="document.getElementById('blog-accion').value='borrador'">Guardar borrador</button>
            <?php if ($editando) : ?><a href="/admin/blog" class="btn btn--ghost">Cancelar</a><?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-head"><h2>Entradas (<?php echo count($posts); ?>)</h2><span class="mini-s" style="color:var(--muted)">↕ arrastra para reordenar · <span class="landing-badge landing-badge--inline"><?php echo icono('estrella'); ?></span> las 3 primeras salen en la landing</span></div>
    <div class="tabla-wrap">
        <table class="tabla">
            <thead><tr><th></th><th>Portada</th><th>Título</th><th>Categoría</th><th>Publicado</th><th>Visitas</th><th>Lectura</th><th>Acciones</th></tr></thead>
            <tbody data-sortable data-orden-url="/admin/blog/orden" data-landing="3">
            <?php foreach ($posts as $ao_ix => $post) : ?>
                <tr class="sortable-row<?php echo $ao_ix < 3 ? ' is-landing' : ''; ?>" draggable="true" data-id="<?php echo $post->id; ?>">
                    <td><span class="drag-handle">⠿</span><?php if ($ao_ix < 3) : ?><span class="landing-badge" title="Se muestra en la landing"><?php echo icono('estrella'); ?></span><?php endif; ?></td>
                    <td>
                        <?php if (!empty($post->cover_img)) : ?><img class="thumb-cell" src="/build/img/blog/<?php echo s($post->cover_img); ?>" alt="">
                        <?php else : ?><div class="thumb-cell" style="background:linear-gradient(135deg,var(--accent),#1a0207)"></div><?php endif; ?>
                    </td>
                    <td>
                        <a href="/tekhne/<?php echo s($post->slug ?: $post->id); ?>" target="_blank"><?php echo s($post->titulo); ?></a>
                        <?php if ($post->estado === 'borrador') : ?> <span class="badge badge--no" style="margin-left:4px">Borrador</span><?php endif; ?>
                    </td>
                    <td><span class="badge badge--cat"><?php echo s($post->categoria); ?></span></td>
                    <td style="color:var(--muted)"><?php echo $post->fecha_pub ? date('d/m/Y', strtotime($post->fecha_pub)) : '—'; ?></td>
                    <td style="font-family:var(--mono)"><?php echo number_format((int) $post->visitas); ?></td>
                    <td style="font-family:var(--mono)"><?php echo $post->tiempoLectura(); ?> min</td>
                    <td class="acciones">
                        <a href="/admin/blog?id=<?php echo $post->id; ?>" class="act-btn act-edit" title="Editar"><?php echo icono('editar'); ?></a>
                        <form method="POST" action="/admin/blog/eliminar" data-confirm="Se eliminará esta entrada." data-confirm-name="<?php echo s($post->titulo); ?>">
                            <input type="hidden" name="id" value="<?php echo $post->id; ?>">
                            <button class="act-btn act-del" title="Eliminar"><?php echo icono('eliminar'); ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($posts)) : ?><tr><td colspan="8" style="color:var(--muted)">Sin entradas todavía.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-head"><h2>Artículos más vistos</h2><span class="mini-s" style="color:var(--muted)">Por número de visitas</span></div>
    <canvas id="blogVisitasChart" style="max-height:280px"></canvas>
</div>

<script>
(function () {
    if (typeof Chart === 'undefined') return;
    var C = <?php echo json_encode($chartVisitas, JSON_UNESCAPED_UNICODE); ?>;
    if (!C.labels.length) return;
    var GRID = 'rgba(255,255,255,.07)';
    new Chart(document.getElementById('blogVisitasChart'), {
        type: 'bar',
        data: { labels: C.labels, datasets: [{ label: 'Visitas', data: C.data, backgroundColor: '#F5B400', borderRadius: 6, borderSkipped: false }] },
        options: { indexAxis: 'y', responsive: true, plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true, grid: { color: GRID }, ticks: { precision: 0 } }, y: { grid: { display: false } } } }
    });
})();
</script>

<script>
(function () {
    var editor = document.getElementById('body-editor'), hidden = document.getElementById('body-hidden'), rt = document.getElementById('rt-count');

    // --- Editor WYSIWYG (contentEditable → guarda HTML) ---
    function calc() { var w = (editor.textContent.trim().match(/\S+/g) || []).length; rt.textContent = Math.max(1, Math.ceil(w / 200)); }
    editor.addEventListener('input', calc);
    // Sincroniza el HTML al hidden antes de enviar (también al final del script)
    editor.closest('form').addEventListener('submit', function () { hidden.value = editor.innerHTML.trim(); });

    // Inserta un nodo en la posición del cursor dentro del editor
    function insertarNodo(node) {
        editor.focus();
        var selc = window.getSelection();
        if (!selc.rangeCount || !editor.contains(selc.anchorNode)) { editor.appendChild(node); }
        else {
            var range = selc.getRangeAt(0); range.collapse(false); range.insertNode(node);
            range.setStartAfter(node); range.collapse(true); selc.removeAllRanges(); selc.addRange(range);
        }
        // asegura un párrafo editable después
        var p = document.createElement('p'); p.innerHTML = '<br>'; node.parentNode.insertBefore(p, node.nextSibling);
        calc();
    }

    // --- Atajos de teclado en el editor: Ctrl/Cmd+1 = formatear título ---
    editor.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key === '1') {
            e.preventDefault();
            document.execCommand('formatBlock', false, 'h2');
            calc();
        }
    });

    // --- Categoría por tabs ---
    var catTabs = document.getElementById('cat-tabs-blog'), catInput = document.getElementById('cat-input-blog'), nuevaCat = document.getElementById('nueva-cat-blog');
    catTabs.querySelectorAll('.tab').forEach(function (t) {
        t.addEventListener('click', function () {
            catTabs.querySelectorAll('.tab').forEach(function (x) { x.classList.remove('sel'); });
            t.classList.add('sel'); catInput.value = t.dataset.val;
            nuevaCat.style.display = t.dataset.val === '__nueva__' ? 'flex' : 'none';
        });
    });

    // --- Slug automático desde el título ---
    function slugify(s) { return s.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, ''); }
    var titulo = document.getElementById('blog-titulo'), slug = document.getElementById('blog-slug'), slugPrev = document.getElementById('slug-preview'), slugTocado = slug.value !== '';
    slug.addEventListener('input', function () { slugTocado = true; slug.value = slugify(slug.value); slugPrev.textContent = slug.value; });
    titulo.addEventListener('input', function () { if (!slugTocado) { slug.value = slugify(titulo.value); slugPrev.textContent = slug.value; } });

    calc();

    // Insertar título de sección
    document.getElementById('btn-heading').addEventListener('click', function () {
        var h = document.createElement('h2'); h.textContent = 'Título de sección';
        insertarNodo(h);
    });

    // Insertar imagen en el cuerpo (sube y coloca un <img> real)
    var btn = document.getElementById('btn-img'), file = document.getElementById('body-img');
    btn.addEventListener('click', function () { file.click(); });
    file.addEventListener('change', function () {
        if (!file.files[0]) return;
        var fd = new FormData(); fd.append('imagen', file.files[0]);
        fetch('/admin/blog/subir-imagen', { method: 'POST', body: fd }).then(function (r) { return r.json(); }).then(function (res) {
            if (!res.ok) { alert('No se pudo subir'); return; }
            var img = document.createElement('img'); img.src = res.url; img.alt = '';
            insertarNodo(img); toast('Imagen insertada'); file.value = '';
        });
    });

    // Asociación de recurso
    window.blogPick = function (item) {
        document.getElementById('ref_tipo').value = item.tipo;
        document.getElementById('ref_id').value = item.id;
        var ch = document.getElementById('ref-chosen');
        ch.querySelector('.ref-label').textContent = (item.tipo === 'libro' ? 'Libro: ' : 'Película: ') + item.titulo;
        ch.classList.add('show');
    };
    document.getElementById('ref-clear').addEventListener('click', function () {
        document.getElementById('ref_tipo').value = ''; document.getElementById('ref_id').value = '';
        document.getElementById('ref-chosen').classList.remove('show');
    });
})();
</script>
