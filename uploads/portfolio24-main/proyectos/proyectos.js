// Fade in al cargar
window.addEventListener('DOMContentLoaded', () => {
  document.body.classList.add('loaded');
});

// Fade out al cambiar de página
document.querySelectorAll('a').forEach(link => {
  if (
    link.hostname === window.location.hostname &&
    !link.hasAttribute('target') &&
    !link.href.includes('#')
  ) {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      const href = this.getAttribute('href');

      document.body.classList.remove('loaded'); // inicia fade out
      setTimeout(() => {
        window.location.href = href;
      }, 500); // duración igual al CSS
    });
  }
});


