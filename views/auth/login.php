<?php
$ao_error = !empty($alertas['error']) ? $alertas['error'] : [];
?>
<!-- Panel de marca: el mismo humo rojo del sitio, aquí en CSS -->
<aside class="auth-aside">
    <div class="auth-humo" aria-hidden="true"><span></span><span></span><span></span></div>

    <div class="auth-marca">
        <span class="auth-mono">AO</span>
        <span class="auth-marca-txt">Alexander <span>Oliva</span></span>
    </div>

    <h2 class="auth-lema">Del otro lado está <em>todo</em>.</h2>

    <p class="auth-pie">CDMX · Acceso privado</p>
</aside>

<main class="auth-wrap">
    <div class="auth-card">
        <span class="auth-kicker">Panel de administración</span>
        <h1 class="auth-title">Hola, Alexander</h1>
        <p class="auth-sub">Escribe tu PIN de 6 dígitos. En cuanto pongas el último, entras.</p>

        <?php foreach ($ao_error as $ao_msg) : ?>
            <div class="alerta alerta--error"><?php echo s($ao_msg); ?></div>
        <?php endforeach; ?>

        <form method="POST" action="/login" class="auth-form" id="login-form" novalidate>
            <label class="campo">
                <span>Usuario</span>
                <input type="text" name="usuario" value="alex" autocomplete="username" required>
            </label>

            <div class="campo">
                <div class="auth-pin-head">
                    <span>PIN</span>
                    <button type="button" class="auth-ojo" id="pin-eye" aria-pressed="false">
                        <?php echo icono('ojo'); ?><span id="pin-eye-txt">Mostrar</span>
                    </button>
                </div>
                <div class="pin-group<?php echo $ao_error ? ' is-error' : ''; ?>" id="pin-group">
                    <?php for ($ao_i = 0; $ao_i < 6; $ao_i++) : ?>
                        <input class="pin-box" type="password" inputmode="numeric" maxlength="1"
                               autocomplete="off" aria-label="Dígito <?php echo $ao_i + 1; ?> de 6"<?php echo $ao_i === 0 ? ' autofocus' : ''; ?>>
                    <?php endfor; ?>
                </div>
                <input type="hidden" name="password" id="pin-value">
            </div>

            <button type="submit" class="btn btn--primary btn--block" id="login-btn">Entrar</button>
        </form>

        <a class="auth-back" href="/">&larr; Volver al sitio</a>
    </div>
</main>

<script>
(function () {
    var group  = document.getElementById('pin-group');
    var boxes  = Array.prototype.slice.call(group.querySelectorAll('.pin-box'));
    var hidden = document.getElementById('pin-value');
    var form   = document.getElementById('login-form');
    var boton  = document.getElementById('login-btn');
    var enviado = false;

    function sync(limpiaError) {
        hidden.value = boxes.map(function (b) { return b.value; }).join('');
        boxes.forEach(function (b) { b.classList.toggle('is-full', b.value !== ''); });
        group.classList.toggle('is-listo', hidden.value.length === boxes.length);
        // El aviso de error se retira al corregir, no al cargar la página
        if (limpiaError) group.classList.remove('is-error');
    }

    // El envío es automático al sexto dígito: conviene que el botón lo diga
    function enviar() {
        if (enviado) return;
        enviado = true;
        boton.textContent = 'Entrando…';
        boton.disabled = true;
        form.requestSubmit();
    }

    boxes.forEach(function (box, i) {
        box.addEventListener('input', function () {
            box.value = box.value.replace(/[^0-9]/g, '').slice(0, 1);
            if (box.value && i < boxes.length - 1) boxes[i + 1].focus();
            sync(true);
            if (box.value && i === boxes.length - 1 && hidden.value.length === boxes.length) enviar();
        });
        box.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && !box.value && i > 0) { boxes[i - 1].focus(); }
            if (e.key === 'ArrowLeft'  && i > 0) boxes[i - 1].focus();
            if (e.key === 'ArrowRight' && i < boxes.length - 1) boxes[i + 1].focus();
        });
        box.addEventListener('focus', function () { box.select(); });
        box.addEventListener('paste', function (e) {
            e.preventDefault();
            var d = (e.clipboardData.getData('text') || '').replace(/[^0-9]/g, '').slice(0, 6);
            for (var k = 0; k < d.length && (i + k) < boxes.length; k++) boxes[i + k].value = d[k];
            sync(true);
            boxes[Math.min(i + d.length, boxes.length - 1)].focus();
            if (hidden.value.length === boxes.length) enviar();
        });
    });

    var ojo = document.getElementById('pin-eye'), ojoTxt = document.getElementById('pin-eye-txt');
    ojo.addEventListener('click', function () {
        var mostrar = boxes[0].type === 'password';
        boxes.forEach(function (b) { b.type = mostrar ? 'text' : 'password'; });
        ojo.setAttribute('aria-pressed', mostrar ? 'true' : 'false');
        ojoTxt.textContent = mostrar ? 'Ocultar' : 'Mostrar';
    });

    form.addEventListener('submit', function () { sync(false); enviado = true; });

    // Si el intento anterior falló, el foco vuelve al principio del PIN
    if (group.classList.contains('is-error')) {
        setTimeout(function () { boxes[0].focus(); }, 60);
    }
    sync(false);
})();
</script>
