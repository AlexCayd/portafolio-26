<?php
/**
 * Cabecera de las páginas internas (Tékhne, proyecto, películas).
 *
 * Trae el mismo menú que el home — Perfil, Proyectos, Servicios, Tékhne,
 * Cursos — para que la navegación no dependa de volver atrás. En escritorio
 * son enlaces; por debajo de 1000px se pliegan en el botón hamburguesa
 * (el breakpoint vive en .pg-nav / .pg-burger, en paginas.scss).
 *
 * El botón «← Tékhne» que vivía aquí se retiró: repetía lo que ya dice el
 * breadcrumb (partials/pg-crumb.php, que va justo debajo) y era lo que
 * descentraba el menú, porque ensanchaba .pg-actions solo en las páginas que
 * lo llevaban. Ahora los tres huecos de la barra tienen un ancho estable.
 *
 * Variables opcionales antes del include:
 *   $ao_top_wa      mensaje de WhatsApp del botón «Contáctame»
 *   $ao_top_extra   HTML propio de la vista (p. ej. el botón Focus)
 */
$ao_top_nav = [
    ['url' => '/#ao-core',      'texto' => 'Perfil'],
    ['url' => '/#ao-projects',  'texto' => 'Proyectos'],
    ['url' => '/#ao-expertise', 'texto' => 'Servicios'],
    ['url' => '/tekhne',        'texto' => 'Tékhne'],
    ['url' => '/#ao-teaching',  'texto' => 'Cursos'],
];
$ao_top_wa = $ao_top_wa ?? 'Hola Alexander, vi tu sitio y me gustaría platicar contigo.';
?>
<header class="pg-top">
    <a href="/" class="brand">Alexander <span>Oliva</span></a>

    <nav class="pg-nav" aria-label="Secciones del sitio">
        <?php foreach ($ao_top_nav as $ao_l) : ?>
            <a href="<?php echo s($ao_l['url']); ?>"><?php echo s($ao_l['texto']); ?></a>
        <?php endforeach; ?>
    </nav>

    <div class="pg-actions">
        <?php echo $ao_top_extra ?? ''; ?>
        <a class="pg-wa" href="<?php echo waLink($ao_top_wa); ?>" target="_blank" rel="noopener">Contáctame</a>
        <button type="button" class="pg-burger" id="pg-burger" aria-label="Abrir menú" aria-expanded="false" aria-controls="pg-menu">
            <span></span><span></span>
        </button>
    </div>
</header>

<!-- Menú a pantalla completa (móvil y tablet) -->
<div class="pg-menu" id="pg-menu">
    <nav aria-label="Menú principal">
        <?php foreach ($ao_top_nav as $ao_l) : ?>
            <a href="<?php echo s($ao_l['url']); ?>"><?php echo s($ao_l['texto']); ?></a>
        <?php endforeach; ?>
    </nav>
    <a class="pg-wa pg-menu-cta" href="<?php echo waLink($ao_top_wa); ?>" target="_blank" rel="noopener">Contáctame</a>
</div>
<?php
// Se limpian para que un segundo include en la misma página no herede opciones
unset($ao_top_extra, $ao_top_wa);
