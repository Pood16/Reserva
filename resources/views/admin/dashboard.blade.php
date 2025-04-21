<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 w-full">
        <!-- Admin Sidebar -->
        <div class="bg-white shadow-md w-64 fixed inset-y-0 left-0 transform transition duration-200 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
            id="sidebar" x-data="{ open: true }" :class="{'translate-x-0': open, '-translate-x-full': !open}">
            {{-- <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <div class="flex items-center">
                    <span class="text-amber-500 text-2xl font-semibold">Admin Panel</span>
                </div>
                <button @click="open = !open" class="lg:hidden">
                    <i class="fas fa-times text-gray-600 hover:text-amber-500"></i>
                </button>
            </div> --}}
            <nav class="mt-6">
                <ul class="space-y-2 px-4">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-amber-50 {{ request()->routeIs('admin.dashboard') ? 'bg-amber-100 text-amber-600' : '' }}">
                            <i class="fas fa-tachometer-alt w-5 h-5 mr-3 text-gray-500"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <!-- User Management Section -->
                    <li class="pt-4">
                        <span class="px-2 text-xs font-semibold text-gray-400 uppercase">User Management</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-amber-50 {{ request()->routeIs('admin.users.*') ? 'bg-amber-100 text-amber-600' : '' }}">
                            <i class="fas fa-users w-5 h-5 mr-3 text-gray-500"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <!-- Restaurant Management Section -->
                    <li class="pt-4">
                        <span class="px-2 text-xs font-semibold text-gray-400 uppercase">Restaurant Management</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.restaurants.index') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-amber-50 {{ request()->routeIs('admin.restaurants.*') ? 'bg-amber-100 text-amber-600' : '' }}">
                            <i class="fas fa-utensils w-5 h-5 mr-3 text-gray-500"></i>
                            <span>Restaurants</span>
                        </a>
                    </li>
                    <!-- System Settings Section -->
                    <li class="pt-4">
                        <span class="px-2 text-xs font-semibold text-gray-400 uppercase">System</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.settings') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-amber-50 {{ request()->routeIs('admin.settings') ? 'bg-amber-100 text-amber-600' : '' }}">
                            <i class="fas fa-cog w-5 h-5 mr-3 text-gray-500"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    <!-- Return to Main Site -->
                    <li class="pt-6">
                        <a href="{{ route('home') }}" class="flex items-center p-2 text-gray-700 rounded-lg hover:bg-amber-50">
                            <i class="fas fa-arrow-left w-5 h-5 mr-3 text-gray-500"></i>
                            <span>Return to Site</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class=" lg:ml-64 mt-10 w-11/12 mx-auto">
            <!-- Top Bar -->
            {{-- <div class="bg-white shadow-sm sticky top-0 z-10">
                <div class="flex items-center justify-between p-4">
                    <button class="lg:hidden" onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')">
                        <i class="fas fa-bars text-gray-600 hover:text-amber-500"></i>
                    </button>
                    <div class="ml-auto flex items-center gap-4">
                        <div class="relative">
                            <button class="flex items-center text-gray-700 focus:outline-none">
                                <span class="mr-2">{{ Auth::user()->name }}</span>
                                <i class="fas fa-user-circle text-xl text-amber-500"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Content -->
            <div class="p-6">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @if(session('unauthorized'))
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                        <p>{{ session('unauthorized') }}</p>
                    </div>
                @endif

                <!-- Page Heading -->
                <div class="mb-6">
                    {{-- <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1> --}}
                    <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}!</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="bg-amber-100 p-3 rounded-full">
                                <i class="fas fa-users text-amber-500"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $userCount ?? 0 }}</h3>
                                <p class="text-gray-500">Total Users</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-utensils text-green-500"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $restaurantCount ?? 0 }}</h3>
                                <p class="text-gray-500">Restaurants</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-calendar-check text-blue-500"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $reservationCount ?? 0 }}</h3>
                                <p class="text-gray-500">Reservations</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Latest Users -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Recently Registered Users</h3>
                        </div>
                        <div class="p-6">
                            @if(isset($latestUsers) && count($latestUsers) > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Registered</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($latestUsers as $user)
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap">{{ $user->name }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap">{{ $user->email }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' :
                                                              ($user->role === 'manager' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                                            {{ ucfirst($user->role) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $user->created_at->format('M j, Y') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4 text-center">
                                    <a href="{{ route('admin.users.index') }}" class="text-amber-500 hover:text-amber-600 font-medium">
                                        View All Users <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @else
                                <p class="text-gray-500">No users found.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Latest Restaurants -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Latest Restaurants</h3>
                        </div>
                        <div class="p-6">
                            @if(isset($latestRestaurants) && count($latestRestaurants) > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Added</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($latestRestaurants as $restaurant)
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap">{{ $restaurant->name }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap">{{ $restaurant->city }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            {{ $restaurant->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                            {{ $restaurant->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $restaurant->created_at->format('M j, Y') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4 text-center">
                                    <a href="{{ route('admin.restaurants.index') }}" class="text-amber-500 hover:text-amber-600 font-medium">
                                        View All Restaurants <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @else
                                <p class="text-gray-500">No restaurants found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script>
        // Any additional JavaScript you need for the dashboard
        document.addEventListener('DOMContentLoaded', function() {
            // Any initialization scripts
        });
    </script>
    @endpush
</x-app-layout>
