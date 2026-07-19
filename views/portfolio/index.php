<!-- INTRO / ENTRADA AL SITIO -->
<div id="ao-intro" style="position:fixed;inset:0;z-index:100000;background:#0b0b0c;display:flex;flex-direction:column;justify-content:space-between;padding:clamp(24px,5vw,56px);overflow:hidden;font-family:'Space Grotesk',system-ui,sans-serif;">
  <div style="display:flex;justify-content:space-between;align-items:flex-start;">
    <span class="ao-intro-fade" style="font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.24em;color:rgba(242,240,234,.54);text-transform:uppercase;">Portafolio</span>
    <span class="ao-intro-fade" style="font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.24em;color:rgba(242,240,234,.54);text-transform:uppercase;">CDMX · MMXXVI</span>
  </div>

  <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;flex:1;text-align:center;">
    <span class="ao-intro-fade" style="font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.32em;color:#ff0a24;text-transform:uppercase;margin-bottom:20px;">Software Developer · UX/UI Designer</span>
    <h2 style="margin:0;font-family:'Clash Display',sans-serif;font-weight:700;line-height:.9;letter-spacing:-.03em;font-size:clamp(2.4rem,9vw,7rem);color:#f2f0ea;">
      <span style="display:block;overflow:hidden;"><span class="ao-intro-line" style="display:block;">ALEXANDER</span></span>
      <span style="display:block;overflow:hidden;"><span class="ao-intro-line" style="display:block;color:transparent;-webkit-text-stroke:1.4px #f2f0ea;">OLIVA</span></span>
    </h2>
  </div>

  <div style="display:flex;flex-direction:column;gap:14px;">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;">
      <span class="ao-intro-fade" style="font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.2em;color:rgba(242,240,234,.54);text-transform:uppercase;">Cargando experiencia</span>
      <span id="ao-intro-count" style="font-family:'Clash Display',sans-serif;font-weight:600;font-size:clamp(1.4rem,4vw,2.4rem);letter-spacing:-.02em;color:#f2f0ea;">0</span>
    </div>
    <div style="position:relative;width:100%;height:2px;background:rgba(242,240,234,.14);overflow:hidden;">
      <div id="ao-intro-bar" style="position:absolute;left:0;top:0;height:100%;width:0%;background:#ff0a24;"></div>
    </div>
  </div>
</div>

<div id="ao-app" data-theme="dark" style="background:var(--bg);color:var(--fg);font-family:'Space Grotesk',system-ui,sans-serif;position:relative;overflow-x:hidden;width:100%;transition:color .5s;">

  <canvas id="ao-webgl" style="position:fixed;inset:0;width:100%;height:100%;z-index:0;pointer-events:none;"></canvas>

  <div id="ao-cursor" class="ao-cursor-el" style="position:fixed;top:0;left:0;width:7px;height:7px;border-radius:50%;background:var(--accent);z-index:10000;pointer-events:none;transform:translate(-50%,-50%);will-change:transform;opacity:0;transition:opacity .2s;"></div>
  <div id="ao-ring" class="ao-cursor-el" style="position:fixed;top:0;left:0;width:42px;height:42px;border-radius:50%;border:1px solid rgba(140,140,140,.6);z-index:9999;pointer-events:none;transform:translate(-50%,-50%);mix-blend-mode:difference;will-change:transform,width,height;display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .2s;">
    <span id="ao-ring-label" style="font-family:'Space Mono',monospace;font-size:10px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#fff;background:var(--accent);border-radius:40px;padding:9px 16px;opacity:0;transform:scale(.6);transition:opacity .25s,transform .25s;white-space:nowrap;box-shadow:0 10px 30px rgba(0,0,0,.35);"></span>
  </div>

  <!-- NAV -->
  <nav id="ao-nav" style="position:fixed;top:0;left:0;width:100%;z-index:500;display:flex;align-items:center;justify-content:space-between;padding:16px clamp(20px,4vw,56px);border-bottom:1px solid transparent;transition:background .4s,backdrop-filter .4s,border-color .4s;">
    <a href="#ao-top" data-cursor data-magnetic style="text-decoration:none;color:var(--fg);display:flex;flex-direction:column;line-height:1;">
      <span style="font-family:'Clash Display',sans-serif;font-weight:700;font-size:16px;letter-spacing:-.01em;">ALEXANDER OLIVA</span>
      <span style="font-family:'Space Mono',monospace;font-size:9px;letter-spacing:.28em;color:var(--muted);margin-top:5px;">DEV · UX/UI · CDMX</span>
    </a>

    <div class="ao-navpill" style="display:flex;align-items:center;gap:2px;">
      <a class="ao-navlink" data-target="core" href="#ao-core" data-cursor style="position:relative;color:var(--fg);text-decoration:none;padding:9px 15px;border-radius:30px;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.14em;text-transform:uppercase;transition:color .3s;">Perfil<span class="ao-navline" style="position:absolute;left:15px;right:15px;bottom:5px;height:1.5px;background:var(--accent);transform:scaleX(0);transform-origin:left;transition:transform .35s cubic-bezier(.16,1,.3,1);"></span></a>
      <a class="ao-navlink" data-target="projects" href="#ao-projects" data-cursor style="position:relative;color:var(--fg);text-decoration:none;padding:9px 15px;border-radius:30px;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.14em;text-transform:uppercase;transition:color .3s;">Trabajos<span class="ao-navline" style="position:absolute;left:15px;right:15px;bottom:5px;height:1.5px;background:var(--accent);transform:scaleX(0);transform-origin:left;transition:transform .35s cubic-bezier(.16,1,.3,1);"></span></a>
      <a class="ao-navlink" data-target="expertise" href="#ao-expertise" data-cursor style="position:relative;color:var(--fg);text-decoration:none;padding:9px 15px;border-radius:30px;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.14em;text-transform:uppercase;transition:color .3s;">Servicios<span class="ao-navline" style="position:absolute;left:15px;right:15px;bottom:5px;height:1.5px;background:var(--accent);transform:scaleX(0);transform-origin:left;transition:transform .35s cubic-bezier(.16,1,.3,1);"></span></a>
      <a class="ao-navlink" data-target="teaching" href="#ao-teaching" data-cursor style="position:relative;color:var(--fg);text-decoration:none;padding:9px 15px;border-radius:30px;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.14em;text-transform:uppercase;transition:color .3s;">Cursos<span class="ao-navline" style="position:absolute;left:15px;right:15px;bottom:5px;height:1.5px;background:var(--accent);transform:scaleX(0);transform-origin:left;transition:transform .35s cubic-bezier(.16,1,.3,1);"></span></a>
      <a class="ao-navlink" data-target="blog" href="#ao-blog" data-cursor style="position:relative;color:var(--fg);text-decoration:none;padding:9px 15px;border-radius:30px;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.14em;text-transform:uppercase;transition:color .3s;">Tékhne<span class="ao-navline" style="position:absolute;left:15px;right:15px;bottom:5px;height:1.5px;background:var(--accent);transform:scaleX(0);transform-origin:left;transition:transform .35s cubic-bezier(.16,1,.3,1);"></span></a>
    </div>

    <div class="ao-nav-actions" style="display:flex;align-items:center;gap:14px;">
      <button id="ao-theme" data-cursor aria-label="Cambiar tema" style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;background:transparent;border:1px solid var(--line);color:var(--fg);border-radius:50%;cursor:pointer;transition:border-color .3s,color .3s;">
        <svg class="ao-icon-moon" viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"></path></svg>
        <svg class="ao-icon-sun" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"></path></svg>
      </button>
      <a class="ao-cta" href="<?php echo waLink('Hola Alexander, vi tu portafolio y me gustaría platicar contigo.'); ?>" target="_blank" rel="noopener" data-cursor data-magnetic style="color:var(--accent-fg);background:var(--accent);text-decoration:none;padding:11px 18px;border-radius:40px;font-weight:700;font-family:'Space Grotesk',sans-serif;font-size:13px;">Contáctame</a>
    </div>

    <button id="ao-nav-toggle" class="ao-nav-burger" aria-label="Abrir menú" aria-expanded="false" style="display:none;align-items:center;justify-content:center;width:44px;height:44px;background:var(--surface);border:1px solid var(--line);border-radius:50%;color:var(--fg);cursor:pointer;">
      <span style="position:relative;display:block;width:18px;height:12px;">
        <span class="ao-burger-line" style="position:absolute;left:0;top:0;width:100%;height:2px;background:var(--fg);border-radius:2px;transition:transform .35s cubic-bezier(.16,1,.3,1),opacity .2s;"></span>
        <span class="ao-burger-line" style="position:absolute;left:0;top:5px;width:100%;height:2px;background:var(--fg);border-radius:2px;transition:transform .35s cubic-bezier(.16,1,.3,1),opacity .2s;"></span>
        <span class="ao-burger-line" style="position:absolute;left:0;top:10px;width:100%;height:2px;background:var(--fg);border-radius:2px;transition:transform .35s cubic-bezier(.16,1,.3,1),opacity .2s;"></span>
      </span>
    </button>
  </nav>

  <!-- MOBILE MENU OVERLAY -->
  <div id="ao-nav-overlay" style="position:fixed;inset:0;z-index:490;background:var(--bg);display:flex;flex-direction:column;justify-content:center;gap:6px;padding:96px clamp(24px,7vw,48px) 40px;opacity:0;visibility:hidden;transform:translateY(-2%);transition:opacity .4s ease,transform .4s cubic-bezier(.16,1,.3,1),visibility .4s;">
    <a class="ao-mnav" href="#ao-core" style="color:var(--fg);text-decoration:none;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(2rem,10vw,3.4rem);line-height:1.12;letter-spacing:-.02em;">Perfil</a>
    <a class="ao-mnav" href="#ao-projects" style="color:var(--fg);text-decoration:none;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(2rem,10vw,3.4rem);line-height:1.12;letter-spacing:-.02em;">Trabajos</a>
    <a class="ao-mnav" href="#ao-expertise" style="color:var(--fg);text-decoration:none;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(2rem,10vw,3.4rem);line-height:1.12;letter-spacing:-.02em;">Servicios</a>
    <a class="ao-mnav" href="#ao-teaching" style="color:var(--fg);text-decoration:none;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(2rem,10vw,3.4rem);line-height:1.12;letter-spacing:-.02em;">Cursos</a>
    <a class="ao-mnav" href="#ao-blog" style="color:var(--fg);text-decoration:none;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(2rem,10vw,3.4rem);line-height:1.12;letter-spacing:-.02em;">Tékhne</a>
    <div style="margin-top:auto;display:flex;flex-wrap:wrap;align-items:center;gap:14px;padding-top:32px;border-top:1px solid var(--line);">
      <a href="<?php echo waLink('Hola Alexander, vi tu portafolio y me gustaría platicar contigo.'); ?>" target="_blank" rel="noopener" class="ao-mnav" style="flex:1 1 auto;text-align:center;background:var(--accent);color:var(--accent-fg);text-decoration:none;padding:15px 22px;border-radius:40px;font-family:'Clash Display',sans-serif;font-weight:700;font-size:1rem;">Contáctame</a>
      <a href="/build/pdf/cv.pdf" download style="flex:1 1 auto;text-align:center;border:1px solid var(--line);color:var(--fg);text-decoration:none;padding:15px 22px;border-radius:40px;font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.12em;text-transform:uppercase;">Descargar CV</a>
      <button id="ao-theme-m" type="button" aria-label="Cambiar tema" style="flex:1 1 auto;display:inline-flex;align-items:center;justify-content:center;gap:10px;background:transparent;border:1px solid var(--line);color:var(--fg);border-radius:40px;padding:15px 22px;font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.12em;text-transform:uppercase;cursor:pointer;">
        <svg class="ao-icon-moon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"></path></svg>
        <svg class="ao-icon-sun" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"></path></svg>
        Tema
      </button>
    </div>
  </div>

  <!-- HERO -->
  <section id="ao-top" style="position:relative;z-index:2;min-height:100vh;display:flex;flex-direction:column;justify-content:center;padding:120px clamp(20px,4vw,56px) 60px;">
    <div aria-hidden="true" style="position:absolute;inset:0;z-index:0;pointer-events:none;background:linear-gradient(180deg,transparent 64%,color-mix(in srgb,var(--bg) 42%,transparent) 100%);"></div>
    <div style="position:relative;z-index:2;display:flex;align-items:center;gap:14px;margin-bottom:clamp(20px,4vh,40px);">
      <span style="width:2px;height:16px;border-radius:2px;background:var(--accent);flex:none;"></span>
      <span style="font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.26em;color:var(--muted);text-transform:uppercase;">Software Developer · UX/UI Designer · CDMX</span>
    </div>

    <h1 style="position:relative;z-index:2;margin:0;font-family:'Clash Display',sans-serif;font-weight:700;line-height:.88;letter-spacing:-.035em;font-size:clamp(2.1rem,8.4vw,7.5rem);text-shadow:0 2px 34px color-mix(in srgb,var(--bg) 72%,transparent);">
      <span style="display:block;overflow:hidden;"><span class="ao-line" style="display:block;">ALEXANDER</span></span>
      <span style="display:block;overflow:hidden;"><span class="ao-line" style="display:block;color:transparent;-webkit-text-stroke:1.4px var(--fg);">OLIVA</span></span>
    </h1>

    <div style="position:relative;z-index:2;display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:32px;margin-top:clamp(26px,5vh,50px);">
      <p id="ao-hero-sub" style="margin:0;max-width:620px;font-size:clamp(1rem,1.4vw,1.3rem);line-height:1.5;color:var(--fg);opacity:.92;text-shadow:0 1px 22px color-mix(in srgb,var(--bg) 78%,transparent);">Hago software y diseño interfaces que se entienden a la primera. Escribo el código y cuido la experiencia, siempre pensando en la persona que está del otro lado de la pantalla.</p>
      <a class="ao-cta" href="#ao-footer" data-cursor data-magnetic style="flex:none;display:inline-flex;align-items:center;gap:14px;background:var(--accent);color:var(--accent-fg);text-decoration:none;padding:18px 28px;border-radius:50px;font-family:'Clash Display',sans-serif;font-weight:700;font-size:1rem;">Contáctame
        <span style="display:inline-flex;width:32px;height:32px;border-radius:50%;background:var(--accent-fg);color:var(--accent);align-items:center;justify-content:center;font-size:15px;">↓</span>
      </a>
    </div>

    <div style="position:absolute;z-index:2;bottom:26px;left:50%;transform:translateX(-50%);display:flex;flex-direction:column;align-items:center;gap:8px;font-family:'Space Mono',monospace;font-size:10px;letter-spacing:.24em;color:var(--muted);">
      <span>DESLIZA</span>
      <span style="font-size:15px;animation:ao-cue 1.6s ease-in-out infinite;">↓</span>
    </div>
  </section>

  <!-- PERFIL / ABOUT -->
  <section id="ao-core" style="position:relative;z-index:2;background:var(--bg);color:var(--fg);padding:clamp(80px,12vh,150px) clamp(20px,4vw,56px);transition:background .5s,color .5s;">
    <div class="ao-core-grid" style="display:grid;grid-template-columns:1.15fr .85fr;gap:clamp(30px,5vw,72px);align-items:start;">
      <div>
        <span data-reveal style="display:block;font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.24em;color:var(--muted);">/ 01 — QUIÉN FIRMA ESTO</span>
        <h2 data-reveal style="margin:18px 0 0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1.8rem,3.8vw,3.4rem);line-height:1.04;letter-spacing:-.025em;">Desarrollador de software.<br>Diseñador UX/UI.<br><span style="color:transparent;-webkit-text-stroke:1.1px var(--fg);">Científico social de fondo.</span></h2>
        <p data-reveal style="margin:24px 0 0;max-width:540px;font-size:clamp(1rem,1.3vw,1.15rem);line-height:1.6;color:var(--fg);opacity:.78;">Construyo productos digitales de punta a punta: escribo el código y diseño la experiencia. Vivo entre la ingeniería y las personas, y traduzco problemas reales en software simple y humano.</p>

        <div data-reveal-stagger style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:40px;">
          <div style="border:1px solid var(--line);border-radius:12px;padding:22px;display:flex;flex-direction:column;gap:14px;">
            <div style="width:80px;height:80px;border-radius:14px;background:var(--chip);display:flex;align-items:center;justify-content:center;overflow:hidden;padding:11px;"><img src="/build/img/logos/anahuac.png" alt="Universidad Anáhuac" style="max-width:100%;max-height:100%;object-fit:contain;"></div>
            <span style="font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.14em;color:var(--muted);">2022 — 2027</span>
            <h3 style="margin:0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:1.15rem;line-height:1.15;">Ingeniería en Sistemas y Tecnologías</h3>
            <p style="margin:0;font-size:13px;color:var(--muted);">Universidad Anáhuac</p>
          </div>
          <div style="border:1px solid var(--line);border-radius:12px;padding:22px;display:flex;flex-direction:column;gap:14px;">
            <div style="width:80px;height:80px;border-radius:14px;background:var(--chip);display:flex;align-items:center;justify-content:center;overflow:hidden;padding:11px;"><img src="/build/img/logos/unam.jpg" alt="UNAM" style="max-width:100%;max-height:100%;object-fit:contain;"></div>
            <span style="font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.14em;color:var(--muted);">2025 — 2028</span>
            <h3 style="margin:0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:1.15rem;line-height:1.15;">Ciencias de la Comunicación</h3>
            <p style="margin:0;font-size:13px;color:var(--muted);">UNAM</p>
          </div>
        </div>
      </div>

      <div style="position:relative;">
        <div style="border-radius:12px;overflow:hidden;background:#0b0b0c;aspect-ratio:3/4;">
          <img src="/build/img/profile.png" alt="Alexander Oliva" style="width:100%;height:100%;object-fit:cover;display:block;">
        </div>
      </div>
    </div>
  </section>

  <!-- PROJECTS (staggered gallery) -->
  <section id="ao-projects" style="position:relative;z-index:2;background:var(--bg);border-top:1px solid var(--line);padding:clamp(80px,12vh,150px) clamp(20px,4vw,56px) clamp(50px,9vh,110px);">
    <div data-reveal style="margin:0 0 clamp(34px,7vh,80px);">
      <span style="font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.24em;color:var(--accent);">/ 02 — PORTAFOLIO</span>
      <h2 style="margin:16px 0 0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(2.2rem,5vw,4.4rem);line-height:.98;letter-spacing:-.02em;">Un poco de lo que he <em style="font-style:normal;font-weight:700;color:var(--accent);">hecho</em></h2>
      <p style="margin:22px 0 0;max-width:460px;color:var(--muted);font-size:1rem;line-height:1.55;">Aquí están algunos de los proyectos que desarrollé &mdash; échales un ojo con las flechas o los puntos, a tu ritmo.</p>
    </div>

    <!-- Proyectos administrados desde /admin (inyectados para el slider) -->
    <script>window.AO_PROJECTS = <?php echo json_encode($proyectosJs ?? [], JSON_UNESCAPED_UNICODE); ?>;</script>

    <?php if (!empty($proyectosJs)) : ?>
    <!-- 3-up auto slider (cards built by JS) -->
    <div class="ao-slider" id="ao-proj-slider">
      <div class="ao-slider-viewport">
        <div class="ao-slider-track" id="ao-slider-track"></div>
      </div>
      <div class="ao-slider-ui">
        <button class="ao-slider-btn" data-dir="prev" aria-label="Proyecto anterior" data-cursor>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
        </button>
        <div class="ao-slider-dots" id="ao-slider-dots"></div>
        <button class="ao-slider-btn" data-dir="next" aria-label="Proyecto siguiente" data-cursor>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
        </button>
      </div>
    </div>
    <?php else : ?>
    <div data-reveal style="border:1px dashed var(--line);border-radius:18px;padding:clamp(40px,7vh,80px) clamp(20px,4vw,40px);text-align:center;color:var(--muted);font-size:1.05rem;">Muy pronto compartiré aquí mis proyectos.</div>
    <?php endif; ?>
  </section>

  <!-- CORAZÓN DE TIERRA -->
  <section id="ao-corazon" style="position:relative;z-index:2;background:var(--bg);padding:clamp(80px,12vh,150px) clamp(20px,4vw,56px);border-top:1px solid var(--line);">
    <div data-reveal style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:16px;margin-bottom:clamp(28px,5vh,52px);">
      <div>
        <span style="font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.24em;color:var(--accent);">/ 03 — RECONOCIMIENTO</span>
        <h2 style="margin:14px 0 0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1.9rem,3.6vw,3rem);letter-spacing:-.02em;">Una investigación mexicana <em style="font-style:normal;font-weight:700;color:var(--accent);">en Oxford</em></h2>
      </div>
      <p style="margin:0;max-width:320px;color:var(--muted);font-size:.95rem;line-height:1.5;">Un trabajo del que estoy muy orgulloso: investigación con impacto real, reconocida a nivel nacional e internacional.</p>
    </div>

    <!-- Award feature — full-bleed poster (Corazón de Tierra) -->
    <div data-reveal class="ao-ct-poster" style="position:relative;border-radius:16px;overflow:hidden;background:#0b0b0c;color:#f4f1ea;min-height:clamp(480px,72vh,660px);">
      <img src="/build/img/corazondetierra.png" alt="Corazón de Tierra" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
      <div style="position:absolute;inset:0;background:linear-gradient(270deg,rgba(8,8,9,.84) 0%,rgba(8,8,9,.34) 50%,rgba(8,8,9,.04) 100%),linear-gradient(180deg,rgba(8,8,9,.28) 0%,rgba(8,8,9,0) 34%,rgba(8,8,9,.55) 68%,rgba(8,8,9,.94) 100%);"></div>

      <!-- top-right: rotating medal -->
      <div class="ao-ct-medal" style="position:absolute;top:clamp(18px,3vw,34px);right:clamp(18px,3vw,34px);width:clamp(92px,10vw,132px);height:clamp(92px,10vw,132px);border-radius:50%;background:rgba(11,11,12,.86);border:2px solid var(--accent);color:#f4f1ea;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 24px rgba(0,0,0,.28),0 22px 54px rgba(0,0,0,.36);backdrop-filter:blur(4px);">
        <svg viewBox="0 0 200 200" style="position:absolute;inset:0;width:100%;height:100%;animation:ao-spin 20s linear infinite;">
          <defs><path id="ao-circle" d="M100,100 m-74,0 a74,74 0 1,1 148,0 a74,74 0 1,1 -148,0"></path></defs>
          <text style="font-family:'Space Mono',monospace;font-size:13px;fill:var(--accent);"><textPath href="#ao-circle" startOffset="0" textLength="465" lengthAdjust="spacingAndGlyphs">MAP THE SYSTEM 2025 · UNIVERSITY OF OXFORD · </textPath></text>
        </svg>
        <div style="text-align:center;line-height:1;">
          <div style="font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1.4rem,2vw,1.9rem);color:var(--accent);">1º</div>
          <div style="font-family:'Space Mono',monospace;font-size:9px;letter-spacing:.18em;margin-top:5px;">LUGAR</div>
        </div>
      </div>

      <!-- bottom-left: Oxford plaque -->
      <div class="ao-ct-plaque" style="position:absolute;left:clamp(18px,3vw,34px);bottom:clamp(18px,3vw,34px);z-index:2;background:#fff;border-radius:12px;display:inline-flex;align-items:center;padding:14px 22px;box-shadow:0 8px 20px rgba(0,0,0,.22),0 18px 44px rgba(0,0,0,.30);"><img src="/build/img/logos/oxford.png" alt="University of Oxford" style="height:clamp(34px,4vw,54px);width:auto;display:block;"></div>

      <!-- bottom-right: content inside the cover -->
      <div class="ao-ct-content" style="position:absolute;left:0;right:0;bottom:0;padding:clamp(26px,4vw,52px);max-width:600px;margin-left:auto;text-align:right;">
        <span style="font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.18em;color:var(--accent);">1ER LUGAR NACIONAL (MÉXICO)</span>
        <h3 style="margin:14px 0 0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(2rem,4.4vw,3.4rem);line-height:1;letter-spacing:-.02em;">Corazón de Tierra</h3>
        <p style="margin:16px 0 0;margin-left:auto;max-width:520px;color:rgba(244,241,234,.85);font-size:1rem;line-height:1.55;">Un proyecto sobre la desigualdad en el sector agrícola y la transformación del campo. Primer lugar en <em>Map the System 2025</em>, University of Oxford.</p>
        <a href="https://www.anahuac.mx/mexico/noticias/alumnos-anahuac-final-global-map-the-system-oxford" target="_blank" data-cursor data-magnetic style="margin-top:24px;display:inline-flex;align-items:center;gap:10px;background:var(--accent);color:var(--accent-fg);text-decoration:none;padding:14px 26px;border-radius:40px;font-family:'Clash Display',sans-serif;font-weight:700;font-size:.98rem;">Conocer más <span style="font-size:1.1em;line-height:1">→</span></a>
      </div>
    </div>
  </section>

  <!-- EXPERTISE (horizontal scroll) -->
  <section id="ao-expertise" style="position:relative;z-index:2;background:var(--surface);">
    <div id="ao-exp-pin" style="height:100vh;overflow:hidden;display:flex;align-items:center;">
      <div id="ao-exp-track" style="display:flex;align-items:stretch;gap:clamp(20px,2.5vw,36px);padding:0 clamp(20px,4vw,56px);will-change:transform;">

        <div style="flex:none;width:min(78vw,440px);display:flex;flex-direction:column;justify-content:center;">
          <span style="font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.24em;color:var(--accent);">/ 04 — SERVICIOS</span>
          <h2 style="margin:18px 0 0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(2.2rem,5vw,4rem);line-height:.98;letter-spacing:-.02em;">En qué te puedo <em style="font-style:normal;font-weight:700;color:var(--accent);">ayudar</em></h2>
          <p style="margin:22px 0 0;max-width:360px;color:var(--muted);font-size:1rem;line-height:1.55;">Varias disciplinas, un mismo estándar. Sigue deslizando &rarr;</p>
        </div>

        <?php foreach ($servicios as $svIndex => $servicio) : ?>
        <article class="ao-svc" data-cursor style="flex:none;width:min(80vw,460px);display:flex;flex-direction:column;justify-content:space-between;gap:28px;padding:clamp(28px,3vw,44px);border:1px solid var(--line);border-radius:16px;background:var(--bg);">
          <span style="font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(2.6rem,4vw,3.6rem);color:var(--accent);line-height:1;"><?php echo sprintf('%02d', $svIndex + 1); ?></span>
          <div>
            <h3 style="margin:0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1.7rem,2.6vw,2.4rem);letter-spacing:-.02em;"><?php echo $servicio->titulo; ?></h3>
            <p style="margin:16px 0 0;color:var(--muted);font-size:1.02rem;line-height:1.55;"><?php echo $servicio->descripcion; ?></p>
          </div>
          <div style="display:flex;flex-direction:column;gap:18px;">
            <div style="display:flex;flex-wrap:wrap;gap:8px;">
              <?php foreach ($servicio->tagsArray() as $tag) : ?>
              <span style="font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.08em;border:1px solid var(--line);border-radius:30px;padding:7px 13px;color:var(--muted);"><?php echo $tag; ?></span>
              <?php endforeach; ?>
            </div>
            <a class="ao-svc-cta" href="<?php echo waLink('Hola Alexander, me interesa cotizar el servicio de «' . $servicio->titulo . '». ¿Podemos platicar?'); ?>" target="_blank" rel="noopener" data-cursor style="display:inline-flex;align-items:center;justify-content:center;gap:10px;background:var(--accent);color:var(--accent-fg);text-decoration:none;padding:13px 20px;border-radius:40px;font-family:'Space Grotesk',sans-serif;font-weight:700;font-size:.95rem;transition:filter .2s,transform .2s;">
              Cotizar
              <span style="font-size:1.05em;line-height:1;">→</span>
            </a>
          </div>
        </article>
        <?php endforeach; ?>

      </div>
    </div>
  </section>

  <!-- BLOG (debajo de Servicios) -->
  <section id="ao-blog" style="position:relative;z-index:2;background:var(--surface);padding:clamp(80px,12vh,150px) clamp(20px,4vw,56px);border-top:1px solid var(--line);">
    <div data-reveal style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:20px;margin-bottom:clamp(28px,5vh,52px);">
      <div>
        <span style="font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.24em;color:var(--accent);">/ 05 — TÉKHNE</span>
        <h2 style="margin:14px 0 0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1.9rem,3.6vw,3rem);letter-spacing:-.02em;">Tékhne</h2>
        <p style="margin:16px 0 0;max-width:440px;color:var(--muted);font-size:1rem;line-height:1.55;">Mi proyecto como periodista y analista: miro la actualidad con lente interdisciplinario y escribo sobre lo que conecta libros, cine, noticias y cuentos.</p>
      </div>
      <a href="/tekhne" data-cursor data-magnetic style="display:inline-flex;align-items:center;gap:10px;background:var(--accent);color:var(--accent-fg);text-decoration:none;padding:14px 26px;border-radius:40px;font-family:'Clash Display',sans-serif;font-weight:700;font-size:1rem;white-space:nowrap;">Entrar a Tékhne <span style="font-size:1.1em;line-height:1;">→</span></a>
    </div>

    <div data-reveal-stagger style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,320px),1fr));gap:clamp(16px,2.4vw,24px);">

      <?php
      $ao_grads = [
        'repeating-linear-gradient(45deg,rgba(255,255,255,.06) 0 2px,transparent 2px 15px),linear-gradient(135deg,var(--accent) 0%,#1a0207 55%,#0b0b0c 100%)',
        'radial-gradient(rgba(255,255,255,.14) 1px,transparent 1.6px) 0 0/17px 17px,radial-gradient(130% 130% at 24% 18%,var(--accent) 0%,#1a0207 52%,#0b0b0c 100%)',
        'repeating-linear-gradient(90deg,rgba(255,255,255,.05) 0 1px,transparent 1px 13px),linear-gradient(115deg,#0b0b0c 18%,#1a0207 55%,var(--accent) 100%)',
      ];
      foreach ($posts as $ao_i => $post) :
        $ao_cover = !empty($post->cover_img)
          ? "url('/build/img/blog/" . s($post->cover_img) . "') center/cover no-repeat"
          : $ao_grads[$ao_i % count($ao_grads)];
      ?>
      <a class="ao-post" data-vt-cover href="/tekhne/<?php echo s($post->slug ?: $post->id); ?>" data-cursor data-cursor-label="LEER" style="display:flex;flex-direction:column;border:1px solid var(--line);border-radius:16px;overflow:hidden;background:var(--bg);text-decoration:none;color:var(--fg);transition:transform .4s cubic-bezier(.16,1,.3,1),border-color .4s,box-shadow .4s;">
        <div class="ao-post-cover" data-vt-img style="position:relative;aspect-ratio:16/9;background:<?php echo $ao_cover; ?>;">
          <span style="position:absolute;top:14px;left:14px;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.12em;color:var(--accent-fg);background:rgba(8,8,9,.4);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,.16);padding:6px 12px;border-radius:30px;"><?php echo s($post->categoria); ?></span>
          <span style="position:absolute;bottom:14px;right:14px;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.14em;color:#f4f1ea;background:rgba(8,8,9,.5);backdrop-filter:blur(6px);padding:6px 12px;border-radius:30px;"><?php echo s($post->metaTarjeta()); ?></span>
        </div>
        <div style="display:flex;flex-direction:column;gap:12px;padding:clamp(22px,2.4vw,28px);flex:1;">
          <h3 style="margin:0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1.35rem,2vw,1.7rem);line-height:1.12;letter-spacing:-.01em;"><?php echo s($post->titulo); ?></h3>
          <p style="margin:0;color:var(--muted);font-size:.96rem;line-height:1.5;"><?php echo s($post->descripcion); ?></p>
          <span style="margin-top:auto;display:inline-flex;align-items:center;gap:8px;font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.1em;color:var(--accent);">Leer artículo <span class="ao-post-arrow" style="display:inline-block;transition:transform .35s cubic-bezier(.16,1,.3,1);">→</span></span>
        </div>
      </a>
      <?php endforeach; ?>

    </div>
  </section>

  <!-- FORMACIÓN & CERTIFICACIONES -->
  <section id="ao-formacion" style="position:relative;z-index:2;background:var(--bg);padding:clamp(80px,12vh,150px) clamp(20px,4vw,56px);">
    <div data-reveal style="display:flex;align-items:baseline;justify-content:space-between;flex-wrap:wrap;gap:14px;margin-bottom:clamp(28px,5vh,52px);">
      <div>
        <span style="font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.24em;color:var(--accent);">/ 05 — CREDENCIALES</span>
        <h2 style="margin:14px 0 0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1.9rem,3.6vw,3rem);letter-spacing:-.02em;">Nunca dejo de <em style="font-style:normal;font-weight:700;color:var(--accent);">aprender</em></h2>
      </div>
      <?php if (!empty($credenciales)) : ?>
      <span style="font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.2em;color:var(--muted);"><?php echo count($credenciales); ?> CREDENCIAL<?php echo count($credenciales) === 1 ? '' : 'ES'; ?> · <?php echo count($instituciones); ?> <?php echo count($instituciones) === 1 ? 'INSTITUCIÓN' : 'INSTITUCIONES'; ?></span>
      <?php endif; ?>
    </div>

    <div data-reveal-stagger style="display:grid;grid-template-columns:repeat(auto-fill,minmax(clamp(230px,30vw,320px),1fr));gap:18px;">

      <?php foreach ($credenciales as $cred) : ?>
      <div class="ao-cert" style="border:1px solid var(--line);border-radius:12px;padding:22px;display:flex;flex-direction:column;gap:16px;min-height:172px;transition:transform .4s cubic-bezier(.16,1,.3,1),border-color .4s,box-shadow .4s;">
        <div style="display:flex;align-items:center;justify-content:space-between;">
          <div style="width:48px;height:48px;border-radius:10px;background:var(--chip);display:flex;align-items:center;justify-content:center;padding:7px;overflow:hidden;"><img src="/build/img/logos/<?php echo $cred->logo; ?>" alt="<?php echo $cred->alt; ?>" style="max-width:100%;max-height:100%;object-fit:contain;border-radius:5px;"></div>
          <span style="font-family:'Space Mono',monospace;font-size:11px;color:var(--muted);letter-spacing:.1em;"><?php echo s($cred->anio); ?></span>
        </div>
        <div style="margin-top:auto;">
          <h3 style="margin:0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:1.08rem;line-height:1.2;"><?php echo $cred->titulo; ?></h3>
          <p style="margin:8px 0 0;font-size:13px;color:var(--muted);line-height:1.35;"><span style="color:var(--accent);"><?php echo $cred->institucion; ?></span></p>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </section>

  <!-- INSTITUTIONS MARQUEE (dinámico: instituciones de las credenciales) -->
  <?php if (!empty($instituciones)) : ?>
  <section aria-label="Instituciones" style="position:relative;z-index:2;background:var(--surface);padding:clamp(22px,4vh,36px) 0;border-top:1px solid var(--line);border-bottom:1px solid var(--line);overflow:hidden;">
    <div style="display:flex;width:max-content;align-items:center;animation:ao-marquee 40s linear infinite;">
      <?php for ($i = 0; $i < 2; $i++) : ?>
      <div style="display:flex;align-items:center;gap:clamp(20px,3vw,44px);padding-right:clamp(20px,3vw,44px);"><?php foreach ($instituciones as $inst) : ?><span style="font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1.2rem,2.2vw,1.9rem);letter-spacing:-.01em;color:var(--fg);white-space:nowrap;"><?php echo s($inst); ?></span><span style="width:8px;height:8px;border-radius:50%;background:var(--accent);flex:none;"></span><?php endforeach; ?></div>
      <?php endfor; ?>
    </div>
  </section>
  <?php endif; ?>

  <!-- TEACHING -->
  <section id="ao-teaching" style="position:relative;z-index:2;background:var(--bg);padding:clamp(80px,12vh,150px) clamp(20px,4vw,56px);">
    <div data-reveal style="display:flex;align-items:baseline;justify-content:space-between;flex-wrap:wrap;gap:14px;margin-bottom:clamp(28px,5vh,52px);">
      <div>
        <span style="font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.24em;color:var(--accent);">/ 06 — DOCENCIA</span>
        <h2 style="margin:14px 0 0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1.9rem,3.6vw,3rem);letter-spacing:-.02em;">También me gusta <em style="font-style:normal;font-weight:700;color:var(--accent);">enseñar</em></h2>
      </div>
      <div class="ao-count-block" style="text-align:right;">
        <span id="ao-count" data-target="25000" style="display:block;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(2rem,4.4vw,3.6rem);line-height:1;letter-spacing:-.02em;color:var(--accent);">+25,000</span>
        <span style="display:block;margin-top:8px;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.22em;color:var(--muted);">ESTUDIANTES INSCRITOS EN MIS CURSOS</span>
      </div>
    </div>

    <div data-reveal-stagger style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,340px),1fr));gap:clamp(18px,2.5vw,28px);">

      <?php foreach ($cursos as $curso) : ?>
      <article class="ao-course" data-cursor data-cursor-label="VISITAR" data-href="<?php echo $curso['href']; ?>" style="position:relative;cursor:pointer;border:1px solid var(--line);border-radius:16px;overflow:hidden;background:#0b0b0c;aspect-ratio:16/10;transition:transform .4s cubic-bezier(.16,1,.3,1),border-color .4s;">
        <img class="ao-course-img" src="/build/img/<?php echo $curso['img']; ?>" alt="<?php echo $curso['alt']; ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;display:block;transition:transform .8s cubic-bezier(.16,1,.3,1);">
        <div style="position:absolute;inset:0;background:linear-gradient(180deg,rgba(8,8,9,.32) 0%,rgba(8,8,9,0) 36%,rgba(8,8,9,.8) 100%);"></div>
        <span style="position:absolute;top:16px;left:16px;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.14em;background:var(--accent);color:var(--accent-fg);padding:6px 12px;border-radius:30px;"><?php echo $curso['num']; ?></span>
        <span style="position:absolute;top:16px;right:16px;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.14em;color:#f4f1ea;background:rgba(8,8,9,.5);backdrop-filter:blur(6px);padding:6px 12px;border-radius:30px;">UDEMY</span>
        <div style="position:absolute;left:0;right:0;bottom:0;padding:clamp(22px,2.6vw,30px);color:#f4f1ea;">
          <span style="font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.18em;color:rgba(244,241,234,.72);"><?php echo $curso['categoria']; ?></span>
          <h3 style="margin:6px 0 0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1.5rem,2.6vw,2.1rem);line-height:1;"><?php echo $curso['titulo']; ?></h3>
        </div>
        <div class="ao-course-overlay">
          <span style="font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.18em;opacity:.85;"><?php echo $curso['categoria']; ?></span>
          <h3 style="margin:0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1.5rem,2.6vw,2.1rem);line-height:1;"><?php echo $curso['titulo']; ?></h3>
          <p style="margin:0;font-size:.95rem;line-height:1.5;opacity:.95;"><?php echo $curso['desc']; ?></p>
          <span style="display:inline-flex;align-items:center;gap:10px;font-family:'Clash Display',sans-serif;font-weight:700;font-size:1rem;">Ver el curso <span style="font-size:1.1em;line-height:1">→</span></span>
        </div>
      </article>
      <?php endforeach; ?>

    </div>

    <!-- Talleres a la medida para organizaciones -->
    <div data-reveal style="margin-top:clamp(28px,5vh,52px);position:relative;overflow:hidden;border-radius:24px;border:1px solid color-mix(in srgb,var(--accent) 22%,var(--line));background:linear-gradient(135deg,color-mix(in srgb,var(--accent) 12%,var(--surface)) 0%,var(--surface) 58%);box-shadow:0 30px 60px -30px color-mix(in srgb,var(--accent) 30%,transparent);padding:clamp(30px,4vw,56px);">
      <div aria-hidden="true" style="position:absolute;top:-42%;right:-6%;width:min(46vw,440px);height:min(46vw,440px);border-radius:50%;background:radial-gradient(circle,color-mix(in srgb,var(--accent) 22%,transparent) 0%,transparent 68%);pointer-events:none;"></div>
      <div style="position:relative;z-index:1;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:clamp(26px,4vw,52px);">
        <div style="flex:1 1 460px;max-width:680px;">
          <span style="display:inline-flex;align-items:center;gap:10px;">
            <span style="display:inline-grid;place-items:center;width:34px;height:34px;border-radius:10px;background:var(--accent);color:var(--accent-fg);flex:none;"><svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.2 6.3L21 9l-5.4 4 2 6.6L12 16l-5.6 3.6 2-6.6L3 9l6.8-.7z"/></svg></span>
            <span style="font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.22em;color:var(--accent);">TALLERES A LA MEDIDA</span>
          </span>
          <h3 style="margin:18px 0 0;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1.7rem,3.2vw,2.8rem);line-height:1.02;letter-spacing:-.02em;">Capacito a tu equipo en lo que <em style="font-style:normal;font-weight:700;color:var(--accent);">viene</em></h3>
          <p style="margin:18px 0 0;font-size:clamp(1rem,1.3vw,1.18rem);line-height:1.6;color:var(--fg);opacity:.86;">Llevo sesiones prácticas a empresas, escuelas y equipos, siempre a la medida de tu organización. Tu gente sale usando lo aprendido desde el primer día.</p>
          <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:26px;">
            <?php foreach (['Inteligencia Artificial', 'Microsoft Office', 'Google Workspace & Cloud', 'Automatización', 'Tecnología', 'Más'] as $ao_tema) : ?>
            <span style="font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.03em;border:1px solid color-mix(in srgb,var(--accent) 26%,var(--line));border-radius:12px;padding:10px 16px;color:var(--fg);background:var(--bg);box-shadow:0 2px 8px rgba(0,0,0,.04);white-space:nowrap;"><?php echo $ao_tema; ?></span>
            <?php endforeach; ?>
          </div>
        </div>
        <a class="ao-cta" href="<?php echo waLink('Hola Alexander, me interesa cotizar un taller para mi organización. ¿Podemos platicar?'); ?>" target="_blank" rel="noopener" data-cursor data-magnetic style="flex:none;display:inline-flex;align-items:center;gap:12px;background:var(--accent);color:var(--accent-fg);text-decoration:none;padding:18px 32px;border-radius:50px;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1rem,1.4vw,1.15rem);white-space:nowrap;box-shadow:0 12px 30px color-mix(in srgb,var(--accent) 32%,transparent);">Cotizar un taller <span style="font-size:1.05em;line-height:1;">→</span></a>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer id="ao-footer" style="position:relative;z-index:2;background:var(--bg);min-height:100vh;display:flex;flex-direction:column;justify-content:space-between;padding:clamp(60px,10vh,110px) clamp(20px,4vw,56px) 36px;border-top:1px solid var(--line);overflow:hidden;">
    <canvas id="ao-webgl-footer" style="position:absolute;inset:0;width:100%;height:100%;display:block;"></canvas>
    <div style="position:absolute;inset:0;background:linear-gradient(180deg,color-mix(in srgb,var(--bg) 60%,transparent) 0%,transparent 38%,transparent 68%,color-mix(in srgb,var(--bg) 42%,transparent) 100%);pointer-events:none;"></div>

    <div style="position:relative;z-index:1;font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.2em;color:var(--muted);display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px;align-items:center;">
      <span>/ 08 — ÚLTIMO PASO</span>
      <span>CDMX · DISPONIBLE PARA PROYECTOS</span>
    </div>

    <div id="ao-footer-hit" data-href="<?php echo waLink('Hola Alexander, vi tu portafolio y me gustaría platicar contigo.'); ?>" style="position:relative;z-index:1;text-align:center;padding:clamp(20px,6vh,50px) 0;cursor:pointer;">
      <h2 style="margin:0;font-family:'Clash Display',sans-serif;font-weight:700;line-height:.98;letter-spacing:-.03em;font-size:clamp(1.6rem,5.6vw,4.6rem);">TODO LO BUENO</h2>
      <h2 style="margin:0;font-family:'Clash Display',sans-serif;font-weight:700;line-height:.98;letter-spacing:-.03em;font-size:clamp(1.6rem,5.6vw,4.6rem);">EMPIEZA CON UN <em style="font-style:normal;font-weight:700;color:var(--accent);">hola</em></h2>
      <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;margin-top:clamp(22px,4.5vh,42px);">
        <a class="ao-cta" href="<?php echo waLink('Hola Alexander, me gustaría cotizar un proyecto contigo. ¿Podemos platicar?'); ?>" target="_blank" rel="noopener" data-cursor data-magnetic style="display:inline-flex;align-items:center;gap:12px;background:var(--accent);color:var(--accent-fg);text-decoration:none;padding:16px 30px;border-radius:50px;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1rem,1.5vw,1.25rem);">Cotiza tu proyecto
          <span style="font-size:.85em;font-weight:500;opacity:.85;">→</span>
        </a>
        <a href="/build/pdf/cv.pdf" download data-cursor data-magnetic style="display:inline-flex;align-items:center;gap:10px;border:1px solid var(--line);color:var(--fg);text-decoration:none;padding:16px 28px;border-radius:50px;font-family:'Space Mono',monospace;font-size:12px;letter-spacing:.12em;text-transform:uppercase;">Descargar CV ↓</a>
      </div>
    </div>

    <div style="position:relative;z-index:1;display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:24px;border-top:1px solid var(--line);padding-top:28px;">
      <div style="display:flex;gap:clamp(18px,3vw,38px);flex-wrap:wrap;font-family:'Clash Display',sans-serif;font-weight:700;font-size:clamp(1rem,1.5vw,1.3rem);">
        <a class="ao-social" href="https://www.linkedin.com/in/alexander-oliva-contreras-8a1244211/" target="_blank" data-cursor data-cursor-label="CONECTAR" data-magnetic style="color:var(--fg);text-decoration:none;transition:color .3s;">LinkedIn</a>
        <a class="ao-social" href="https://www.instagram.com/abstrkto/" target="_blank" data-cursor data-cursor-label="SEGUIR" data-magnetic style="color:var(--fg);text-decoration:none;transition:color .3s;">Instagram</a>
      </div>
      <div style="display:flex;align-items:center;gap:clamp(14px,3vw,26px);flex-wrap:wrap;font-family:'Space Mono',monospace;font-size:11px;letter-spacing:.14em;color:var(--muted);">
        <a class="ao-social" href="/login" data-cursor style="color:var(--muted);text-decoration:none;transition:color .3s;">ACCESO</a>
        <span>© ALEXANDER OLIVA</span>
      </div>
    </div>
  </footer>

</div>

<!-- anime.js: hero por letras + contador + monograma dibujado -->
<script>
(function () {
    if (typeof anime === 'undefined') return;

    // 1) Hero: revelado letra por letra
    document.querySelectorAll('#ao-top .ao-line').forEach(function (line) {
        var txt = line.textContent;
        line.innerHTML = txt.split('').map(function (ch) {
            return '<span class="ao-ch" style="display:inline-block;transform:translateY(115%)">' + (ch === ' ' ? '&nbsp;' : ch) + '</span>';
        }).join('');
    });
    setTimeout(function () {
        anime({ targets: '#ao-top .ao-ch', translateY: ['115%', '0%'], opacity: [0, 1], easing: 'easeOutExpo', duration: 1150, delay: anime.stagger(38) });
    }, 780);

    // Dispara una animación al entrar en viewport
    function once(el, cb) {
        if (!el) return;
        var o = new IntersectionObserver(function (es) {
            es.forEach(function (e) { if (e.isIntersecting) { cb(); o.disconnect(); } });
        }, { threshold: 0.4 });
        o.observe(el);
    }

    // 2) Contador +25,000 con count-up
    once(document.getElementById('ao-count'), function () {
        var c = document.getElementById('ao-count'), obj = { v: 0 };
        anime({ targets: obj, v: +c.dataset.target, round: 1, easing: 'easeOutCubic', duration: 1900, update: function () { c.textContent = '+' + obj.v.toLocaleString('es-MX'); } });
    });

    // 3) Monograma "AO" que se dibuja
    var mono = document.querySelector('#ao-mono .ao-mono-t'), ML = 1000;
    if (mono) { mono.style.strokeDasharray = ML; mono.style.strokeDashoffset = ML; }
    once(mono, function () { anime({ targets: mono, strokeDashoffset: [ML, 0], easing: 'easeInOutSine', duration: 2200 }); });
})();
</script>
