<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
$ao_dominio = 'https://alexanderoliva.com';
$ao_desc = $metaDescripcion ?? 'Alexander Oliva, desarrollador de software y diseñador UX/UI en Ciudad de México. Construyo productos digitales de punta a punta: del código a la experiencia, con criterio humano.';
$ao_ogTitulo = $ogTitulo ?? ($titulo ?? 'Alexander Oliva — Desarrollador de Software & Diseñador UX/UI');
$ao_ogImg = $ogImagen ?? '/build/img/profile.png';
// Las imágenes OG deben ser URL absolutas para redes sociales
if (strpos($ao_ogImg, '/') === 0) { $ao_ogImg = $ao_dominio . $ao_ogImg; }
$ao_canonical = $canonical ?? 'https://alexanderoliva.com/';
$ao_ogTipo = $ogTipo ?? 'website';
?>
<!-- SEO primario -->
<title><?php echo $titulo ?? 'Alexander Oliva — Desarrollador de Software & Diseñador UX/UI en CDMX'; ?></title>
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
<link href="https://api.fontshare.com/v2/css?f[]=clash-display@500,600,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

<!-- Librerías de animación (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>

<!-- Estilos compilados del sitio -->
<link rel="stylesheet" href="/build/css/portfolio.css">

<!-- Transición de página: paneles deslizantes (motion graphics) -->
<style>
#ao-pagefx { position: fixed; inset: 0; z-index: 99999; display: flex; pointer-events: none; visibility: hidden; }
#ao-pagefx.on { visibility: visible; }
/* Franjas alternadas negro/rojo (telón). Se solapan 1px para no dejar costuras. */
#ao-pagefx .ao-fx-panel { flex: 1 0 auto; width: calc(20% + 1px); margin-left: -1px; background: #0b0b0c; transform: scaleY(0); transform-origin: top; will-change: transform; }
#ao-pagefx .ao-fx-panel:first-child { margin-left: 0; }
#ao-pagefx .ao-fx-panel:nth-child(even) { background: var(--accent, #ff0a24); }
@media (prefers-reduced-motion: reduce) { #ao-pagefx { display: none; } }
</style>
</head>
<body>
    <div id="ao-pagefx" aria-hidden="true">
        <div class="ao-fx-panel"></div><div class="ao-fx-panel"></div><div class="ao-fx-panel"></div><div class="ao-fx-panel"></div><div class="ao-fx-panel"></div>
    </div>
    <script>
    // Entrada: si venimos de una navegación interna, cubre y revela con las franjas.
    (function () {
        var fx = document.getElementById('ao-pagefx');
        var panels = fx ? fx.querySelectorAll('.ao-fx-panel') : [];
        var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (!fx || reduce) { try { sessionStorage.removeItem('ao-nav'); } catch (e) {} }
        else if (sessionStorage.getItem('ao-nav')) {
            // Cubrir de inmediato (antes de pintar) y luego retirar hacia abajo
            fx.classList.add('on');
            panels.forEach(function (p) { p.style.transformOrigin = 'bottom'; p.style.transform = 'scaleY(1)'; });
            function salir() {
                if (!window.anime) { fx.classList.remove('on'); try { sessionStorage.removeItem('ao-nav'); } catch (e) {} return; }
                anime({ targets: panels, scaleY: [1, 0], duration: 560, delay: anime.stagger(70), easing: 'easeInOutQuart',
                    complete: function () { fx.classList.remove('on'); panels.forEach(function (p) { p.style.transform = 'scaleY(0)'; p.style.transformOrigin = 'top'; }); } });
                try { sessionStorage.removeItem('ao-nav'); } catch (e) {}
            }
            if (document.readyState === 'complete') salir(); else window.addEventListener('load', salir);
        }
    })();
    // Salida: intercepta enlaces internos y barre con las franjas antes de navegar.
    document.addEventListener('click', function (e) {
        if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        var a = e.target.closest('a[href]'); if (!a) return;
        var href = a.getAttribute('href') || '';
        if (a.target || a.hasAttribute('download')) return;
        if (href.charAt(0) === '#') return;                       // ancla
        if (a.origin !== location.origin) return;                 // externos / mailto / tel
        if (/\.(pdf|zip|png|jpe?g|webp|svg)$/i.test(a.pathname)) return;
        if (a.pathname === location.pathname && a.hash) return;   // ancla en la misma página
        var fx = document.getElementById('ao-pagefx');
        var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (!fx || reduce || !window.anime) return; // navegación normal
        e.preventDefault();
        try { sessionStorage.setItem('ao-nav', '1'); } catch (er) {}
        var panels = fx.querySelectorAll('.ao-fx-panel');
        fx.classList.add('on');
        panels.forEach(function (p) { p.style.transformOrigin = 'top'; });
        anime({ targets: panels, scaleY: [0, 1], duration: 520, delay: anime.stagger(64), easing: 'easeInOutQuart',
            complete: function () { window.location.href = a.href; } });
    });
    </script>
    <?php echo $contenido; ?>
    <script src="/build/js/bundle.min.js" defer></script>
</body>
</html>
