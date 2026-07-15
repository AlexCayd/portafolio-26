<div class="admin-head">
    <div>
        <h1>Mi cuenta</h1>
        <p>Cambia tu PIN de acceso de 6 dígitos.</p>
    </div>
</div>

<div class="card" style="max-width:680px">
    <h2>Cambiar PIN</h2>
    <?php if ($msg === 'ok') : ?><div class="alerta alerta--exito">PIN actualizado correctamente.</div>
    <?php elseif ($msg === 'nomatch') : ?><div class="alerta alerta--error">El nuevo PIN y su confirmación no coinciden.</div>
    <?php elseif ($msg === 'err') : ?><div class="alerta alerta--error">No se pudo cambiar: verifica el PIN actual y que el nuevo sean 6 dígitos.</div><?php endif; ?>

    <form method="POST" action="/admin/cuenta/guardar" id="pin-form" novalidate>
        <div class="campo full">
            <span>PIN actual</span>
            <div class="pin-group" data-pin="pin-actual">
                <?php for ($i = 0; $i < 6; $i++) : ?><input class="pin-box" type="password" inputmode="numeric" maxlength="1" autocomplete="off" <?php echo $i === 0 ? 'autofocus' : ''; ?>><?php endfor; ?>
            </div>
            <input type="hidden" name="actual" id="pin-actual">
        </div>

        <div class="campo full" style="margin-top:22px">
            <span>Nuevo PIN (6 dígitos)</span>
            <div class="pin-group" data-pin="pin-nuevo">
                <?php for ($i = 0; $i < 6; $i++) : ?><input class="pin-box" type="password" inputmode="numeric" maxlength="1" autocomplete="off"><?php endfor; ?>
            </div>
            <input type="hidden" name="nuevo" id="pin-nuevo">
        </div>

        <div class="campo full" style="margin-top:22px">
            <span>Confirmar nuevo PIN</span>
            <div class="pin-group" data-pin="pin-confirmar">
                <?php for ($i = 0; $i < 6; $i++) : ?><input class="pin-box" type="password" inputmode="numeric" maxlength="1" autocomplete="off"><?php endfor; ?>
            </div>
            <input type="hidden" name="confirmar" id="pin-confirmar">
            <small class="pin-hint" id="pin-hint" style="display:none;color:var(--c-red);font-size:.78rem;margin-top:8px">El PIN de confirmación no coincide.</small>
        </div>

        <div class="form-actions" style="margin-top:24px">
            <button type="submit" class="btn btn--primary">Guardar PIN</button>
        </div>
    </form>
</div>

<script>
(function () {
    // Cada .pin-group[data-pin] concatena sus 6 casillas en el hidden con ese id.
    document.querySelectorAll('.pin-group[data-pin]').forEach(function (group) {
        var boxes = Array.prototype.slice.call(group.querySelectorAll('.pin-box'));
        var hidden = document.getElementById(group.dataset.pin);
        function sync() { hidden.value = boxes.map(function (b) { return b.value; }).join(''); }
        boxes.forEach(function (box, i) {
            box.addEventListener('input', function () {
                box.value = box.value.replace(/[^0-9]/g, '').slice(0, 1);
                if (box.value && i < boxes.length - 1) boxes[i + 1].focus();
                sync();
            });
            box.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && !box.value && i > 0) boxes[i - 1].focus();
                else if (e.key === 'ArrowLeft' && i > 0) boxes[i - 1].focus();
                else if (e.key === 'ArrowRight' && i < boxes.length - 1) boxes[i + 1].focus();
            });
            box.addEventListener('paste', function (e) {
                e.preventDefault();
                var d = (e.clipboardData.getData('text') || '').replace(/[^0-9]/g, '').slice(0, 6);
                for (var k = 0; k < d.length && (i + k) < boxes.length; k++) boxes[i + k].value = d[k];
                sync(); boxes[Math.min(i + d.length, boxes.length - 1)].focus();
            });
        });
    });

    // Validar en el submit que el nuevo PIN y su confirmación coincidan.
    var form = document.getElementById('pin-form');
    var hint = document.getElementById('pin-hint');
    if (form) form.addEventListener('submit', function (e) {
        var nuevo = document.getElementById('pin-nuevo').value;
        var conf  = document.getElementById('pin-confirmar').value;
        if (nuevo !== conf) {
            e.preventDefault();
            if (hint) hint.style.display = 'block';
            document.querySelector('.pin-group[data-pin="pin-confirmar"] .pin-box').focus();
        }
    });
})();
</script>
