<?php
/**
 * generar-iconos.php — genera el icono del sitio y la imagen para compartir.
 *
 * Por qué existe: los tres layouts apuntaban a /build/img/profile.png, un
 * retrato en semitono de 1366x644 y 1.4 MB. Como favicon no se lee (es una
 * foto deformada a 32 px y muchos navegadores ni la pintan) y como imagen de
 * Open Graph pesa de más.
 *
 * Genera, en public/build/img/:
 *   favicon-32.png    icono de pestaña (monograma AO)
 *   favicon-180.png   apple-touch-icon
 *   favicon-512.png   PWA / Android
 *   og-default.jpg    1200x630 para compartir (recorte de profile.png)
 *
 * Uso:  php scripts/generar-iconos.php
 */

$dir    = __DIR__ . '/../public/build/img';
$fuente = 'C:/Windows/Fonts/arialbd.ttf';     // solo se rasteriza, no se distribuye

$BG     = [0x0b, 0x0b, 0x0c];   // negro del sitio
$BLANCO = [0xf4, 0xf1, 0xea];
$ROJO   = [0xff, 0x0a, 0x24];   // --accent

/**
 * Monograma «AO» sobre cuadrado redondeado, igual que el logotipo del sitio:
 * «Alexander» en blanco y «Oliva» en rojo. Se dibuja a 4x y se reduce, que es
 * como GD consigue bordes limpios.
 */
function monograma(int $lado, array $bg, array $blanco, array $rojo, string $fuente) {
    $ss = 4;
    $n  = $lado * $ss;
    $im = imagecreatetruecolor($n, $n);
    imagealphablending($im, true);
    imagesavealpha($im, true);

    $cBg     = imagecolorallocate($im, ...$bg);
    $cBlanco = imagecolorallocate($im, ...$blanco);
    $cRojo   = imagecolorallocate($im, ...$rojo);
    $trans   = imagecolorallocatealpha($im, 0, 0, 0, 127);

    imagefill($im, 0, 0, $trans);

    // Cuadrado redondeado (radio ~22% del lado, como los botones del sitio)
    $r = (int) round($n * 0.22);
    imagefilledrectangle($im, $r, 0, $n - $r, $n, $cBg);
    imagefilledrectangle($im, 0, $r, $n, $n - $r, $cBg);
    foreach ([[$r, $r], [$n - $r, $r], [$r, $n - $r], [$n - $r, $n - $r]] as [$cx, $cy]) {
        imagefilledellipse($im, $cx, $cy, $r * 2, $r * 2, $cBg);
    }

    // «AO» centrado: la A blanca y la O roja
    $tam = $n * 0.46;
    $aA = imagettfbbox($tam, 0, $fuente, 'A');
    $aO = imagettfbbox($tam, 0, $fuente, 'O');
    $wA = $aA[2] - $aA[0];
    $wO = $aO[2] - $aO[0];
    $kern = -$tam * 0.06;                      // se aprietan un poco, como el wordmark
    $total = $wA + $kern + $wO;
    $x = (int) round(($n - $total) / 2);
    $y = (int) round($n / 2 + $tam * 0.36);

    imagettftext($im, $tam, 0, $x, $y, $cBlanco, $fuente, 'A');
    imagettftext($im, $tam, 0, (int) round($x + $wA + $kern), $y, $cRojo, $fuente, 'O');

    $out = imagecreatetruecolor($lado, $lado);
    imagealphablending($out, false);
    imagesavealpha($out, true);
    imagecopyresampled($out, $im, 0, 0, 0, 0, $lado, $lado, $n, $n);
    return $out;
}

if (!is_file($fuente)) {
    fwrite(STDERR, "No encuentro la fuente {$fuente}.\n");
    exit(1);
}

foreach ([32, 180, 512] as $lado) {
    $im = monograma($lado, $BG, $BLANCO, $ROJO, $fuente);
    imagepng($im, "{$dir}/favicon-{$lado}.png", 9);
    echo "  · favicon-{$lado}.png\n";
}

// Imagen para compartir: recorte 1200x630 de la portada, en JPG ligero
$src = @imagecreatefrompng("{$dir}/profile.png");
if ($src) {
    $sw = imagesx($src); $sh = imagesy($src);
    $ow = 1200; $oh = 630;
    $escala = max($ow / $sw, $oh / $sh);
    $nw = (int) round($sw * $escala); $nh = (int) round($sh * $escala);
    $og = imagecreatetruecolor($ow, $oh);
    imagecopyresampled($og, $src, (int) round(($ow - $nw) / 2), (int) round(($oh - $nh) / 2), 0, 0, $nw, $nh, $sw, $sh);
    imagejpeg($og, "{$dir}/og-default.jpg", 82);
    echo "  · og-default.jpg (" . number_format(filesize("{$dir}/og-default.jpg") / 1024) . " KB, antes 1,367 KB)\n";
}

echo "Listo. Recuerda que las rutas se imprimen con asset() para romper la caché.\n";
