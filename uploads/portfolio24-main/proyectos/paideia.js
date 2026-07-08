/* CAMBIOS DE TEXTO – PROCESO Y RETO */

// --- Reto (Overview / Desafío / Solución) ---
const retoTextos = {
  overview: 'Un espacio donde la elección de materias se basa en información clara, diseño accesible y una comunidad comprometida con la mejora académica.',
  desafio: 'La toma de decisiones dependía de información dispersa y no verificada; era necesaria una fuente confiable y centralizada.',
  solucion: 'Reseñas verificadas, filtros precisos y perfiles detallados para facilitar una planificación académica informada.'
};

document.querySelectorAll('.reto__seccion')[0].querySelector('.reto__txt').textContent = retoTextos.overview;
document.querySelectorAll('.reto__seccion')[1].querySelector('.reto__txt').textContent = retoTextos.desafio;
document.querySelectorAll('.reto__seccion')[2].querySelector('.reto__txt').textContent = retoTextos.solucion;


// --- Proceso ---
document.querySelector('.proceso__titulo').textContent = 'Desarrollo del proceso';
document.querySelector('.proceso__subtitulo').textContent = 'Una guía adaptable para cualquier metodología';

const titulos = [
  'Explorar',
  'Definición',
  'Arquitectura & Flujos',
  'Wireframes → UI',
  'Desarrollo & QA'
];

const descripciones = [
  'Investigar el contexto y necesidades reales del usuario.',
  'Perfilar usuarios y journeys; priorizar con criterios claros.',
  'Estructurar contenidos y recorridos; optimizar filtros clave.',
  'Convertir estructura en interfaces usables y consistentes.',
  'Implementar con stack sólido y pruebas iterativas.'
];

const tags = [
  ['UX Research', 'Users'],
  ['Personas', 'Design Thinking'],
  ['Sitemaps', 'Information Arquitecture'],
  ['Wireframes', 'UI'],
  ['JavaScript', 'PHP']
];

const iconos = [
  'users.svg',
  'target.svg',
  'idea.svg',
  'tool.svg',
  'test.svg'
];

document.querySelectorAll('.paso').forEach((paso, i) => {
  // Título
  paso.querySelector('.paso__titulo').textContent = titulos[i];
  
  // Descripción
  paso.querySelector('.paso__descripcion').textContent = descripciones[i];
  
  // Tags
  const tagEls = paso.querySelectorAll('.paso__tag');
  tagEls[0].textContent = tags[i][0];
  tagEls[1].textContent = tags[i][1];
  
  // Icono
  const iconoEl = paso.querySelector('.paso__icono');
  iconoEl.setAttribute('src', `../proyectos/${iconos[i]}`);
  iconoEl.setAttribute('alt', `Icono del paso ${i + 1}`);
});
