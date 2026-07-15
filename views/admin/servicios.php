<div class="admin-head">
    <div>
        <h1>Servicios</h1>
        <p>Sección «Del problema al producto». El número se asigna solo por la posición. Arrastra para reordenar.</p>
    </div>
    <a href="/#ao-expertise" target="_blank" class="btn btn--ghost">Ver en el sitio ↗</a>
</div>

<div class="card">
    <h2><?php echo $editando ? 'Editar servicio' : 'Nuevo servicio'; ?></h2>
    <form method="POST" action="/admin/servicios/guardar">
        <input type="hidden" name="id" value="<?php echo $editando->id ?? ''; ?>">
        <div class="form-grid">
            <label class="campo full">
                <span>Título</span>
                <input type="text" name="titulo" value="<?php echo s($editando->titulo ?? ''); ?>" required>
            </label>
            <label class="campo full">
                <span>Descripción</span>
                <textarea name="descripcion" required><?php echo s($editando->descripcion ?? ''); ?></textarea>
            </label>
            <div class="campo full">
                <span>Tags <small style="color:var(--muted-2)">— escribe y presiona coma para crear un pill</small></span>
                <div class="tag-input" data-input="#tags-hidden">
                    <input type="text" class="tag-field" placeholder="Front-end, Responsive…">
                </div>
                <input type="hidden" name="tags" id="tags-hidden" value="<?php echo s($editando->tags ?? ''); ?>">
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn--primary"><?php echo $editando ? 'Guardar cambios' : 'Crear servicio'; ?></button>
            <?php if ($editando) : ?><a href="/admin/servicios" class="btn btn--ghost">Cancelar</a><?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-head"><h2>Listado (<?php echo count($servicios); ?>)</h2><span class="mini-s" style="color:var(--muted)">↕ arrastra para reordenar</span></div>
    <div class="tabla-wrap">
        <table class="tabla">
            <thead><tr><th></th><th>#</th><th>Título</th><th>Tags</th><th>Acciones</th></tr></thead>
            <tbody data-sortable data-orden-url="/admin/servicios/orden">
            <?php foreach ($servicios as $i => $sv) : ?>
                <tr class="sortable-row" draggable="true" data-id="<?php echo $sv->id; ?>">
                    <td><span class="drag-handle">⠿</span></td>
                    <td class="num-cell" data-num="pad2" style="font-family:var(--mono);color:var(--muted)"><?php echo sprintf('%02d', $i + 1); ?></td>
                    <td><?php echo s($sv->titulo); ?></td>
                    <td style="color:var(--muted)"><?php echo s(str_replace(',', ', ', $sv->tags)); ?></td>
                    <td class="acciones">
                        <a href="/admin/servicios?id=<?php echo $sv->id; ?>" class="act-btn act-edit" title="Editar"><?php echo icono('editar'); ?></a>
                        <form method="POST" action="/admin/servicios/eliminar" data-confirm="Se eliminará este servicio." data-confirm-name="<?php echo s($sv->titulo); ?>">
                            <input type="hidden" name="id" value="<?php echo $sv->id; ?>">
                            <button class="act-btn act-del" title="Eliminar"><?php echo icono('eliminar'); ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($servicios)) : ?><tr><td colspan="5" style="color:var(--muted)">Sin servicios todavía.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
