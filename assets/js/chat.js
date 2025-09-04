document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('chatbotBtn');
    var box = document.getElementById('chatbotBox');
    if(btn && box) {
        btn.addEventListener('click', function() {
            if (box.style.display === 'block') {
                box.style.display = 'none';
            } else {
                box.style.display = 'block';
            }
        });
    }
});