/* CAMBIOS DE TEXTO */

document.querySelector('.proceso__titulo').textContent = 'Desarrollo del proceso';
document.querySelector('.proceso__subtitulo').textContent = 'Una guía adaptable para cualquier metodología';

document.querySelectorAll('.paso__titulo')[0].textContent = 'Explorar';
document.querySelectorAll('.paso__descripcion')[0].textContent = 'Investigar el contexto del problema';
document.querySelectorAll('.paso__tag')[0].textContent = 'Entrevistas';
document.querySelectorAll('.paso__tag')[1].textContent = 'Desk Research';


const iconos = [
  'users.svg',
  'target.svg',
  'idea.svg',
  'tool.svg',
  'test.svg'
];

document.querySelectorAll('.paso__icono').forEach((img, i) => {
  img.setAttribute('src', `../proyectos/${iconos[i]}`);
  img.setAttribute('alt', `Icono del paso ${i + 1}`);
});
