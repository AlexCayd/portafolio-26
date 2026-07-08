/* CAMBIOS DE TEXTO – PROCESO Y RETO */

// --- Reto (Overview / Desafío / Solución) ---
const retoTextos = {
  overview: 'Implementamos un canal de pedidos en la web para residentes del edificio, con identificación por departamento, menú y flujo de compra optimizado para todos los dispositivos.',
  desafio: 'Centralizar pedidos (antes vía llamadas), minimizar errores en cocina y optimizar entregas; controlar disponibilidad por horario y stock.',
  solucion: 'Arquitectura de información clara, menú completo, carrito persistente, panel de cocina con estados de orden y actualización en tiempo real para nuevos pedidos.'
};

document.querySelectorAll('.reto__seccion')[0].querySelector('.reto__txt').textContent = retoTextos.overview;
document.querySelectorAll('.reto__seccion')[1].querySelector('.reto__txt').textContent = retoTextos.desafio;
document.querySelectorAll('.reto__seccion')[2].querySelector('.reto__txt').textContent = retoTextos.solucion;


// --- Proceso ---
document.querySelector('.proceso__titulo').textContent = 'Desarrollo del proceso';
document.querySelector('.proceso__subtitulo').textContent = 'Una guía adaptable para cualquier metodología';

const titulos = [
  'Research',
  'Diseño de Menú',
  'UI temática',
  'Desarrollo',
  'Lanzamiento'
];

const descripciones = [
  'Entendimiento del funcionamiento del restaurante para detectar necesidades y KPIs.',
  'Flujo de usuarios, diseño del menú, arquitectura de la información.',
  'Paleta verde/tierra, texturas y microinteracciones accesibles.',
  'Desarrollo en tecnologías web HTML, CSS y JavaScript. Integración con Google Sheets para el panel de cocina.',
  'Pruebas móviles y panel de cocina; métricas tras lanzamiento.'
];

const tags = [
  ['Entrevistas', 'KPIs'],
  ['User Flows', 'AI'],
  ['Design System', 'Accesibilidad'],
  ['Frontend', 'Sheets'],
  ['QA', 'Analytics']
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
