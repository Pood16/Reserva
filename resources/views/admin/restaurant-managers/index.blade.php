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
                        <h1 class="text-2xl font-semibold text-gray-800">Restaurant Managers</h1>
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

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-800">Restaurant Managers</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manager</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Restaurants</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($managers as $manager)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($manager->profile_picture)
                                                        <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $manager->profile_picture) }}" alt="{{ $manager->name }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-800 font-medium">
                                                            {{ strtoupper(substr($manager->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $manager->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $manager->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $manager->restaurants_count }} restaurants
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($manager->is_banned)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Banned
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $manager->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-3">
                                                @if($manager->is_banned)
                                                    <button type="button"
                                                            class="text-green-600 hover:text-green-900 action-btn"
                                                            data-action="unban"
                                                            data-manager-id="{{ $manager->id }}"
                                                            data-manager-name="{{ $manager->name }}">
                                                        <i class="fas fa-unlock mr-1"></i> Unban
                                                    </button>
                                                @else
                                                    <button type="button"
                                                            class="text-yellow-600 hover:text-yellow-900 action-btn"
                                                            data-action="ban"
                                                            data-manager-id="{{ $manager->id }}"
                                                            data-manager-name="{{ $manager->name }}">
                                                        <i class="fas fa-ban mr-1"></i> Ban
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No restaurant managers found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Confirm Action</h3>
            </div>
            <div class="px-6 py-4">
                <p id="modalMessage" class="text-gray-700"></p>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3 rounded-b-lg">
                <button type="button" id="cancelAction" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <form id="confirmForm" method="POST">
                    @csrf
                    <button type="submit" id="confirmAction" class="px-4 py-2 bg-amber-500 text-white rounded-md hover:bg-amber-600">
                        Confirm
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('resources/js/manager/toggleNav.js') }}"></script>
    <script>
        // Handle action button clicks
        const actionButtons = document.querySelectorAll('.action-btn');
        actionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const managerId = this.getAttribute('data-manager-id');
                const managerName = this.getAttribute('data-manager-name');
                const action = this.getAttribute('data-action');

                const modal = document.getElementById('confirmationModal');
                const modalTitle = document.getElementById('modalTitle');
                const modalMessage = document.getElementById('modalMessage');
                const confirmForm = document.getElementById('confirmForm');

                // Configure modal based on action
                switch(action) {
                    case 'ban':
                        modalTitle.textContent = 'Confirm Ban';
                        modalMessage.textContent = `Are you sure you want to ban ${managerName}? This will deactivate all their restaurants and change their role to client.`;
                        confirmForm.action = "{{ route('admin.restaurant-managers.ban', ':id') }}".replace(':id', managerId);
                        break;
                    case 'unban':
                        modalTitle.textContent = 'Confirm Unban';
                        modalMessage.textContent = `Are you sure you want to unban ${managerName}? This will reactivate their restaurants and restore manager privileges.`;
                        confirmForm.action = "{{ route('admin.restaurant-managers.unban', ':id') }}".replace(':id', managerId);
                        break;
                }

                // Show modal
                modal.classList.remove('hidden');
            });
        });

        // Close modal on cancel
        document.getElementById('cancelAction').addEventListener('click', function() {
            document.getElementById('confirmationModal').classList.add('hidden');
        });

        // Close modal when clicking outside
        document.getElementById('confirmationModal').addEventListener('click', function(event) {
            if (event.target === this) {
                this.classList.add('hidden');
            }
        });
    </script>
    @endpush
</x-app-layout>
