// ===== MOBILE MENU TOGGLE - IMPROVED VERSION =====
document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector(".menu-toggle");
    const navList = document.querySelector(".nav-list");
    const sideMenu = document.getElementById("sideMenu");
    const sideMenuOverlay = document.getElementById("sideMenuOverlay");
    const sideMenuClose = document.getElementById("sideMenuClose");
    const sideMenuLinks = sideMenu ? sideMenu.querySelectorAll("a") : [];
    const navLinks = navList ? navList.querySelectorAll("a") : [];

    // Función para prevenir el scroll del body cuando el menú está abierto
    function preventBodyScroll(prevent) {
        if (prevent) {
            document.body.style.overflow = 'hidden';
            document.body.style.position = 'fixed';
            document.body.style.width = '100%';
        } else {
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.width = '';
        }
    }

    // Función para abrir el menú móvil
    function openMobileMenu() {
        if (navList) {
            navList.classList.add('show');
            preventBodyScroll(true);
        }
        if (sideMenu && sideMenuOverlay) {
            sideMenu.classList.add('open');
            sideMenuOverlay.style.display = 'block';
            setTimeout(() => { sideMenuOverlay.style.opacity = '1'; }, 10);
            preventBodyScroll(true);
        }
    }

    // Función para cerrar el menú móvil
    function closeMobileMenu() {
        if (navList) {
            navList.classList.remove('show');
            preventBodyScroll(false);
        }
        if (sideMenu && sideMenuOverlay) {
            sideMenu.classList.remove('open');
            sideMenuOverlay.style.opacity = '0';
            setTimeout(() => { sideMenuOverlay.style.display = 'none'; }, 300);
            preventBodyScroll(false);
        }
    }

    // Event listeners para el menú toggle
    if (menuToggle) {
        // Usar tanto click como touchstart para mejor compatibilidad
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (navList && navList.classList.contains('show')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });

        // Mejorar la accesibilidad
        menuToggle.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                if (navList && navList.classList.contains('show')) {
                    closeMobileMenu();
                } else {
                    openMobileMenu();
                }
            }
        });
    }

    // Cerrar menú al hacer clic en el overlay
    if (sideMenuOverlay) {
        sideMenuOverlay.addEventListener('click', closeMobileMenu);
    }

    // Cerrar menú con el botón de cerrar
    if (sideMenuClose) {
        sideMenuClose.addEventListener('click', closeMobileMenu);
    }

    // Cerrar menú al hacer clic en los enlaces
    [...sideMenuLinks, ...navLinks].forEach(link => {
        link.addEventListener('click', function() {
            // Pequeño delay para permitir la navegación
            setTimeout(closeMobileMenu, 100);
        });
    });

    // Cerrar menú al presionar Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMobileMenu();
        }
    });

    // Cerrar menú al redimensionar la ventana (si se vuelve desktop)
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeMobileMenu();
        }
    });

    // Mejorar la experiencia táctil
    if (navList) {
        navList.addEventListener('touchstart', function(e) {
            e.stopPropagation();
        });
    }

    // Prevenir el zoom en inputs en iOS
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            if (window.innerWidth <= 768) {
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
    });

    // Smooth scroll para enlaces internos
    const internalLinks = document.querySelectorAll('a[href^="#"]');
    internalLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                closeMobileMenu();
            }
        });
    });

    // Lazy loading para imágenes
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => imageObserver.observe(img));
    }
});
