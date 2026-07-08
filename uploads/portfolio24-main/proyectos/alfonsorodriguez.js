/* CAMBIOS DE TEXTO – PROCESO Y RETO */

// --- Reto (Overview / Desafío / Solución) ---
const retoTextos = {
  overview: 'Creación de un portafolio digital para mostrar el trabajo arquitectónico de Alfonso Rodríguez y facilitar el contacto con potenciales clientes.',
  desafio: 'Transmitir la calidad de sus proyectos en un entorno web claro y atractivo, accesible desde cualquier dispositivo.',
  solucion: 'Diseño y desarrollo de un sitio minimalista y funcional, con secciones de proyectos, biografía y un canal de contacto directo.'
};

document.querySelectorAll('.reto__seccion')[0].querySelector('.reto__txt').textContent = retoTextos.overview;
document.querySelectorAll('.reto__seccion')[1].querySelector('.reto__txt').textContent = retoTextos.desafio;
document.querySelectorAll('.reto__seccion')[2].querySelector('.reto__txt').textContent = retoTextos.solucion;


// --- Proceso ---
document.querySelector('.proceso__titulo').textContent = 'Proceso de diseño y desarrollo';
document.querySelector('.proceso__subtitulo').textContent = 'Etapas clave en la construcción del portafolio web';

const titulos = [
  'Research',
  'Arquitectura de Contenido',
  'Diseño Visual',
  'Desarrollo Web',
  'Lanzamiento'
];

const descripciones = [
  'Revisión de referencias y análisis de necesidades de comunicación.',
  'Definición de secciones, jerarquía de proyectos y flujo de navegación.',
  'Creación de una identidad visual minimalista con enfoque en arquitectura.',
  'Implementación en HTML, CSS y JavaScript; optimización responsive.',
  'Pruebas en distintos dispositivos y publicación con métricas iniciales.'
];

const tags = [
  ['Referencias', 'Análisis'],
  ['Sitemaps', 'UX'],
  ['UI', 'Branding'],
  ['Frontend', 'Responsive'],
  ['QA', 'Deploy']
];


const iconos = [
  'users.svg',
  'target.svg',
  'idea.svg',
  'tool.svg',
  'test.svg'
];

document.querySelectorAll('.paso').forEach((paso, i) => {
  paso.querySelector('.paso__titulo').textContent = titulos[i];
  paso.querySelector('.paso__descripcion').textContent = descripciones[i];
  const tagEls = paso.querySelectorAll('.paso__tag');
  tagEls[0].textContent = tags[i][0];
  tagEls[1].textContent = tags[i][1];
  const iconoEl = paso.querySelector('.paso__icono');
  iconoEl.setAttribute('src', `../proyectos/${iconos[i]}`);
  iconoEl.setAttribute('alt', `Icono del paso ${i + 1}`);
});
