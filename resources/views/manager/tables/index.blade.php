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

            <x-flash-messages />

            <!-- content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                <!-- Flash Messages -->
                <x-flash-messages />

                <!-- Breadcrumbs and back button -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <a href="{{ route('restaurant.details', $restaurant->id) }}" class="inline-flex items-center text-gray-700 hover:text-amber-600">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Restaurant Details
                        </a>
                    </div>
                    <div>
                        <button id="openTableModal" class="bg-amber-500 hover:bg-amber-600 text-white py-2 px-4 rounded inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i> Add New Table
                        </button>
                    </div>
                </div>

                <!-- Restaurant Name -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Tables for {{ $restaurant->name }}</h3>
                    </div>
                </div>

                <!-- Tables List -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        @if(count($restaurant->tables) > 0)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capacity</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Availability</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($restaurant->tables as $table)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $table->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $table->capacity }} people</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ ucfirst($table->location) }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500">{{ $table->description ?? 'No description' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('manager.tables.toggle-availability', ['restaurantId' => $restaurant->id, 'id' => $table->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $table->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $table->is_available ? 'Available' : 'Unavailable' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('manager.tables.toggle-active', ['restaurantId' => $restaurant->id, 'id' => $table->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $table->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                        {{ $table->is_active ? 'Active' : 'Inactive' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                <a href="{{ route('manager.tables.edit', ['restaurantId' => $restaurant->id, 'id' => $table->id]) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('manager.tables.destroy', ['restaurantId' => $restaurant->id, 'id' => $table->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this table?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-10">
                                <div class="text-gray-500 mb-4">No tables have been added to this restaurant yet</div>
                                <p class="text-sm text-gray-500">Add tables to allow customers to make reservations</p>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Table Modal -->
    <div id="addTableModal" class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg w-full max-w-md max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800">Add New Table</h3>
                <button id="closeTableModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('manager.tables.store', $restaurant->id) }}" method="POST" class="p-6">
                @csrf

                <div class="space-y-6">
                    <!-- Table Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Table Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md p-1" placeholder="e.g. Table 1" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Capacity -->
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">Capacity <span class="text-red-500">*</span></label>
                        <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" min="1" max="20" class="p-1 shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                        @error('capacity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location <span class="text-red-500">*</span></label>
                        <select name="location" id="location" class="p-1 shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            <option value="">Select location</option>
                            <option value="indoors" {{ old('location') == 'indoor' ? 'selected' : '' }}>Indoor</option>
                            <option value="outdoors" {{ old('location') == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                            <option value="terrace" {{ old('location') == 'outdoor' ? 'selected' : '' }}>Terrace</option>
                        </select>
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                        <textarea name="description" id="description" rows="3" class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g. Near the window with a nice view">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Is Available -->
                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_available" id="is_available" class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded" {{ old('is_available') ? 'checked' : 'checked' }}>
                                <label for="is_available" class="ml-2 block text-sm font-medium text-gray-700">
                                    Available for booking
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Customers can book this table if checked</p>
                        </div>

                        <!-- Is Active -->
                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded" {{ old('is_active') ? 'checked' : 'checked' }}>
                                <label for="is_active" class="ml-2 block text-sm font-medium text-gray-700">
                                    Active
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Table is active and displayed on the site</p>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" id="cancelTable" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Cancel
                        </button>
                        <button type="submit" class="bg-amber-500 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Create Table
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="{{asset('resources/js/manager/toggleNav.js')}}"></script>
    <script>
        // Table Modal
        const tableModal = document.getElementById('addTableModal');
        const openTableModalBtn = document.getElementById('openTableModal');
        const closeTableModalBtn = document.getElementById('closeTableModal');
        const cancelTableBtn = document.getElementById('cancelTable');

        function openTableModal() {
            tableModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeTableModal() {
            tableModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        openTableModalBtn.addEventListener('click', openTableModal);
        closeTableModalBtn.addEventListener('click', closeTableModal);
        cancelTableBtn.addEventListener('click', closeTableModal);

        // Close modal when clicking outside of it
        tableModal.addEventListener('click', function(event) {
            if (event.target === tableModal) {
                closeTableModal();
            }
        });

        // Check for validation errors to reopen the modal
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there are validation errors
            @if($errors->any())
            openTableModal();
            @endif
        });
    </script>
    @endpush
</x-app-layout>
