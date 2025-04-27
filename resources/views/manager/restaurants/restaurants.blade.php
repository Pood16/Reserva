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
                <!-- manage restaurants -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">My Restaurants</h3>
                        <button id="openRestaurantModal" class="bg-amber-500 hover:bg-amber-600 text-white py-2 px-4 rounded inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i> Add Restaurant
                        </button>
                    </div>
                    <div class="p-6">
                        @if(count($myRestaurants) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviews</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tables</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($myRestaurants as $restaurant)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-4">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-14">
                                                            <img class="h-10 w-14 object-cover"
                                                                src="{{ asset('storage/' . $restaurant->cover_image) }}"
                                                                alt="{{ $restaurant->name }}"
                                                                onerror="this.src='/resources/images/default-profile.png'">
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
                                                    <div class="flex items-center">
                                                        @php
                                                            $reviewCount = $restaurant->reviews->count();
                                                            $averageRating = $reviewCount > 0 ? number_format($restaurant->reviews->avg('rating'), 1) : 'N/A';
                                                        @endphp

                                                        <div class="flex items-center">
                                                            <div class="flex text-yellow-400">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    @if ($averageRating != 'N/A' && $i <= $averageRating)
                                                                        <i class="fas fa-star"></i>
                                                                    @elseif ($averageRating != 'N/A' && $i - 0.5 <= $averageRating)
                                                                        <i class="fas fa-star-half-alt"></i>
                                                                    @else
                                                                        <i class="far fa-star"></i>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <div class="flex items-center">
                                                        <span class="px-3 py-1 inline-flex items-center justify-center bg-blue-100 text-blue-800 rounded-full font-medium">
                                                            <i class="fas fa-chair mr-1"></i>
                                                            {{$restaurant->tables->count()}}
                                                        </span>
                                                    </div>
                                                </td>

                                                <td class="px-4 py-4">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        {{ $restaurant->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $restaurant->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                                    <div class="flex space-x-4">
                                                        <a href="{{ route('restaurant.details', $restaurant->id) }}" class="text-blue-600 hover:text-blue-900" title="View details">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('manager.tables.index', $restaurant->id) }}" class="text-blue-600 hover:text-blue-900" title="View details">
                                                            <i class="fas fa-chair"></i>
                                                        </a>
                                                        <a href="{{ route('restaurant.update.show', $restaurant->id) }}" class="text-amber-600 hover:text-amber-900" title="Edit restaurant">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('restaurant.toggle.status', $restaurant->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
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
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>



    <!-- Add Restaurant Modal -->
    <div id="addRestaurantModal" class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg w-full max-w-4xl max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800">Add New Restaurant</h3>
                <button id="closeRestaurantModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('restaurant.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left  -->
                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Restaurant Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 p-1" required>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description <span class="text-red-500">*</span></label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border p-1 border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" required></textarea>
                        </div>

                        <!-- Contact Info -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" id="phone" class="mt-1 block w-full rounded-md border p-1 border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border p-1 border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" required>
                        </div>

                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                            <input type="text" name="website" id="website" class="mt-1 block w-full border p-1 rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" placeholder="https://...">
                        </div>

                        <!-- Active Status -->
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Restaurant Status</label>
                            <div class="flex space-x-4">
                                <div class="flex items-center">
                                    <input type="radio" name="is_active" id="is_active_yes" value="1" class="rounded-full border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-500 focus:ring-opacity-50" checked>
                                    <label for="is_active_yes" class="ml-2 text-sm text-gray-700">Active</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" name="is_active" id="is_active_no" value="0" class="rounded-full border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                                    <label for="is_active_no" class="ml-2 text-sm text-gray-700">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Location -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address <span class="text-red-500">*</span></label>
                            <input type="text" name="address" id="address" class="mt-1 block w-full border p-1 rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" required>
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">City <span class="text-red-500">*</span></label>
                            <input type="text" name="city" id="city" class="mt-1 block w-full border p-1 rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" required>
                        </div>
                        <!-- Opening Days -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Opening Days <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-4 gap-2">
                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="opening_days[]" id="day-{{ $day }}" value="{{ $day }}" class="rounded border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                                        <label for="day-{{ $day }}" class="ml-2 text-sm text-gray-700">{{ $day }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                                                <!-- Food Types -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Food Types <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto p-2 border border-gray-300 rounded-md">
                                <div class="flex items-center">
                                    <input type="checkbox" id="all-food-types" class="rounded border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                                    <label for="all-food-types" class="ml-2 text-sm text-gray-700 font-semibold">All Types</label>
                                </div>

                                @foreach($foodTypes as $foodType)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="food_types[]" id="food-type-{{ $foodType->id }}" value="{{ $foodType->id }}" class="food-type-checkbox rounded border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                                        <label for="food-type-{{ $foodType->id }}" class="ml-2 text-sm text-gray-700">{{ $foodType->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                          <!-- Business Hours -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="opening_time" class="block text-sm font-medium text-gray-700">Opening Time <span class="text-red-500">*</span></label>
                                <input type="time" name="opening_time" id="opening_time" class="mt-1 block w-full border rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" required>
                            </div>

                            <div>
                                <label for="closing_time" class="block text-sm font-medium text-gray-700">Closing Time <span class="text-red-500">*</span></label>
                                <input type="time" name="closing_time" id="closing_time" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <label for="cover_image" class="block text-sm font-medium text-gray-700">Restaurant Cover Image</label>
                    <div class="mt-1 flex items-center">
                        <input type="file" name="cover_image" id="cover_image" accept="image/*" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4 file:rounded-md
                            file:border-0 file:text-sm file:font-semibold
                            file:bg-amber-50 file:text-amber-700
                            hover:file:bg-amber-100">
                    </div>
                </div>
                <!-- Hidden User ID Field -->
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-3">
                    <button type="button" id="cancelRestaurant" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500" onclick="document.getElementById('addRestaurantModal').classList.add('hidden')">
                        Cancel
                    </button>
                    <button type="submit" class="bg-amber-500 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                        Save Restaurant
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="{{asset('resources/js/manager/toggleNav.js')}}"></script>
    <script src="{{asset('resources/js/manager/restaurantsList.js')}}"></script>
    <script>
        // Food type checkboxes functionality
        document.addEventListener('DOMContentLoaded', function() {
            const allFoodTypesCheckbox = document.getElementById('all-food-types');
            const foodTypeCheckboxes = document.querySelectorAll('.food-type-checkbox');

            // Handle "All" checkbox
            allFoodTypesCheckbox.addEventListener('change', function() {
                foodTypeCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Update "All" checkbox state based on individual selections
            foodTypeCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(foodTypeCheckboxes).every(cb => cb.checked);
                    const noneChecked = Array.from(foodTypeCheckboxes).every(cb => !cb.checked);

                    if (allChecked) {
                        allFoodTypesCheckbox.checked = true;
                        allFoodTypesCheckbox.indeterminate = false;
                    } else if (noneChecked) {
                        allFoodTypesCheckbox.checked = false;
                        allFoodTypesCheckbox.indeterminate = false;
                    } else {
                        allFoodTypesCheckbox.checked = false;
                        allFoodTypesCheckbox.indeterminate = true;
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
