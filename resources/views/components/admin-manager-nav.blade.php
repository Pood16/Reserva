<div class="bg-white shadow-lg fixed inset-y-0 left-0 z-30 w-64 transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0"
        id="sidebar">
    <div class="flex items-center justify-between px-4 py-4 bg-amber-50 border-b border-gray-200">
        <div class="flex items-center space-x-2">
            <i class="fas fa-utensils text-amber-500 text-xl"></i>
            <span class="text-gray-800 text-lg font-semibold">QuickTable {{auth()->user()->role}}</span>
        </div>
        <button id="closeSidebar" class="lg:hidden text-gray-600 hover:text-amber-500">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="h-full overflow-y-auto pb-20">
        <nav class="mt-5">
            <ul class="space-y-2 px-4">
                @if(auth()->user()->role == 'admin')
                    <ul class="space-y-2 px-4">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-amber-50 {{ request()->routeIs('admin.dashboard') ? 'bg-amber-100 text-amber-600' : '' }}">
                                <i class="fas fa-tachometer-alt w-5 h-5 mr-3 text-gray-500"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <!-- User Management Section -->

                        <li>
                            <a href="{{ route('admin.restaurant-managers.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-amber-50 {{ request()->routeIs('admin.restaurant-managers.*') ? 'bg-amber-100 text-amber-600' : '' }}">
                                <i class="fas fa-user-tie w-5 h-5 mr-3 text-gray-500"></i>
                                <span>Restaurant Managers</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.manager-requests.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-amber-50 {{ request()->routeIs('admin.manager-requests.*') ? 'bg-amber-100 text-amber-600' : '' }}">
                                <i class="fas fa-user-plus w-5 h-5 mr-3 text-gray-500"></i>
                                <span>Manager Requests</span>
                                @if(isset($managerRequestCount) && $managerRequestCount > 0)
                                <span class="inline-flex ml-auto items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                    {{ $managerRequestCount }}
                                </span>
                                @endif
                            </a>
                        </li>
                @elseif(auth()->user()->role == 'manager')
                        <li class="pt-4">
                            <span class="px-2 text-xs font-semibold text-gray-400 uppercase">Dashboard Statistics</span>
                        </li>
                        <li>
                            <a href="{{ route('restaurant.dashboard') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-amber-50 {{ request()->routeIs('restaurant.dashboard') ? 'bg-amber-100 text-amber-600' : '' }}">
                                <i class="fas fa-tachometer-alt w-5 h-5 mr-3 text-gray-500"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <!-- restaurant management section -->
                        <li class="pt-4">
                            <span class="px-2 text-xs font-semibold text-gray-400 uppercase">Restaurant Management</span>
                        </li>
                        <li>
                            <a href="{{ route('manage.restaurants') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-amber-50 {{ request()->routeIs('manage.restaurants') ? 'bg-amber-100 text-amber-600' : '' }}">
                                <i class="fas fa-utensils w-5 h-5 mr-3 text-gray-500"></i>
                                <span>Restaurants</span>
                            </a>
                        </li>
                        <li class="pt-4">
                            <span class="px-2 text-xs font-semibold text-gray-400 uppercase">Rservations Management</span>
                        </li>
                        <li>
                            <a href="{{ route('manager.reservations') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-amber-50 {{ request()->routeIs('manager.reservations*') ? 'bg-amber-100 text-amber-600' : '' }}">
                                <i class="fas fa-calendar-check w-5 h-5 mr-3 text-gray-500"></i>
                                <span>Reservations</span>
                            </a>
                        </li>
                    </ul>
                </ul>
                @endif
                <!-- back to maain  -->
                <li class="pt-6">
                    <a href="{{ route('home') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-amber-50">
                        <i class="fas fa-arrow-left w-5 h-5 mr-3 text-gray-500"></i>
                        <span>Explore site</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

