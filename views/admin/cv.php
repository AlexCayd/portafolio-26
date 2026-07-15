<div class="admin-head">
    <div>
        <h1>Curriculum Vitae</h1>
        <p>El PDF que se descarga desde el botón «Descargar CV» de la landing.</p>
    </div>
    <?php if ($existe) : ?><a href="/build/pdf/cv.pdf" target="_blank" class="btn btn--ghost">Ver CV actual ↗</a><?php endif; ?>
</div>

<div class="dash-grid" style="grid-template-columns:1fr 1fr;align-items:start">
    <div class="card">
        <h2>Reemplazar CV</h2>
        <?php if ($existe) : ?>
            <p style="color:var(--muted);font-size:.9rem;margin:-8px 0 18px">
                Hay un CV publicado. Última actualización: <strong><?php echo s($modificado); ?></strong>.
            </p>
        <?php else : ?>
            <div class="alerta alerta--error">Aún no hay ningún CV publicado.</div>
        <?php endif; ?>

        <form method="POST" action="/admin/cv/subir" enctype="multipart/form-data">
            <div class="campo full">
                <span>Archivo PDF</span>
                <label class="upload-drop">
                    <b>Elige</b> o arrastra el PDF de tu CV<br><small>Solo PDF · reemplaza el actual</small>
                    <input type="file" name="cv_file" accept="application/pdf" required>
                </label>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn--primary">Publicar CV</button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-head"><h2>CV actual</h2><?php if ($existe) : ?><a href="/build/pdf/cv.pdf" target="_blank" class="btn btn--sm btn--ghost">Abrir ↗</a><?php endif; ?></div>
        <?php if ($existe) : ?>
            <iframe class="cv-preview" src="/build/pdf/cv.pdf#toolbar=0" title="CV actual"></iframe>
        <?php else : ?>
            <div class="placeholder" style="padding:60px 20px"><div class="emoji">📄</div><p>Sin CV para previsualizar.</p></div>
        <?php endif; ?>
    </div>
</div>
