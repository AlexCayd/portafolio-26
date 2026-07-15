<div class="admin-head">
    <div>
        <h1>Videojuegos</h1>
        <p>«Horas 2026» se calcula solo (totales − iniciales). La posición es el orden de la lista — arrastra para cambiarla.</p>
    </div>
</div>

<div class="card">
    <h2><?php echo $editando ? 'Editar videojuego' : 'Nuevo videojuego'; ?></h2>
    <form method="POST" action="/admin/videojuegos/guardar" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $editando->id ?? ''; ?>">
        <div class="pel-form-grid" style="grid-template-columns:200px 1fr">
            <div class="campo">
                <span>Portada <small style="color:var(--muted-2)">— opcional</small></span>
                <div class="upload upload--stack" style="max-width:200px">
                    <div class="upload-preview" id="prev-portada" style="width:100%;aspect-ratio:3/4;height:auto">
                        <?php if (!empty($editando->portada)) : ?><img src="/build/img/videojuegos/<?php echo s($editando->portada); ?>" alt="" style="object-fit:cover"><?php else : ?><span class="vj-ph-ico"><?php echo icono('videojuegos'); ?></span><?php endif; ?>
                    </div>
                    <label class="upload-drop"><b>Elige</b> o arrastra la portada<br><small>JPG, PNG, WEBP</small><input type="file" name="portada_file" accept="image/*" data-preview="#prev-portada"></label>
                </div>
            </div>
            <div class="form-grid">
                <label class="campo full"><span>Nombre</span><input type="text" name="nombre" value="<?php echo s($editando->nombre ?? ''); ?>" required></label>
                <label class="campo"><span>Horas iniciales</span><input type="number" step="0.1" name="horas_iniciales" value="<?php echo s($editando->horas_iniciales ?? '0'); ?>"></label>
                <label class="campo"><span>Horas totales <small style="color:var(--muted-2)">(opcional)</small></span><input type="number" step="0.1" name="horas_totales" value="<?php echo s($editando->horas_totales ?? ''); ?>"></label>
                <p class="campo full mini-s" style="color:var(--muted-2);margin:0">«Horas 2026» se calcula solo (totales − iniciales). La posición se ajusta arrastrando en la lista.</p>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn--primary"><?php echo $editando ? 'Guardar cambios' : 'Agregar'; ?></button>
            <?php if ($editando) : ?><a href="/admin/videojuegos" class="btn btn--ghost">Cancelar</a><?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-head"><h2>Lista (<?php echo count($videojuegos); ?>)</h2><span class="mini-s" style="color:var(--muted)">↕ arrastra para reordenar</span></div>
    <div class="tabla-wrap">
        <table class="tabla">
            <thead><tr><th></th><th>Posición</th><th>Portada</th><th>Nombre</th><th>Horas iniciales</th><th>Horas totales</th><th>Horas 2026</th><th>Acciones</th></tr></thead>
            <tbody data-sortable data-orden-url="/admin/videojuegos/orden">
            <?php foreach ($videojuegos as $i => $vj) : $h = $vj->horas2026(); ?>
                <tr class="sortable-row" draggable="true" data-id="<?php echo $vj->id; ?>">
                    <td><span class="drag-handle">⠿</span></td>
                    <td class="num-cell"><?php echo $i + 1; ?></td>
                    <td><?php if (!empty($vj->portada)) : ?><img class="vj-thumb" src="/build/img/videojuegos/<?php echo s($vj->portada); ?>" alt=""><?php else : ?><div class="vj-thumb vj-thumb--ph"><?php echo icono('videojuegos'); ?></div><?php endif; ?></td>
                    <td><?php echo s($vj->nombre); ?></td>
                    <td><?php echo rtrim(rtrim(number_format((float)$vj->horas_iniciales, 1), '0'), '.'); ?></td>
                    <td><?php echo $vj->horas_totales !== null ? rtrim(rtrim(number_format((float)$vj->horas_totales, 1), '0'), '.') : '—'; ?></td>
                    <td>
                        <?php if ($h === null) : ?><span class="vj-2026 na">—</span>
                        <?php else : ?><span class="vj-2026 <?php echo $h < 0 ? 'neg' : ''; ?>"><?php echo rtrim(rtrim(number_format($h, 1), '0'), '.'); ?></span><?php endif; ?>
                    </td>
                    <td class="acciones">
                        <a href="/admin/videojuegos?id=<?php echo $vj->id; ?>" class="act-btn act-edit" title="Editar"><?php echo icono('editar'); ?></a>
                        <form method="POST" action="/admin/videojuegos/eliminar" data-confirm="Se eliminará este videojuego." data-confirm-name="<?php echo s($vj->nombre); ?>">
                            <input type="hidden" name="id" value="<?php echo $vj->id; ?>">
                            <button class="act-btn act-del" title="Eliminar"><?php echo icono('eliminar'); ?></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($videojuegos)) : ?><tr><td colspan="8" style="color:var(--muted)">Sin videojuegos todavía.</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
