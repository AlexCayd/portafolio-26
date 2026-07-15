<div class="admin-head">
    <div>
        <h1>Proyectos</h1>
        <p>Slider del portafolio. Arrastra las filas para cambiar el orden.</p>
    </div>
    <a href="/" target="_blank" class="btn btn--ghost">Ver en el sitio ↗</a>
</div>

<div class="card">
    <h2><?php echo $editando ? 'Editar proyecto' : 'Nuevo proyecto'; ?></h2>
    <form method="POST" action="/admin/proyectos/guardar" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $editando->id ?? ''; ?>">
        <div style="display:grid;grid-template-columns:380px 1fr;gap:26px;align-items:start" class="pel-form-grid">
            <div class="campo">
                <span>Portada (horizontal 16:9)</span>
                <div class="upload upload--stack" style="max-width:380px">
                    <div class="upload-preview" id="prev-portada" style="width:100%;aspect-ratio:16/9;height:auto">
                        <?php if (!empty($editando->img)) : ?><img src="/build/img/proyectos/portadas/<?php echo s($editando->img); ?>" alt="" style="object-fit:cover"><?php else : ?>Sin imagen<?php endif; ?>
                    </div>
                    <label class="upload-drop">
                        <b>Elige</b> o arrastra una imagen<br><small>PNG, JPG, WEBP · reemplaza la actual</small>
                        <input type="file" name="img_file" accept="image/*" data-preview="#prev-portada">
                    </label>
                </div>
            </div>
            <div class="form-grid" style="grid-template-columns:2fr 1fr">
                <label class="campo">
                    <span>Título</span>
                    <input type="text" name="titulo" value="<?php echo s($editando->titulo ?? ''); ?>" required>
                </label>
                <label class="campo">
                    <span>Año</span>
                    <input type="text" name="anio" value="<?php echo s($editando->anio ?? ''); ?>" placeholder="2026">
                </label>
                <label class="campo full">
                    <span>Descripción</span>
                    <textarea name="descripcion" style="min-height:120px"><?php echo s($editando->descripcion ?? ''); ?></textarea>
                </label>
                <div class="campo full">
                    <span>Galería de la página interna (varias imágenes)</span>
                    <label class="upload-drop" style="display:block">
                        <b>Elige</b> o arrastra <b>varias</b> imágenes<br><small>PNG, JPG, WEBP · se añaden al guardar</small>
                        <input type="file" name="galeria_files[]" accept="image/*" multiple id="galeria-input">
                    </label>
                    <div id="galeria-preview" class="galeria-preview"></div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn--primary"><?php echo $editando ? 'Guardar cambios' : 'Crear proyecto'; ?></button>
            <?php if ($editando) : ?><a href="/admin/proyectos" class="btn btn--ghost">Cancelar</a><?php endif; ?>
        </div>
    </form>

    <?php if ($editando && !empty($galeria)) : ?>
        <div class="form-section">
            <div class="form-section-title">Imágenes actuales <small style="color:var(--muted-2);font-weight:400">— arrastra para reordenar</small></div>
            <div class="galeria" data-sortable data-orden-url="/admin/proyectos/imagen/orden">
                <?php foreach ($galeria as $g) : ?>
                    <div class="galeria-item" draggable="true" data-id="<?php echo $g->id; ?>">
                        <span class="galeria-drag" title="Arrastrar">⠿</span>
                        <img src="/build/img/proyectos/galeria/<?php echo s($g->img); ?>" alt="">
                        <form method="POST" action="/admin/proyectos/imagen/eliminar">
                            <input type="hidden" name="id" value="<?php echo $g->id; ?>">
                            <button class="del" title="Quitar">✕</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
(function () {
    // Vista previa de las imágenes seleccionadas (antes de guardar)
    var inp = document.getElementById('galeria-input'), prev = document.getElementById('galeria-preview');
    if (inp && prev) inp.addEventListener('change', function () {
        prev.innerHTML = '';
        Array.prototype.forEach.call(inp.files, function (f) {
            if (!/^image\//.test(f.type)) return;
            var im = document.createElement('img'); im.className = 'gp-thumb'; im.src = URL.createObjectURL(f);
            im.onload = function () { URL.revokeObjectURL(im.src); };
            prev.appendChild(im);
        });
        if (inp.files.length) {
            var t = document.createElement('span'); t.className = 'mini-s gp-count'; t.textContent = inp.files.length + ' nueva(s) — se añaden al guardar';
            prev.appendChild(t);
        }
    });
})();
</script>

<div class="card">
    <div class="card-head"><h2>Listado (<?php echo count($proyectos); ?>)</h2><span class="mini-s" style="color:var(--muted)">↕ arrastra para reordenar</span></div>
    <div class="tabla-wrap">
        <table class="tabla">
            <thead><tr><th></th><th>Portada</th><th>Título</th><th>Año</th><th>Acciones</th></tr></thead>
            <tbody data-sortable data-orden-url="/admin/proyectos/orden">
            <?php foreach ($proyectos as $p) : ?>
                <tr class="sortable-row" draggable="true" data-id="<?php echo $p->id; ?>">
                    <td><span class="drag-handle">⠿</span></td>
                    <td><img class="thumb-cell" src="/build/img/proyectos/portadas/<?php echo s($p->img); ?>" alt="" onerror="this.style.visibility='hidden'"></td>
                    <td><?php echo s($p->titulo); ?></td>
                    <td><?php echo s($p->anio); ?></td>
                    <td class="acciones">
                        <a href="/admin/proyectos?id=<?php echo $p->id; ?>" class="act-btn act-edit" title="Editar"><?php echo icono('editar'); ?></a>
                        <form method="POST" action="/admin/proyectos/eliminar" data-confirm="Esto eliminará el proyecto y sus imágenes." data-confirm-name="<?php echo s($p->titulo); ?>">
                            <input type="hidden" name="id" value="<?php echo $p->id; ?>">
                            <button class="act-btn act-del" title="Eliminar"><?php echo icono('eliminar'); ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($proyectos)) : ?><tr><td colspan="5" style="color:var(--muted)">Sin proyectos todavía.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
