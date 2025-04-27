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
                        <a href="{{ route('manager.menus.index', $restaurant->id) }}" class="inline-flex items-center text-gray-700 hover:text-amber-600">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Menus
                        </a>
                    </div>
                    <h1 class="text-xl font-semibold text-gray-800">{{ $menu->name }} - Items</h1>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Menu Items List -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-800">Menu Items</h3>
                                <button id="openAddItemModal" class="bg-amber-500 hover:bg-amber-600 text-white py-2 px-4 rounded inline-flex items-center">
                                    <i class="fas fa-plus mr-2"></i> Add Item
                                </button>
                            </div>
                            <div class="p-6">
                                @if($menu->items->count() > 0)
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($menu->items as $item)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center">
                                                                <div class="flex-shrink-0 h-10 w-10">
                                                                    @if($item->image)
                                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                                                                    @else
                                                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                                            <i class="fas fa-utensils text-gray-400"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                                                    <div class="text-sm text-gray-500 max-w-xs truncate">{{ $item->description }}</div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                            {{ $item->price }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                                {{ $item->is_available ? 'Available' : 'Unavailable' }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                            <div class="flex space-x-3">
                                                                <a href="{{ route('manager.menus.items.edit', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id, 'itemId' => $item->id]) }}" class="text-blue-600 hover:text-blue-900" title="Edit item">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('manager.menus.items.toggle', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id, 'itemId' => $item->id]) }}" method="POST" class="inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit" class="{{ $item->is_available ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}" title="{{ $item->is_available ? 'Mark as unavailable' : 'Mark as available' }}">
                                                                        <i class="fas {{ $item->is_available ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('manager.menus.items.destroy', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id, 'itemId' => $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete item">
                                                                        <i class="fas fa-trash"></i>
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
                                        <div class="text-gray-500 mb-4">No items in this menu yet</div>
                                        <button id="emptyAddItemBtn" class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-600 active:bg-amber-700 focus:outline-none focus:border-amber-700 focus:ring focus:ring-amber-300 disabled:opacity-25 transition">
                                            <i class="fas fa-plus mr-2"></i> Add Your First Item
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Menu Info -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-800">Menu Details</h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Name</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $menu->name }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Description</h4>
                                        <p class="mt-1 text-sm text-gray-900">{{ $menu->description }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Statistics</h4>
                                        <div class="mt-2 flex flex-col space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-500">Total Items:</span>
                                                <span class="text-sm font-medium text-gray-900">{{ $menu->items->count() }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-500">Available Items:</span>
                                                <span class="text-sm font-medium text-gray-900">{{ $menu->items->where('is_available', true)->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-4 border-t border-gray-200">
                                        <a href="{{ route('manager.menus.edit', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id]) }}" class="inline-flex w-full justify-center items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                            <i class="fas fa-edit mr-2"></i> Edit Menu
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Item Modal -->
    <div id="addItemModal" class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg w-full max-w-3xl max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800">Add New Menu Item</h3>
                <button id="closeItemModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('manager.menus.items.store', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id]) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Item Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 p-2" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description <span class="text-red-500">*</span></label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 p-2" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Price <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="price" id="price" min="0" step="0.01" value="{{ old('price') }}" class="mt-1 block w-full pl-7 rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 p-2" required>
                            </div>
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                            <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                            <p class="text-xs text-gray-500 mt-1">Upload an image of the item (optional). Max 2MB.</p>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Availability -->
                        <div class="mt-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_available" id="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }} class="h-4 w-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                                <label for="is_available" class="ml-2 block text-sm text-gray-700">Item is available</label>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Uncheck if this item is temporarily unavailable.</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                    <button type="button" id="cancelItemBtn" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Cancel
                    </button>
                    <button type="submit" class="bg-amber-500 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Add Item
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="{{asset('resources/js/manager/toggleNav.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal functionality
            const addItemModal = document.getElementById('addItemModal');
            const openAddItemModalBtn = document.getElementById('openAddItemModal');
            const closeItemModalBtn = document.getElementById('closeItemModal');
            const cancelItemBtn = document.getElementById('cancelItemBtn');
            const emptyAddItemBtn = document.getElementById('emptyAddItemBtn');

            const openModal = () => {
                addItemModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            };

            const closeModal = () => {
                addItemModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };

            if (openAddItemModalBtn) {
                openAddItemModalBtn.addEventListener('click', openModal);
            }

            if (emptyAddItemBtn) {
                emptyAddItemBtn.addEventListener('click', openModal);
            }

            if (closeItemModalBtn) {
                closeItemModalBtn.addEventListener('click', closeModal);
            }

            if (cancelItemBtn) {
                cancelItemBtn.addEventListener('click', closeModal);
            }

            // Close modal on outside click
            addItemModal.addEventListener('click', function(e) {
                if (e.target === addItemModal) {
                    closeModal();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
