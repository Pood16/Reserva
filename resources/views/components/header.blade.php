<div class="fixed top-0 w-full z-50 bg-white shadow-md transition-transform duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-wrap justify-between items-center">
        <div class="flex justify-center items-center gap-2.5">
            <a href="{{ route('home') }}" class="flex items-center">
                <div class="text-center text-amber-500 text-2xl sm:text-4xl font-normal font-['Architects_Daughter'] leading-10">QuickTable</div>
            </a>
        </div>

        <!-- Main Navigation -->
        <div class="hidden md:flex items-center space-x-6 text-gray-700 text-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-amber-500 transition duration-200">Home</a>
            <a href="{{ route('restaurants.index') }}" class="hover:text-amber-500 transition duration-200">Find Restaurants</a>
            <a href="{{ route('about') }}" class="hover:text-amber-500 transition duration-200">About Us</a>
            <a href="{{ route('contact') }}" class="hover:text-amber-500 transition duration-200">Contact</a>
        </div>

        <div class="flex flex-wrap items-center gap-3 mt-4 sm:mt-0">
            @auth
                <!-- User is logged in -->
                <div class="relative flex">
                    @if(auth()->user()->role === 'admin')
                        <!-- Admin  -->
                        <div class="px-4 py-2 bg-red-100 text-red-700 rounded-lg mr-3 hidden md:block">
                            Admin
                        </div>
                    @elseif(auth()->user()->role === 'manager')
                        <!-- Restaurant Owner  -->
                        <div class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg mr-3 hidden md:block">
                            Restaurant Manager
                        </div>
                    @endif

                    <!-- Notification Button -->
                    <button type="button" class="w-10 h-10 p-2 bg-yellow-500 rounded-lg flex justify-center items-center hover:bg-yellow-600 cursor-pointer relative mx-1" id="notification-button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405C18.79 14.79 18 13.42 18 12V8c0-3.314-2.686-6-6-6S6 4.686 6 8v4c0 1.42-.79 2.79-1.595 3.595L3 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">2</span>
                    </button>

                    <!-- User Dropdown -->
                    <div class="relative inline-block text-left">
                        <!-- User icon  -->
                        <button id="user-menu-button" type="button" class="w-10 h-10 p-2 bg-yellow-500 rounded-lg flex justify-center items-center hover:bg-yellow-600 cursor-pointer"  aria-expanded="false" aria-haspopup="true">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="user-dropdown-menu" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-50"  role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <!-- User name -->
                                <div class="px-4 py-2 text-sm text-gray-700 font-medium border-b border-gray-100">{{ auth()->user()->name }}</div>

                                <!-- admin or manager -->
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Dashboard</a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                @endif

                                <!-- Common for all users -->
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Profile Settings</a>

                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}" role="menuitem">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Sign out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- User is not logged in -->
                <div class="flex items-center gap-x-2">
                    <a href="{{ route('login.show') }}" class="px-5 py-2 bg-white border border-yellow-500 hover:bg-yellow-50 rounded-lg text-gray-900 font-medium text-sm transition-colors duration-300">
                        Login
                    </a>
                    <a href="{{ route('register.show') }}" class="px-5 py-2 rounded-lg text-gray-900 font-medium text-sm bg-yellow-500 hover:bg-yellow-600 transition-colors duration-300">
                        Register
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
<div id="header-spacer" class="h-[80px]"></div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // user dropdown
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdownMenu = document.getElementById('user-dropdown-menu');
        const notificationButton = document.getElementById('notification-button');
        // notification logic
        notificationButton.addEventListener('click', function(e) {
        });
        // toggle user dropdown
        userMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdownMenu.classList.toggle('hidden');
        });
    });
</script>
@endpush


