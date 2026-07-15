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
        <div style="display:grid;grid-template-columns:220px 1fr;gap:26px;align-items:stretch" class="pel-form-grid">
            <div class="campo" style="display:flex;flex-direction:column">
                <span>Logo de la institución</span>
                <div class="upload upload--stack" style="max-width:220px;flex:1;display:flex;flex-direction:column">
                    <div class="upload-preview logo" id="prev-logo" style="width:100%;flex:1;min-height:150px">
                        <?php if (!empty($editando->logo)) : ?><img src="/build/img/logos/<?php echo s($editando->logo); ?>" alt=""><?php else : ?>Sin logo<?php endif; ?>
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
    <div class="tabla-wrap">
        <table class="tabla">
            <thead><tr><th></th><th>Logo</th><th>Título</th><th>Institución</th><th>Año</th><th>Acciones</th></tr></thead>
            <tbody data-sortable data-orden-url="/admin/credenciales/orden">
            <?php foreach ($credenciales as $c) : ?>
                <tr class="sortable-row" draggable="true" data-id="<?php echo $c->id; ?>">
                    <td><span class="drag-handle">⠿</span></td>
                    <td><img class="logo-cell" src="/build/img/logos/<?php echo s($c->logo); ?>" alt="" onerror="this.style.visibility='hidden'"></td>
                    <td><?php echo s($c->titulo); ?></td>
                    <td style="color:var(--muted)"><?php echo s($c->institucion); ?></td>
                    <td style="font-family:var(--mono)"><?php echo s($c->anio); ?></td>
                    <td class="acciones">
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
