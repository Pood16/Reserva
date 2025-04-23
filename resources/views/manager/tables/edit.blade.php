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
                <x-flash-messages />

                <!-- Back button -->
                <div class="mb-6">
                    <a href="{{ route('manager.tables.index', $restaurant->id) }}" class="inline-flex items-center text-gray-700 hover:text-amber-600">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Tables
                    </a>
                </div>

                <!-- Edit Table Form -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Edit Table: {{ $table->name }}</h3>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('manager.tables.update', ['restaurantId' => $restaurant->id, 'id' => $table->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Table Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Table Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $table->name) }}" class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g. Table 1" required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Capacity -->
                                <div>
                                    <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">Capacity</label>
                                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $table->capacity) }}" min="1" max="20" class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    @error('capacity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="mb-6">
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                <select name="location" id="location" class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    <option value="">Select location</option>
                                    <option value="indoor" {{ old('location', $table->location) == 'indoor' ? 'selected' : '' }}>Indoor</option>
                                    <option value="outdoor" {{ old('location', $table->location) == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                                </select>
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-6">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                                <textarea name="description" id="description" rows="3" class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g. Near the window with a nice view">{{ old('description', $table->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Is Available -->
                                <div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_available" id="is_available" class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded" {{ old('is_available', $table->is_available) ? 'checked' : '' }}>
                                        <label for="is_available" class="ml-2 block text-sm font-medium text-gray-700">
                                            Available for booking
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Customers can book this table if checked</p>
                                </div>

                                <!-- Is Active -->
                                <div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded" {{ old('is_active', $table->is_active) ? 'checked' : '' }}>
                                        <label for="is_active" class="ml-2 block text-sm font-medium text-gray-700">
                                            Active
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Table is active and displayed on the site</p>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                    <i class="fas fa-save mr-2"></i> Update Table
                                </button>

                                <!-- Delete Button -->
                                <button type="button" onclick="if(confirm('Are you sure you want to delete this table?')) { document.getElementById('delete-form').submit(); }" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <i class="fas fa-trash mr-2"></i> Delete
                                </button>
                            </div>
                        </form>

                        <form id="delete-form" action="{{ route('manager.tables.destroy', ['restaurantId' => $restaurant->id, 'id' => $table->id]) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @push('scripts')
    <script src="{{asset('resources/js/manager/toggleNav.js')}}"></script>
    @endpush
</x-app-layout>
