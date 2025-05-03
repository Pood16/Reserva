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
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
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
                <x-flash-messages />

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="fas fa-user-plus text-purple-500"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $managerRequestCount ?? 0 }}</h3>
                                <p class="text-gray-500">Manager Requests</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- User Roles Chart -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">User Distribution by Role</h3>
                        </div>
                        <div class="p-6">
                            <canvas id="userRolesChart" width="400" height="250"></canvas>
                        </div>
                    </div>

                    <!-- Reservation Status Chart -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Reservation Status Distribution</h3>
                        </div>
                        <div class="p-6">
                            <canvas id="reservationStatusChart" width="400" height="250"></canvas>
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

                    <!-- Recent Reservations -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Reservations</h3>
                        </div>
                        <div class="p-6">
                            @if(isset($recentReservations) && count($recentReservations) > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Restaurant</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($recentReservations as $reservation)
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap">{{ $reservation->restaurant->name }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap">{{ $reservation->user->name }}</td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                        {{ \Carbon\Carbon::parse($reservation->date . ' ' . $reservation->time)->format('M j, Y g:i A') }}
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            {{ $reservation->status === 'confirmed' ? 'bg-blue-100 text-blue-800' :
                                                              ($reservation->status === 'completed' ? 'bg-green-100 text-green-800' :
                                                              ($reservation->status === 'canceled' || $reservation->status === 'declined' ? 'bg-red-100 text-red-800' :
                                                              'bg-yellow-100 text-yellow-800')) }}">
                                                            {{ ucfirst($reservation->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500">No reservations found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{asset('resources/js/manager/toggleNav.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart
            const userRolesCtx = document.getElementById('userRolesChart').getContext('2d');
            const userRolesData = @json($usersByRole);

            new Chart(userRolesCtx, {
                type: 'doughnut',
                data: {
                    labels: userRolesData.map(item => item.role.charAt(0).toUpperCase() + item.role.slice(1)),
                    datasets: [{
                        data: userRolesData.map(item => item.count),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',  // Red admin
                            'rgba(54, 162, 235, 0.7)',  // Blue manager
                            'rgba(75, 192, 192, 0.7)'   // Green client
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: 'User Distribution by Role'
                        }
                    }
                }
            });

            // Reservation Status Chart
            const reservationStatusCtx = document.getElementById('reservationStatusChart').getContext('2d');
            const statusLabels = @json($statusLabels);
            const statusCounts = @json($statusCounts);
            const statusBgColors = @json($statusBgColors);
            const statusBorderColors = @json($statusBorderColors);

            new Chart(reservationStatusCtx, {
                type: 'bar',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        label: 'Reservations',
                        data: statusCounts,
                        backgroundColor: statusBgColors,
                        borderColor: statusBorderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Reservation Status Distribution'
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
