document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector(".menu-toggle");
    const sideMenu = document.getElementById("sideMenu");
    const sideMenuOverlay = document.getElementById("sideMenuOverlay");
    const sideMenuClose = document.getElementById("sideMenuClose");
    const sideMenuLinks = sideMenu ? sideMenu.querySelectorAll("a") : [];

    // Función para abrir el menú
    function openSideMenu() {
        if (sideMenu && sideMenuOverlay) {
            sideMenu.classList.add('open');
            sideMenuOverlay.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Previene scroll del body
            setTimeout(() => { 
                sideMenuOverlay.style.opacity = '1'; 
            }, 10);
        }
    }

    // Función para cerrar el menú
    function closeSideMenu() {
        if (sideMenu && sideMenuOverlay) {
            sideMenu.classList.remove('open');
            sideMenuOverlay.style.opacity = '0';
            document.body.style.overflow = ''; // Restaura scroll del body
            setTimeout(() => { 
                sideMenuOverlay.style.display = 'none'; 
            }, 300);
        }
    }

    // Event listeners
    if (menuToggle) {
        menuToggle.addEventListener('click', openSideMenu);
    }

    if (sideMenuClose) {
        sideMenuClose.addEventListener('click', closeSideMenu);
    }

    if (sideMenuOverlay) {
        sideMenuOverlay.addEventListener('click', closeSideMenu);
    }

    // Cerrar menú al hacer clic en un enlace
    if (sideMenuLinks.length) {
        sideMenuLinks.forEach(link => {
            link.addEventListener('click', closeSideMenu);
        });
    }

    // Cerrar menú con tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sideMenu && sideMenu.classList.contains('open')) {
            closeSideMenu();
        }
    });

    // Manejar redimensionamiento de ventana
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && sideMenu && sideMenu.classList.contains('open')) {
            closeSideMenu();
        }
    });
});
