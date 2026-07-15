<main class="auth-wrap">
    <div class="auth-card">
        <div class="auth-brand">
            <span class="auth-mono">AO</span>
            <span>Alexander Oliva</span>
        </div>
        <h1 class="auth-title">Panel de administración</h1>
        <p class="auth-sub">Ingresa tu usuario y PIN de 6 dígitos.</p>

        <?php
        if (!empty($alertas['error'])) {
            foreach ($alertas['error'] as $mensaje) {
                echo '<div class="alerta alerta--error">' . s($mensaje) . '</div>';
            }
        }
        ?>

        <form method="POST" action="/login" class="auth-form" id="login-form" novalidate>
            <label class="campo">
                <span>Usuario</span>
                <input type="text" name="usuario" value="alex" autocomplete="username" required>
            </label>
            <div class="campo">
                <span style="display:flex;align-items:center;justify-content:space-between">
                    PIN
                    <button type="button" id="pin-eye" title="Mostrar/ocultar" style="background:none;border:none;color:var(--muted);cursor:pointer;padding:0;display:inline-flex">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </span>
                <div class="pin-group" id="pin-group">
                    <input class="pin-box" type="password" inputmode="numeric" maxlength="1" autocomplete="off" autofocus>
                    <input class="pin-box" type="password" inputmode="numeric" maxlength="1" autocomplete="off">
                    <input class="pin-box" type="password" inputmode="numeric" maxlength="1" autocomplete="off">
                    <input class="pin-box" type="password" inputmode="numeric" maxlength="1" autocomplete="off">
                    <input class="pin-box" type="password" inputmode="numeric" maxlength="1" autocomplete="off">
                    <input class="pin-box" type="password" inputmode="numeric" maxlength="1" autocomplete="off">
                </div>
                <input type="hidden" name="password" id="pin-value">
            </div>
            <button type="submit" class="btn btn--primary btn--block">Entrar</button>
        </form>

        <a class="auth-back" href="/">&larr; Volver al sitio</a>
    </div>
</main>

<script>
(function () {
    var group = document.getElementById('pin-group');
    var boxes = Array.prototype.slice.call(group.querySelectorAll('.pin-box'));
    var hidden = document.getElementById('pin-value');
    function sync() { hidden.value = boxes.map(function (b) { return b.value; }).join(''); }
    boxes.forEach(function (box, i) {
        box.addEventListener('input', function () {
            box.value = box.value.replace(/[^0-9]/g, '').slice(0, 1);
            if (box.value && i < boxes.length - 1) boxes[i + 1].focus();
            sync();
            // Al completar el último dígito → enviar automáticamente
            if (box.value && i === boxes.length - 1 && hidden.value.length === boxes.length) {
                document.getElementById('login-form').requestSubmit();
            }
        });
        box.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && !box.value && i > 0) boxes[i - 1].focus();
            if (e.key === 'ArrowLeft' && i > 0) boxes[i - 1].focus();
            if (e.key === 'ArrowRight' && i < boxes.length - 1) boxes[i + 1].focus();
        });
        box.addEventListener('paste', function (e) {
            e.preventDefault();
            var d = (e.clipboardData.getData('text') || '').replace(/[^0-9]/g, '').slice(0, 6);
            for (var k = 0; k < d.length && (i + k) < boxes.length; k++) boxes[i + k].value = d[k];
            sync();
            boxes[Math.min(i + d.length, boxes.length - 1)].focus();
            if (hidden.value.length === boxes.length) document.getElementById('login-form').requestSubmit();
        });
    });
    document.getElementById('pin-eye').addEventListener('click', function () {
        var show = boxes[0].type === 'password';
        boxes.forEach(function (b) { b.type = show ? 'text' : 'password'; });
    });
    document.getElementById('login-form').addEventListener('submit', sync);
})();
</script>
