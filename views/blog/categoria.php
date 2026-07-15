<link rel="stylesheet" href="/build/css/paginas.css">
<div id="ao-app" data-theme="dark">
<div data-barba-namespace="blog-categoria">
    <header class="pg-top">
        <a href="/" class="brand">Alexander <span>Oliva</span></a>
        <div class="pg-actions">
            <a class="pg-back" href="/tekhne">Tékhne</a>
            <a class="pg-wa" href="<?php echo waLink('Hola Alexander, quiero platicar contigo.'); ?>" target="_blank" rel="noopener">Contáctame</a>
        </div>
    </header>

    <main class="pg pg--wide">
        <!-- Masthead editorial (como la portada de Tékhne) -->
        <div class="tk-masthead" data-anim>
            <div class="tk-issue">
                <span>Publicación de Alexander Oliva</span>
                <span><?php echo count($posts); ?> ARTÍCULO<?php echo count($posts) === 1 ? '' : 'S'; ?></span>
            </div>
            <h1 class="tk-wordmark"><?php echo s($categoriaNombre); ?></h1>
            <p class="tk-tagline">Todo lo publicado en Tékhne dentro de la categoría <em><?php echo s($categoriaNombre); ?></em>.</p>
        </div>

        <!-- Navegación por categorías (la actual, resaltada) -->
        <nav class="tk-cats" data-anim aria-label="Categorías">
            <a class="tk-cat" href="/tekhne">Todos</a>
            <?php foreach ($categorias as $cat) : $slug = generarSlug($cat); ?>
                <a class="tk-cat<?php echo $slug === $categoriaSlug ? ' is-on' : ''; ?>" href="/tekhne/categoria/<?php echo s($slug); ?>"><?php echo s($cat); ?></a>
            <?php endforeach; ?>
        </nav>

        <!-- Artículos -->
        <?php
        $ao_grads = [
            'repeating-linear-gradient(45deg,rgba(255,255,255,.06) 0 2px,transparent 2px 15px),linear-gradient(135deg,var(--accent) 0%,#1a0207 55%,#0b0b0c 100%)',
            'radial-gradient(rgba(255,255,255,.14) 1px,transparent 1.6px) 0 0/17px 17px,radial-gradient(130% 130% at 24% 18%,var(--accent) 0%,#1a0207 52%,#0b0b0c 100%)',
            'repeating-linear-gradient(90deg,rgba(255,255,255,.05) 0 1px,transparent 1px 13px),linear-gradient(115deg,#0b0b0c 18%,#1a0207 55%,var(--accent) 100%)',
        ];
        ?>
        <div class="pg-grid">
            <?php foreach ($posts as $ao_i => $post) :
                $cover = !empty($post->cover_img) ? "url('/build/img/blog/" . s($post->cover_img) . "') center/cover no-repeat" : $ao_grads[$ao_i % count($ao_grads)];
            ?>
                <a href="/tekhne/<?php echo s($post->slug ?: $post->id); ?>" data-anim data-vt-cover class="pg-card<?php echo $ao_i === 0 ? ' pg-card--feat' : ''; ?>">
                    <div class="pg-card-cover" data-vt-img style="background:<?php echo $cover; ?>;">
                        <span class="pg-cat"><?php echo s($post->categoria); ?></span>
                    </div>
                    <div class="pg-card-body">
                        <span class="pg-card-meta"><?php echo s($post->metaTarjeta()); ?></span>
                        <h3><?php echo s($post->titulo); ?></h3>
                        <p class="pg-card-desc"><?php echo s($post->descripcion); ?></p>
                        <span class="pg-card-read">Leer artículo →</span>
                    </div>
                </a>
            <?php endforeach; ?>
            <?php if (empty($posts)) : ?>
                <div class="tk-empty">Aún no hay entradas publicadas en esta categoría. Vuelve pronto.</div>
            <?php endif; ?>
        </div>
    </main>
</div>
</div>

<?php include __DIR__ . '/../partials/paginas-foot.php'; ?>
