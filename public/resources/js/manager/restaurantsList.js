

document.addEventListener('DOMContentLoaded', function() {
    // add Restaurant modal
    const modal = document.getElementById('addRestaurantModal');
    const openButton = document.getElementById('openRestaurantModal');
    const closeButton = document.getElementById('closeRestaurantModal');

    openButton.addEventListener('click', function() {
        modal.classList.remove('hidden');
    });

    closeButton.addEventListener('click', function() {
        modal.classList.add('hidden');
    });

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
