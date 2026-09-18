<div class="admin-head">
    <div>
        <h1>Proyectos</h1>
        <p>Slider del portafolio. Arrastra las filas para cambiar el orden.</p>
    </div>
    <a href="/" target="_blank" class="btn btn--ghost">Ver en el sitio ↗</a>
</div>

<?php
// La ficha pública se pinta siempre en el mismo orden: contexto, galería y
// después las secciones. El formulario va igual, y los números de la izquierda
// son los que se verán en la página (los recalcula el JS del final).
$ao_secs   = !empty($secciones) ? $secciones : [null];
$ao_hayCtx = trim((string) ($editando->contexto ?? '')) !== '';
$ao_hayGal = !empty($galeria);
// Contador vivo de bloques que SÍ se publican: el JS lo recalcula al escribir,
// pero lo que sale del servidor ya tiene que ser el número bueno (sin JS, y
// para no parpadear con un número equivocado en la primera pintada).
$ao_n   = ($ao_hayCtx ? 1 : 0) + ($ao_hayGal ? 1 : 0);
$ao_num = static fn($v) => str_pad((string) $v, 2, '0', STR_PAD_LEFT);
?>

<div class="card">
    <h2><?php echo $editando ? 'Editar proyecto' : 'Nuevo proyecto'; ?></h2>
    <p class="ficha-orden">La ficha se arma en este orden: <b>contexto</b>, <b>galería</b> y después las <b>secciones</b> que escribas.</p>

    <form method="POST" action="/admin/proyectos/guardar" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $editando->id ?? ''; ?>">

        <!-- Bloque sin número: la portada es el hero de la ficha y el resumen no
             se pinta en la página, así que no entran en la cuenta 01, 02, 03… -->
        <div class="form-section-title">Portada y datos</div>
        <div class="pel-form-grid proy-datos-grid">
            <div class="campo">
                <span>Portada <small style="color:var(--muted-2)">— horizontal 16:9</small></span>
                <div class="upload upload--stack upload--ancho">
                    <div class="upload-preview upload-preview--16x9" id="prev-portada">
                        <?php if (!empty($editando->img)) : ?><img src="<?php echo urlSubida('proyectos/portadas', $editando->img); ?>" alt=""><?php else : ?>Sin imagen<?php endif; ?>
                    </div>
                    <label class="upload-drop">
                        <b>Elige</b> o arrastra una imagen<br><small>PNG, JPG, WEBP · reemplaza la actual</small>
                        <input type="file" name="img_file" accept="image/*" data-preview="#prev-portada">
                    </label>
                </div>
            </div>
            <div class="form-grid proy-datos">
                <label class="campo">
                    <span>Título</span>
                    <input type="text" name="titulo" value="<?php echo s($editando->titulo ?? ''); ?>" required>
                </label>
                <label class="campo">
                    <span>Año</span>
                    <input type="text" name="anio" value="<?php echo s($editando->anio ?? ''); ?>" placeholder="2026">
                </label>
                <label class="campo full">
                    <span>Enlace del sitio <small style="color:var(--muted-2)">— si existe, la portada del hero lleva ahí</small></span>
                    <input type="url" name="enlace" value="<?php echo s($editando->enlace ?? ''); ?>" placeholder="https://…">
                </label>
                <!-- Ocupa el alto que sobra: su borde inferior cae con el de la
                     zona de subida de la portada y el bloque queda cuadrado. -->
                <label class="campo full proy-resumen">
                    <span>Resumen <small style="color:var(--muted-2)">— para buscadores; si lo dejas vacío se toma del contexto</small></span>
                    <textarea name="resumen" maxlength="255" placeholder="Una o dos frases sobre el proyecto"><?php echo s($editando->resumen ?? ''); ?></textarea>
                </label>
            </div>
        </div>

        <div class="form-section">
            <!-- El número es decorativo: quien usa lector de pantalla ya tiene el
                 orden en el propio orden del formulario, y «—» no se lee. -->
            <div class="form-section-title"><span class="ficha-num" id="num-contexto" aria-hidden="true"><?php echo $ao_hayCtx ? '01' : '—'; ?></span> Contexto</div>
            <label class="campo">
                <span>Abre la ficha <small style="color:var(--muted-2)">— deja una línea en blanco entre párrafos</small></span>
                <textarea name="contexto" id="campo-contexto" style="min-height:150px" placeholder="De qué iba el proyecto"><?php echo s($editando->contexto ?? ''); ?></textarea>
            </label>
        </div>

        <div class="form-section">
            <div class="form-section-title"><span class="ficha-num" id="num-galeria" aria-hidden="true"><?php echo $ao_hayGal ? $ao_num($ao_hayCtx ? 2 : 1) : '—'; ?></span> Galería</div>
            <div class="campo">
                <span>Capturas de la página interna <small style="color:var(--muted-2)">— la primera va a sangre y el resto en dos columnas</small></span>
                <label class="upload-drop" style="display:block">
                    <b>Elige</b> o arrastra <b>varias</b> imágenes<br><small>PNG, JPG, WEBP · se añaden al guardar</small>
                    <input type="file" name="galeria_files[]" accept="image/*" multiple id="galeria-input">
                </label>
                <div id="galeria-preview" class="galeria-preview"></div>
            </div>
            <?php if ($editando && !empty($galeria)) : ?>
                <div class="galeria" id="galeria-actual" data-sortable data-orden-url="/admin/proyectos/imagen/orden">
                    <?php foreach ($galeria as $g) : ?>
                        <div class="galeria-item" draggable="true" data-id="<?php echo $g->id; ?>">
                            <span class="galeria-drag" title="Arrastrar">⠿</span>
                            <img src="<?php echo urlSubida('proyectos/galeria', $g->img); ?>" alt="">
                            <!-- El borrado cuelga del formulario del final: dentro de otro
                                 formulario no se puede anidar uno. -->
                            <button class="del" type="submit" form="borrar-imagen" name="id" value="<?php echo $g->id; ?>" title="Quitar">✕</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Quitar recarga la página (es otro POST): hay que avisarlo o se
                     pierde lo escrito en el resto del formulario sin guardar. -->
                <span class="mini-s" style="color:var(--muted)">Arrastra las miniaturas para cambiar su orden. Quitar una imagen recarga la página: guarda antes lo que hayas escrito.</span>
            <?php endif; ?>
        </div>

        <div class="form-section">
            <div class="form-section-title">Secciones <small style="color:var(--muted-2);text-transform:none;letter-spacing:0">— con el título que quieras</small></div>
            <div class="campo filas-repetibles" id="secciones-lista">
                <?php foreach ($ao_secs as $ao_ix => $ao_sec) :
                    // Una sección sin título ni cuerpo no se guarda (ProyectoSeccion::reemplazar)
                    // y por tanto no se publica: no gasta número.
                    $ao_vacia = trim((string) ($ao_sec->titulo ?? '')) === '' && trim((string) ($ao_sec->cuerpo ?? '')) === '';
                    if (!$ao_vacia) $ao_n++;
                    $ao_pos = $ao_ix + 1;
                ?>
                    <div class="fila-rep fila-rep--seccion<?php echo $ao_vacia ? ' is-vacia' : ''; ?>">
                        <span class="ficha-num sec-num" aria-hidden="true"><?php echo $ao_vacia ? '—' : $ao_num($ao_n); ?></span>
                        <input type="text" name="sec_titulo[]" value="<?php echo s($ao_sec->titulo ?? ''); ?>" aria-label="Título de la sección <?php echo $ao_pos; ?>" placeholder="Título de la sección">
                        <div class="fila-rep-acciones">
                            <button type="button" class="btn btn--sm btn--ghost" data-mover="-1" title="Subir" aria-label="Subir la sección <?php echo $ao_pos; ?>"<?php echo $ao_ix === 0 ? ' aria-disabled="true"' : ''; ?>><?php echo icono('arriba'); ?></button>
                            <button type="button" class="btn btn--sm btn--ghost" data-mover="1" title="Bajar" aria-label="Bajar la sección <?php echo $ao_pos; ?>"<?php echo $ao_ix === count($ao_secs) - 1 ? ' aria-disabled="true"' : ''; ?>><?php echo icono('abajo'); ?></button>
                            <button type="button" class="btn btn--sm btn--ghost fila-rep-quitar" title="Quitar" aria-label="Quitar la sección <?php echo $ao_pos; ?>"><?php echo icono('trash'); ?></button>
                        </div>
                        <textarea name="sec_cuerpo[]" aria-label="Cuerpo de la sección <?php echo $ao_pos; ?>" placeholder="Descripción"><?php echo s($ao_sec->cuerpo ?? ''); ?></textarea>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn--sm btn--ghost" id="agregar-seccion">+ Añadir sección</button>
            <!-- Mover una fila no cambia el nombre de ningún control y el número es
                 decorativo: sin este aviso, con lector de pantalla no pasa nada. -->
            <p class="oculto-visual" id="secciones-aviso" role="status" aria-live="polite"></p>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn--primary"><?php echo $editando ? 'Guardar cambios' : 'Crear proyecto'; ?></button>
            <?php if ($editando) : ?><a href="/admin/proyectos" class="btn btn--ghost">Cancelar</a><?php endif; ?>
        </div>
    </form>

    <?php if ($editando && !empty($galeria)) : ?>
        <form id="borrar-imagen" method="POST" action="/admin/proyectos/imagen/eliminar" hidden></form>
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
        numerar();
    });

    var lista = document.getElementById('secciones-lista');
    var ctx   = document.getElementById('campo-contexto');
    var aviso = document.getElementById('secciones-aviso');
    if (!lista) return;

    function pad(n) { return n < 10 ? '0' + n : '' + n; }
    function filas() { return [].slice.call(lista.querySelectorAll('.fila-rep--seccion')); }
    // Lo que en pantalla cuenta el número o el borde punteado, aquí se dice
    function avisar(txt) { if (aviso) aviso.textContent = txt; }

    // Los números del formulario son los que se verán en la ficha: un bloque
    // vacío no se pinta, así que no gasta número. De paso se mantienen los
    // nombres accesibles (posición en la lista) y qué botón no puede mover.
    function numerar() {
        var n = 0;
        var hayCtx = ctx && ctx.value.trim() !== '';
        var hayGal = !!document.querySelector('#galeria-actual .galeria-item') || (inp && inp.files.length > 0);
        var nCtx = document.getElementById('num-contexto'), nGal = document.getElementById('num-galeria');
        if (nCtx) nCtx.textContent = hayCtx ? pad(++n) : '—';
        if (nGal) nGal.textContent = hayGal ? pad(++n) : '—';
        var todas = filas();
        todas.forEach(function (fila, i) {
            var vacia = !fila.querySelector('input').value.trim() && !fila.querySelector('textarea').value.trim();
            fila.querySelector('.sec-num').textContent = vacia ? '—' : pad(++n);
            fila.classList.toggle('is-vacia', vacia);

            var pos = i + 1;
            rotular(fila, 'input', 'Título de la sección ' + pos);
            rotular(fila, 'textarea', 'Cuerpo de la sección ' + pos);
            rotular(fila, '[data-mover="-1"]', 'Subir la sección ' + pos, i === 0);
            rotular(fila, '[data-mover="1"]', 'Bajar la sección ' + pos, i === todas.length - 1);
            rotular(fila, '.fila-rep-quitar', 'Quitar la sección ' + pos);
        });
    }

    // aria-disabled y no disabled: el botón tiene que seguir enfocable o el
    // foco se cae al body justo al mover una fila al primer/último puesto.
    function rotular(fila, sel, etiqueta, apagado) {
        var el = fila.querySelector(sel); if (!el) return;
        el.setAttribute('aria-label', etiqueta);
        if (apagado === undefined) return;
        el.setAttribute('aria-disabled', apagado ? 'true' : 'false');
    }

    if (ctx) ctx.addEventListener('input', numerar);
    lista.addEventListener('input', numerar);

    document.getElementById('agregar-seccion').addEventListener('click', function () {
        var fila = lista.querySelector('.fila-rep--seccion').cloneNode(true);
        fila.querySelectorAll('input, textarea').forEach(function (c) { c.value = ''; });
        lista.appendChild(fila);
        numerar();
        fila.querySelector('input').focus();
        avisar('Sección añadida al final. Ahora hay ' + filas().length + '.');
    });

    lista.addEventListener('click', function (e) {
        var fila = e.target.closest('.fila-rep--seccion'); if (!fila) return;

        var mover = e.target.closest('[data-mover]');
        if (mover) {
            var dir = parseInt(mover.dataset.mover, 10);
            var otra = dir < 0 ? fila.previousElementSibling : fila.nextElementSibling;
            if (otra) {
                lista.insertBefore(dir < 0 ? fila : otra, dir < 0 ? otra : fila);
                numerar();
                fila.querySelector('[data-mover="' + dir + '"]').focus();
                var todas = filas();
                avisar('Sección movida a la posición ' + (todas.indexOf(fila) + 1) + ' de ' + todas.length + '.');
            }
            return;
        }

        if (e.target.closest('.fila-rep-quitar')) {
            if (filas().length > 1) {
                // El botón pulsado se va con la fila: el foco pasa al mismo botón
                // de la vecina (o al de añadir si ya no queda ninguno visible).
                var vecina = fila.nextElementSibling || fila.previousElementSibling;
                fila.remove();
                numerar();
                var quedan = filas().length;
                var destino = (quedan > 1 && vecina) ? vecina.querySelector('.fila-rep-quitar') : document.getElementById('agregar-seccion');
                if (destino) destino.focus();
                avisar('Sección quitada. Quedan ' + quedan + '.');
            } else {
                fila.querySelectorAll('input, textarea').forEach(function (c) { c.value = ''; });
                numerar();
                fila.querySelector('input').focus();
                avisar('Sección vaciada.');
            }
        }
    });

    numerar();
})();
</script>

<div class="card">
    <div class="card-head"><h2>Listado (<?php echo count($proyectos); ?>)</h2><span class="mini-s" style="color:var(--muted)">↕ arrastra para reordenar</span></div>
    <div class="tabla-wrap tabla-wrap--cards">
        <table class="tabla tabla--cards">
            <thead><tr><th></th><th>Portada</th><th>Título</th><th>Año</th><th>Acciones</th></tr></thead>
            <tbody data-sortable data-orden-url="/admin/proyectos/orden">
            <?php foreach ($proyectos as $p) : ?>
                <tr class="sortable-row" draggable="true" data-id="<?php echo $p->id; ?>">
                    <td class="cell-arrastre" data-label=""><span class="drag-handle">⠿</span></td>
                    <td class="cell-portada" data-label=""><img class="thumb-cell" src="<?php echo urlSubida('proyectos/portadas', $p->img); ?>" alt="" onerror="this.style.visibility='hidden'"></td>
                    <td class="cell-titulo" data-label="Título"><?php echo s($p->titulo); ?></td>
                    <td data-label="Año"><?php echo s($p->anio); ?></td>
                    <td class="acciones" data-label="Acciones">
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
