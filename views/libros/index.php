<div class="admin-head">
    <div>
        <h1>Libros</h1>
        <p><strong>Un click</strong> marca completado · <strong>doble click</strong> abre la ficha. Los libros pasan a leídos cuando completas el <strong>primero</strong> de la lista.</p>
    </div>
</div>

<div class="card">
    <h2>Agregar libro pendiente</h2>
    <form method="POST" action="/admin/libros/crear">
        <div class="form-grid">
            <label class="campo"><span>Título</span><input type="text" name="titulo" required></label>
            <label class="campo"><span>Autor</span><input type="text" name="autor"></label>
        </div>
        <div class="form-actions"><button class="btn btn--primary">Agregar a pendientes</button></div>
    </form>
</div>

<div class="card">
    <h2>Buscar libro</h2>
    <p class="mini-s" style="color:var(--muted);margin:-6px 0 12px">Localiza un título en cualquier columna y descubre su posición.</p>
    <div class="libro-buscar">
        <div class="libro-buscar-field">
            <span class="libro-buscar-ic"><?php echo icono('buscar'); ?></span>
            <input type="search" id="libro-q" placeholder="Título o autor..." autocomplete="off">
        </div>
        <div class="libro-buscar-res" id="libro-q-res"></div>
    </div>
</div>

<?php
/**
 * Cada registro lleva sus datos en data-*: la ficha se edita en una sola modal
 * que se puebla al abrirla, en vez de repetir un formulario oculto por libro.
 */
$ao_datos = function ($l, $pos, $esLeido) {
    return ' data-id="' . (int) $l->id . '"'
        . ' data-titulo="' . s($l->titulo) . '"'
        . ' data-autor="' . s($l->autor) . '"'
        . ' data-estrellas="' . (float) $l->estrellas . '"'
        . ' data-comentario="' . s($l->comentario) . '"'
        . ' data-fecha="' . ($l->fecha_leido ? date('d/m/Y', strtotime($l->fecha_leido)) : '') . '"'
        . ' data-completado="' . ((int) $l->completado ? '1' : '0') . '"'
        . ' data-leido="' . ($esLeido ? '1' : '0') . '"'
        . ' data-pos="' . (int) $pos . '"';
};
?>

<div class="libros-cols">
    <!-- PENDIENTES -->
    <section class="libros-col">
        <h2>Pendientes <span class="conteo"><?php echo count($pendientes); ?></span></h2>
        <ul class="libro-lista" id="lista-pendientes">
            <?php foreach ($pendientes as $idx => $l) : $tienePend = $l->estrellas !== null && (float)$l->estrellas > 0; ?>
                <li class="libro libro-item is-editable<?php echo $l->completado ? ' is-completado' : ''; ?>" id="libro-<?php echo $l->id; ?>"<?php echo $ao_datos($l, $idx + 1, false); ?>>
                    <span class="pos"><?php echo $idx + 1; ?></span>
                    <div class="libro-info">
                        <div class="leido-head">
                            <div class="leido-main">
                                <div class="libro-titulo"><?php echo s($l->titulo); ?></div>
                                <div class="libro-autor"><?php echo s($l->autor); ?></div>
                            </div>
                            <?php if ($l->completado) : /* Completado: se muestra su reseña igual que en Leídos */ ?>
                                <div class="leido-meta">
                                    <?php if ($tienePend) : ?>
                                        <span class="leido-stars-static"><?php
                                            echo estrellasHtml((float)$l->estrellas);
                                            echo '<span class="leido-stars-num">' . number_format((float)$l->estrellas, 1) . '</span>';
                                        ?></span>
                                    <?php else : ?><span class="sin-resena">Sin reseña</span><?php endif; ?>
                                    <span class="leido-fecha"><?php echo icono('calendario'); ?><?php echo $l->fecha_leido ? date('d/m/Y', strtotime($l->fecha_leido)) : 'Sin fecha'; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <span class="check"><?php echo icono('ok'); ?></span>
                </li>
            <?php endforeach; ?>
            <?php if (empty($pendientes)) : ?><li style="color:var(--muted)">Sin pendientes.</li><?php endif; ?>
        </ul>
    </section>

    <!-- LEÍDOS -->
    <section class="libros-col" id="col-leidos">
        <h2>Leídos <span class="conteo"><?php echo $totalLeidos; ?></span></h2>
        <ul class="libro-lista" id="lista-leidos">
            <?php foreach ($leidos as $idx => $l) : $tiene = $l->estrellas !== null && (float)$l->estrellas > 0; ?>
                <li class="libro libro-item leido is-editable" id="libro-<?php echo $l->id; ?>"<?php echo $ao_datos($l, $inicioLeido + $idx + 1, true); ?>>
                    <span class="pos"><?php echo $inicioLeido + $idx + 1; ?></span>
                    <div class="libro-info">
                        <div class="leido-head">
                            <div class="leido-main">
                                <div class="libro-titulo"><?php echo s($l->titulo); ?></div>
                                <div class="libro-autor"><?php echo s($l->autor); ?></div>
                            </div>
                            <div class="leido-meta">
                                <?php if ($tiene) : ?>
                                    <span class="leido-stars-static"><?php
                                        echo estrellasHtml((float)$l->estrellas);
                                        echo '<span class="leido-stars-num">' . number_format((float)$l->estrellas, 1) . '</span>';
                                    ?></span>
                                <?php else : ?><span class="sin-resena">Sin reseña</span><?php endif; ?>
                                <span class="leido-fecha"><?php echo icono('calendario'); ?><?php echo $l->fecha_leido ? date('d/m/Y', strtotime($l->fecha_leido)) : 'Sin fecha'; ?></span>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
            <?php if (empty($leidos)) : ?><li style="color:var(--muted)">Aún no hay libros leídos.</li><?php endif; ?>
        </ul>
        <?php if ($totalPag > 1) : ?>
            <div class="paginacion">
                <?php for ($i = 1; $i <= $totalPag; $i++) : ?>
                    <?php if ($i === $pag) : ?><span class="actual"><?php echo $i; ?></span>
                    <?php else : ?><a href="/admin/libros?pag=<?php echo $i; ?>#col-leidos"><?php echo $i; ?></a><?php endif; ?>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<!-- Ficha del libro. Una sola modal que se puebla con los data-* del registro.
     Arriba la identidad (portada generada, título y autor); abajo el estado,
     que se elige como opción y se aplica al guardar, y solo los bloques que
     aplican a ese estado: reseña si está terminado, lugar en la cola si sigue
     pendiente. -->
<div class="modal-backdrop" id="libro-modal">
    <div class="modal modal--libro" role="dialog" aria-modal="true" aria-labelledby="lm-h">
        <div class="lm-hero">
            <div class="lm-portada" id="lm-portada" aria-hidden="true">
                <span class="lm-portada-ini" id="lm-ini"></span>
            </div>
            <div class="lm-identidad">
                <h3 id="lm-h" class="modal-kicker">Ficha del libro</h3>
                <input type="text" class="lm-titulo" id="lm-titulo" autocomplete="off" aria-label="Título" placeholder="Título">
                <input type="text" class="lm-autor" id="lm-autor" autocomplete="off" aria-label="Autor" placeholder="Autor">
            </div>
            <button type="button" class="modal-x" id="lm-cerrar" aria-label="Cerrar">&times;</button>
        </div>

        <div class="modal-body">
            <!-- Estado: tres opciones; las que no se pueden elegir desde el estado
                 actual quedan desactivadas y dicen por qué. -->
            <section class="lm-bloque">
                <h4 class="lm-bloque-t" id="lm-estado-t">Estado</h4>
                <div class="lm-estados" role="radiogroup" aria-labelledby="lm-estado-t">
                    <label class="lm-estado-op" data-estado="pendiente">
                        <input type="radio" name="lm-estado" value="pendiente">
                        <span class="lm-estado-ic"><?php echo icono('libros'); ?></span>
                        <span class="lm-estado-nombre">Pendiente</span>
                        <span class="lm-estado-desc">Por leer, en la cola</span>
                    </label>
                    <label class="lm-estado-op" data-estado="completado">
                        <input type="radio" name="lm-estado" value="completado">
                        <span class="lm-estado-ic"><?php echo icono('ok'); ?></span>
                        <span class="lm-estado-nombre">Completado</span>
                        <span class="lm-estado-desc">Terminado, sigue en la cola</span>
                    </label>
                    <label class="lm-estado-op" data-estado="leido">
                        <input type="radio" name="lm-estado" value="leido">
                        <span class="lm-estado-ic"><?php echo icono('estrella'); ?></span>
                        <span class="lm-estado-nombre">Leído</span>
                        <span class="lm-estado-desc">En tu lista de leídos</span>
                    </label>
                </div>
                <p class="lm-ayuda lm-ayuda--estado" id="lm-estado-ayuda" aria-live="polite"></p>
            </section>

            <!-- Reseña: solo tiene sentido en un libro terminado -->
            <section class="lm-bloque" id="lm-resena" hidden>
                <h4 class="lm-bloque-t">Reseña</h4>
                <div class="lm-resena-grid">
                    <div class="lm-campo">
                        <span class="lm-label" id="lm-cal-l">Calificación</span>
                        <div class="star-rating star-rating--lg lm-stars" data-max="5" data-input="#lm-estrellas" data-onhover="lmEstrellas" id="lm-stars" role="group" aria-labelledby="lm-cal-l"></div>
                        <span class="lm-cal-num" id="lm-cal-num" aria-live="polite">Sin nota</span>
                        <input type="hidden" id="lm-estrellas" value="0">
                    </div>
                    <!-- Mismo campo de fecha que Películas y Series -->
                    <label class="campo lm-fecha">
                        <span>Terminado el</span>
                        <input type="text" id="lm-fecha" inputmode="numeric" maxlength="10" placeholder="dd/mm/aaaa" autocomplete="off">
                    </label>
                </div>
                <label class="campo">
                    <span>Tu opinión <span class="lm-contador" id="lm-contador"></span></span>
                    <textarea id="lm-comentario" rows="4" placeholder="Qué te dejó…"></textarea>
                </label>
            </section>

            <!-- Posición: solo aplica mientras el libro sigue en la cola -->
            <section class="lm-bloque" id="lm-posicion" hidden>
                <h4 class="lm-bloque-t">Lugar en la cola</h4>
                <div class="lm-pos">
                    <div class="lm-pos-actual">
                        <span class="lm-pos-num" id="lm-pos-num">#1</span>
                        <span class="lm-pos-de" id="lm-pos-de">de 1 pendientes</span>
                    </div>
                    <div class="lm-stepper">
                        <button type="button" class="lm-step" data-paso="-1" aria-label="Adelantar un puesto"><?php echo icono('arriba'); ?></button>
                        <input type="number" id="lm-pos" min="1" aria-label="Mover a la posición">
                        <button type="button" class="lm-step" data-paso="1" aria-label="Atrasar un puesto"><?php echo icono('abajo'); ?></button>
                    </div>
                    <div class="lm-chips" role="group" aria-label="Mover rápido">
                        <button type="button" class="lm-chip" data-ir="inicio" aria-pressed="false">Al principio</button>
                        <button type="button" class="lm-chip" data-ir="fin" aria-pressed="false">Al final</button>
                    </div>
                </div>
                <p class="lm-ayuda" id="lm-pos-ayuda" aria-live="polite"></p>
            </section>
        </div>

        <div class="modal-actions modal-actions--split">
            <button type="button" class="btn btn--sm lm-eliminar" id="lm-eliminar"><?php echo icono('trash'); ?> Eliminar</button>
            <div class="modal-actions-main">
                <button type="button" class="btn btn--sm btn--ghost" id="lm-cancelar">Cancelar</button>
                <button type="button" class="btn btn--sm btn--primary" id="lm-guardar" title="Ctrl + Enter">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    function post(url, data, cb) {
        var body = Object.keys(data).map(function (k) { return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]); }).join('&');
        fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: body })
            .then(function (r) { return r.json(); }).then(cb).catch(function () { alert('Error'); });
    }

    var modal   = document.getElementById('libro-modal');
    var elTit   = document.getElementById('lm-titulo');
    var elAut   = document.getElementById('lm-autor');
    var elEst   = document.getElementById('lm-estrellas');
    var elFec   = document.getElementById('lm-fecha');
    var elCom   = document.getElementById('lm-comentario');
    var elPos   = document.getElementById('lm-pos');
    var secRes  = document.getElementById('lm-resena');
    var secPos  = document.getElementById('lm-posicion');
    var stars   = document.getElementById('lm-stars');
    var portada = document.getElementById('lm-portada');
    var elIni   = document.getElementById('lm-ini');
    var calNum  = document.getElementById('lm-cal-num');
    var contador = document.getElementById('lm-contador');
    var posNum  = document.getElementById('lm-pos-num');
    var posDe   = document.getElementById('lm-pos-de');
    var ayuda   = document.getElementById('lm-pos-ayuda');
    var ayudaEstado = document.getElementById('lm-estado-ayuda');
    var opciones = [].slice.call(modal.querySelectorAll('input[name="lm-estado"]'));
    var chipFin = secPos.querySelector('[data-ir="fin"]');
    var chipIni = secPos.querySelector('[data-ir="inicio"]');
    var actual  = null;          // <li> que se está editando
    var inicial = '';            // instantánea para detectar cambios sin guardar
    var estadoInicial = 'pendiente';
    var posActual = 1, totalPend = 1, alFinal = false;

    // Mismo calendario que Películas y Series. Se monta al cargar la página:
    // initDatePicker vive en el script del layout, que corre después de este.
    document.addEventListener('DOMContentLoaded', function () {
        if (window.initDatePicker) window.initDatePicker(elFec);
    });

    function estadoElegido() {
        var r = opciones.filter(function (o) { return o.checked; })[0];
        return r ? r.value : estadoInicial;
    }
    function instantanea() {
        return [elTit.value, elAut.value, elEst.value, elFec.value, elCom.value,
                alFinal ? 1 : 0, elPos.value, estadoElegido()].join('');
    }
    function hayCambios() { return !!actual && inicial !== instantanea(); }

    /* ---- Identidad: portada generada con las iniciales del título ---- */
    function iniciales(t) {
        var vacias = ['el', 'la', 'los', 'las', 'un', 'una', 'de', 'del', 'y', 'the', 'a', 'of'];
        var pal = (t || '').trim().split(/\s+/).filter(function (w) { return w && vacias.indexOf(w.toLowerCase()) === -1; });
        if (!pal.length) pal = (t || '').trim().split(/\s+/);
        return pal.slice(0, 2).map(function (w) { return w.charAt(0); }).join('').toUpperCase() || '?';
    }
    function pintarPortada() { elIni.textContent = iniciales(elTit.value); }
    elTit.addEventListener('input', pintarPortada);

    /* ---- Calificación: lectura en vivo (también al pasar el cursor) ---- */
    var PALABRAS = { 1: 'No me gustó', 2: 'Flojo', 3: 'Bueno', 4: 'Muy bueno', 5: 'Imprescindible' };
    window.lmEstrellas = function (v) {
        v = parseFloat(v) || 0;
        calNum.textContent = v > 0 ? String(v).replace('.', ',') + ' / 5 · ' + PALABRAS[Math.ceil(v)] : 'Sin nota';
        calNum.classList.toggle('is-vacia', !(v > 0));
    };

    function contarPalabras() {
        var t = elCom.value.trim(), n = t ? t.split(/\s+/).length : 0;
        contador.textContent = n ? '· ' + n + (n === 1 ? ' palabra' : ' palabras') : '';
    }
    elCom.addEventListener('input', contarPalabras);

    /* ---- Estado: se elige como opción y se aplica al guardar ---- */
    // Qué se puede elegir desde cada estado. Leídos solo se alcanza solo:
    // al completar el primero de la cola pasan todos los completados seguidos.
    var PERMITIDOS = {
        pendiente:  ['pendiente', 'completado'],
        completado: ['pendiente', 'completado'],
        leido:      ['pendiente', 'leido']
    };
    var BLOQUEO = {
        leido:      'Llega al completar el primero',
        completado: 'Primero vuelve a pendientes'
    };
    var DESCRIPCION = {};
    modal.querySelectorAll('.lm-estado-op').forEach(function (op) {
        DESCRIPCION[op.dataset.estado] = op.querySelector('.lm-estado-desc').textContent;
    });

    function pintarEstados() {
        var elegido = estadoElegido(), permitidos = PERMITIDOS[estadoInicial];
        opciones.forEach(function (o) {
            var op = o.closest('.lm-estado-op'), puede = permitidos.indexOf(o.value) !== -1;
            o.disabled = !puede;
            op.classList.toggle('is-bloqueado', !puede);
            op.classList.toggle('is-sel', o.value === elegido);
                        op.querySelector('.lm-estado-desc').textContent = puede ? DESCRIPCION[o.value] : BLOQUEO[o.value];
        });

        var txt = '';
        if (elegido !== estadoInicial) {
            if (elegido === 'completado') {
                txt = posActual === 1
                    ? 'Al guardar se marca como terminado y, por ser el primero de la cola, pasa a Leídos.'
                    : 'Al guardar se marca como terminado. Pasa a Leídos cuando llegue al primer lugar de la cola.';
            } else if (estadoInicial === 'leido') {
                txt = 'Al guardar vuelve a Pendientes y se borra la fecha de lectura. La reseña se conserva.';
            } else {
                txt = 'Al guardar deja de estar marcado como terminado. La reseña se conserva.';
            }
        }
        ayudaEstado.textContent = txt;

        // Lo que aplica al estado elegido: reseña si está terminado, cola si sigue en ella
        secRes.hidden = elegido === 'pendiente';
        secPos.hidden = estadoInicial === 'leido' || elegido === 'leido';
        if (!secPos.hidden) pintarPos();
        if (!secRes.hidden && stars.repintar) stars.repintar();
    }
    opciones.forEach(function (o) { o.addEventListener('change', pintarEstados); });

    /* ---- Lugar en la cola ---- */
    function destino() {
        if (alFinal) return totalPend;
        var v = parseInt(elPos.value, 10);
        return isNaN(v) ? posActual : Math.max(1, Math.min(totalPend, v));
    }
    function pintarPos() {
        var d = destino(), cambia = alFinal || d !== posActual;
        chipFin.setAttribute('aria-pressed', alFinal ? 'true' : 'false');
        chipIni.setAttribute('aria-pressed', !alFinal && d === 1 && posActual !== 1 ? 'true' : 'false');
        secPos.querySelector('[data-paso="-1"]').disabled = !alFinal && d <= 1;
        secPos.querySelector('[data-paso="1"]').disabled = alFinal || d >= totalPend;
        if (alFinal)     ayuda.textContent = 'Al guardar pasa al final de la cola.';
        else if (cambia) ayuda.textContent = 'Al guardar pasa del #' + posActual + ' al #' + d + '.';
        else             ayuda.textContent = '';
        posNum.classList.toggle('is-cambio', cambia);
        posNum.textContent = '#' + d;
    }
    function fijarPos(v) {
        alFinal = false;
        v = Math.max(1, Math.min(totalPend, v));
        elPos.value = v === posActual ? '' : v;
        pintarPos();
    }
    secPos.querySelectorAll('.lm-step').forEach(function (b) {
        b.addEventListener('click', function () { fijarPos(destino() + parseInt(b.dataset.paso, 10)); });
    });
    chipIni.addEventListener('click', function () { fijarPos(1); });
    chipFin.addEventListener('click', function () {
        alFinal = !alFinal;
        elPos.value = '';
        pintarPos();
    });
    elPos.addEventListener('input', function () { alFinal = false; pintarPos(); });

    function abrir(li) {
        actual = li;
        var d = li.dataset;
        estadoInicial = d.leido === '1' ? 'leido' : (d.completado === '1' ? 'completado' : 'pendiente');

        elTit.value = d.titulo || '';
        elAut.value = d.autor || '';
        elEst.value = parseFloat(d.estrellas) || 0;
        elFec.value = d.fecha || '';
        elCom.value = d.comentario || '';
        elPos.value = '';
        alFinal = false;
        opciones.forEach(function (o) { o.checked = o.value === estadoInicial; });

        posActual = parseInt(d.pos, 10) || 1;
        totalPend = document.querySelectorAll('#lista-pendientes .libro-item').length || 1;
        elPos.max = totalPend;
        elPos.placeholder = posActual;
        posDe.textContent = 'de ' + totalPend + (totalPend === 1 ? ' pendiente' : ' pendientes');

        // Tono de la portada derivado del id: cada libro conserva su color
        portada.style.setProperty('--lm-h', (parseInt(d.id, 10) * 47) % 360);
        pintarPortada();
        contarPalabras();
        pintarEstados();
        if (stars.repintar) stars.repintar(); else window.lmEstrellas(elEst.value);

        modal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        inicial = instantanea();
        setTimeout(function () { elTit.focus(); elTit.select(); }, 30);
    }

    function cerrar(forzar) {
        if (!forzar && hayCambios()) {
            confirmar('Hay cambios sin guardar en esta ficha. Si cierras, se pierden.', null,
                      { titulo: 'Descartar cambios', ok: 'Descartar', danger: true })
                .then(function (v) { if (v) cerrar(true); });
            return;
        }
        modal.classList.remove('is-open');
        document.body.style.overflow = '';
        actual = null;
    }

    // Guarda en orden: datos y posición → cambio de estado → reseña. El estado
    // va antes de la reseña porque marcar completado puede pasarlo a Leídos.
    function guardar() {
        if (!actual) return;
        var d = { id: actual.dataset.id, titulo: elTit.value, autor: elAut.value };
        if (!secPos.hidden) {
            if (alFinal) d.al_final = 1;
            else if (destino() !== posActual) d.nueva_pos = destino();
        }
        if (window.fechaISO) {
            var iso = window.fechaISO(elFec.value);
            if (iso === null) {
                (window.toast ? toast('Fecha inválida: usa dd/mm/aaaa', 'eliminado') : alert('Fecha inválida'));
                elFec.focus(); return;
            }
            d.fecha_leido = iso;
        }
        var id = actual.dataset.id, conResena = !secRes.hidden, cambiaEstado = estadoElegido() !== estadoInicial;
        document.getElementById('lm-guardar').disabled = true;
        function resena()  { if (conResena) post('/admin/libros/resenar', { id: id, estrellas: elEst.value, comentario: elCom.value }, fin); else fin(); }
        function estado()  { if (cambiaEstado) post('/admin/libros/estado', { id: id }, resena); else resena(); }
        function fin()     { location.reload(); }
        post('/admin/libros/editar', d, estado);
    }

    document.getElementById('lm-guardar').addEventListener('click', guardar);
    document.getElementById('lm-cancelar').addEventListener('click', function () { cerrar(false); });
    document.getElementById('lm-cerrar').addEventListener('click', function () { cerrar(false); });
    modal.addEventListener('click', function (e) { if (e.target === modal) cerrar(false); });

    document.getElementById('lm-eliminar').addEventListener('click', function () {
        if (!actual) return;
        var id = actual.dataset.id, titulo = actual.dataset.titulo || '';
        confirmar('Se eliminará este libro de forma permanente. Escribe su título para confirmar.', titulo).then(function (v) {
            if (!v) return;
            var f = document.createElement('form');
            f.method = 'POST'; f.action = '/admin/libros/eliminar';
            f.innerHTML = '<input type="hidden" name="id" value="' + id + '">';
            document.body.appendChild(f); f.submit();
        });
    });

    document.addEventListener('keydown', function (e) {
        if (!modal.classList.contains('is-open')) return;
        if (e.key === 'Escape') { e.preventDefault(); cerrar(false); }
        else if (e.key === 'Enter' && (e.metaKey || e.ctrlKey)) { e.preventDefault(); guardar(); }
    });

    /* ---- Apertura desde la lista ---- */
    document.querySelectorAll('.libro-item').forEach(function (libro) {
        var timer = null;
        var esLeido = libro.classList.contains('leido');

        libro.addEventListener('click', function () {
            if (timer) return;
            // Leído o pendiente ya completado: el click abre la ficha
            if (esLeido || libro.classList.contains('is-completado')) { abrir(libro); return; }
            // Pendiente: el click lo completa (el timer distingue del doble click)
            timer = setTimeout(function () {
                timer = null;
                function completar() {
                    post('/admin/libros/estado', { id: libro.dataset.id }, function (r) { if (r.ok) location.reload(); });
                }
                // Completar el PRIMERO lo pasa a Leídos: conviene avisar
                var lista = document.getElementById('lista-pendientes');
                var esPrimero = lista && lista.querySelector('.libro-item') === libro;
                if (esPrimero) {
                    var t = libro.dataset.titulo || 'Este libro';
                    confirmar('«' + t + '» es el primero de tu lista: al marcarlo como leído pasará a la columna de Leídos.', null,
                              { titulo: 'Pasar a Leídos', ok: 'Sí, marcar leído', danger: false })
                        .then(function (v) { if (v) completar(); });
                } else {
                    completar();
                }
            }, 250);
        });
        libro.addEventListener('dblclick', function () {
            clearTimeout(timer); timer = null;
            abrir(libro);
        });
    });
})();
</script>
