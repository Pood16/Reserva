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
                <x-flash-messages />

                <div class="flex justify-between items-center mb-6">
                    <div>
                        <a href="{{ route('manager.tables.index', $restaurant->id) }}" class="inline-flex items-center text-gray-700 hover:text-amber-600">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Tables
                        </a>
                    </div>
                </div>

                <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white">Edit Table: {{ $table->name }}</h3>
                    </div>

                    <form action="{{ route('manager.tables.update', ['restaurantId' => $restaurant->id, 'id' => $table->id]) }}" method="POST" class="p-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Table Name <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $table->name) }}" class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md p-2" placeholder="e.g. Table 1" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Capacity -->
                            <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">Capacity <span class="text-red-500">*</span></label>
                                <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $table->capacity) }}" min="1" max="20" class="p-2 shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                @error('capacity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location <span class="text-red-500">*</span></label>
                            <select name="location" id="location" class="p-2 shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">Select location</option>
                                <option value="indoors" {{ old('location', $table->location) == 'indoors' ? 'selected' : '' }}>Indoor</option>
                                <option value="outdoors" {{ old('location', $table->location) == 'outdoors' ? 'selected' : '' }}>Outdoor</option>
                                <option value="terrace" {{ old('location', $table->location) == 'terrace' ? 'selected' : '' }}>Terrace</option>
                            </select>
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                            <textarea name="description" id="description" rows="3" class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md p-2" placeholder="e.g. Near the window with a nice view">{{ old('description', $table->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-md">
                            <!-- Is Available -->
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input type="checkbox" name="is_available" id="is_available" class="h-5 w-5 text-amber-600 focus:ring-amber-500 border-gray-300 rounded" {{ old('is_available', $table->is_available) ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_available" class="font-medium text-gray-700">Available for booking</label>
                                    <p class="text-gray-500">Customers can book this table if checked</p>
                                </div>
                            </div>

                            <!-- Is Active -->
                            <div class="flex items-start">
                                <div class="flex h-5 items-center">
                                    <input type="checkbox" name="is_active" id="is_active" class="h-5 w-5 text-amber-600 focus:ring-amber-500 border-gray-300 rounded" {{ old('is_active', $table->is_active) ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_active" class="font-medium text-gray-700">Active</label>
                                    <p class="text-gray-500">Table is active and displayed on the site</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t flex justify-end space-x-3">
                            <a href="{{ route('manager.tables.index', $restaurant->id) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                Cancel
                            </a>
                            <button type="submit" class="bg-amber-500 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                Update Table
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    @push('scripts')
    <script src="{{asset('resources/js/manager/toggleNav.js')}}"></script>
    @endpush
</x-app-layout>
