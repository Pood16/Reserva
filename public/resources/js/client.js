

console.log('hello');

// Timeout for the unauthorized flash
setTimeout(() => {
    const flashMessage = document.getElementById('unauthorized-flash-message');
    if (flashMessage) {
        flashMessage.style.opacity = '0';
        setTimeout(() => flashMessage.remove(), 500);
    }
}, 5000);
