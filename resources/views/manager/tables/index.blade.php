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
                        <h3 class="text-lg font-semibold text-gray-800">Tables for {{ $restaurant->name }} <i class="fas fa-utensils mr-1"></i></h3>
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
                                                <button type="button" class="text-indigo-600 hover:text-indigo-900 edit-table-btn"
                                                    data-table-id="{{ $table->id }}"
                                                    data-table-name="{{ $table->name }}"
                                                    data-table-capacity="{{ $table->capacity }}"
                                                    data-table-location="{{ $table->location }}"
                                                    data-table-description="{{ $table->description }}"
                                                    data-table-available="{{ $table->is_available ? 'true' : 'false' }}"
                                                    data-table-active="{{ $table->is_active ? 'true' : 'false' }}"
                                                    data-edit-url="{{ route('manager.tables.update', ['restaurantId' => $restaurant->id, 'id' => $table->id]) }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="text-red-600 hover:text-red-900 delete-table-btn"
                                                    data-table-id="{{ $table->id }}"
                                                    data-table-name="{{ $table->name }}"
                                                    data-delete-url="{{ route('manager.tables.destroy', ['restaurantId' => $restaurant->id, 'id' => $table->id]) }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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

    <!-- Edit Table Modal -->
    <div id="editTableModal" class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg w-full max-w-md max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800">Edit Table: <span id="editTableTitle"></span></h3>
                <button id="closeEditModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="editTableForm" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Table Name -->
                    <div>
                        <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Table Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="edit_name" class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md p-1" placeholder="e.g. Table 1" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Capacity -->
                    <div>
                        <label for="edit_capacity" class="block text-sm font-medium text-gray-700 mb-1">Capacity <span class="text-red-500">*</span></label>
                        <input type="number" name="capacity" id="edit_capacity" min="1" max="20" class="p-1 shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                        @error('capacity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="edit_location" class="block text-sm font-medium text-gray-700 mb-1">Location <span class="text-red-500">*</span></label>
                        <select name="location" id="edit_location" class="p-1 shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                            <option value="">Select location</option>
                            <option value="indoors">Indoor</option>
                            <option value="outdoors">Outdoor</option>
                            <option value="terrace">Terrace</option>
                        </select>
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                        <textarea name="description" id="edit_description" rows="3" class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g. Near the window with a nice view"></textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Is Available -->
                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_available" id="edit_is_available" class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                                <label for="edit_is_available" class="ml-2 block text-sm font-medium text-gray-700">
                                    Available for booking
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Customers can book this table if checked</p>
                        </div>

                        <!-- Is Active -->
                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="edit_is_active" class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                                <label for="edit_is_active" class="ml-2 block text-sm font-medium text-gray-700">
                                    Active
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Table is active and displayed on the site</p>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" id="cancelEdit" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Cancel
                        </button>
                        <button type="submit" class="bg-amber-500 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Update Table
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Table Confirmation Modal -->
    <div id="deleteTableModal" class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg w-full max-w-md">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800">Confirm Deletion</h3>
                <button id="closeDeleteModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <p class="text-gray-700 mb-6">Are you sure you want to delete this table? This action cannot be undone.</p>
                <div class="flex justify-end space-x-3">
                    <button id="cancelDelete" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Cancel
                    </button>
                    <form id="deleteTableForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete Table
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{asset('resources/js/manager/toggleNav.js')}}"></script>
    <script src="{{asset('resources/js/manager/tables.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formHasErrors = {{ $errors->any() && old('_token') ? 'true' : 'false' }};

            if (formHasErrors) {
                if ("{{ old('_method') }}" === "PUT") {
                    const editModal = document.getElementById('editTableModal');
                    if (editModal) {
                        editModal.classList.remove('hidden');
                    }
                } else {
                    const addModal = document.getElementById('addTableModal');
                    if (addModal) {
                        addModal.classList.remove('hidden');
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
