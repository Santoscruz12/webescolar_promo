document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector(".menu-toggle");
    const sideMenu = document.getElementById("sideMenu");
    const sideMenuOverlay = document.getElementById("sideMenuOverlay");
    const sideMenuClose = document.getElementById("sideMenuClose");
    const sideMenuLinks = sideMenu ? sideMenu.querySelectorAll("a") : [];

    function openSideMenu() {
        if (sideMenu && sideMenuOverlay) {
            sideMenu.classList.add('open');
            sideMenuOverlay.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeSideMenu() {
        if (sideMenu && sideMenuOverlay) {
            sideMenu.classList.remove('open');
            sideMenuOverlay.classList.remove('open');
            document.body.style.overflow = '';
        }
    }

    if (menuToggle) menuToggle.addEventListener('click', openSideMenu);
    if (sideMenuClose) sideMenuClose.addEventListener('click', closeSideMenu);
    if (sideMenuOverlay) sideMenuOverlay.addEventListener('click', closeSideMenu);

    if (sideMenuLinks.length) {
        sideMenuLinks.forEach(link => link.addEventListener('click', closeSideMenu));
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sideMenu && sideMenu.classList.contains('open')) {
            closeSideMenu();
        }
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && sideMenu && sideMenu.classList.contains('open')) {
            closeSideMenu();
        }
    });
});
