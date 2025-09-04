// ===== MOBILE-OPTIMIZED CAROUSEL =====
document.addEventListener("DOMContentLoaded", () => {
  const secciones = document.querySelectorAll('.seccion-carrusel');
  let indice = 0;
  let intervaloCarrusel = null;
  let yaActivadoPorScroll = false;
  let mousePresionado = false;
  let touchStartX = 0;
  let touchEndX = 0;
  let isScrolling = false;

  // Detectar si es dispositivo móvil
  const isMobile = window.innerWidth <= 768;
  const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

  function mostrarSeccion(index) {
    secciones.forEach(sec => {
      sec.classList.remove('activa');
      sec.style.display = 'none';
    });

    if (secciones[index]) {
      secciones[index].style.display = 'block';
      secciones[index].classList.add('activa');
      
      // Scroll suave a la sección en móvil
      if (isMobile) {
        secciones[index].scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    }
  }

  function iniciarCarruselAutomatico() {
    if (intervaloCarrusel) return;
    
    // Intervalo más largo en móvil para mejor UX
    const intervalo = isMobile ? 20000 : 15000;
    
    intervaloCarrusel = setInterval(() => {
      if (!mousePresionado && !isScrolling) {
        indice = (indice + 1) % secciones.length;
        mostrarSeccion(indice);
      }
    }, intervalo);
  }

  function detenerCarrusel() {
    mousePresionado = true;
    isScrolling = true;
  }

  function reanudarCarrusel() {
    mousePresionado = false;
    // Delay para reanudar después del scroll
    setTimeout(() => {
      isScrolling = false;
    }, 1000);
  }

  // Navegación por swipe en móvil
  function handleSwipe() {
    const swipeThreshold = 50;
    const swipeDistance = touchEndX - touchStartX;

    if (Math.abs(swipeDistance) > swipeThreshold) {
      if (swipeDistance > 0) {
        // Swipe derecha - sección anterior
        indice = indice > 0 ? indice - 1 : secciones.length - 1;
      } else {
        // Swipe izquierda - sección siguiente
        indice = (indice + 1) % secciones.length;
      }
      mostrarSeccion(indice);
    }
  }

  // Detectar scroll a #alumnos_padres con throttling
  let scrollTimeout;
  window.addEventListener("scroll", () => {
    if (scrollTimeout) {
      clearTimeout(scrollTimeout);
    }
    
    scrollTimeout = setTimeout(() => {
      const target = document.getElementById("alumnos_padres");
      if (!yaActivadoPorScroll && target) {
        const rect = target.getBoundingClientRect();
        const threshold = isMobile ? window.innerHeight / 2 : window.innerHeight / 1.5;
        
        if (rect.top >= 0 && rect.top <= threshold) {
          const index = Array.from(secciones).findIndex(s => s.id === "alumnos_padres");
          if (index !== -1) {
            indice = index;
            mostrarSeccion(indice);
            iniciarCarruselAutomatico();
            yaActivadoPorScroll = true;
          }
        }
      }
    }, 100);
  });

  // Mostrar la primera visible por defecto
  if (secciones.length > 0) {
    mostrarSeccion(indice);
    iniciarCarruselAutomatico();
  }

  // Event listeners mejorados para móvil
  secciones.forEach(sec => {
    // Eventos de mouse (desktop)
    sec.addEventListener('mousedown', detenerCarrusel);
    sec.addEventListener('mouseup', reanudarCarrusel);
    sec.addEventListener('mouseleave', reanudarCarrusel);

    // Eventos táctiles (móvil)
    sec.addEventListener('touchstart', (e) => {
      detenerCarrusel();
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    sec.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
      reanudarCarrusel();
    }, { passive: true });

    // Prevenir scroll durante swipe
    sec.addEventListener('touchmove', (e) => {
      if (Math.abs(e.changedTouches[0].screenX - touchStartX) > 10) {
        e.preventDefault();
      }
    }, { passive: false });
  });

  // Navegación por teclado
  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') {
      indice = indice > 0 ? indice - 1 : secciones.length - 1;
      mostrarSeccion(indice);
    } else if (e.key === 'ArrowRight') {
      indice = (indice + 1) % secciones.length;
      mostrarSeccion(indice);
    }
  });

  // Pausar carrusel cuando la ventana no está visible
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      if (intervaloCarrusel) {
        clearInterval(intervaloCarrusel);
        intervaloCarrusel = null;
      }
    } else {
      iniciarCarruselAutomatico();
    }
  });

  // Reajustar en resize
  window.addEventListener('resize', () => {
    if (intervaloCarrusel) {
      clearInterval(intervaloCarrusel);
      intervaloCarrusel = null;
    }
    iniciarCarruselAutomatico();
  });

  // Indicadores de navegación (opcional)
  function crearIndicadores() {
    if (isMobile && secciones.length > 1) {
      const contenedor = document.getElementById('contenedor-fragmentos');
      if (contenedor) {
        const indicadores = document.createElement('div');
        indicadores.className = 'carousel-indicators';
        indicadores.style.cssText = `
          position: fixed;
          bottom: 20px;
          left: 50%;
          transform: translateX(-50%);
          display: flex;
          gap: 8px;
          z-index: 1000;
        `;

        secciones.forEach((_, index) => {
          const indicador = document.createElement('button');
          indicador.className = 'carousel-indicator';
          indicador.style.cssText = `
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: none;
            background: ${index === indice ? '#2230b2' : 'rgba(255,255,255,0.5)'};
            cursor: pointer;
            transition: background 0.3s ease;
          `;
          
          indicador.addEventListener('click', () => {
            indice = index;
            mostrarSeccion(indice);
          });
          
          indicadores.appendChild(indicador);
        });

        contenedor.appendChild(indicadores);
      }
    }
  }

  // Crear indicadores si es móvil
  if (isMobile) {
    crearIndicadores();
  }
});
