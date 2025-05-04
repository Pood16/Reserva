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
                        <a href="{{ route('manage.restaurants') }}" class="inline-flex items-center text-gray-700 hover:text-amber-600">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Restaurants
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('restaurant.details', $restaurant->id) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                            <i class="fas fa-eye mr-2"></i> View Restaurant Details
                        </a>
                    </div>
                </div>

                <!-- main -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Edit Restaurant: {{ $restaurant->name }}</h3>
                    </div>
                    <div class="p-6">
                        <p>Update your restaurant information using the sections below. Each section can be updated independently.</p>
                    </div>
                </div>

                <!-- General info -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6" id="general-section">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">General Information</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('restaurant.update', $restaurant->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="section" value="general">

                            <div class="space-y-4">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Restaurant Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $restaurant->name) }}" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 p-2" required>
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description <span class="text-red-500">*</span></label>
                                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border p-2 border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" required>{{ old('description', $restaurant->description) }}</textarea>
                                    @error('description')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">Address <span class="text-red-500">*</span></label>
                                    <input type="text" name="address" id="address" value="{{ old('address', $restaurant->address) }}" class="mt-1 block w-full border p-2 rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" required>
                                    @error('address')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- City -->
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">City <span class="text-red-500">*</span></label>
                                    <input type="text" name="city" id="city" value="{{ old('city', $restaurant->city) }}" class="mt-1 block w-full border p-2 rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" required>
                                    @error('city')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-amber-500 text-white px-4 py-2 rounded-md hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50">
                                    Update General Information
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6" id="contact-section">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Contact Information</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('restaurant.update', $restaurant->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="section" value="contact">

                            <div class="space-y-4">
                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $restaurant->phone) }}" class="mt-1 block w-full rounded-md border p-2 border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" required>
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $restaurant->email) }}" class="mt-1 block w-full rounded-md border p-2 border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" required>
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Website -->
                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                                    <input type="url" name="website" id="website" value="{{ old('website', $restaurant->website) }}" class="mt-1 block w-full border p-2 rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50" placeholder="https://...">
                                    @error('website')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-amber-500 text-white px-4 py-2 rounded-md hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50">
                                    Update Contact Information
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Business Hours Section -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6" id="hours-section">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Business Hours</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('restaurant.update', $restaurant->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="section" value="hours">

                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Opening Time -->
                                    <div>
                                        <label for="opening_time" class="block text-sm font-medium text-gray-700">Opening Time <span class="text-red-500">*</span></label>
                                        <div class="flex items-center">
                                            @php
                                                $formattedTime = '';
                                                if($restaurant->opening_time) {
                                                    $time = new DateTime($restaurant->opening_time);
                                                    $formattedTime = $time->format('g:i A');
                                                    $inputTime = $time->format('H:i');
                                                }
                                            @endphp
                                            <input type="time" name="opening_time" id="opening_time" value="{{ old('opening_time', $inputTime ?? $restaurant->opening_time) }}"
                                                   class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                                        </div>
                                        @error('opening_time')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Closing Time -->
                                    <div>
                                        <label for="closing_time" class="block text-sm font-medium text-gray-700">Closing Time <span class="text-red-500">*</span></label>
                                        <div class="flex items-center">
                                            @php
                                                $formattedClosingTime = '';
                                                if($restaurant->closing_time) {
                                                    $time = new DateTime($restaurant->closing_time);
                                                    $formattedClosingTime = $time->format('g:i A');
                                                    $inputClosingTime = $time->format('H:i');
                                                }
                                            @endphp
                                            <input type="time" name="closing_time" id="closing_time" value="{{ old('closing_time', $inputClosingTime ?? $restaurant->closing_time) }}"
                                                   class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                                        </div>
                                        @error('closing_time')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Opening Days -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Opening Days <span class="text-red-500">*</span></label>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                        @php
                                            $openingDays = $restaurant->openingDays->pluck('day_of_week')->toArray();
                                        @endphp

                                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                            <div class="flex items-center">
                                                <input type="checkbox" name="opening_days[]" id="day-{{ $day }}" value="{{ $day }}" class="rounded border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-500 focus:ring-opacity-50"
                                                    {{ in_array($day, old('opening_days', $openingDays)) ? 'checked' : '' }}>
                                                <label for="day-{{ $day }}" class="ml-2 text-sm text-gray-700">{{ $day }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('opening_days')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-amber-500 text-white px-4 py-2 rounded-md hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50">
                                    Update Business Hours
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Images Section -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6" id="images-section">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Restaurant Images</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('restaurant.update', $restaurant->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="section" value="images">

                            <div class="space-y-6">
                                <!-- Current Cover Image -->
                                <div>
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Current Cover Image</h4>
                                    <div class="relative w-full h-40 overflow-hidden rounded-lg">
                                        <img src="{{ asset('storage/' . $restaurant->cover_image) }}" alt="{{ $restaurant->name }}" class="w-full h-full object-cover">
                                    </div>
                                </div>

                                <!-- Update Cover Image -->
                                <div>
                                    <label for="cover_image" class="block text-sm font-medium text-gray-700">Update Cover Image</label>
                                    <div class="mt-1 flex items-center">
                                        <input type="file" name="cover_image" id="cover_image" accept="image/*" class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4 file:rounded-md
                                            file:border-0 file:text-sm file:font-semibold
                                            file:bg-amber-50 file:text-amber-700
                                            hover:file:bg-amber-100">
                                    </div>
                                    @error('cover_image')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Add Multiple Images -->
                                <div>
                                    <label for="additional_images" class="block text-sm font-medium text-gray-700">Add More Images</label>
                                    <div class="mt-1">
                                        <input type="file" name="additional_images[]" id="additional_images" accept="image/*" multiple class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4 file:rounded-md
                                            file:border-0 file:text-sm file:font-semibold
                                            file:bg-amber-50 file:text-amber-700
                                            hover:file:bg-amber-100">
                                    </div>
                                    @error('additional_images')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    @error('additional_images.*')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Additional Images -->
                                <div>
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Current Images</h4>
                                    @if(count($restaurant->images) > 0)
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            @foreach($restaurant->images as $image)
                                                <div class="relative group">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Restaurant Image" class="h-32 w-full object-cover rounded">
                                                    <button type="button"
                                                        onclick="deleteImage('{{ $restaurant->id }}', '{{ $image->id }}')"
                                                        class="absolute top-2 right-2  text-white p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <i class="fas fa-times text-red-600"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-500">No additional images yet.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-amber-500 text-white px-4 py-2 rounded-md hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50">
                                    Update Images
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Food Types Section -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6" id="food-types-section">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Food Types</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('restaurant.update', $restaurant->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="section" value="food_types">

                            <div class="space-y-4">
                                <!-- Food Types Selection -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Food Types</label>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-64 overflow-y-auto p-3 border border-gray-300 rounded-md">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="edit-all-food-types" class="rounded border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-500 focus:ring-opacity-50">
                                            <label for="edit-all-food-types" class="ml-2 text-sm text-gray-700 font-semibold">All Types</label>
                                        </div>

                                        @php
                                            $restaurantFoodTypes = $restaurant->foodTypes->pluck('id')->toArray();
                                        @endphp

                                        @foreach($foodTypes as $foodType)
                                            <div class="flex items-center">
                                                <input type="checkbox" name="food_types[]" id="edit-food-type-{{ $foodType->id }}" value="{{ $foodType->id }}"
                                                    class="edit-food-type-checkbox rounded border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-500 focus:ring-opacity-50"
                                                    {{ in_array($foodType->id, old('food_types', $restaurantFoodTypes)) ? 'checked' : '' }}>
                                                <label for="edit-food-type-{{ $foodType->id }}" class="ml-2 text-sm text-gray-700">{{ $foodType->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('food_types')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-amber-500 text-white px-4 py-2 rounded-md hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50">
                                    Update Food Types
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Status -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6" id="status-section">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Restaurant Status</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('restaurant.update', $restaurant->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="section" value="status">

                            <div class="space-y-4">
                                <div class="block text-sm font-medium text-gray-700 mb-2">Current Status:
                                    <span class="inline-flex px-2 text-xs font-semibold rounded-full {{ $restaurant->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $restaurant->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>

                                <div class="flex space-x-4">
                                    <div class="flex items-center">
                                        <input type="radio" name="is_active" id="is_active_yes" value="1" class="rounded-full border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-500 focus:ring-opacity-50" {{ $restaurant->is_active ? 'checked' : '' }}>
                                        <label for="is_active_yes" class="ml-2 text-sm text-gray-700">Active</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" name="is_active" id="is_active_no" value="0" class="rounded-full border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-500 focus:ring-opacity-50" {{ !$restaurant->is_active ? 'checked' : '' }}>
                                        <label for="is_active_no" class="ml-2 text-sm text-gray-700">Inactive</label>
                                    </div>
                                </div>
                                @error('is_active')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror

                                <div class="text-sm text-gray-600 mt-2">
                                    <p>
                                        <span class="font-medium">Active:</span> Your restaurant will be visible to customers and can receive reservations.
                                    </p>
                                    <p>
                                        <span class="font-medium">Inactive:</span> Your restaurant will be hidden from customers and cannot receive reservations.
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-amber-500 text-white px-4 py-2 rounded-md hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50">
                                    Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Hidden form for image deletion -->
    <form id="delete-image-form" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
    <script src="{{ asset('resources/js/manager/toggleNav.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            window.deleteImage = function(restaurantId, imageId) {
                const form = document.getElementById('delete-image-form');
                form.action = `/manager/restaurant/${restaurantId}/images/${imageId}`;
                form.submit();
            }


            // food type checkboxes
            const allFoodTypesCheckbox = document.getElementById('edit-all-food-types');
            const foodTypeCheckboxes = document.querySelectorAll('.edit-food-type-checkbox');


            updateAllCheckboxState();

            // all
            allFoodTypesCheckbox.addEventListener('change', function() {
                foodTypeCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });


            foodTypeCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateAllCheckboxState);
            });

            function updateAllCheckboxState() {
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
            }
        });
    </script>
    @endpush
</x-app-layout>
