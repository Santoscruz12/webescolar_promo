// Variables globales para el carrusel
let secciones = [];
let indice = 0;
let intervaloCarrusel = null;
let yaActivadoPorScroll = false;
let mousePresionado = false;

document.addEventListener("DOMContentLoaded", () => {
  secciones = document.querySelectorAll('.seccion-carrusel');
  indice = 0;
  intervaloCarrusel = null;
  yaActivadoPorScroll = false;
  mousePresionado = false;

  function mostrarSeccion(index) {
    secciones.forEach(sec => {
      sec.classList.remove('activa');
      sec.style.display = 'none';
    });

    secciones[index].style.display = 'block';
    secciones[index].classList.add('activa');
    
    // Actualizar contador
    actualizarContador(index);
  }

  function actualizarContador(index) {
    actualizarTodosLosContadores(index);
  }

  function iniciarCarruselAutomatico() {
    if (intervaloCarrusel) return;
    console.log('Iniciando carrusel automático');
    intervaloCarrusel = setInterval(() => {
      if (!mousePresionado) { // ✅ Solo avanza si no está presionado
        console.log('Carrusel automático avanzando, mousePresionado:', mousePresionado);
        indice = (indice + 1) % secciones.length;
        mostrarSeccion(indice);
      } else {
        console.log('Carrusel automático pausado por mousePresionado:', mousePresionado);
      }
    }, 15000);
  }
  
  // Hacer función global
  window.iniciarCarruselAutomatico = iniciarCarruselAutomatico;

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

// Función global para navegación manual del carrusel
function navegarCarrusel(direccion) {
  console.log('navegarCarrusel llamada con direccion:', direccion);
  
  // PAUSAR INMEDIATAMENTE el carrusel automático
  if (intervaloCarrusel) {
    clearInterval(intervaloCarrusel);
    intervaloCarrusel = null;
    console.log('Carrusel automático pausado INMEDIATAMENTE');
  }
  
  // Marcar que se está navegando manualmente
  mousePresionado = true;
  
  console.log('Secciones encontradas:', secciones.length);
  if (secciones.length === 0) return;
  
  // Usar la variable global del índice actual
  let indiceActual = indice;
  console.log('Índice actual:', indiceActual);
  
  // Calcular nuevo índice
  let nuevoIndice = indiceActual + direccion;
  console.log('Nuevo índice calculado:', nuevoIndice, '(dirección:', direccion, ')');
  
  // Manejar límites del carrusel
  if (nuevoIndice < 0) {
    nuevoIndice = secciones.length - 1; // Ir al último
    console.log('Límite inferior alcanzado, yendo al último:', nuevoIndice);
  } else if (nuevoIndice >= secciones.length) {
    nuevoIndice = 0; // Ir al primero
    console.log('Límite superior alcanzado, yendo al primero:', nuevoIndice);
  }
  
  // Mostrar nueva sección
  secciones.forEach(sec => {
    sec.classList.remove('activa');
    sec.style.display = 'none';
  });
  
  secciones[nuevoIndice].style.display = 'block';
  secciones[nuevoIndice].classList.add('activa');
  
  // Actualizar variable global del índice
  indice = nuevoIndice;
  console.log('Índice actualizado a:', indice);
  
  // Actualizar todos los contadores posibles
  actualizarTodosLosContadores(nuevoIndice);
  
  // Reiniciar el carrusel automático después de 15 segundos
  setTimeout(() => {
    mousePresionado = false;
    console.log('Carrusel automático reanudado después de 15 segundos');
    iniciarCarruselAutomatico();
  }, 15000);
}

// Función para actualizar todos los contadores
function actualizarTodosLosContadores(indice) {
  const numero = String(indice + 1).padStart(2, '0');
  
  // Lista de posibles IDs de contadores
  const contadores = [
    'contador-carrusel',
    'conten_iconos_numps', 
    'conten_iconos_numsi',
    'conten_iconos_numsi2',
    'conten_iconos_numse',
    'conten_iconos_numsa',
    'conten_iconos_numv',
    'conten_iconos_numsf'
  ];
  
  contadores.forEach(id => {
    const contador = document.getElementById(id);
    if (contador) {
      contador.textContent = numero;
    }
  });
}
