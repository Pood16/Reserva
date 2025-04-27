<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <!-- Navbar -->
        <x-admin-manager-nav />

        <div class="flex flex-col flex-1 lg:ml-64">
            <!-- Fixed Header -->
            <x-dashboard-header />

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

                <!-- Chart Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Restaurant Statistics Chart -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Restaurant Statistics</h3>
                        </div>
                        <div class="p-6">
                            <canvas id="restaurantChart" width="400" height="300"></canvas>
                        </div>
                    </div>

                    <!-- Table Usage Chart -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Table Usage</h3>
                        </div>
                        <div class="p-6">
                            <canvas id="tableUsageChart" width="400" height="300"></canvas>
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
    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Restaurant Statistics Chart
            var restaurantCtx = document.getElementById('restaurantChart').getContext('2d');
            var activeCount = {{ $activeRestaurants ?? 0 }};
            var totalCount = {{ $restaurantCount ?? 0 }};
            var inactiveCount = totalCount - activeCount;

            new Chart(restaurantCtx, {
                type: 'pie',
                data: {
                    labels: ['Active Restaurants', 'Inactive Restaurants'],
                    datasets: [{
                        data: [activeCount, inactiveCount],
                        backgroundColor: [
                            'rgba(52, 211, 153, 0.7)',
                            'rgba(239, 68, 68, 0.7)'
                        ],
                        borderColor: [
                            'rgba(52, 211, 153, 1)',
                            'rgba(239, 68, 68, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Restaurant Status Distribution'
                        }
                    }
                }
            });

            // Table Usage Chart
            var tableCtx = document.getElementById('tableUsageChart').getContext('2d');
            var tableCount = {{ $tableCount ?? 0 }};
            var reservedTables = Math.floor(tableCount / 3); // Example data
            var availableTables = tableCount - reservedTables; // Example data

            new Chart(tableCtx, {
                type: 'bar',
                data: {
                    labels: ['Tables Total', 'Tables Reserved', 'Tables Available'],
                    datasets: [{
                        label: 'Table Statistics',
                        data: [tableCount, reservedTables, availableTables],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.7)',
                            'rgba(251, 191, 36, 0.7)',
                            'rgba(52, 211, 153, 0.7)'
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(251, 191, 36, 1)',
                            'rgba(52, 211, 153, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Table Utilization'
                        }
                    }
                }
            });
        });
    </script>

    <script src="{{asset('resources/js/manager/toggleNav.js')}}"></script>
    <script src="{{asset('resources/js/manager/dashboard.js')}}"></script>
    <script src="{{asset('resources/js/manager/restaurantsList.js')}}"></script>
    @endpush
</x-app-layout>
