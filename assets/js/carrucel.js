document.addEventListener("DOMContentLoaded", () => {
  const secciones = document.querySelectorAll('.seccion-carrusel');
  let indice = 0;
  let intervaloCarrusel = null;
  let yaActivadoPorScroll = false;
  let mousePresionado = false;

  function mostrarSeccion(index) {
    secciones.forEach(sec => {
      sec.classList.remove('activa');
      sec.style.display = 'none';
    });

    secciones[index].style.display = 'block';
    secciones[index].classList.add('activa');
  }

  function iniciarCarruselAutomatico() {
    if (intervaloCarrusel) return;
    intervaloCarrusel = setInterval(() => {
      if (!mousePresionado) { // ✅ Solo avanza si no está presionado
        indice = (indice + 1) % secciones.length;
        mostrarSeccion(indice);
      }
    }, 15000);
  }

  function detenerCarrusel() {
    mousePresionado = true; // ✅ Marca que se presionó el mouse
  }

  function reanudarCarrusel() {
    mousePresionado = false; // ✅ Marca que se soltó el mouse
  }

  // Detectar scroll a #alumnos_padres
  window.addEventListener("scroll", () => {
    const target = document.getElementById("alumnos_padres");
    if (!yaActivadoPorScroll && target) {
      const rect = target.getBoundingClientRect();
      if (rect.top >= 0 && rect.top <= window.innerHeight / 1.5) {
        const index = Array.from(secciones).findIndex(s => s.id === "alumnos_padres");
        if (index !== -1) {
          indice = index;
          mostrarSeccion(indice);
          iniciarCarruselAutomatico();
          yaActivadoPorScroll = true;
        }
      }
    }
  });

  // Mostrar la primera visible por defecto
  mostrarSeccion(indice);
  iniciarCarruselAutomatico();

  // ✅ Pausar al presionar, reanudar al soltar (mouse y touch)
  secciones.forEach(sec => {
    sec.addEventListener('mousedown', detenerCarrusel);
    sec.addEventListener('mouseup', reanudarCarrusel);

    sec.addEventListener('touchstart', detenerCarrusel);
    sec.addEventListener('touchend', reanudarCarrusel);
  });
});
