<div class="fixed top-0 w-full z-50 bg-white shadow-md" id="navbar">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-2 sm:py-3 flex flex-wrap justify-between items-center">
        <!-- Logo Section -->
        <div class="flex-shrink-0 flex items-center">
            <a href="{{ route('home') }}" class="flex items-center">
                <div class="text-amber-500 text-xl sm:text-2xl lg:text-3xl font-medium font-['Architects_Daughter']">QuickTable</div>
            </a>
        </div>

        <!-- Main Navigation -->
        <div class="hidden md:flex items-center space-x-3 lg:space-x-6 text-gray-700 text-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-amber-500 {{request()->routeIs('home') ? 'text-amber-600' : ''}} transition duration-200 flex items-center gap-1 p-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Home</span>
            </a>
            <a href="{{ route('restaurants.index') }}" class="hover:text-amber-500 {{request()->routeIs('restaurants.index') ? 'text-amber-600' : ''}} transition duration-200 flex items-center gap-1 p-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span>Find Restaurants</span>
            </a>
            <a href="{{ route('about') }}" class="hover:text-amber-500 {{request()->routeIs('about') ? 'text-amber-600' : ''}} transition duration-200 flex items-center gap-1 p-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>About Us</span>
            </a>
            <a href="{{ route('contact') }}" class="hover:text-amber-500 {{request()->routeIs('contact') ? 'text-amber-600' : ''}} transition duration-200 flex items-center gap-1 p-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>Contact</span>
            </a>
        </div>

        <div class="flex items-center gap-2 sm:gap-3">
            @auth
                <div class="relative flex items-center">
                    <!-- Role badges with responsive adjustments -->
                    @if(auth()->user()->role === 'admin')
                        <div class="hidden md:flex px-2 py-1 bg-red-100 text-red-700 rounded-md mr-2 items-center text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="hidden lg:inline">Admin</span>
                        </div>
                    @elseif(auth()->user()->role === 'manager')
                        <div class="hidden md:flex px-2 py-1 bg-blue-100 text-blue-700 rounded-md mr-2 items-center text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="hidden lg:inline">Manager</span>
                        </div>
                    @endif

                    @include('components.notifications')

                    <!-- User Dropdown with responsive adjustments -->
                    <div class="relative inline-block text-left">
                        <button id="user-menu-button" type="button" class="flex items-center gap-1 sm:gap-2 py-2 px-2 sm:px-3 lg:px-4 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="hidden sm:inline max-w-[80px] lg:max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                        </button>

                        <!-- Dropdown menu with responsive width -->
                        <div id="user-dropdown-menu" class="origin-top-right absolute right-0 mt-2 w-48 sm:w-56 lg:w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-500">Signed in as</p>
                                <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <div class="py-1" role="none">
                                @if(auth()->user()->role === 'client' || auth()->user()->role === 'user')
                                    <a href="{{ route('client.reservations.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        <svg class="mr-3 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        My Reservations
                                    </a>
                                    <a href="{{ route('client.reservations.history') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        <svg class="mr-3 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Reservation History
                                    </a>
                                    <a href="{{ route('favorites.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        <svg class="mr-3 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Favorites
                                    </a>
                                @endif

                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('restaurant.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                        <svg class="mr-3 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Dashboard
                                    </a>
                                @endif
                            </div>

                            <div class="py-1" role="none">
                                <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    <svg class="mr-3 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile Settings
                                </a>

                                <form method="POST" action="{{ route('logout') }}" role="menuitem">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        <svg class="mr-3 h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-x-1 sm:gap-x-2">
                    <a href="{{ route('login.show') }}" class="px-2 sm:px-3 lg:px-4 py-1.5 sm:py-2 bg-white border border-yellow-500 hover:bg-yellow-50 rounded-md text-gray-900 font-medium text-xs sm:text-sm">
                        <span class="hidden sm:inline">Login</span>
                        <span class="sm:hidden">Log</span>
                    </a>
                    <a href="{{ route('register.show') }}" class="px-2 sm:px-3 lg:px-4 py-1.5 sm:py-2 rounded-md text-gray-900 font-medium text-xs sm:text-sm bg-yellow-500 hover:bg-yellow-600">
                        <span class="hidden sm:inline">Register</span>
                        <span class="sm:hidden">Reg</span>
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Mobile menu button with improved touch target -->
    <div class="md:hidden border-t border-gray-100">
        <button id="mobile-menu-button" class="flex w-full items-center justify-between px-4 py-3 text-gray-500 hover:bg-gray-50">
            <span class="text-sm font-medium">Menu</span>
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Mobile menu with better spacing -->
        <div id="mobile-menu" class="hidden px-2 pb-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">Home</a>
            <a href="{{ route('restaurants.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">Find Restaurants</a>
            @auth
            <a href="{{ route('client.reservations.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">My Reservations</a>
            <a href="{{ route('favorites.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">My Favorites</a>
            @endauth
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">About Us</a>
            <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-200">Contact</a>
        </div>
    </div>
</div>
<!-- Responsive spacer -->
<div id="header-spacer" class="h-[64px] sm:h-[72px] md:h-[60px]"></div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdownMenu = document.getElementById('user-dropdown-menu');
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        // Toggle user dropdown
        if (userMenuButton) {
            userMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdownMenu.classList.toggle('hidden');
            });
        }

        // Toggle mobile menu
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (userDropdownMenu && !userDropdownMenu.contains(e.target) && !userMenuButton.contains(e.target)) {
                userDropdownMenu.classList.add('hidden');
            }
        });
    });
</script>
@endpush


