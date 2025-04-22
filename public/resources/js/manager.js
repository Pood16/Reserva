

document.addEventListener('DOMContentLoaded', function() {
    // Toggle navbar
    const sidebar = document.getElementById('sidebar');
    const toggleSidebar = document.getElementById('toggleSidebar');
    const closeSidebar = document.getElementById('closeSidebar');
    toggleSidebar.addEventListener('click', function() {
        sidebar.classList.toggle('-translate-x-full');
    });
    closeSidebar.addEventListener('click', function() {
        sidebar.classList.add('-translate-x-full');
    });
    // User menu dropdown toggle
    const toggleUserMenu = document.getElementById('toggleUserMenu');
    const userMenuDropdown = document.getElementById('userMenuDropdown');

    toggleUserMenu.addEventListener('click', function() {
        userMenuDropdown.classList.toggle('hidden');
    });
    // Close user menu when clicking outside
    document.addEventListener('click', function(event) {
        const userMenu = document.getElementById('userMenu');
        if (!userMenu.contains(event.target)) {
            userMenuDropdown.classList.add('hidden');
        }
    });
    // Add smooth scrolling to the main content
    const mainContent = document.querySelector('main');
    if (mainContent) {
        mainContent.classList.add('scroll-smooth');
    }

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
