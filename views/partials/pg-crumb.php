<?php
/**
 * Breadcrumb de las páginas internas.
 *
 * Va justo después de pg-top.php y FUERA de <main>: se queda pegado bajo la
 * cabecera en cuanto el hero se va (position: sticky). Es quien hace ahora el
 * trabajo del botón «← Tékhne» que vivía en la barra — con la ventaja de que
 * dice el camino entero, no solo el escalón anterior.
 *
 * Variable obligatoria antes del include:
 *   $ao_crumb = [
 *       ['url' => '/',       'texto' => 'Home'],
 *       ['url' => '/tekhne', 'texto' => 'Tékhne'],
 *       ['texto' => 'Título actual'],      // el último va sin url
 *   ];
 *
 * El penúltimo eslabón es el «padre»: es el que queda solo en móvil, con la
 * flecha, porque es el único al que de verdad se vuelve desde aquí.
 */
if (empty($ao_crumb) || count($ao_crumb) < 2) { unset($ao_crumb); return; }

$ao_crumb      = array_values($ao_crumb);
$ao_crumb_ult  = count($ao_crumb) - 1;
$ao_crumb_padre = $ao_crumb_ult - 1;   // el escalón al que lleva el botón «volver»
?>
<?php /* Centinela: marca dónde está la barra ANTES de anclarse. paginas-foot.php
         lo vigila con un IntersectionObserver para saber si la barra está
         pegada al menú o todavía en su sitio, que es lo que decide si se pinta
         como banda o como simple línea. Mide 1px y lo recupera con un margen
         negativo: no ocupa nada. */ ?>
<div class="pg-crumb-centinela" aria-hidden="true"></div>
<nav class="pg-crumb-bar" aria-label="Ruta de navegación">
    <ol class="pg-crumb">
        <?php foreach ($ao_crumb as $ao_i => $ao_paso) : ?>
            <li class="<?php echo $ao_i === $ao_crumb_padre ? 'is-padre' : ''; ?>">
                <?php if ($ao_i > 0) : ?>
                    <span class="pg-crumb-sep" aria-hidden="true"><?php echo icono('chevron'); ?></span>
                <?php endif; ?>
                <?php if ($ao_i === $ao_crumb_ult || empty($ao_paso['url'])) : ?>
                    <span class="cur" aria-current="page"><?php echo s($ao_paso['texto']); ?></span>
                <?php else : ?>
                    <a href="<?php echo s($ao_paso['url']); ?>"><?php echo s($ao_paso['texto']); ?></a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>
<?php
// Se limpia para que un segundo include en la misma página no herede la ruta
unset($ao_crumb, $ao_crumb_ult, $ao_crumb_padre, $ao_i, $ao_paso);
