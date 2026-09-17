<?php
$modulo = $modulo ?? '';
$nav = [
    ['seccion' => 'Contenido del sitio'],
    ['key' => 'dashboard',    'url' => '/admin',              'ic' => 'dashboard',    'label' => 'Dashboard'],
    ['key' => 'proyectos',    'url' => '/admin/proyectos',    'ic' => 'proyectos',    'label' => 'Proyectos'],
    ['key' => 'servicios',    'url' => '/admin/servicios',    'ic' => 'servicios',    'label' => 'Servicios'],
    ['key' => 'credenciales', 'url' => '/admin/credenciales',  'ic' => 'credenciales', 'label' => 'Credenciales'],
    ['key' => 'blog',         'url' => '/admin/blog',         'ic' => 'blog',         'label' => 'Tékhne'],
    ['key' => 'cv',           'url' => '/admin/cv',           'ic' => 'cv',           'label' => 'CV'],
    ['seccion' => 'Colecciones'],
    ['key' => 'libros',       'url' => '/admin/libros',       'ic' => 'libros',       'label' => 'Libros'],
    ['key' => 'peliculas',    'url' => '/admin/peliculas',    'ic' => 'peliculas',    'label' => 'Películas y Series'],
    ['key' => 'videojuegos',  'url' => '/admin/videojuegos',  'ic' => 'videojuegos',  'label' => 'Videojuegos'],
    ['seccion' => 'Vida'],
    ['key' => 'gym',          'url' => '/admin/gym',          'ic' => 'gym',          'label' => 'Gym'],
    ['key' => 'finanzas',     'url' => '/admin/finanzas',     'ic' => 'finanzas',     'label' => 'Finanzas'],
    ['key' => 'horario',      'url' => '/admin/horario',      'ic' => 'horario',      'label' => 'Horario'],
    ['seccion' => 'Mapas curriculares'],
    ['key' => 'anahuac',      'url' => '/admin/anahuac',      'ic' => 'mapa',         'label' => 'Mapa Anáhuac'],
    ['key' => 'unam',         'url' => '/admin/unam',         'ic' => 'mapa',         'label' => 'Mapa UNAM'],
    ['seccion' => 'Cuenta'],
    ['key' => 'cuenta',       'url' => '/admin/cuenta',       'ic' => 'cuenta',       'label' => 'Mi cuenta'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $titulo ?? 'Panel'; ?> - Admin · Alexander Oliva</title>
<meta name="robots" content="noindex, nofollow">
<meta name="theme-color" content="#0b0b0c">
<!-- Mismo icono que el sitio público: el panel también se reconoce en la pestaña -->
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo asset('/build/img/favicon-32.png'); ?>">
<link rel="icon" type="image/png" sizes="512x512" href="<?php echo asset('/build/img/favicon-512.png'); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo asset('/build/img/favicon-180.png'); ?>">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo asset('/build/css/admin.css'); ?>">
<?php if (!empty($usaCharts)) : ?><script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script><?php endif; ?>
<?php if (!empty($usaPdf)) : ?>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<?php endif; ?>
</head>
<body>
<button class="admin-burger" id="admin-burger" aria-label="Abrir menú"><?php echo icono('menu'); ?></button>
<div class="admin">
    <div class="admin-backdrop" id="admin-backdrop"></div>
    <aside class="admin-sidebar" id="admin-sidebar">
        <a href="/admin" class="admin-brand">Alexander&nbsp;<span class="brand-accent">Oliva</span></a>
        <nav class="admin-nav">
            <?php foreach ($nav as $item) : ?>
                <?php if (isset($item['seccion'])) : ?>
                    <div class="admin-nav-label"><?php echo $item['seccion']; ?></div>
                <?php else : ?>
                    <a href="<?php echo $item['url']; ?>" class="<?php echo $modulo === $item['key'] ? 'is-active' : ''; ?>">
                        <?php echo icono($item['ic']); ?><span><?php echo $item['label']; ?></span>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>
        <form method="POST" action="/logout"><button type="submit" class="admin-logout"><?php echo icono('logout'); ?> Cerrar sesión</button></form>
    </aside>
    <main class="admin-main"><?php echo $contenido; ?></main>
</div>

<div class="toast" id="toast" data-tipo="ok"><span class="toast-ic" id="toast-ic"></span> <span id="toast-msg">Guardado</span><span class="toast-bar" id="toast-bar"></span></div>

<!-- Modal de confirmación global -->
<div class="modal-backdrop" id="confirm-modal">
    <div class="modal">
        <h3 id="confirm-title">Confirmar eliminación</h3>
        <p id="confirm-text">¿Seguro?</p>
        <div id="confirm-name-wrap" style="display:none;margin-top:6px">
            <p class="mini-s" style="color:var(--muted);margin:0 0 8px">Escribe <b id="confirm-name-target"></b> para confirmar.</p>
            <input type="text" id="confirm-name-input" class="confirm-input" autocomplete="off" placeholder="Nombre exacto…">
        </div>
        <div class="modal-actions">
            <button class="btn btn--ghost" id="confirm-no">Cancelar</button>
            <button class="btn btn--danger" id="confirm-yes">Eliminar</button>
        </div>
    </div>
</div>

<script>
// ---- Helpers ----
window.postForm = function (url, data) {
    var params = new URLSearchParams();
    Object.keys(data).forEach(function (k) {
        var v = data[k];
        if (Array.isArray(v)) v.forEach(function (i) { params.append(k + '[]', i); });
        else params.append(k, v);
    });
    return fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: params.toString() })
        .then(function (r) { return r.json().catch(function () { return {}; }); });
};
window.toast = function (msg, tipo) {
    var t = document.getElementById('toast');
    var ICONS = {
        ok:       '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>',
        eliminado:'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>',
        editado:  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>'
    };
    tipo = tipo || 'ok';
    var DUR = 3000;
    t.dataset.tipo = tipo;
    document.getElementById('toast-ic').innerHTML = ICONS[tipo] || ICONS.ok;
    document.getElementById('toast-msg').textContent = msg || 'Guardado';
    var bar = document.getElementById('toast-bar');
    t.classList.remove('show'); void t.offsetWidth;   // reinicia la animación de entrada
    t.classList.add('show'); clearTimeout(window._tt);
    if (bar) { bar.style.transition = 'none'; bar.style.transform = 'scaleX(1)'; void bar.offsetWidth;
        bar.style.transition = 'transform ' + DUR + 'ms linear'; bar.style.transform = 'scaleX(0)'; }
    window._tt = setTimeout(function () { t.classList.remove('show'); }, DUR);
};
// Notificaciones flash tras redirect (create/edit/delete)
(function () {
    var flashes = <?php echo json_encode(obtenerFlash(), JSON_UNESCAPED_UNICODE); ?>;
    flashes.forEach(function (f, i) { setTimeout(function () { window.toast(f.msg, f.tipo); }, 200 + i * 3200); });
})();

// ---- Modal de confirmación (Promise). Si `nombre` viene, exige escribirlo.
//      `opts` = { titulo, ok, danger } permite reusarlo fuera de "eliminar". ----
window.confirmar = function (msg, nombre, opts) {
    opts = opts || {};
    return new Promise(function (resolve) {
        var m = document.getElementById('confirm-modal');
        var wrap = document.getElementById('confirm-name-wrap');
        var input = document.getElementById('confirm-name-input');
        var yes = document.getElementById('confirm-yes'), no = document.getElementById('confirm-no');
        document.getElementById('confirm-title').textContent = opts.titulo || 'Confirmar eliminación';
        yes.textContent = opts.ok || 'Eliminar';
        yes.classList.toggle('btn--danger', opts.danger !== false);
        yes.classList.toggle('btn--primary', opts.danger === false);
        document.getElementById('confirm-text').textContent = msg || '¿Seguro?';
        var pideNombre = !!(nombre && nombre.trim());
        wrap.style.display = pideNombre ? 'block' : 'none';
        if (pideNombre) {
            document.getElementById('confirm-name-target').textContent = '«' + nombre + '»';
            input.value = ''; yes.disabled = true;
            setTimeout(function () { input.focus(); }, 60);
        } else { yes.disabled = false; }
        m.classList.add('is-open');
        function check() { yes.disabled = input.value.trim() !== nombre.trim(); }
        function onEnter(e) { if (e.key === 'Enter' && !yes.disabled) { e.preventDefault(); ok(); } }
        function cleanup(v) {
            m.classList.remove('is-open'); yes.disabled = false;
            yes.removeEventListener('click', ok); no.removeEventListener('click', cancel);
            if (pideNombre) { input.removeEventListener('input', check); input.removeEventListener('keydown', onEnter); }
            resolve(v);
        }
        function ok() { cleanup(true); } function cancel() { cleanup(false); }
        yes.addEventListener('click', ok); no.addEventListener('click', cancel);
        if (pideNombre) { input.addEventListener('input', check); input.addEventListener('keydown', onEnter); }
        m.onclick = function (e) { if (e.target === m) cleanup(false); };
    });
};
document.querySelectorAll('form[data-confirm]').forEach(function (f) {
    f.addEventListener('submit', function (e) {
        if (f.dataset.ok === '1') return;
        e.preventDefault();
        confirmar(f.dataset.confirm, f.dataset.confirmName).then(function (v) { if (v) { f.dataset.ok = '1'; f.submit(); } });
    });
});

// ---- Sidebar móvil (drawer) ----
(function () {
    var sb = document.getElementById('admin-sidebar'), bd = document.getElementById('admin-backdrop'), bt = document.getElementById('admin-burger');
    function open() { sb.classList.add('open'); bd.classList.add('show'); }
    function close() { sb.classList.remove('open'); bd.classList.remove('show'); }
    if (bt) bt.addEventListener('click', open);
    if (bd) bd.addEventListener('click', close);
    sb.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', close); });
})();

// ---- Drag & drop reordenar ----
(function () {
    // Renumera las celdas .num-cell según su orden visible (data-num="pad2" => 01,02…)
    function renumber(cont) {
        var n = 0;
        cont.querySelectorAll('[data-id]').forEach(function (row) {
            var cell = row.querySelector('.num-cell'); if (!cell) return;
            n++;
            cell.textContent = cell.dataset.num === 'pad2' ? (n < 10 ? '0' + n : '' + n) : n;
        });
    }
    // Marca las primeras N filas como "en portada" (estrella) tras reordenar.
    function updateLanding(cont) {
        var n = parseInt(cont.dataset.landing || '0', 10); if (!n) return;
        Array.prototype.forEach.call(cont.querySelectorAll('[data-id]'), function (row, i) {
            var on = i < n;
            row.classList.toggle('is-landing', on);
            var handle = row.querySelector('.drag-handle');
            var cell = handle ? handle.parentNode : row.cells && row.cells[0];
            if (!cell) return;
            var badge = cell.querySelector('.landing-badge');
            if (on && !badge) { badge = document.createElement('span'); badge.className = 'landing-badge'; badge.title = 'Se muestra en la landing'; badge.innerHTML = '<svg class="ico" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>'; cell.appendChild(badge); }
            else if (!on && badge) { badge.remove(); }
        });
    }
    document.querySelectorAll('[data-sortable]').forEach(function (cont) {
        var url = cont.dataset.ordenUrl, drag = null;
        cont.addEventListener('dragstart', function (e) { var r = e.target.closest('[draggable="true"]'); if (!r) return; drag = r; r.classList.add('dragging'); });
        cont.addEventListener('dragend', function () {
            if (!drag) return; drag.classList.remove('dragging'); drag = null;
            renumber(cont); updateLanding(cont);
            var ids = Array.prototype.map.call(cont.querySelectorAll('[data-id]'), function (x) { return x.dataset.id; });
            postForm(url, { ids: ids }).then(function () { toast('Orden actualizado'); });
        });
        cont.addEventListener('dragover', function (e) {
            e.preventDefault(); var r = e.target.closest('[draggable="true"]'); if (!r || r === drag) return;
            var rect = r.getBoundingClientRect();
            // En una tabla el orden lo marca el eje Y; en una rejilla (la galería
            // de un proyecto) las miniaturas van en fila, así que manda la X.
            var enFila = drag.offsetTop === r.offsetTop;
            var pasado = enFila
                ? (e.clientX - rect.left) / rect.width  > 0.5
                : (e.clientY - rect.top)  / rect.height > 0.5;
            cont.insertBefore(drag, pasado ? r.nextSibling : r);
            renumber(cont); updateLanding(cont);
        });
    });
    // Preview de imagen
    document.querySelectorAll('input[type="file"][data-preview]').forEach(function (inp) {
        inp.addEventListener('change', function () { var f = inp.files[0]; if (!f) return; var p = document.querySelector(inp.dataset.preview); if (p) p.innerHTML = '<img src="' + URL.createObjectURL(f) + '">'; });
    });
    // Dropzone
    document.querySelectorAll('.upload-drop').forEach(function (drop) {
        var inp = drop.querySelector('input[type="file"]');
        ['dragover', 'dragenter'].forEach(function (ev) { drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.add('dragover'); }); });
        ['dragleave', 'drop'].forEach(function (ev) { drop.addEventListener(ev, function () { drop.classList.remove('dragover'); }); });
        drop.addEventListener('drop', function (e) { e.preventDefault(); if (inp && e.dataTransfer.files.length) { inp.files = e.dataTransfer.files; inp.dispatchEvent(new Event('change')); } });
    });
})();

// ---- Estrellas reutilizable (.star-rating data-max data-step data-input) ----
// Se excluye .is-readonly: esas las pinta estrellasHtml() en el servidor y no
// tienen data-input, así que construirlas aquí duplicaba las estrellas.
window.initStars = function (root) {
    (root || document).querySelectorAll('.star-rating:not(.is-readonly)').forEach(function (sr) {
        if (sr.dataset.built) return; sr.dataset.built = '1';
        var max = parseInt(sr.dataset.max || '5', 10), input = document.querySelector(sr.dataset.input);
        if (!input) return;                                            // sin destino no hay widget
        var permiteMedia = parseFloat(sr.dataset.step || '0.5') < 1;   // step=1 => sin decimales
        function media(e, st) { if (!permiteMedia) return 0; var r = st.getBoundingClientRect(); return (e.clientX - r.left) < r.width / 2 ? 0.5 : 0; }
        var SVG = '<svg class="star-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M11.48 3.5a.56.56 0 011.04 0l2.12 5.11a.56.56 0 00.48.35l5.52.44c.5.04.7.66.32.99l-4.2 3.6a.56.56 0 00-.18.56l1.28 5.39a.56.56 0 01-.84.6l-4.72-2.88a.56.56 0 00-.59 0l-4.72 2.88a.56.56 0 01-.84-.6l1.28-5.39a.56.56 0 00-.18-.56l-4.2-3.6a.56.56 0 01.32-.99l5.52-.44a.56.56 0 00.48-.35z"/></svg>';
        for (var i = 1; i <= max; i++) { var s = document.createElement('span'); s.className = 'star'; s.dataset.i = i; s.innerHTML = '<span class="half">' + SVG + '</span>' + SVG; sr.appendChild(s); }
        function paint(v) { sr.querySelectorAll('.star').forEach(function (st) { var i = +st.dataset.i; st.classList.remove('full', 'half-on'); if (v >= i) st.classList.add('full'); else if (v >= i - 0.5) st.classList.add('half-on'); }); }
        // Callback opcional de etiqueta en hover (data-onhover="fnGlobal")
        function hover(v) { var fn = sr.dataset.onhover && window[sr.dataset.onhover]; if (fn) fn(v); }
        var val0 = parseFloat(input.value) || 0;
        paint(val0); hover(val0);
        // Para widgets reutilizados (una modal que se abre con otro registro):
        // permite repintar tras cambiar el input por fuera.
        sr.repintar = function () { var v = parseFloat(input.value) || 0; paint(v); hover(v); };
        sr.querySelectorAll('.star').forEach(function (st) {
            var i = +st.dataset.i;
            st.addEventListener('mousemove', function (e) { var v = i - media(e, st); paint(v); hover(v); });
            st.addEventListener('click', function (e) { var v = i - media(e, st); input.value = v; paint(v); hover(v); input.dispatchEvent(new Event('change')); });
        });
        sr.addEventListener('mouseleave', function () { var v = parseFloat(input.value) || 0; paint(v); hover(v); });
    });
};
initStars();

// ---- Fechas dd/mm/aaaa ([data-fecha-dmy] + hidden con el ISO) ----
// Convierte "dd/mm/aaaa" a ISO "aaaa-mm-dd". '' => '' (limpia). Inválida => null.
window.fechaISO = function (v) {
    v = (v || '').trim();
    if (v === '') return '';
    var m = v.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
    if (!m) return null;
    var d = +m[1], mo = +m[2], y = +m[3];
    var dt = new Date(y, mo - 1, d);
    if (dt.getFullYear() !== y || dt.getMonth() !== mo - 1 || dt.getDate() !== d) return null;
    return y + '-' + ('0' + mo).slice(-2) + '-' + ('0' + d).slice(-2);
};
// Máscara dd/mm/aaaa mientras se escribe (también la usan los editores inline)
window.mascaraFechaDmy = function (inp) {
    inp.addEventListener('input', function () {
        var n = inp.value.replace(/\D/g, '').slice(0, 8), out = n.slice(0, 2);
        if (n.length > 2) out += '/' + n.slice(2, 4);
        if (n.length > 4) out += '/' + n.slice(4, 8);
        inp.value = out;
        inp.classList.remove('is-invalid');
    });
};
window.initFechasDmy = function (root) {
    (root || document).querySelectorAll('[data-fecha-dmy]').forEach(function (inp) {
        if (inp.dataset.built) return; inp.dataset.built = '1';
        window.mascaraFechaDmy(inp);
        // El hidden hermano es el que viaja en el POST. Se resuelve ANTES de montar
        // el calendario, que envuelve el input y le cambia el parentNode.
        var hidden = inp.parentNode.querySelector('input[type="hidden"][name="' + inp.dataset.fechaDmy + '"]');
        // Atajo «Hoy» del rótulo (campoFechaDmy con $conHoy)
        var hoyBtn = inp.parentNode.querySelector('[data-fecha-hoy]');
        if (hoyBtn) hoyBtn.addEventListener('click', function (e) {
            e.preventDefault(); e.stopPropagation();
            var d = new Date();
            inp.value = ('0' + d.getDate()).slice(-2) + '/' + ('0' + (d.getMonth() + 1)).slice(-2) + '/' + d.getFullYear();
            inp.classList.remove('is-invalid');
            inp.dispatchEvent(new Event('change', { bubbles: true }));
        });
        window.initDatePicker(inp);
        var form = inp.closest('form');
        if (!hidden || !form) return;
        form.addEventListener('submit', function (e) {
            var iso = window.fechaISO(inp.value);
            if (iso === null) {
                e.preventDefault();
                inp.classList.add('is-invalid'); inp.focus();
                if (window.toast) toast('Fecha inválida: usa dd/mm/aaaa', 'eliminado');
                return;
            }
            hidden.value = iso;
        });
    });
};

// ---- Calendario emergente para los campos dd/mm/aaaa ----
// Se apoya en window.fechaISO / window.mascaraFechaDmy: el input visible sigue
// aceptando tecleo y el valor sigue viajando en el hidden hermano.
window.initDatePicker = function (inp) {
    if (!inp || inp.dataset.dp) return; inp.dataset.dp = '1';
    // La fecha se elige siempre en el calendario, nunca se teclea: así no hay
    // formatos a medias ni fechas inválidas que validar. Para vaciarla está la
    // acción «Limpiar» del propio calendario.
    inp.readOnly = true;
    inp.setAttribute('aria-haspopup', 'dialog');
    var MESES = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    var DIAS  = ['L','M','M','J','V','S','D'];
    var ANIO_MIN = 2020;   // primer año con registros: el calendario no baja de ahí

    // El input se envuelve para poder anclar el popover y el botón de calendario
    var wrap = inp.parentNode;
    if (!wrap.classList.contains('dp-wrap')) {
        wrap = document.createElement('span');
        wrap.className = 'dp-wrap';
        inp.parentNode.insertBefore(wrap, inp);
        wrap.appendChild(inp);
    }
    var btn = document.createElement('button');
    btn.type = 'button'; btn.className = 'dp-btn'; btn.tabIndex = -1;
    btn.setAttribute('aria-label', 'Abrir calendario');
    btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 11h18"/></svg>';
    wrap.appendChild(btn);

    var pop = null, cursor = null;   // cursor = mes que se está mostrando
    // El popover vive dentro del <label>, así que al elegir un día el navegador
    // reenvía la activación de la etiqueta al input y lo vuelve a enfocar. Sin
    // esta ventana muerta, el calendario se reabriría justo después de cerrarse.
    var ultimoCierre = 0;

    function hoy0() { var d = new Date(); d.setHours(0, 0, 0, 0); return d; }
    function seleccionada() {
        var iso = window.fechaISO(inp.value);
        if (!iso) return null;
        var p = iso.split('-');
        return new Date(+p[0], +p[1] - 1, +p[2]);
    }
    function escribir(d) {
        inp.value = ('0' + d.getDate()).slice(-2) + '/' + ('0' + (d.getMonth() + 1)).slice(-2) + '/' + d.getFullYear();
        inp.classList.remove('is-invalid');
        inp.dispatchEvent(new Event('change', { bubbles: true }));
    }

    function render() {
        var sel = seleccionada(), hoy = hoy0();
        var y = cursor.getFullYear(), m = cursor.getMonth();
        var primero = new Date(y, m, 1);
        var offset = (primero.getDay() + 6) % 7;            // semana lun–dom
        var total  = new Date(y, m + 1, 0).getDate();

        var opts = '';
        for (var i = 0; i < 12; i++) opts += '<option value="' + i + '"' + (i === m ? ' selected' : '') + '>' + MESES[i] + '</option>';
        // Todas las fechas del panel son de hechos ya ocurridos (visto, leído,
        // publicado) y el registro empieza en 2020: la lista va del año actual a
        // ANIO_MIN. Si el año del cursor cae fuera se añade para no perder la selección.
        var anios = '', tope = hoy.getFullYear(), piso = Math.min(ANIO_MIN, y), techo = Math.max(tope, y);
        for (var a = techo; a >= piso; a--) anios += '<option value="' + a + '"' + (a === y ? ' selected' : '') + '>' + a + '</option>';
        var sinAnterior = y < ANIO_MIN || (y === ANIO_MIN && m === 0);

        var celdas = '';
        for (var b = 0; b < offset; b++) celdas += '<span class="dp-d dp-d--off"></span>';
        for (var d = 1; d <= total; d++) {
            var cls = 'dp-d';
            if (hoy.getFullYear() === y && hoy.getMonth() === m && hoy.getDate() === d) cls += ' is-hoy';
            if (sel && sel.getFullYear() === y && sel.getMonth() === m && sel.getDate() === d) cls += ' is-sel';
            celdas += '<button type="button" class="' + cls + '" data-d="' + d + '">' + d + '</button>';
        }

        pop.innerHTML =
            '<div class="dp-head">' +
                '<button type="button" class="dp-nav" data-nav="-1" aria-label="Mes anterior"' + (sinAnterior ? ' disabled' : '') + '>&lsaquo;</button>' +
                '<select class="dp-sel dp-mes" aria-label="Mes">' + opts + '</select>' +
                '<select class="dp-sel dp-anio" aria-label="Año">' + anios + '</select>' +
                '<button type="button" class="dp-nav" data-nav="1" aria-label="Mes siguiente">&rsaquo;</button>' +
            '</div>' +
            '<div class="dp-sem">' + DIAS.map(function (x) { return '<span>' + x + '</span>'; }).join('') + '</div>' +
            '<div class="dp-grid">' + celdas + '</div>' +
            '<div class="dp-foot">' +
                '<button type="button" class="dp-accion" data-accion="hoy">Hoy</button>' +
                '<button type="button" class="dp-accion" data-accion="limpiar">Limpiar</button>' +
            '</div>';
    }

    function abrir() {
        if (pop || Date.now() - ultimoCierre < 250) return;
        pop = document.createElement('div');
        pop.className = 'dp-pop';
        cursor = seleccionada() || hoy0();
        wrap.appendChild(pop);
        render();
        // Si no cabe abajo, se despliega hacia arriba. El límite es la ventana o,
        // si el campo vive en un contenedor con scroll (el cuerpo de una modal),
        // ese contenedor: lo que se salga de él queda recortado.
        requestAnimationFrame(function () {
            if (!pop) return;
            var caja = { top: 0, bottom: window.innerHeight }, scroller = null;
            for (var el = wrap.parentElement; el && el !== document.body; el = el.parentElement) {
                if (/(auto|scroll)/.test(getComputedStyle(el).overflowY)) { scroller = el; caja = el.getBoundingClientRect(); break; }
            }
            var r = pop.getBoundingClientRect(), w = wrap.getBoundingClientRect();
            if (r.bottom <= caja.bottom - 8) return;
            if (w.top - r.height - 7 >= caja.top + 8 || !scroller) pop.classList.add('dp-pop--arriba');
            else pop.scrollIntoView({ block: 'nearest' });   // ni arriba ni abajo: se desplaza el contenedor
        });
        document.addEventListener('mousedown', fuera, true);
        document.addEventListener('keydown', teclas, true);
    }
    function cerrar() {
        if (!pop) return;
        pop.remove(); pop = null;
        ultimoCierre = Date.now();
        document.removeEventListener('mousedown', fuera, true);
        document.removeEventListener('keydown', teclas, true);
    }
    function fuera(e) { if (!wrap.contains(e.target)) cerrar(); }
    function teclas(e) {
        if (e.key === 'Escape') { e.stopPropagation(); cerrar(); inp.focus(); return; }
        if (!pop) return;
        var salto = { ArrowLeft: -1, ArrowRight: 1, ArrowUp: -7, ArrowDown: 7 }[e.key];
        if (salto === undefined) return;
        e.preventDefault();
        var base = seleccionada() || cursor;
        var d = new Date(base.getFullYear(), base.getMonth(), base.getDate() + salto);
        if (d.getFullYear() < ANIO_MIN && d < base) return;
        cursor = new Date(d.getFullYear(), d.getMonth(), 1);
        escribir(d); render();
    }

    btn.addEventListener('click', function (e) { e.preventDefault(); pop ? cerrar() : (inp.focus(), abrir()); });
    inp.addEventListener('focus', abrir);
    inp.addEventListener('click', function (e) { e.stopPropagation(); abrir(); });

    wrap.addEventListener('click', function (e) {
        if (!pop) return;
        var nav = e.target.closest('.dp-nav');
        if (nav) { cursor = new Date(cursor.getFullYear(), cursor.getMonth() + (+nav.dataset.nav), 1); render(); return; }
        var dia = e.target.closest('.dp-d[data-d]');
        if (dia) { escribir(new Date(cursor.getFullYear(), cursor.getMonth(), +dia.dataset.d)); cerrar(); return; }
        var acc = e.target.closest('.dp-accion');
        if (acc) {
            if (acc.dataset.accion === 'hoy') { var h = hoy0(); cursor = new Date(h.getFullYear(), h.getMonth(), 1); escribir(h); }
            else { inp.value = ''; inp.dispatchEvent(new Event('change', { bubbles: true })); }
            cerrar();
        }
    });
    wrap.addEventListener('change', function (e) {
        if (!pop) return;
        if (e.target.classList.contains('dp-mes'))  { cursor = new Date(cursor.getFullYear(), +e.target.value, 1); render(); }
        if (e.target.classList.contains('dp-anio')) { cursor = new Date(+e.target.value, cursor.getMonth(), 1); render(); }
    });
};

initFechasDmy();

// ---- Tag-pills (.tag-input data-input) ----
window.initTagInputs = function () {
    document.querySelectorAll('.tag-input').forEach(function (box) {
        if (box.dataset.built) return; box.dataset.built = '1';
        var hidden = document.querySelector(box.dataset.input), field = box.querySelector('.tag-field'), tags = [];
        (hidden.value ? hidden.value.split(',') : []).forEach(function (t) { t = t.trim(); if (t) tags.push(t); });
        function sync() { hidden.value = tags.join(','); render(); }
        function render() {
            box.querySelectorAll('.tag-pill').forEach(function (p) { p.remove(); });
            tags.forEach(function (t, idx) {
                var pill = document.createElement('span'); pill.className = 'tag-pill'; pill.innerHTML = t + ' <b data-x="' + idx + '">✕</b>';
                box.insertBefore(pill, field);
            });
        }
        function add(v) { v = v.trim().replace(/,$/, ''); if (v && tags.indexOf(v) < 0) tags.push(v); field.value = ''; sync(); }
        field.addEventListener('keydown', function (e) { if (e.key === ',' || e.key === 'Enter') { e.preventDefault(); add(field.value); } else if (e.key === 'Backspace' && !field.value && tags.length) { tags.pop(); sync(); } });
        field.addEventListener('blur', function () { if (field.value.trim()) add(field.value); });
        box.addEventListener('click', function (e) { if (e.target.dataset.x !== undefined) { tags.splice(+e.target.dataset.x, 1); sync(); } else field.focus(); });
        render();
    });
};
initTagInputs();

// ---- Autocompletar ([data-autocomplete] con .ac-input, .ac-results, data-endpoint, data-onpick) ----
// Icono de reserva cuando el resultado no trae portada. Se toma de icono()
// para no duplicar SVGs sueltos en el JS.
var AC_ICONOS = {
    libro:      <?php echo json_encode(icono('libros'), JSON_HEX_TAG); ?>,
    pelicula:   <?php echo json_encode(icono('peliculas'), JSON_HEX_TAG); ?>,
    videojuego: <?php echo json_encode(icono('videojuegos'), JSON_HEX_TAG); ?>
};
// Se expone para poder engancharlo en campos creados por JS (filas de
// director, formularios en modal). El flag `acBuilt` evita duplicar oyentes.
window.initAutocomplete = function (raiz) {
(raiz || document).querySelectorAll('[data-autocomplete]').forEach(function (box) {
    if (box.dataset.acBuilt) return;
    box.dataset.acBuilt = '1';
    var input = box.querySelector('.ac-input'), results = box.querySelector('.ac-results'), endpoint = box.dataset.endpoint, onpick = box.dataset.onpick, t;
    if (!input || !results) return;
    input.addEventListener('input', function () {
        clearTimeout(t); var q = input.value.trim();
        if (q.length < 2) { results.innerHTML = ''; results.classList.remove('open'); return; }
        t = setTimeout(function () {
            fetch(endpoint + (endpoint.indexOf('?') < 0 ? '?' : '&') + 'q=' + encodeURIComponent(q)).then(function (r) { return r.json(); }).then(function (items) {
                results.innerHTML = (items && items.length) ? items.map(function (it) {
                    return '<div class="ac-item" data-json="' + encodeURIComponent(JSON.stringify(it)) + '">' +
                        (it.poster ? '<img src="' + it.poster + '">' : '<span class="ac-ico">' + (AC_ICONOS[it.tipo] || AC_ICONOS.pelicula) + '</span>') +
                        '<div><div class="ac-t">' + it.titulo + '</div><div class="ac-s">' + (it.sub || '') + '</div></div></div>';
                }).join('') : '<div class="ac-empty">Sin resultados</div>';
                results.classList.add('open');
            });
        }, 220);
    });
    function pick(item) {
        results.classList.remove('open');
        if (onpick && window[onpick]) window[onpick](JSON.parse(decodeURIComponent(item.dataset.json)), box);
    }
    results.addEventListener('click', function (e) {
        var item = e.target.closest('.ac-item'); if (!item) return;
        pick(item);
    });
    // Navegación con flechas ↑/↓ + Enter
    input.addEventListener('keydown', function (e) {
        var items = Array.prototype.slice.call(results.querySelectorAll('.ac-item'));
        if (!items.length || !results.classList.contains('open')) return;
        var cur = results.querySelector('.ac-item.active'), idx = items.indexOf(cur);
        if (e.key === 'ArrowDown') { e.preventDefault(); idx = (idx + 1) % items.length; }
        else if (e.key === 'ArrowUp') { e.preventDefault(); idx = (idx - 1 + items.length) % items.length; }
        else if (e.key === 'Enter') { if (cur) { e.preventDefault(); pick(cur); } return; }
        else return;
        items.forEach(function (x) { x.classList.remove('active'); });
        items[idx].classList.add('active'); items[idx].scrollIntoView({ block: 'nearest' });
    });
    document.addEventListener('click', function (e) { if (!box.contains(e.target)) results.classList.remove('open'); });
});
};
initAutocomplete();
</script>
<?php if (!empty($scriptExtra)) echo $scriptExtra; ?>
</body>
</html>
