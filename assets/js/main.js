document.addEventListener('DOMContentLoaded', function() {
    // Cargar header
    fetch('./pages/header.html')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('header-container').innerHTML = data;
            initHeader();
        })
        .catch(error => {
            console.error('Error loading header:', error);
        });
    
    // Cargar footer
    fetch('./pages/footer.html')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            document.querySelector('.site-footer').innerHTML = data;
        })
        .catch(error => {
            console.error('Error loading footer:', error);
        });
});

function initHeader() {
    // Funcionalidad específica del header
    const navItems = document.querySelectorAll('nav ul li a');
    
    navItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.color = '#f1c40f';
            this.querySelector('img').style.transform = 'scale(1.1)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.color = 'white';
            this.querySelector('img').style.transform = 'scale(1)';
        });
    });
}