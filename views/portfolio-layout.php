<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
$ao_dominio = 'https://alexanderoliva.com';
$ao_desc = $metaDescripcion ?? 'Alexander Oliva, desarrollador de software y diseñador UX/UI en Ciudad de México. Construyo productos digitales de punta a punta: del código a la experiencia, con criterio humano.';
$ao_ogTitulo = $ogTitulo ?? ($titulo ?? 'Alexander Oliva - Desarrollador de Software & Diseñador UX/UI');
$ao_ogImg = $ogImagen ?? '/build/img/profile.png';
// Las imágenes OG deben ser URL absolutas para redes sociales
if (strpos($ao_ogImg, '/') === 0) { $ao_ogImg = $ao_dominio . $ao_ogImg; }
$ao_canonical = $canonical ?? 'https://alexanderoliva.com/';
$ao_ogTipo = $ogTipo ?? 'website';
?>
<!-- SEO primario -->
<title><?php echo $titulo ?? 'Alexander Oliva - Desarrollador de Software & Diseñador UX/UI en CDMX'; ?></title>
<meta name="description" content="<?php echo htmlspecialchars($ao_desc); ?>">
<meta name="keywords" content="Alexander Oliva, desarrollador de software, diseñador UX/UI, diseño de interfaces, desarrollo web, product designer, front-end, portafolio, CDMX">
<meta name="author" content="Alexander Oliva">
<meta name="robots" content="<?php echo $robots ?? 'index, follow'; ?>">
<meta name="theme-color" content="#0b0b0c">
<link rel="canonical" href="<?php echo htmlspecialchars($ao_canonical); ?>">

<!-- Favicon -->
<link rel="icon" type="image/png" href="/build/img/profile.png">
<link rel="apple-touch-icon" href="/build/img/profile.png">

<!-- Open Graph / redes sociales -->
<meta property="og:type" content="<?php echo htmlspecialchars($ao_ogTipo); ?>">
<meta property="og:site_name" content="Alexander Oliva">
<meta property="og:title" content="<?php echo htmlspecialchars($ao_ogTitulo); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($ao_desc); ?>">
<meta property="og:image" content="<?php echo htmlspecialchars($ao_ogImg); ?>">
<meta property="og:url" content="<?php echo htmlspecialchars($ao_canonical); ?>">
<meta property="og:locale" content="es_MX">
<?php if ($ao_ogTipo === 'article') : ?>
<meta property="article:author" content="Alexander Oliva">
<?php if (!empty($ogFecha)) : ?><meta property="article:published_time" content="<?php echo htmlspecialchars($ogFecha); ?>"><?php endif; ?>
<?php endif; ?>

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo htmlspecialchars($ao_ogTitulo); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($ao_desc); ?>">
<meta name="twitter:image" content="<?php echo htmlspecialchars($ao_ogImg); ?>">

<!-- Datos estructurados (schema.org Person) -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": "Alexander Oliva",
  "jobTitle": "Desarrollador de Software y Diseñador UX/UI",
  "url": "https://alexanderoliva.com/",
  "image": "/build/img/profile.png",
  "address": { "@type": "PostalAddress", "addressLocality": "Ciudad de México", "addressCountry": "MX" },
  "alumniOf": [
    { "@type": "CollegeOrUniversity", "name": "Universidad Anáhuac" },
    { "@type": "CollegeOrUniversity", "name": "UNAM" }
  ],
  "knowsAbout": ["Desarrollo de software", "Diseño UX/UI", "Diseño de interfaces", "Desarrollo web"]
}
</script>

<!-- Fuentes -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<!-- Clash Display autoalojada (no depende de la red: funciona en local y offline) -->
<link rel="preload" as="font" type="font/woff2" href="/build/fonts/ClashDisplay-Bold.woff2" crossorigin>
<style>
@font-face { font-family: 'Clash Display'; src: url('/build/fonts/ClashDisplay-Medium.woff2') format('woff2');   font-weight: 500; font-style: normal; font-display: swap; }
@font-face { font-family: 'Clash Display'; src: url('/build/fonts/ClashDisplay-Semibold.woff2') format('woff2'); font-weight: 600; font-style: normal; font-display: swap; }
@font-face { font-family: 'Clash Display'; src: url('/build/fonts/ClashDisplay-Bold.woff2') format('woff2');     font-weight: 700; font-style: normal; font-display: swap; }
</style>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

<!-- Librerías de animación (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/Flip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>

<!-- Estilos compilados del sitio -->
<link rel="stylesheet" href="<?php echo asset('/build/css/portfolio.css'); ?>">

<!-- Las transiciones entre páginas las hace View Transitions nativo:
     las reglas @view-transition / ::view-transition viven en portfolio.css
     (src/scss/portfolio/_transitions.scss). No hay interceptor de clicks:
     cualquier JS que llame a preventDefault() las anularía. -->
</head>
<body>
    <script>
    // Firefox y navegadores sin View Transitions: fundido de entrada equivalente,
    // sin telones ni barras. Se aplica antes de pintar para no ver el salto.
    (function () {
        if (document.startViewTransition) return;
        if (window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        var st = document.createElement('style');
        st.textContent = '@keyframes ao-fb-in{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}' +
                         'body{animation:ao-fb-in .42s cubic-bezier(.16,1,.3,1) both}';
        document.head.appendChild(st);
    })();
    </script>
    <?php echo $contenido; ?>
    <script src="<?php echo asset('/build/js/bundle.min.js'); ?>" defer></script>
</body>
</html>
