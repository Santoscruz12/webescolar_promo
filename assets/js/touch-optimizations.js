// ===== TOUCH OPTIMIZATIONS =====
document.addEventListener("DOMContentLoaded", function() {
    
    // ===== DETECCIÓN DE DISPOSITIVO TÁCTIL =====
    const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    const isMobile = window.innerWidth <= 768;
    
    // Agregar clase al body para CSS específico
    if (isTouchDevice) {
        document.body.classList.add('touch-device');
    }
    
    if (isMobile) {
        document.body.classList.add('mobile-device');
    }
    
    // ===== MEJORAR ELEMENTOS TÁCTILES =====
    function optimizeTouchElements() {
        // Botones
        const buttons = document.querySelectorAll('button, .boton, .conte_button, .conte_buttoni, .conte_buttonap');
        buttons.forEach(button => {
            // Asegurar tamaño mínimo táctil
            if (button.offsetWidth < 44 || button.offsetHeight < 44) {
                button.style.minWidth = '44px';
                button.style.minHeight = '44px';
            }
            
            // Mejorar feedback táctil
            button.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.95)';
                this.style.transition = 'transform 0.1s ease';
            }, { passive: true });
            
            button.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            }, { passive: true });
            
            button.addEventListener('touchcancel', function() {
                this.style.transform = 'scale(1)';
            }, { passive: true });
        });
        
        // Enlaces
        const links = document.querySelectorAll('a');
        links.forEach(link => {
            // Asegurar tamaño mínimo táctil
            if (link.offsetWidth < 44 || link.offsetHeight < 44) {
                link.style.minWidth = '44px';
                link.style.minHeight = '44px';
                link.style.display = 'inline-flex';
                link.style.alignItems = 'center';
                link.style.justifyContent = 'center';
            }
            
            // Mejorar feedback táctil
            link.addEventListener('touchstart', function() {
                this.style.opacity = '0.7';
                this.style.transition = 'opacity 0.1s ease';
            }, { passive: true });
            
            link.addEventListener('touchend', function() {
                this.style.opacity = '1';
            }, { passive: true });
            
            link.addEventListener('touchcancel', function() {
                this.style.opacity = '1';
            }, { passive: true });
        });
        
        // Inputs y formularios
        const inputs = document.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            // Prevenir zoom en iOS
            input.addEventListener('focus', function() {
                if (isMobile) {
                    const viewport = document.querySelector('meta[name="viewport"]');
                    if (viewport) {
                        viewport.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
                    }
                }
            });
            
            input.addEventListener('blur', function() {
                const viewport = document.querySelector('meta[name="viewport"]');
                if (viewport) {
                    viewport.setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes');
                }
            });
            
            // Mejorar feedback táctil
            input.addEventListener('touchstart', function() {
                this.style.borderColor = '#2230b2';
                this.style.boxShadow = '0 0 0 2px rgba(34, 48, 178, 0.2)';
            }, { passive: true });
        });
    }
    
    // ===== PREVENIR ZOOM DOBLE TAP =====
    let lastTouchEnd = 0;
    document.addEventListener('touchend', function(event) {
        const now = (new Date()).getTime();
        if (now - lastTouchEnd <= 300) {
            event.preventDefault();
        }
        lastTouchEnd = now;
    }, false);
    
    // ===== MEJORAR SCROLL TÁCTIL =====
    function improveTouchScroll() {
        // Smooth scroll para dispositivos táctiles
        if (isTouchDevice) {
            document.documentElement.style.scrollBehavior = 'smooth';
        }
        
        // Mejorar scroll en contenedores
        const scrollContainers = document.querySelectorAll('.carrusel-container, .scroll-container');
        scrollContainers.forEach(container => {
            container.style.webkitOverflowScrolling = 'touch';
            container.style.overflowScrolling = 'touch';
        });
    }
    
    // ===== GESTOS TÁCTILES =====
    function addTouchGestures() {
        let startX, startY, startTime;
        
        document.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            startTime = Date.now();
        }, { passive: true });
        
        document.addEventListener('touchend', function(e) {
            if (!startX || !startY) return;
            
            const endX = e.changedTouches[0].clientX;
            const endY = e.changedTouches[0].clientY;
            const endTime = Date.now();
            
            const diffX = startX - endX;
            const diffY = startY - endY;
            const diffTime = endTime - startTime;
            
            // Detectar swipe rápido
            if (diffTime < 300) {
                if (Math.abs(diffX) > Math.abs(diffY)) {
                    // Swipe horizontal
                    if (Math.abs(diffX) > 50) {
                        if (diffX > 0) {
                            // Swipe izquierda
                            document.dispatchEvent(new CustomEvent('swipeLeft'));
                        } else {
                            // Swipe derecha
                            document.dispatchEvent(new CustomEvent('swipeRight'));
                        }
                    }
                } else {
                    // Swipe vertical
                    if (Math.abs(diffY) > 50) {
                        if (diffY > 0) {
                            // Swipe arriba
                            document.dispatchEvent(new CustomEvent('swipeUp'));
                        } else {
                            // Swipe abajo
                            document.dispatchEvent(new CustomEvent('swipeDown'));
                        }
                    }
                }
            }
            
            startX = startY = null;
        }, { passive: true });
    }
    
    // ===== MEJORAR PERFORMANCE TÁCTIL =====
    function optimizeTouchPerformance() {
        // Usar transform en lugar de cambiar propiedades que causan reflow
        const elements = document.querySelectorAll('.conte_button, .conte_buttoni, .conte_buttonap, .boton');
        elements.forEach(element => {
            element.style.willChange = 'transform';
        });
        
        // Optimizar animaciones para dispositivos táctiles
        if (isTouchDevice) {
            document.documentElement.style.touchAction = 'manipulation';
        }
    }
    
    // ===== FEEDBACK HÁPTICO (si está disponible) =====
    function addHapticFeedback() {
        if ('vibrate' in navigator) {
            const buttons = document.querySelectorAll('button, .boton, .conte_button');
            buttons.forEach(button => {
                button.addEventListener('touchstart', function() {
                    navigator.vibrate(10); // Vibración suave
                }, { passive: true });
            });
        }
    }
    
    // ===== MEJORAR ACCESIBILIDAD TÁCTIL =====
    function improveTouchAccessibility() {
        // Aumentar área táctil para elementos pequeños
        const smallElements = document.querySelectorAll('.logo_ini, .logo_no, .contenido_iconoap, .contenido_iconot');
        smallElements.forEach(element => {
            const rect = element.getBoundingClientRect();
            if (rect.width < 44 || rect.height < 44) {
                element.style.padding = '10px';
                element.style.margin = '-10px';
            }
        });
        
        // Mejorar contraste para elementos táctiles
        const touchElements = document.querySelectorAll('button, a, input, select, textarea');
        touchElements.forEach(element => {
            const computedStyle = window.getComputedStyle(element);
            const backgroundColor = computedStyle.backgroundColor;
            const color = computedStyle.color;
            
            // Si el contraste es bajo, mejorar
            if (backgroundColor === 'rgba(0, 0, 0, 0)' || backgroundColor === 'transparent') {
                element.style.backgroundColor = '#f5f5f5';
                element.style.border = '1px solid #ddd';
            }
        });
    }
    
    // ===== DETECCIÓN DE ORIENTACIÓN =====
    function handleOrientationChange() {
        const orientation = window.orientation;
        
        if (orientation === 0 || orientation === 180) {
            // Portrait
            document.body.classList.add('portrait');
            document.body.classList.remove('landscape');
        } else {
            // Landscape
            document.body.classList.add('landscape');
            document.body.classList.remove('portrait');
        }
        
        // Reajustar elementos después del cambio de orientación
        setTimeout(() => {
            optimizeTouchElements();
        }, 100);
    }
    
    // ===== INICIALIZACIÓN =====
    function init() {
        optimizeTouchElements();
        improveTouchScroll();
        addTouchGestures();
        optimizeTouchPerformance();
        addHapticFeedback();
        improveTouchAccessibility();
        handleOrientationChange();
        
        // Re-ejecutar en resize
        window.addEventListener('resize', function() {
            setTimeout(() => {
                optimizeTouchElements();
                improveTouchAccessibility();
            }, 100);
        });
        
        // Re-ejecutar en cambio de orientación
        window.addEventListener('orientationchange', function() {
            setTimeout(() => {
                handleOrientationChange();
            }, 100);
        });
    }
    
    // Inicializar
    init();
    
    // Re-ejecutar cuando se agreguen nuevos elementos dinámicamente
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                setTimeout(() => {
                    optimizeTouchElements();
                    improveTouchAccessibility();
                }, 100);
            }
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
