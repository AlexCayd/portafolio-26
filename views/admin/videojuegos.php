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
        <div class="campo" style="display:block">
            <span>Portada <small style="color:var(--muted-2)">— opcional</small></span>
            <div class="upload upload--vj" style="margin-top:8px">
                <div class="upload-preview vj-prev" id="prev-portada">
                    <?php if (!empty($editando->portada)) : ?><img src="/build/img/videojuegos/<?php echo s($editando->portada); ?>" alt=""><?php else : ?><span class="vj-ph-ico"><?php echo icono('videojuegos'); ?></span><?php endif; ?>
                </div>
                <label class="upload-drop"><b>Elige</b> o arrastra la portada<br><small>JPG, PNG, WEBP</small><input type="file" name="portada_file" accept="image/*" data-preview="#prev-portada"></label>
            </div>
        </div>
        <div class="form-grid" style="margin-top:16px">
            <label class="campo full"><span>Nombre</span><input type="text" name="nombre" value="<?php echo s($editando->nombre ?? ''); ?>" required></label>
            <label class="campo"><span>Horas iniciales</span><input type="number" step="0.1" name="horas_iniciales" value="<?php echo s($editando->horas_iniciales ?? '0'); ?>"></label>
            <label class="campo"><span>Horas totales <small style="color:var(--muted-2)">(opcional)</small></span><input type="number" step="0.1" name="horas_totales" value="<?php echo s($editando->horas_totales ?? ''); ?>"></label>
            <p class="campo full mini-s" style="color:var(--muted-2);margin:0">«Horas 2026» se calcula solo (totales − iniciales). La posición se ajusta arrastrando en la lista.</p>
        </div>
        <div class="form-actions">
            <button class="btn btn--primary"><?php echo $editando ? 'Guardar cambios' : 'Agregar'; ?></button>
            <?php if ($editando) : ?><a href="/admin/videojuegos" class="btn btn--ghost">Cancelar</a><?php endif; ?>
        </div>
    </form>
</div>

<?php
    // Galería ordenada por horas jugadas en 2026 (desc); los que no tienen totales van al final.
    $galeria = $videojuegos;
    usort($galeria, function ($a, $b) {
        $ha = $a->horas2026(); $hb = $b->horas2026();
        if ($ha === null && $hb === null) return 0;
        if ($ha === null) return 1;
        if ($hb === null) return -1;
        return $hb <=> $ha;
    });
?>
<?php if (!empty($galeria)) : ?>
<div class="card">
    <div class="card-head"><h2>Galería</h2><span class="mini-s" style="color:var(--muted)">ordenada por horas jugadas en 2026</span></div>
    <div class="vj-galeria">
        <?php foreach ($galeria as $vj) : $h = $vj->horas2026(); ?>
            <a class="vj-poster" href="/admin/videojuegos?id=<?php echo $vj->id; ?>" title="Editar <?php echo s($vj->nombre); ?>">
                <div class="vj-poster-img">
                    <?php if (!empty($vj->portada)) : ?><img src="/build/img/videojuegos/<?php echo s($vj->portada); ?>" alt="" loading="lazy">
                    <?php else : ?><span class="vj-ph-ico"><?php echo icono('videojuegos'); ?></span><?php endif; ?>
                    <span class="vj-poster-h <?php echo ($h !== null && $h < 0) ? 'neg' : ($h === null ? 'na' : ''); ?>">
                        <?php echo $h === null ? '—' : rtrim(rtrim(number_format($h, 1), '0'), '.') . ' h'; ?>
                    </span>
                </div>
                <span class="vj-poster-nombre"><?php echo s($vj->nombre); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

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
