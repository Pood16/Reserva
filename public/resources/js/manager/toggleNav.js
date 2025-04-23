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
    // smooth scrolling
    const mainContent = document.querySelector('main');
    if (mainContent) {
        mainContent.classList.add('scroll-smooth');
    }
})
