<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- SEO primario -->
<title><?php echo $titulo ?? 'Alexander Oliva — Desarrollador de Software & Diseñador UX/UI en CDMX'; ?></title>
<meta name="description" content="Alexander Oliva, desarrollador de software y diseñador UX/UI en Ciudad de México. Construyo productos digitales de punta a punta: del código a la experiencia, con criterio humano.">
<meta name="keywords" content="Alexander Oliva, desarrollador de software, diseñador UX/UI, diseño de interfaces, desarrollo web, product designer, front-end, portafolio, CDMX">
<meta name="author" content="Alexander Oliva">
<meta name="robots" content="index, follow">
<meta name="theme-color" content="#0b0b0c">
<!-- TODO: reemplaza el dominio por el real cuando publiques -->
<link rel="canonical" href="https://alexanderoliva.com/">

<!-- Favicon -->
<link rel="icon" type="image/png" href="/build/img/profile.png">
<link rel="apple-touch-icon" href="/build/img/profile.png">

<!-- Open Graph / redes sociales -->
<meta property="og:type" content="website">
<meta property="og:site_name" content="Alexander Oliva">
<meta property="og:title" content="Alexander Oliva — Desarrollador de Software & Diseñador UX/UI">
<meta property="og:description" content="Construyo productos digitales de punta a punta: del código a la experiencia, bajo un mismo criterio: el de las personas.">
<meta property="og:image" content="/build/img/profile.png">
<meta property="og:url" content="https://alexanderoliva.com/">
<meta property="og:locale" content="es_MX">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Alexander Oliva — Desarrollador de Software & Diseñador UX/UI">
<meta name="twitter:description" content="Del código a la experiencia, bajo un mismo criterio: el de las personas.">
<meta name="twitter:image" content="/build/img/profile.png">

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
<link href="https://api.fontshare.com/v2/css?f[]=clash-display@500,600,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Space+Grotesk:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

<!-- Librerías de animación (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>

<!-- Estilos compilados del sitio -->
<link rel="stylesheet" href="/build/css/portfolio.css">
</head>
<body>
    <?php echo $contenido; ?>
    <script src="/build/js/bundle.min.js" defer></script>
</body>
</html>
