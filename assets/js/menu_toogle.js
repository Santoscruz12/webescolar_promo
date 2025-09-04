debugger;
    document.addEventListener("DOMContentLoaded", function () {
        const menuToggle = document.querySelector(".menu-toggle");
        const sideMenu = document.getElementById("sideMenu");
        const sideMenuOverlay = document.getElementById("sideMenuOverlay");
        const sideMenuClose = document.getElementById("sideMenuClose");
        const sideMenuLinks = sideMenu ? sideMenu.querySelectorAll("a") : [];

        // OCULTAR OVERLAY POR DEFECTO
        if (sideMenuOverlay) {
            sideMenuOverlay.style.display = 'none';
            sideMenuOverlay.style.opacity = '0';
        }

        // Abrir menú
        if (menuToggle && sideMenu && sideMenuOverlay) {
            menuToggle.addEventListener('click', () => {
                sideMenu.classList.add('open');
                sideMenuOverlay.style.display = 'block';
                setTimeout(() => { sideMenuOverlay.style.opacity = '1'; }, 10);
            });
        }
        // Cerrar menú
        function closeSideMenu() {
            sideMenu.classList.remove('open');
            sideMenuOverlay.style.opacity = '0';
            setTimeout(() => { sideMenuOverlay.style.display = 'none'; }, 300);
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
    });
