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

                <!-- Breadcrumbs and back button -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <a href="{{ route('manager.menus.items', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id]) }}" class="inline-flex items-center text-gray-700 hover:text-amber-600">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Menu Items
                        </a>
                    </div>
                </div>

                <!-- Edit Item Form -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Edit Menu Item: {{ $item->name }}</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('manager.menus.items.update', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id, 'itemId' => $item->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Left Column -->
                                <div class="space-y-4">
                                    <!-- Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Item Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $item->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 p-2" required>
                                        @error('name')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-gray-700">Description <span class="text-red-500">*</span></label>
                                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 p-2" required>{{ old('description', $item->description) }}</textarea>
                                        @error('description')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <!-- Price -->
                                    <div>
                                        <label for="price" class="block text-sm font-medium text-gray-700">Price <span class="text-red-500">*</span></label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">$</span>
                                            </div>
                                            <input type="number" name="price" id="price" min="0" step="0.01" value="{{ old('price', $item->price) }}" class="mt-1 block w-full pl-7 rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 p-2" required>
                                        </div>
                                        @error('price')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>


                                </div>

                                <!-- Right Column -->
                                <div class="space-y-4">


                                    <!-- Current Image -->
                                    @if($item->image)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Current Image</label>
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="h-32 w-32 object-cover rounded-md">
                                        </div>
                                    </div>
                                    @endif

                                    <!-- New Image -->
                                    <div>
                                        <label for="image" class="block text-sm font-medium text-gray-700">{{ $item->image ? 'Update Image' : 'Add Image' }}</label>
                                        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                                        <p class="text-xs text-gray-500 mt-1">Upload a new image (optional). Max 2MB.</p>
                                        @error('image')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Availability -->
                                    <div class="mt-4">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', $item->is_available) ? 'checked' : '' }} class="h-4 w-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                                            <label for="is_available" class="ml-2 block text-sm text-gray-700">Item is available</label>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Uncheck if this item is temporarily unavailable.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex justify-end space-x-3 pt-4 border-t">
                                <a href="{{ route('manager.menus.items', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id]) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                    Cancel
                                </a>
                                <button type="submit" class="bg-amber-500 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                    Update Item
                                </button>
                            </div>
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
