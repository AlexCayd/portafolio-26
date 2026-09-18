<div class="admin-head">
    <div>
        <h1>Credenciales</h1>
        <p>Sección «La curiosidad, certificada». Arrastra para reordenar o usa el orden automático.</p>
    </div>
    <a href="/#ao-formacion" target="_blank" class="btn btn--ghost">Ver en el sitio ↗</a>
</div>

<div class="card">
    <h2><?php echo $editando ? 'Editar credencial' : 'Nueva credencial'; ?></h2>
    <form method="POST" action="/admin/credenciales/guardar" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $editando->id ?? ''; ?>">
        <div class="pel-form-grid pel-form-grid--logo">
            <div class="campo">
                <span>Logo de la institución</span>
                <div class="upload upload--stack upload--logo">
                    <div class="upload-preview logo upload-preview--alto" id="prev-logo">
                        <?php if (!empty($editando->logo)) : ?><img src="<?php echo urlSubida('logos', $editando->logo); ?>" alt=""><?php else : ?>Sin logo<?php endif; ?>
                    </div>
                    <label class="upload-drop">
                        <b>Elige</b> o arrastra el logo<br><small>PNG, JPG, SVG, WEBP</small>
                        <input type="file" name="logo_file" accept="image/*" data-preview="#prev-logo">
                    </label>
                </div>
            </div>
            <div class="form-grid" style="align-content:center">
                <label class="campo full">
                    <span>Título</span>
                    <input type="text" name="titulo" value="<?php echo s($editando->titulo ?? ''); ?>" required>
                </label>
                <label class="campo">
                    <span>Institución</span>
                    <input type="text" name="institucion" value="<?php echo s($editando->institucion ?? ''); ?>">
                </label>
                <label class="campo">
                    <span>Año</span>
                    <input type="number" name="anio" min="1990" max="2100" value="<?php echo s($editando->anio ?? ''); ?>" placeholder="<?php echo date('Y'); ?>">
                </label>
                <label class="campo full">
                    <span>Texto alternativo (logo) <small style="color:var(--muted-2)">— para accesibilidad</small></span>
                    <input type="text" name="alt" value="<?php echo s($editando->alt ?? ''); ?>" placeholder="Google">
                </label>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn--primary"><?php echo $editando ? 'Guardar cambios' : 'Crear credencial'; ?></button>
            <?php if ($editando) : ?><a href="/admin/credenciales" class="btn btn--ghost">Cancelar</a><?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-head">
        <h2>Listado (<?php echo count($credenciales); ?>)</h2>
        <div class="acciones">
            <form method="POST" action="/admin/credenciales/orden-alfa"><button class="btn btn--sm">Ordenar A–Z</button></form>
            <form method="POST" action="/admin/credenciales/orden-crono"><button class="btn btn--sm">Ordenar por año</button></form>
        </div>
    </div>
    <div class="tabla-wrap tabla-wrap--cards">
        <table class="tabla tabla--cards">
            <thead><tr><th></th><th>Logo</th><th>Título</th><th>Institución</th><th>Año</th><th>Acciones</th></tr></thead>
            <tbody data-sortable data-orden-url="/admin/credenciales/orden">
            <?php foreach ($credenciales as $c) : ?>
                <tr class="sortable-row" draggable="true" data-id="<?php echo $c->id; ?>">
                    <td class="cell-arrastre" data-label=""><span class="drag-handle">⠿</span></td>
                    <td class="cell-portada" data-label=""><img class="logo-cell" src="<?php echo urlSubida('logos', $c->logo); ?>" alt="" onerror="this.style.visibility='hidden'"></td>
                    <td class="cell-titulo" data-label="Título"><?php echo s($c->titulo); ?></td>
                    <td data-label="Institución" style="color:var(--muted)"><?php echo s($c->institucion); ?></td>
                    <td data-label="Año" style="font-family:var(--mono)"><?php echo s($c->anio); ?></td>
                    <td class="acciones" data-label="Acciones">
                        <a href="/admin/credenciales?id=<?php echo $c->id; ?>" class="act-btn act-edit" title="Editar"><?php echo icono('editar'); ?></a>
                        <form method="POST" action="/admin/credenciales/eliminar" data-confirm="Se eliminará esta credencial." data-confirm-name="<?php echo s($c->titulo); ?>">
                            <input type="hidden" name="id" value="<?php echo $c->id; ?>">
                            <button class="act-btn act-del" title="Eliminar"><?php echo icono('eliminar'); ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($credenciales)) : ?><tr><td colspan="6" style="color:var(--muted)">Sin credenciales todavía.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
