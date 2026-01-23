document.addEventListener("DOMContentLoaded", function() {
    const notification = document.getElementById('notification-wrapper');
    if (notification) {
        notification.classList.remove('hidden');
        setTimeout(function() {
            notification.classList.add('hidden');
        }, 3500); 
        }
});