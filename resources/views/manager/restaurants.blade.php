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

                <!-- manage restaurants -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">My Restaurants</h3>
                        <a href="#" class="bg-amber-500 hover:bg-amber-600 text-white py-2 px-4 rounded inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i> Add Restaurant
                        </a>
                    </div>

                    <div class="p-6">
                        @if(count($myRestaurants) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hours</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($myRestaurants as $restaurant)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-4">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full object-cover"
                                                                src="{{ asset('storage/restaurants/' . $restaurant->cover_image)}}"
                                                                alt="{{ $restaurant->name }}"
                                                                onerror="this.src='{{ asset('resources/images/default-profile.png') }}'">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">{{ $restaurant->name }}</div>
                                                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ $restaurant->description }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <div class="text-sm text-gray-900">{{ $restaurant->city }}</div>
                                                    <div class="text-sm text-gray-500">{{ $restaurant->address }}</div>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <div class="text-sm text-gray-900">{{ $restaurant->phone }}</div>
                                                    <div class="text-sm text-gray-500">{{ $restaurant->email }}</div>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <div class="text-sm text-gray-900">{{ substr($restaurant->opening_time, 0, 5) }} - {{ substr($restaurant->closing_time, 0, 5) }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        @php
                                                            $days = json_decode($restaurant->opening_days);
                                                            echo $days ? implode(', ', array_map(function($day) {
                                                                return substr($day, 0, 3);
                                                            }, $days)) : 'Not set';
                                                        @endphp
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        {{ $restaurant->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $restaurant->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                                    <div class="flex space-x-2">
                                                        <a href="#" class="text-blue-600 hover:text-blue-900" title="View details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="#" class="text-amber-600 hover:text-amber-900" title="Edit restaurant">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="#" class="text-green-600 hover:text-green-900" title="Manage tables">
                                                            <i class="fas fa-chair"></i>
                                                        </a>
                                                        <form action="#" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="{{ $restaurant->is_active ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" title="{{ $restaurant->is_active ? 'Deactivate' : 'Activate' }}">
                                                                <i class="fas {{ $restaurant->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-10">
                                <div class="text-gray-500 mb-4">You haven't added any restaurants yet</div>
                                <a href="#" class="bg-amber-500 hover:bg-amber-600 text-white py-2 px-4 rounded inline-flex items-center">
                                    <i class="fas fa-plus mr-2"></i> Add Your First Restaurant
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    @push('scripts')
    <script src="{{asset('resources/js/dashboardToggle.js')}}"></script>
    @endpush
</x-app-layout>
