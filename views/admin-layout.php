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
<link rel="icon" type="image/png" href="/build/img/profile.png">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/build/css/admin.css">
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
            cont.insertBefore(drag, (e.clientY - rect.top) / rect.height > 0.5 ? r.nextSibling : r);
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
window.initStars = function (root) {
    (root || document).querySelectorAll('.star-rating').forEach(function (sr) {
        if (sr.dataset.built) return; sr.dataset.built = '1';
        var max = parseInt(sr.dataset.max || '5', 10), input = document.querySelector(sr.dataset.input);
        var permiteMedia = parseFloat(sr.dataset.step || '0.5') < 1;   // step=1 => sin decimales
        function media(e, st) { if (!permiteMedia) return 0; var r = st.getBoundingClientRect(); return (e.clientX - r.left) < r.width / 2 ? 0.5 : 0; }
        for (var i = 1; i <= max; i++) { var s = document.createElement('span'); s.className = 'star'; s.dataset.i = i; s.innerHTML = '<span class="half">★</span>★'; sr.appendChild(s); }
        function paint(v) { sr.querySelectorAll('.star').forEach(function (st) { var i = +st.dataset.i; st.classList.remove('full', 'half-on'); if (v >= i) st.classList.add('full'); else if (v >= i - 0.5) st.classList.add('half-on'); }); }
        // Callback opcional de etiqueta en hover (data-onhover="fnGlobal")
        function hover(v) { var fn = sr.dataset.onhover && window[sr.dataset.onhover]; if (fn) fn(v); }
        var val0 = parseFloat(input.value) || 0;
        paint(val0); hover(val0);
        sr.querySelectorAll('.star').forEach(function (st) {
            var i = +st.dataset.i;
            st.addEventListener('mousemove', function (e) { var v = i - media(e, st); paint(v); hover(v); });
            st.addEventListener('click', function (e) { var v = i - media(e, st); input.value = v; paint(v); hover(v); input.dispatchEvent(new Event('change')); });
        });
        sr.addEventListener('mouseleave', function () { var v = parseFloat(input.value) || 0; paint(v); hover(v); });
    });
};
initStars();

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
document.querySelectorAll('[data-autocomplete]').forEach(function (box) {
    var input = box.querySelector('.ac-input'), results = box.querySelector('.ac-results'), endpoint = box.dataset.endpoint, onpick = box.dataset.onpick, t;
    input.addEventListener('input', function () {
        clearTimeout(t); var q = input.value.trim();
        if (q.length < 2) { results.innerHTML = ''; results.classList.remove('open'); return; }
        t = setTimeout(function () {
            fetch(endpoint + (endpoint.indexOf('?') < 0 ? '?' : '&') + 'q=' + encodeURIComponent(q)).then(function (r) { return r.json(); }).then(function (items) {
                results.innerHTML = (items && items.length) ? items.map(function (it) {
                    return '<div class="ac-item" data-json="' + encodeURIComponent(JSON.stringify(it)) + '">' +
                        (it.poster ? '<img src="' + it.poster + '">' : '<span class="ac-ico">' + (it.tipo === 'libro' ? '<svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>' : '<svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="2"/><path d="M7 2v20M17 2v20M2 12h20M2 7h5M2 17h5M17 17h5M17 7h5"/></svg>') + '</span>') +
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
</script>
<?php if (!empty($scriptExtra)) echo $scriptExtra; ?>
</body>
</html>
