<header class="bg-white shadow-sm sticky top-0 z-20 py-1">
    <div class="flex items-center justify-between px-6 py-3">
        <div class="flex items-center">
            <button id="toggleSidebar" class="mr-4 text-gray-600 hover:text-amber-500 lg:hidden">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative" id="userMenu">
                <button id="toggleUserMenu" class="flex items-center text-gray-700 hover:text-amber-500 focus:outline-none">
                    <span class="mr-2 hidden sm:inline">{{ Auth::user()->name }}</span>
                    <i class="fas fa-user-circle text-xl"></i>
                </button>
                <div id="userMenuDropdown" class="absolute right-0 w-48 py-2 mt-2 bg-white rounded-md shadow-lg z-50 hidden">
                    @if(Auth::user()->role === 'manager')
                        <a href="{{ route('manager.profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                    @elseif(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
