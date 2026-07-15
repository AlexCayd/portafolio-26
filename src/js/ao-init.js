(function(){
  if (window.__aoBoot) return; window.__aoBoot = true;
  var THEME = 'dark';
  var GEN = 0;               // generation counter — bumping it stops all loops
  var cleanupFns = [];
  var recolorFns = [];
  var bootNodes = null;

  function libsReady(){ return window.gsap && window.THREE && window.ScrollTrigger; }
  function grabNodes(){
    return {
      app: document.getElementById('ao-app'),
      footer: document.getElementById('ao-footer'),
      hero: document.getElementById('ao-webgl'),
      track: document.getElementById('ao-exp-track'),
      card: document.getElementById('ao-slider-track')
    };
  }
  function sameNodes(a, b){
    return a && b && a.app === b.app && a.footer === b.footer && a.hero === b.hero && a.track === b.track && a.card === b.card;
  }

  /* Watchdog: boot only once the DOM is stable; re-boot if the runtime swaps nodes. */
  var lastSeen = null, stableSince = 0;
  setInterval(function(){
    var n = grabNodes();
    if (!libsReady() || !n.app || !n.footer || !n.hero) { lastSeen = null; return; }
    if (!sameNodes(lastSeen, n)){ lastSeen = n; stableSince = Date.now(); return; }
    if (Date.now() - stableSince < 500) return;
    if (sameNodes(bootNodes, n)) return; // already booted on these exact nodes
    try { teardown(); bootNodes = n; boot(n); } catch(e){ console.warn('AO init failed', e); }
  }, 250);

  function teardown(){
    GEN++;
    cleanupFns.forEach(function(f){ try { f(); } catch(e){} });
    cleanupFns = [];
    recolorFns = [];
    if (window.ScrollTrigger) try { ScrollTrigger.getAll().forEach(function(t){ t.kill(); }); } catch(e){}
    if (window.__aoLenis){ try { window.__aoLenis.destroy(); } catch(e){} window.__aoLenis = null; }
  }

  function accentOf(app){ return (getComputedStyle(app).getPropertyValue('--accent') || '#ff0a24').trim(); }

  function boot(n){
    var gen = GEN;
    var app = n.app;
    var reduced = app.hasAttribute('data-reduced') || (window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches);
    gsap.registerPlugin(ScrollTrigger);
    window.__aoRecolor = function(theme){ recolorFns.forEach(function(f){ try { f(theme); } catch(e){} }); };
    initTheme(app);
    initLenis(reduced);
    initProjects(app, reduced);
    initCursor(app, gen);
    initHeroGL(app, reduced, gen);
    initFooterGL(app, reduced, gen);
    initReveals(app, reduced);
    initExpertise(app, reduced);
    initNav(app, reduced);
    initMobileNav(app);
    initHovers(app);
    initDataHref(app);
    window.__aoRecolor(THEME);
    setTimeout(function(){ if (gen === GEN) ScrollTrigger.refresh(); }, 400);
  }

  function onWin(ev, fn){ addEventListener(ev, fn); cleanupFns.push(function(){ removeEventListener(ev, fn); }); }

  /* ---------- THEME ---------- */
  function initTheme(app){
    try { THEME = localStorage.getItem('ao-theme') || 'dark'; } catch(e){ THEME = 'dark'; }
    applyTheme(app, THEME);
    var btn = document.getElementById('ao-theme');
    if (btn) btn.addEventListener('click', function(){
      THEME = (THEME === 'dark') ? 'light' : 'dark';
      try { localStorage.setItem('ao-theme', THEME); } catch(e){}
      applyTheme(app, THEME);
      if (window.__aoRecolor) window.__aoRecolor(THEME);
    });
  }
  function applyTheme(app, t){
    app.setAttribute('data-theme', t);
    var dot = document.getElementById('ao-theme-dot');
    var lbl = document.getElementById('ao-theme-label');
    if (dot) dot.style.transform = (t === 'light') ? 'translateX(20px)' : 'translateX(0)';
    if (lbl) lbl.textContent = (t === 'light') ? 'LIGHT' : 'DARK';
  }

  /* ---------- SMOOTH SCROLL ---------- */
  function initLenis(reduced){
    if (!window.Lenis || reduced) return;
    try {
      var lenis = new Lenis({ duration: 1.15, smoothWheel: true, lerp: 0.09 });
      window.__aoLenis = lenis;
      lenis.on('scroll', ScrollTrigger.update);
      var raf = function(t){ lenis.raf(t * 1000); };
      gsap.ticker.add(raf);
      gsap.ticker.lagSmoothing(0);
      cleanupFns.push(function(){ gsap.ticker.remove(raf); try { lenis.destroy(); } catch(e){} });
      document.querySelectorAll('#ao-app a[href^="#"]').forEach(function(a){
        a.addEventListener('click', function(e){
          var id = a.getAttribute('href');
          var t = id && id.length > 1 ? document.querySelector(id) : null;
          if (t) { e.preventDefault(); lenis.scrollTo(t, { offset: 0 }); }
        });
      });
    } catch(e){}
  }

  /* ---------- CUSTOM CURSOR (CTA labels) ---------- */
  function initCursor(app, gen){
    if (!window.matchMedia || !matchMedia('(hover:hover) and (pointer:fine)').matches) return;
    var dot = document.getElementById('ao-cursor'), ring = document.getElementById('ao-ring'), label = document.getElementById('ao-ring-label');
    if (!dot || !ring) return;
    var mx = innerWidth/2, my = innerHeight/2, rx = mx, ry = my, shown = false;
    onWin('mousemove', function(e){
      mx = e.clientX; my = e.clientY;
      dot.style.transform = 'translate('+mx+'px,'+my+'px) translate(-50%,-50%)';
      if (!shown){ shown = true; dot.style.opacity = '1'; ring.style.opacity = '1'; }  // evita el flash en la esquina
    });
    (function loop(){
      if (gen !== GEN) return;
      rx += (mx-rx)*0.16; ry += (my-ry)*0.16;
      ring.style.transform = 'translate('+rx+'px,'+ry+'px) translate(-50%,-50%)';
      requestAnimationFrame(loop);
    })();
    app.querySelectorAll('[data-cursor]').forEach(function(el){
      el.addEventListener('mouseenter', function(){
        var txt = el.getAttribute('data-cursor-label') || el.getAttribute('data-ring-label');
        if (txt){
          label.textContent = txt;
          label.style.opacity = '1'; label.style.transform = 'scale(1)';
          ring.style.width = '10px'; ring.style.height = '10px';
          ring.style.mixBlendMode = 'normal'; ring.style.borderColor = 'transparent'; ring.style.background = 'transparent';
          dot.style.opacity = '0';
        } else {
          var acc = accentOf(app);
          ring.style.width = '64px'; ring.style.height = '64px';
          ring.style.borderColor = acc;
          ring.style.background = 'color-mix(in srgb, ' + acc + ' 14%, transparent)';
          ring.style.mixBlendMode = 'normal';
          dot.style.opacity = '1';
        }
      });
      el.addEventListener('mouseleave', function(){
        ring.style.width = '42px'; ring.style.height = '42px';
        ring.style.borderColor = 'rgba(140,140,140,.6)'; ring.style.background = 'transparent'; ring.style.mixBlendMode = 'difference';
        label.style.opacity = '0'; label.style.transform = 'scale(.6)';
        dot.style.opacity = '1';
      });
    });
    app.querySelectorAll('[data-magnetic]').forEach(function(el){
      el.addEventListener('mousemove', function(e){
        var r = el.getBoundingClientRect();
        var x = e.clientX-(r.left+r.width/2), y = e.clientY-(r.top+r.height/2);
        el.style.transition='transform .2s ease-out'; el.style.transform='translate('+(x*0.32)+'px,'+(y*0.42)+'px)';
      });
      el.addEventListener('mouseleave', function(){ el.style.transform='translate(0,0)'; });
    });
  }

  /* ---------- GLSL SIMPLEX NOISE ---------- */
  var SNOISE = [
    'vec3 mod289(vec3 x){return x - floor(x * (1.0/289.0)) * 289.0;}',
    'vec4 mod289(vec4 x){return x - floor(x * (1.0/289.0)) * 289.0;}',
    'vec4 permute(vec4 x){return mod289(((x*34.0)+1.0)*x);}',
    'vec4 taylorInvSqrt(vec4 r){return 1.79284291400159 - 0.85373472095314 * r;}',
    'float snoise(vec3 v){',
    '  const vec2 C = vec2(1.0/6.0, 1.0/3.0);',
    '  const vec4 D = vec4(0.0, 0.5, 1.0, 2.0);',
    '  vec3 i = floor(v + dot(v, C.yyy));',
    '  vec3 x0 = v - i + dot(i, C.xxx);',
    '  vec3 g = step(x0.yzx, x0.xyz);',
    '  vec3 l = 1.0 - g;',
    '  vec3 i1 = min(g.xyz, l.zxy);',
    '  vec3 i2 = max(g.xyz, l.zxy);',
    '  vec3 x1 = x0 - i1 + C.xxx;',
    '  vec3 x2 = x0 - i2 + C.yyy;',
    '  vec3 x3 = x0 - D.yyy;',
    '  i = mod289(i);',
    '  vec4 p = permute(permute(permute(i.z + vec4(0.0, i1.z, i2.z, 1.0)) + i.y + vec4(0.0, i1.y, i2.y, 1.0)) + i.x + vec4(0.0, i1.x, i2.x, 1.0));',
    '  float n_ = 0.142857142857;',
    '  vec3 ns = n_ * D.wyz - D.xzx;',
    '  vec4 j = p - 49.0 * floor(p * ns.z * ns.z);',
    '  vec4 x_ = floor(j * ns.z);',
    '  vec4 y_ = floor(j - 7.0 * x_);',
    '  vec4 x = x_ * ns.x + ns.yyyy;',
    '  vec4 y = y_ * ns.x + ns.yyyy;',
    '  vec4 h = 1.0 - abs(x) - abs(y);',
    '  vec4 b0 = vec4(x.xy, y.xy);',
    '  vec4 b1 = vec4(x.zw, y.zw);',
    '  vec4 s0 = floor(b0)*2.0 + 1.0;',
    '  vec4 s1 = floor(b1)*2.0 + 1.0;',
    '  vec4 sh = -step(h, vec4(0.0));',
    '  vec4 a0 = b0.xzyw + s0.xzyw*sh.xxyy;',
    '  vec4 a1 = b1.xzyw + s1.xzyw*sh.zzww;',
    '  vec3 p0 = vec3(a0.xy, h.x);',
    '  vec3 p1 = vec3(a0.zw, h.y);',
    '  vec3 p2 = vec3(a1.xy, h.z);',
    '  vec3 p3 = vec3(a1.zw, h.w);',
    '  vec4 norm = taylorInvSqrt(vec4(dot(p0,p0), dot(p1,p1), dot(p2,p2), dot(p3,p3)));',
    '  p0 *= norm.x; p1 *= norm.y; p2 *= norm.z; p3 *= norm.w;',
    '  vec4 m = max(0.6 - vec4(dot(x0,x0), dot(x1,x1), dot(x2,x2), dot(x3,x3)), 0.0);',
    '  m = m * m;',
    '  return 42.0 * dot(m*m, vec4(dot(p0,x0), dot(p1,x1), dot(p2,x2), dot(p3,x3)));',
    '}'
  ].join('\n');

  /* ---------- HERO: interactive liquid-silk shader ---------- */
  function initHeroGL(app, reduced, gen){
    if (!window.THREE) return;
    var canvas = document.getElementById('ao-webgl'); if (!canvas) return;
    try {
      var renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: false, alpha: false });
      var PR = Math.min(window.devicePixelRatio || 1, 1.75);
      renderer.setPixelRatio(PR);
      renderer.setSize(innerWidth, innerHeight, false);

      var uniforms = {
        uTime: { value: 0 },
        uRes: { value: new THREE.Vector2(innerWidth*PR, innerHeight*PR) },
        uMouse: { value: new THREE.Vector2(0.5, 0.5) },
        uPtr: { value: 0 },
        uBg: { value: new THREE.Color('#0b0b0c') },
        uC1: { value: new THREE.Color('#40030e') },
        uC2: { value: new THREE.Color(accentOf(app)) },
        uBand: { value: 0.9 },
        uHi: { value: 0.85 }
      };
      var mat = new THREE.ShaderMaterial({
        uniforms: uniforms,
        vertexShader: 'void main(){ gl_Position = vec4(position, 1.0); }',
        fragmentShader: [
          'precision highp float;',
          'uniform float uTime; uniform vec2 uRes; uniform vec2 uMouse; uniform float uPtr;',
          'uniform vec3 uBg; uniform vec3 uC1; uniform vec3 uC2; uniform float uBand; uniform float uHi;',
          'float hash(vec2 p){ return fract(sin(dot(p, vec2(127.1, 311.7))) * 43758.5453123); }',
          'float noise(vec2 p){',
          '  vec2 i = floor(p), f = fract(p);',
          '  f = f*f*(3.0-2.0*f);',
          '  return mix(mix(hash(i), hash(i+vec2(1.0,0.0)), f.x), mix(hash(i+vec2(0.0,1.0)), hash(i+vec2(1.0,1.0)), f.x), f.y);',
          '}',
          'float fbm(vec2 p){',
          '  float v = 0.0, a = 0.5;',
          '  for (int i = 0; i < 5; i++){ v += a*noise(p); p = p*2.02 + vec2(1.7, 4.1); a *= 0.5; }',
          '  return v;',
          '}',
          'void main(){',
          '  vec2 uv = gl_FragCoord.xy / uRes;',
          '  float asp = uRes.x / uRes.y;',
          '  vec2 p = vec2(uv.x*asp, uv.y) * 1.8;',
          '  vec2 m = vec2(uMouse.x*asp, uMouse.y) * 1.8;',
          '  vec2 md = p - m; float mdl = length(md);',
          '  float infl = exp(-mdl*mdl*3.0) * uPtr;',
          '  p += normalize(md + 1e-4) * infl * 0.5;',           // silk parts around cursor
          '  p += vec2(-md.y, md.x) * infl * 0.75;',             // swirl / vortex
          '  float t = uTime*0.09;',
          '  vec2 q = vec2(fbm(p + t), fbm(p + vec2(5.2, 1.3) - t*0.7));',
          '  vec2 r = vec2(fbm(p + 3.4*q + vec2(1.7, 9.2) + t*0.5), fbm(p + 3.4*q + vec2(8.3, 2.8) - t*0.35));',
          '  float f = fbm(p + 3.2*r);',
          '  vec3 col = uBg;',
          '  col = mix(col, uC1, smoothstep(0.30, 0.9, f) * uBand);',
          '  col = mix(col, uC2, smoothstep(0.46, 0.95, f*r.x + q.y*0.5) * uHi);',
          '  col += uC2 * exp(-mdl*mdl*5.0) * 0.18 * uPtr;',     // glow follows cursor
          '  float edge = smoothstep(1.12, 0.2, length(uv - vec2(0.5, 0.5)));',
          '  col = mix(uBg, col, 0.6 + 0.4*edge);',
          '  gl_FragColor = vec4(col, 1.0);',
          '}'
        ].join('\n')
      });
      var scene = new THREE.Scene();
      var quad = new THREE.Mesh(new THREE.PlaneGeometry(2, 2), mat);
      scene.add(quad);
      var cam = new THREE.Camera();
      cleanupFns.push(function(){ try { quad.geometry.dispose(); mat.dispose(); renderer.dispose(); } catch(e){} });

      function size(){
        renderer.setSize(innerWidth, innerHeight, false);
        uniforms.uRes.value.set(innerWidth*PR, innerHeight*PR);
        if (reduced) renderer.render(scene, cam);
      }
      size();
      onWin('resize', size);

      recolorFns.push(function(theme){
        uniforms.uC2.value.set(accentOf(app));
        if (theme === 'light'){
          uniforms.uBg.value.set('#f1eee6');
          uniforms.uC1.value.set('#dcdcdc');
          uniforms.uBand.value = 0.85; uniforms.uHi.value = 0.72;
        } else {
          uniforms.uBg.value.set('#0b0b0c');
          uniforms.uC1.value.set('#40030e');
          uniforms.uBand.value = 1.0; uniforms.uHi.value = 1.05;
        }
        if (reduced) renderer.render(scene, cam);
      });

      var mT = new THREE.Vector2(0.5, 0.5), ptrT = 0;
      onWin('mousemove', function(e){
        mT.set(e.clientX/innerWidth, 1.0 - e.clientY/innerHeight);
        ptrT = 1.0;
      });
      ScrollTrigger.create({ trigger:'#ao-top', start:'top top', end:'bottom top', onUpdate:function(self){ canvas.style.opacity = String(1 - self.progress*0.92); } });

      if (reduced){ uniforms.uTime.value = 8; renderer.render(scene, cam); return; }
      var clock = new THREE.Clock();
      (function animate(){
        if (gen !== GEN) return;
        var dt = Math.min(clock.getDelta(), 0.05);
        uniforms.uTime.value += dt;
        uniforms.uMouse.value.lerp(mT, 0.06);
        uniforms.uPtr.value += (ptrT - uniforms.uPtr.value) * 0.05;
        ptrT *= 0.97;
        renderer.render(scene, cam);
        requestAnimationFrame(animate);
      })();
    } catch(e){ console.warn('hero webgl', e); }
  }

  /* ---------- FOOTER: flowing silk shader ---------- */
  function initFooterGL(app, reduced, gen){
    if (!window.THREE) return;
    var canvas = document.getElementById('ao-webgl-footer'); if (!canvas) return;
    var footer = document.getElementById('ao-footer');
    try {
      var renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: false });
      var PR = Math.min(window.devicePixelRatio || 1, 1.5);
      renderer.setPixelRatio(PR);
      var uniforms = {
        uTime: { value: 0 },
        uRes: { value: new THREE.Vector2(1, 1) },
        uMouse: { value: new THREE.Vector2(0.5, 0.5) },
        uBg: { value: new THREE.Color('#0b0b0c') },
        uC1: { value: new THREE.Color('#40030e') },
        uC2: { value: new THREE.Color('#ff0a24') },
        uBand: { value: 0.9 },
        uHi: { value: 0.75 }
      };
      var mat = new THREE.ShaderMaterial({
        uniforms: uniforms,
        vertexShader: 'void main(){ gl_Position = vec4(position, 1.0); }',
        fragmentShader: [
          'precision highp float;',
          'uniform float uTime; uniform vec2 uRes; uniform vec2 uMouse;',
          'uniform vec3 uBg; uniform vec3 uC1; uniform vec3 uC2;',
          'uniform float uBand; uniform float uHi;',
          'float hash(vec2 p){ return fract(sin(dot(p, vec2(127.1, 311.7))) * 43758.5453123); }',
          'float noise(vec2 p){',
          '  vec2 i = floor(p), f = fract(p);',
          '  f = f*f*(3.0-2.0*f);',
          '  return mix(mix(hash(i), hash(i+vec2(1.0,0.0)), f.x), mix(hash(i+vec2(0.0,1.0)), hash(i+vec2(1.0,1.0)), f.x), f.y);',
          '}',
          'float fbm(vec2 p){',
          '  float v = 0.0, a = 0.5;',
          '  for (int i = 0; i < 5; i++){ v += a*noise(p); p = p*2.03 + vec2(1.7, 4.1); a *= 0.5; }',
          '  return v;',
          '}',
          'void main(){',
          '  vec2 uv = gl_FragCoord.xy / uRes;',
          '  float asp = uRes.x / uRes.y;',
          '  vec2 p = vec2(uv.x*asp, uv.y) * 1.9;',
          '  float t = uTime*0.10;',
          '  vec2 q = vec2(fbm(p + t), fbm(p + vec2(5.2, 1.3) - t*0.7));',
          '  vec2 r = vec2(fbm(p + 3.2*q + vec2(1.7, 9.2) + t*0.55), fbm(p + 3.2*q + vec2(8.3, 2.8) - t*0.35));',
          '  float f = fbm(p + 3.0*r);',
          '  vec3 col = uBg;',
          '  col = mix(col, uC1, smoothstep(0.34, 0.9, f) * uBand);',
          '  col = mix(col, uC2, smoothstep(0.52, 0.95, f*r.x + q.y*0.45) * uHi);',
          '  vec2 m = vec2(uMouse.x*asp, uMouse.y);',
          '  vec2 pp = vec2(uv.x*asp, uv.y);',
          '  col += uC2 * exp(-dot(pp-m, pp-m) * 6.0) * 0.10;',
          '  float edge = smoothstep(0.98, 0.35, length(uv - vec2(0.5, 0.52)));',
          '  col = mix(uBg, col, 0.3 + 0.7*edge);',
          '  gl_FragColor = vec4(col, 1.0);',
          '}'
        ].join('\n')
      });
      var scene = new THREE.Scene();
      var quad = new THREE.Mesh(new THREE.PlaneGeometry(2, 2), mat);
      scene.add(quad);
      var cam = new THREE.Camera();
      cleanupFns.push(function(){ try { quad.geometry.dispose(); mat.dispose(); renderer.dispose(); } catch(e){} });
      function size(){
        var w = footer.clientWidth || innerWidth, h = footer.clientHeight || innerHeight;
        renderer.setSize(w, h, false);
        uniforms.uRes.value.set(w*PR, h*PR);
        if (reduced) renderer.render(scene, cam);
      }
      size();
      onWin('resize', size);
      setTimeout(function(){ if (gen === GEN) size(); }, 600);
      recolorFns.push(function(theme){
        uniforms.uC2.value.set(accentOf(app));
        if (theme === 'light'){
          uniforms.uBg.value.set('#f1eee6');
          uniforms.uC1.value.set('#dcdcdc');
          uniforms.uBand.value = 0.85; uniforms.uHi.value = 0.5;
        } else {
          uniforms.uBg.value.set('#0b0b0c');
          uniforms.uC1.value.set('#40030e');
          uniforms.uBand.value = 0.9; uniforms.uHi.value = 0.75;
        }
        if (reduced) renderer.render(scene, cam);
      });
      var mT = new THREE.Vector2(0.5, 0.5);
      footer.addEventListener('mousemove', function(e){
        var rct = footer.getBoundingClientRect();
        mT.set((e.clientX - rct.left)/rct.width, 1 - (e.clientY - rct.top)/rct.height);
      });
      if (reduced){ uniforms.uTime.value = 7; renderer.render(scene, cam); return; }
      var visible = false;
      var io = new IntersectionObserver(function(en){ visible = en[0].isIntersecting; }, { rootMargin: '80px' });
      io.observe(footer);
      cleanupFns.push(function(){ io.disconnect(); });
      var clock = new THREE.Clock();
      (function animate(){
        if (gen !== GEN) return;
        var dt = Math.min(clock.getDelta(), 0.05);
        if (visible){
          uniforms.uTime.value += dt;
          uniforms.uMouse.value.lerp(mT, 0.05);
          renderer.render(scene, cam);
        }
        requestAnimationFrame(animate);
      })();
    } catch(e){ console.warn('footer webgl', e); }
  }

  /* ---------- GSAP REVEALS ---------- */
  function initReveals(app, reduced){
    // El revelado por letras del hero lo maneja anime.js (ver landing). Aquí solo el subtítulo.
    var sub = document.getElementById('ao-hero-sub');
    if (sub && !reduced && !sub.querySelector('.ao-w')){
      var words = sub.textContent.trim().split(/\s+/);
      sub.innerHTML = words.map(function(w){ return '<span style="display:inline-block;overflow:hidden;"><span class="ao-w" style="display:inline-block;transform:translateY(110%)">'+w+'</span></span>'; }).join(' ');
      gsap.to(sub.querySelectorAll('.ao-w'), { yPercent:0, y:0, duration:0.8, ease:'expo.out', stagger:0.02, delay:0.4 });
    }
    if (reduced) return;
    app.querySelectorAll('[data-reveal]').forEach(function(el){
      gsap.from(el, { y:40, opacity:0, duration:0.9, ease:'power3.out', clearProps:'transform', scrollTrigger:{ trigger:el, start:'top 90%' } });
    });
    app.querySelectorAll('[data-reveal-stagger]').forEach(function(group){
      gsap.from(group.children, { y:44, opacity:0, duration:0.7, ease:'power3.out', stagger:0.06, clearProps:'transform', scrollTrigger:{ trigger:group, start:'top 82%' } });
    });
    app.querySelectorAll('#ao-footer-hit h2').forEach(function(el, i){
      gsap.from(el, { y:80, opacity:0, duration:1, ease:'power4.out', delay:i*0.08, scrollTrigger:{ trigger:'#ao-footer', start:'top 60%' } });
    });
  }

  /* ---------- HORIZONTAL EXPERTISE ---------- */
  function initExpertise(app, reduced){
    var track = document.getElementById('ao-exp-track'), pin = document.getElementById('ao-exp-pin');
    if (!track || !pin) return;
    if (reduced || innerWidth < 768){
      pin.style.height='auto'; pin.style.overflow='visible';
      track.style.flexWrap='wrap'; track.style.gap='clamp(16px,3vh,28px)';
      return;
    }
    var getDist = function(){ return Math.max(0, track.scrollWidth - innerWidth + 56); };
    gsap.to(track, {
      x: function(){ return -getDist(); },
      ease: 'none', immediateRender: false,
      scrollTrigger: { trigger:'#ao-expertise', start:'top top', end:function(){ return '+=' + getDist(); }, scrub:0.6, pin:pin, pinSpacing:true, anticipatePin:1, invalidateOnRefresh:true, refreshPriority:1 }
    });
    // Recalcular el pin cuando todo esté medido (fuentes, imágenes, load) — evita que
    // el scroll horizontal de servicios no arranque por dimensiones tempranas.
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(function(){ ScrollTrigger.refresh(); });
    onWin('load', function(){ ScrollTrigger.refresh(); });
    var expRt; onWin('resize', function(){ clearTimeout(expRt); expRt = setTimeout(function(){ ScrollTrigger.refresh(); }, 200); });
  }

  /* ---------- PROJECTS: 3-up auto slider ---------- */
  function initProjects(app, reduced){
    var slider = document.getElementById('ao-proj-slider');
    var track  = document.getElementById('ao-slider-track');
    var dotsW  = document.getElementById('ao-slider-dots');
    if (!slider || !track || !dotsW) return;

    /* Proyectos administrados desde /admin (window.AO_PROJECTS). Sin datos = sin slider. */
    var projects = (Array.isArray(window.AO_PROJECTS) && window.AO_PROJECTS.length) ? window.AO_PROJECTS : [];
    var BASE = '/build/img/proyectos/portadas/';
    var n = projects.length;
    if (!n) { slider.style.display = 'none'; return; }   // sección dinámica: nada que mostrar
    var EASE = 'transform .85s cubic-bezier(.16,1,.3,1)';
    var DELAY = 3000;

    function cardHTML(p){
      var href = p.slug ? '/proyecto/'+p.slug : (p.id ? '/proyecto?id='+p.id : '#ao-projects');
      return '<a class="ao-slide-card" data-vt-cover href="'+href+'" data-cursor data-cursor-label="Ver proyecto" aria-label="'+p.title+'">' +
               '<img data-vt-img src="'+BASE+p.img+'" alt="Portada del proyecto '+p.title+'" decoding="async">' +
               '<div class="ao-slide-grad"></div>' +
               '<div class="ao-slide-cap"><span>'+p.year+'</span><h3>'+p.title+'</h3></div>' +
             '</a>';
    }

    var index = 0, vis = 3, animating = false, timer = null;

    function visCount(){ return innerWidth <= 600 ? 1 : innerWidth <= 900 ? 2 : 3; }

    /* exact pixel offset of card `i` from the first card — no subpixel drift */
    function offsetFor(i){
      var cards = track.children;
      if (!cards[i] || !cards[0]) return 0;
      return cards[i].offsetLeft - cards[0].offsetLeft;
    }
    function apply(anim){
      track.style.transition = anim ? EASE : 'none';
      track.style.transform  = 'translateX(' + (-offsetFor(index)) + 'px)';
    }
    function updateDots(){
      var dots = dotsW.children, active = ((index % n) + n) % n;
      for (var i = 0; i < dots.length; i++) dots[i].setAttribute('data-active', i === active ? '1' : '0');
    }
    function go(to){
      if (animating) return;
      index = to; animating = true;
      apply(true); updateDots();
    }
    function next(){ go(index + 1); }
    function prev(){
      if (index <= 0){ index = n; apply(false); void track.offsetWidth; go(n - 1); }
      else go(index - 1);
    }

    function build(){
      vis = visCount();
      slider.style.setProperty('--vis', vis);
      /* real cards + clones of the first `vis` so the wrap is seamless */
      track.innerHTML = projects.map(cardHTML).join('') +
                        projects.slice(0, vis).map(cardHTML).join('');
      dotsW.innerHTML = projects.map(function(_, i){
        return '<button class="ao-slider-dot" type="button" data-i="'+i+'" aria-label="Ir al proyecto '+(i+1)+'"></button>';
      }).join('');
      index = 0; animating = false;
      requestAnimationFrame(function(){ apply(false); updateDots(); });
    }

    /* seamless reset once we animate onto the cloned tail */
    track.addEventListener('transitionend', function(e){
      if (e.propertyName !== 'transform') return;
      animating = false;
      if (index >= n){ index = 0; apply(false); updateDots(); }
    });

    /* autoplay (skipped when reduced motion is requested) */
    function start(){ if (!reduced && !timer) timer = setInterval(next, DELAY); }
    function stop(){ if (timer){ clearInterval(timer); timer = null; } }
    function restart(){ stop(); start(); }

    slider.addEventListener('mouseenter', stop);
    slider.addEventListener('mouseleave', start);
    slider.addEventListener('focusin', stop);
    slider.addEventListener('focusout', start);

    slider.querySelectorAll('.ao-slider-btn').forEach(function(btn){
      btn.addEventListener('click', function(){
        (btn.getAttribute('data-dir') === 'prev' ? prev : next)(); restart();
      });
    });
    dotsW.addEventListener('click', function(e){
      var d = e.target.closest('.ao-slider-dot'); if (!d) return;
      go(parseInt(d.getAttribute('data-i'), 10)); restart();
    });

    var rt;
    // En móvil, mostrar/ocultar la barra de direcciones dispara 'resize' constantemente.
    // Solo reconstruimos si cambia el número de tarjetas visibles; si no, reaplicamos el offset
    // (evita que las tarjetas "parpadeen" o se queden mal cargadas).
    function onResize(){ clearTimeout(rt); rt = setTimeout(function(){ if (visCount() !== vis) build(); else apply(false); }, 200); }
    addEventListener('resize', onResize);
    addEventListener('orientationchange', function(){ clearTimeout(rt); rt = setTimeout(build, 260); });
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(function(){ apply(false); });

    build();
    start();

    /* register cleanup so re-boots don't leak timers/listeners */
    cleanupFns.push(function(){ stop(); clearTimeout(rt); removeEventListener('resize', onResize); });
  }

  /* ---------- NAV (frosted + active + underline) ---------- */
  function initNav(app, reduced){
    var nav = document.getElementById('ao-nav');
    if (nav){
      ScrollTrigger.create({ start: 120, end: 99999999,
        onToggle: function(self){
          if (self.isActive){
            nav.style.background = 'color-mix(in srgb, var(--bg) 68%, transparent)';
            nav.style.backdropFilter = 'blur(22px) saturate(1.6)';
            nav.style.webkitBackdropFilter = 'blur(22px) saturate(1.6)';
            nav.style.borderColor = 'color-mix(in srgb, var(--fg) 16%, transparent)';
          } else {
            nav.style.background = 'transparent';
            nav.style.backdropFilter = 'none';
            nav.style.webkitBackdropFilter = 'none';
            nav.style.borderColor = 'transparent';
          }
        }
      });
    }
    var links = [].slice.call(app.querySelectorAll('.ao-navlink'));
    links.forEach(function(link){
      var line = link.querySelector('.ao-navline');
      link.addEventListener('mouseenter', function(){ if(line) line.style.transform='scaleX(1)'; });
      link.addEventListener('mouseleave', function(){ if(line && link.getAttribute('data-active')!=='1') line.style.transform='scaleX(0)'; });
    });
    var map = { 'ao-projects':'projects', 'ao-expertise':'expertise', 'ao-core':'core', 'ao-formacion':'formacion', 'ao-teaching':'teaching', 'ao-blog':'blog' };
    var io = new IntersectionObserver(function(entries){
      entries.forEach(function(en){
        var key = map[en.target.id]; if(!key) return;
        var link = app.querySelector('.ao-navlink[data-target="'+key+'"]');
        if(!link) return;
        var line = link.querySelector('.ao-navline');
        if (en.isIntersecting){
          link.setAttribute('data-active','1'); link.style.color='var(--accent)';
          if(line) line.style.transform='scaleX(1)';
        } else {
          link.removeAttribute('data-active'); link.style.color='';
          if(line) line.style.transform='scaleX(0)';
        }
      });
    }, { rootMargin: '-48% 0px -48% 0px' });
    Object.keys(map).forEach(function(id){ var el=document.getElementById(id); if(el) io.observe(el); });
    cleanupFns.push(function(){ io.disconnect(); });
  }

  /* ---------- MOBILE MENU ---------- */
  function initMobileNav(app){
    var toggle = document.getElementById('ao-nav-toggle');
    var overlay = document.getElementById('ao-nav-overlay');
    if (!toggle || !overlay) return;
    var open = false;
    function setOpen(v){
      open = v;
      toggle.classList.toggle('ao-open', v);
      overlay.classList.toggle('ao-open', v);
      toggle.setAttribute('aria-expanded', v ? 'true' : 'false');
      toggle.setAttribute('aria-label', v ? 'Cerrar menú' : 'Abrir menú');
      if (window.__aoLenis){ try { v ? window.__aoLenis.stop() : window.__aoLenis.start(); } catch(e){} }
    }
    toggle.addEventListener('click', function(){ setOpen(!open); });
    [].slice.call(overlay.querySelectorAll('a')).forEach(function(a){
      a.addEventListener('click', function(e){
        var id = a.getAttribute('href') || '';
        setOpen(false);
        if (id.charAt(0) === '#' && id.length > 1){
          var target = document.querySelector(id);
          if (target){
            e.preventDefault();
            requestAnimationFrame(function(){
              if (window.__aoLenis){ try { window.__aoLenis.scrollTo(target, { offset: 0 }); return; } catch(e){} }
              target.scrollIntoView({ behavior: 'smooth' });
            });
          }
        }
      });
    });
    var mThemeBtn = document.getElementById('ao-theme-m');
    var mThemeLbl = document.getElementById('ao-theme-m-label');
    var mainLbl = document.getElementById('ao-theme-label');
    if (mThemeLbl && mainLbl) mThemeLbl.textContent = mainLbl.textContent;
    if (mThemeBtn) mThemeBtn.addEventListener('click', function(){
      var real = document.getElementById('ao-theme'); if (real) real.click();
      if (mThemeLbl && mainLbl) mThemeLbl.textContent = mainLbl.textContent;
    });
    onWin('keydown', function(e){ if (e.key === 'Escape' && open) setOpen(false); });
    cleanupFns.push(function(){ setOpen(false); });
  }

  /* ---------- ELEMENT-SPECIFIC HOVERS ---------- */
  function initHovers(app){
    app.querySelectorAll('.ao-cert').forEach(function(card){
      card.addEventListener('mouseenter', function(){ card.style.zIndex='5'; card.style.transform='translateY(-4px)'; card.style.borderColor='var(--accent)'; card.style.boxShadow='var(--sh-md)'; });
      card.addEventListener('mouseleave', function(){ card.style.transform='translateY(0)'; card.style.borderColor=''; card.style.boxShadow='none'; card.style.zIndex=''; });
    });
    app.querySelectorAll('.ao-post').forEach(function(card){
      var arrow = card.querySelector('.ao-post-arrow');
      card.addEventListener('mouseenter', function(){ card.style.transform='translateY(-6px)'; card.style.borderColor='var(--accent)'; card.style.boxShadow='var(--sh-lg)'; if(arrow) arrow.style.transform='translateX(4px)'; });
      card.addEventListener('mouseleave', function(){ card.style.transform='translateY(0)'; card.style.borderColor=''; card.style.boxShadow='none'; if(arrow) arrow.style.transform='translateX(0)'; });
    });
    app.querySelectorAll('.ao-svc').forEach(function(card){
      card.style.transition = 'transform .4s cubic-bezier(.16,1,.3,1), border-color .4s, box-shadow .4s';
      card.addEventListener('mouseenter', function(){ card.style.transform='translateY(-6px)'; card.style.borderColor='var(--accent)'; card.style.boxShadow='var(--sh-md)'; });
      card.addEventListener('mouseleave', function(){ card.style.transform='translateY(0)'; card.style.borderColor=''; card.style.boxShadow='none'; });
    });
    app.querySelectorAll('.ao-course').forEach(function(card){
      card.style.transition = 'transform .4s cubic-bezier(.16,1,.3,1), border-color .4s, box-shadow .4s';
      var img = card.querySelector('.ao-course-img');
      card.addEventListener('mouseenter', function(){ card.style.transform='translateY(-6px)'; card.style.borderColor='var(--accent)'; card.style.boxShadow='var(--sh-lg)'; if(img) img.style.transform='scale(1.06)'; });
      card.addEventListener('mouseleave', function(){ card.style.transform='translateY(0)'; card.style.borderColor=''; card.style.boxShadow='none'; if(img) img.style.transform='scale(1)'; });
    });
    app.querySelectorAll('.ao-social').forEach(function(a){
      a.addEventListener('mouseenter', function(){ a.style.color='var(--accent)'; });
      a.addEventListener('mouseleave', function(){ a.style.color=''; });
    });
  }

  /* ---------- data-href clickable blocks ---------- */
  function initDataHref(app){
    app.querySelectorAll('[data-href]').forEach(function(el){
      el.addEventListener('click', function(e){
        if (e.target.closest && e.target.closest('a')) return;
        var h = el.getAttribute('data-href'); if (!h) return;
        if (h.indexOf('mailto:') === 0) location.href = h; else window.open(h, '_blank');
      });
    });
  }
})();

/* ---------- INTRO / ANIMACIÓN DE ENTRADA AL SITIO ---------- */
(function(){
  if (window.__aoIntroBoot) return; window.__aoIntroBoot = true;

  function run(){
    var intro = document.getElementById('ao-intro');
    if (!intro) return;

    /* La cortina de entrada solo se juega en la 1ª visita de la sesión.
       Al volver al home desde otra página, se retira al instante (las
       transiciones entre páginas las maneja View Transitions). */
    try {
      if (sessionStorage.getItem('ao-intro-seen')) {
        if (intro.parentNode) intro.parentNode.removeChild(intro);
        return;
      }
      sessionStorage.setItem('ao-intro-seen', '1');
    } catch(e){}

    var countEl = document.getElementById('ao-intro-count');
    var bar     = document.getElementById('ao-intro-bar');
    var htmlEl  = document.documentElement, bodyEl = document.body;
    var prevHtmlOv = htmlEl.style.overflow, prevBodyOv = bodyEl.style.overflow;
    var reduced = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* bloquea el scroll mientras dura la entrada */
    htmlEl.style.overflow = 'hidden'; bodyEl.style.overflow = 'hidden';
    try { window.scrollTo(0, 0); } catch(e){}

    var done = false;
    function finish(){
      if (done) return; done = true;
      htmlEl.style.overflow = prevHtmlOv; bodyEl.style.overflow = prevBodyOv;
      if (intro && intro.parentNode) intro.parentNode.removeChild(intro);
    }

    /* red de seguridad: nunca dejar la pantalla bloqueada */
    var guard = setTimeout(function(){ if (!window.gsap) finish(); }, 4500);

    if (reduced){
      clearTimeout(guard);
      if (countEl) countEl.textContent = '100';
      if (bar) bar.style.width = '100%';
      setTimeout(finish, 300);
      return;
    }

    /* espera brevemente a GSAP; si no llega, usa un fallback en CSS */
    var waited = 0;
    (function waitGsap(){
      if (window.gsap){ clearTimeout(guard); gsapIntro(window.gsap); return; }
      if (waited > 1400){ cssIntro(); return; }
      waited += 60; setTimeout(waitGsap, 60);
    })();

    function heroRise(gsap){
      var hero = document.getElementById('ao-top');
      if (hero) gsap.from(hero, { y:30, opacity:0, duration:1.1, ease:'expo.out' });
    }

    function gsapIntro(gsap){
      var counter = { v:0 };
      var lines = intro.querySelectorAll('.ao-intro-line');
      var fades = intro.querySelectorAll('.ao-intro-fade');
      var tl = gsap.timeline({ defaults:{ ease:'expo.out' } });
      tl.set(lines, { yPercent:110 });
      tl.set(fades, { opacity:0, y:10 });
      tl.to(lines, { yPercent:0, duration:1.0, stagger:0.09 }, 0.15);
      tl.to(fades, { opacity:1, y:0, duration:0.8, stagger:0.05 }, 0.25);
      tl.to(counter, { v:100, duration:1.6, ease:'power2.inOut', onUpdate:function(){
        var n = Math.round(counter.v);
        if (countEl) countEl.textContent = n;
        if (bar) bar.style.width = n + '%';
      }}, 0.2);
      tl.to(intro.querySelectorAll('h2, #ao-intro-count'), { y:-24, opacity:0, duration:0.6, ease:'power2.in' }, '+=0.15');
      tl.to(fades, { opacity:0, duration:0.4 }, '<');
      tl.to(intro, { yPercent:-100, duration:0.95, ease:'expo.inOut', onStart:function(){ heroRise(gsap); } }, '-=0.1');
      tl.add(finish);
    }

    function cssIntro(){
      var start = null, dur = 1600;
      function step(t){
        if (start === null) start = t;
        var p = Math.min(1, (t - start) / dur);
        var n = Math.round(p * 100);
        if (countEl) countEl.textContent = n;
        if (bar) bar.style.width = n + '%';
        if (p < 1){ requestAnimationFrame(step); }
        else {
          intro.style.transition = 'transform .9s cubic-bezier(.7,0,.2,1)';
          intro.style.transform = 'translateY(-100%)';
          setTimeout(finish, 950);
        }
      }
      requestAnimationFrame(step);
    }
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', run);
  else run();
})();
