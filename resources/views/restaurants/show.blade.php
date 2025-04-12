<x-app-layout>
<div class="bg-gray-100 min-h-screen">
    <!-- Success message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Restaurant Header - Cover Image -->
    <div class="relative h-64 sm:h-80 md:h-96 w-full bg-gray-300">
        <img src="{{ $restaurant->cover_image ? asset($restaurant->cover_image) : asset('images/restaurant-placeholder-cover.jpg') }}"
            alt="{{ $restaurant->name }}" class="w-full h-full object-cover">
        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black to-transparent p-4 md:p-6">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-white text-2xl md:text-4xl font-bold">{{ $restaurant->name }}</h1>
                <div class="flex items-center mt-2 text-white">
                    <span class="bg-green-600 text-white text-sm px-2 py-1 rounded mr-2">{{ number_format($avgRating, 1) }}</span>
                    <div class="flex">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($avgRating))
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="ml-2 text-sm">{{ $restaurant->reviews->count() }} reviews</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column - Restaurant Details -->
            <div class="w-full lg:w-2/3">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h2 class="text-xl font-semibold mb-4">About {{ $restaurant->name }}</h2>
                            <p class="text-gray-700 mb-4">{{ $restaurant->description }}</p>

                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $restaurant->address }}, {{ $restaurant->city }}</span>
                            </div>

                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>{{ $restaurant->phone }}</span>
                            </div>

                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $restaurant->email }}</span>
                            </div>

                            @if($restaurant->website)
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                                <a href="{{ $restaurant->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $restaurant->website }}</a>
                            </div>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-2">Opening Hours</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="text-gray-600">Days:</div>
                                    <div>{{ $openingDays }}</div>

                                    <div class="text-gray-600">Hours:</div>
                                    <div>{{ $restaurant->opening_time->format('g:i A') }} - {{ $restaurant->closing_time->format('g:i A') }}</div>
                                </div>

                                <div class="mt-4">
                                    <div class="flex items-center text-green-600">
                                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Bookings available up to {{ $restaurant->max_booking_days_ahead }} days ahead</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photos Gallery -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Photos</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                        @forelse($restaurant->images as $image)
                        <div class="relative h-24 md:h-32 lg:h-36 bg-gray-200 rounded overflow-hidden">
                            <img src="{{ asset($image->image_path) }}" alt="{{ $restaurant->name }}" class="w-full h-full object-cover">
                        </div>
                        @empty
                        <div class="col-span-full text-gray-500 italic">No photos available</div>
                        @endforelse
                    </div>
                </div>

                <!-- Tables -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Tables</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($restaurant->tables->where('is_active', true)->where('is_available', true) as $table)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="font-medium">{{ $table->name }}</h3>
                            <div class="flex items-center text-sm text-gray-600 mt-1">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                </svg>
                                <span>Capacity: {{ $table->capacity }}</span>
                            </div>
                            <div class="text-sm text-gray-600 mt-1">
                                <span class="capitalize">Location: {{ $table->location }}</span>
                            </div>
                            @if($table->description)
                            <p class="text-sm text-gray-500 mt-2">{{ $table->description }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Reviews</h2>

                    @forelse($restaurant->reviews as $review)
                    <div class="border-b border-gray-200 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                        <div class="flex justify-between mb-2">
                            <div class="flex items-center">
                                <div class="mr-3">
                                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="font-medium">{{ $review->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $review->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="bg-green-600 text-white text-xs px-2 py-1 rounded">{{ $review->rating }}</span>
                            </div>
                        </div>
                        <p class="text-gray-700">{{ $review->comment }}</p>
                    </div>
                    @empty
                    <div class="text-gray-500 italic">No reviews yet</div>
                    @endforelse
                </div>
            </div>

            <!-- Right Column - Reservation Form -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-semibold mb-4">Make a Reservation</h2>

                    <!-- If user is not logged in -->
                    @guest
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                        <p class="text-yellow-700 text-sm">Please <a href="{{ route('login.show') }}" class="text-blue-600 hover:underline">log in</a> to make a reservation.</p>
                    </div>
                    @else

                    <form action="{{ route('reservations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

                        <!-- Date picker -->
                        <div class="mb-4">
                            <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" id="booking_date" name="booking_date"
                                min="{{ now()->format('Y-m-d') }}"
                                max="{{ now()->addDays($restaurant->max_booking_days_ahead)->format('Y-m-d') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                required>
                            @error('booking_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Time picker group -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="booking_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                                <input type="time" id="booking_time" name="booking_time"
                                    min="{{ $restaurant->opening_time->format('H:i') }}"
                                    max="{{ $restaurant->closing_time->subHours(1)->format('H:i') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    required>
                                @error('booking_time')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                                <input type="time" id="end_time" name="end_time"
                                    min="{{ $restaurant->opening_time->addHour()->format('H:i') }}"
                                    max="{{ $restaurant->closing_time->format('H:i') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    required>
                                @error('end_time')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Guests number -->
                        <div class="mb-4">
                            <label for="guests_number" class="block text-sm font-medium text-gray-700 mb-1">Number of Guests</label>
                            <select id="guests_number" name="guests_number" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Person' : 'People' }}</option>
                                @endfor
                            </select>
                            @error('guests_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Table selection -->
                        <div class="mb-4">
                            <label for="table_id" class="block text-sm font-medium text-gray-700 mb-1">Select Table</label>
                            <select id="table_id" name="table_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                                <option value="">Select a table</option>
                                @foreach($restaurant->tables->where('is_active', true)->where('is_available', true) as $table)
                                    <option value="{{ $table->id }}" data-capacity="{{ $table->capacity }}">
                                        {{ $table->name }} ({{ $table->location }}, Capacity: {{ $table->capacity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('table_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Special requests -->
                        <div class="mb-4">
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Special Requests (Optional)</label>
                            <textarea id="special_requests" name="special_requests" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Any special requirements or preferences..."></textarea>
                            @error('special_requests')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md shadow transition duration-200">
                            Book Now
                        </button>
                    </form>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validate that guests number doesn't exceed table capacity
        const guestsSelect = document.getElementById('guests_number');
        const tableSelect = document.getElementById('table_id');

        function validateCapacity() {
            const selectedOption = tableSelect.options[tableSelect.selectedIndex];
            if (selectedOption.value) {
                const tableCapacity = parseInt(selectedOption.dataset.capacity);
                const guestsNumber = parseInt(guestsSelect.value);

                if (guestsNumber > tableCapacity) {
                    alert(`This table can only accommodate ${tableCapacity} guests. Please select a different table or reduce the number of guests.`);
                    tableSelect.value = '';
                }
            }
        }

        guestsSelect.addEventListener('change', validateCapacity);
        tableSelect.addEventListener('change', validateCapacity);

        // Ensure end time is after start time
        const bookingTimeInput = document.getElementById('booking_time');
        const endTimeInput = document.getElementById('end_time');

        function validateTimeRange() {
            if (bookingTimeInput.value && endTimeInput.value) {
                if (endTimeInput.value <= bookingTimeInput.value) {
                    alert('End time must be after start time');
                    endTimeInput.value = '';
                }
            }
        }

        bookingTimeInput.addEventListener('change', validateTimeRange);
        endTimeInput.addEventListener('change', validateTimeRange);
    });
</script>
@endpush


</x-app-layout>
