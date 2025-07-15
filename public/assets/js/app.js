// Cambiar fondo al hacer scroll
window.addEventListener('scroll', function() {
  if (window.scrollY > 20) {
    document.body.classList.add('scrolled');
  } else {
    document.body.classList.remove('scrolled');
  }
});
