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
                        <?php if (!empty($editando->cover_img)) : ?><img src="<?php echo urlSubida('blog', $editando->cover_img); ?>" alt="" style="object-fit:cover"><?php else : ?>Degradado<?php endif; ?>
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
                <?php echo campoFechaDmy('fecha_pub', $editando->fecha_pub ?? date('Y-m-d'), 'Fecha de publicación'); ?>
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
                <span>Recursos asociados (libros / películas / series / videojuegos) — opcional, puedes añadir varios</span>
                <input type="text" class="ac-input" placeholder="Busca un título y elígelo para añadirlo…">
                <div class="ac-results"></div>
                <div class="ref-lista" id="ref-lista">
                    <?php
                    // Etiqueta del chip por tipo de recurso (los videojuegos guardan
                    // el título en `nombre`, no en `titulo`).
                    $ao_etiquetas = ['libro' => 'Libro: ', 'pelicula' => 'Película: ', 'videojuego' => 'Videojuego: '];
                    ?>
                    <?php foreach ($recursos as $r) : ?>
                        <span class="tag-pill" data-tipo="<?php echo s($r['tipo']); ?>" data-id="<?php echo (int) $r['obj']->id; ?>">
                            <?php echo s(($ao_etiquetas[$r['tipo']] ?? '') . ($r['tipo'] === 'videojuego' ? $r['obj']->nombre : $r['obj']->titulo)); ?> <b data-x>✕</b>
                        </span>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="recursos" id="ref-json" value="">
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
                        <?php if (!empty($post->cover_img)) : ?><img class="thumb-cell" src="<?php echo urlSubida('blog', $post->cover_img); ?>" alt="">
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
    // Enter debe generar <p> y no <div>: <div> no está en la whitelist de
    // sanitizarHtml() y strip_tags lo borraría fusionando los párrafos.
    try { document.execCommand('defaultParagraphSeparator', false, 'p'); } catch (e) {}

    function calc() { var w = (editor.textContent.trim().match(/\S+/g) || []).length; rt.textContent = Math.max(1, Math.ceil(w / 200)); }
    editor.addEventListener('input', calc);

    // Pegar siempre como texto plano: los dobles saltos se vuelven párrafos y los
    // sencillos <br>. Así nada del portapapeles llega con etiquetas que se pierdan.
    editor.addEventListener('paste', function (e) {
        var texto = (e.clipboardData || window.clipboardData).getData('text/plain');
        if (!texto) return;
        e.preventDefault();
        var frag = document.createDocumentFragment();
        texto.replace(/\r\n?/g, '\n').split(/\n{2,}/).forEach(function (parrafo) {
            if (parrafo.trim() === '') return;
            var p = document.createElement('p');
            parrafo.split('\n').forEach(function (linea, i) {
                if (i) p.appendChild(document.createElement('br'));
                p.appendChild(document.createTextNode(linea));
            });
            frag.appendChild(p);
        });
        if (!frag.childNodes.length) return;
        var ultimo = frag.lastChild;
        var selc = window.getSelection();
        if (!selc.rangeCount || !editor.contains(selc.anchorNode)) { editor.appendChild(frag); }
        else {
            var range = selc.getRangeAt(0);
            range.deleteContents(); range.insertNode(frag);
            range.setStartAfter(ultimo); range.collapse(true);
            selc.removeAllRanges(); selc.addRange(range);
        }
        calc();
    });
    // Sincroniza el HTML al hidden antes de enviar (también al final del script)
    editor.closest('form').addEventListener('submit', function () { hidden.value = editor.innerHTML.trim(); });

    // ¿El nodo es un bloque vacío? (solo espacios o un <br> suelto)
    function bloqueVacio(n) {
        if (!n || n.nodeType !== 1) return false;
        if (!/^(P|DIV|H2|H3)$/.test(n.nodeName)) return false;
        return n.textContent.trim() === '';
    }

    // Inserta un nodo en la posición del cursor dentro del editor
    function insertarNodo(node) {
        editor.focus();
        var selc = window.getSelection();
        if (!selc.rangeCount || !editor.contains(selc.anchorNode)) { editor.appendChild(node); }
        else {
            var range = selc.getRangeAt(0); range.collapse(false); range.insertNode(node);
            range.setStartAfter(node); range.collapse(true); selc.removeAllRanges(); selc.addRange(range);
        }
        // Solo se añade el párrafo si no hay ya uno vacío detrás; si no, se
        // acumulaba una línea en blanco de más en cada inserción.
        if (!bloqueVacio(node.nextSibling)) {
            var p = document.createElement('p'); p.innerHTML = '<br>';
            node.parentNode.insertBefore(p, node.nextSibling);
        }
        calc();
    }

    // Bloque (hijo directo del editor) que contiene el cursor
    function bloqueDelCursor() {
        var selc = window.getSelection();
        if (!selc.rangeCount || !editor.contains(selc.anchorNode)) return null;
        var n = selc.anchorNode;
        while (n && n.parentNode !== editor) n = n.parentNode;
        return n && n.nodeType === 1 ? n : null;
    }

    /**
     * Convierte en <h2> la línea donde está el cursor (o la devuelve a <p> si
     * ya era título). Se reemplaza el bloque en su sitio, sin insertar nodos
     * nuevos, para que no aparezca un salto de línea extra.
     */
    function formatearTitulo() {
        editor.focus();
        var bloque = bloqueDelCursor();

        // Texto suelto sin bloque: se envuelve el editor completo no, solo se
        // crea el h2 con lo que haya seleccionado/escrito en esa línea.
        if (!bloque) {
            if (editor.textContent.trim() === '') {
                var vacio = document.createElement('h2'); vacio.innerHTML = '<br>';
                editor.appendChild(vacio); colocarCaret(vacio); calc(); return;
            }
            document.execCommand('formatBlock', false, 'h2'); calc(); return;
        }

        var nuevo = document.createElement(bloque.nodeName === 'H2' ? 'p' : 'h2');
        nuevo.innerHTML = bloque.innerHTML.replace(/<br\s*\/?>\s*$/i, '') || '<br>';
        bloque.parentNode.replaceChild(nuevo, bloque);
        colocarCaret(nuevo);
        calc();
    }

    // Deja el cursor al final del bloque indicado
    function colocarCaret(nodo) {
        var range = document.createRange(), selc = window.getSelection();
        range.selectNodeContents(nodo); range.collapse(false);
        selc.removeAllRanges(); selc.addRange(range);
    }

    // --- Atajos de teclado en el editor: Ctrl/Cmd+1 = formatear título ---
    editor.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key === '1') {
            e.preventDefault();
            formatearTitulo();
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

    // El botón hace exactamente lo mismo que Ctrl+1 (lo anuncia su tooltip)
    document.getElementById('btn-heading').addEventListener('click', formatearTitulo);

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

    // --- Recursos asociados: varios por entrada, como chips ---
    var refLista = document.getElementById('ref-lista'), refJson = document.getElementById('ref-json');

    // El hidden viaja como JSON [{tipo, id}, …] en el orden de los chips
    function sincronizarRefs() {
        refJson.value = JSON.stringify(Array.prototype.map.call(refLista.querySelectorAll('.tag-pill'), function (p) {
            return { tipo: p.dataset.tipo, id: +p.dataset.id };
        }));
    }
    window.blogPick = function (item, box) {
        var yaEsta = refLista.querySelector('.tag-pill[data-tipo="' + item.tipo + '"][data-id="' + item.id + '"]');
        if (!yaEsta) {
            var pill = document.createElement('span');
            pill.className = 'tag-pill';
            pill.dataset.tipo = item.tipo; pill.dataset.id = item.id;
            var etiquetas = { libro: 'Libro: ', pelicula: 'Película: ', videojuego: 'Videojuego: ' };
            pill.textContent = (etiquetas[item.tipo] || '') + item.titulo + ' ';
            var x = document.createElement('b'); x.setAttribute('data-x', ''); x.textContent = '✕';
            pill.appendChild(x);
            refLista.appendChild(pill);
            sincronizarRefs();
        }
        box.querySelector('.ac-input').value = '';
    };
    refLista.addEventListener('click', function (e) {
        var x = e.target.closest('[data-x]'); if (!x) return;
        x.closest('.tag-pill').remove();
        sincronizarRefs();
    });
    sincronizarRefs();   // estado inicial (chips precargados al editar)
})();
</script>
