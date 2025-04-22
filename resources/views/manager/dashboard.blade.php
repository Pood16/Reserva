<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <!-- Navbar -->
        <x-admin-manager-nav />

        <div class="flex flex-col flex-1 lg:ml-64">
            <!-- Fixed Header -->
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
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                    <i class="fas fa-user mr-2"></i> Profile
                                </a>
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

            <!-- content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
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

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-utensils text-green-500"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $restaurantCount ?? 0 }}</h3>
                                <p class="text-gray-500">Your Restaurants</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-chair text-blue-500"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $tableCount ?? 0 }}</h3>
                                <p class="text-gray-500">Total Tables</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="bg-amber-100 p-3 rounded-full">
                                <i class="fas fa-check-circle text-amber-500"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $activeRestaurants ?? 0 }}</h3>
                                <p class="text-gray-500">Active Restaurants</p>
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
                            @else
                                <p class="text-gray-500">No restaurants found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    @push('scripts')
    <script src="{{asset('resources/js/manager.js')}}"></script>
    @endpush
</x-app-layout>
