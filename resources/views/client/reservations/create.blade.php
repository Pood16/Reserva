<x-app-layout>
    <div class="min-h-screen bg-gray-100 flex flex-col">
        <main class="flex-1 p-4 sm:p-6 bg-gray-100">
            <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Book a Table at {{ $restaurant->name }}</h2>
                <form id="reservationForm" action="{{ route('client.reservations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

                    <!-- Date Picker -->
                    <div class="mb-4">
                        <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">Reservation Date</label>
                        <input type="date" name="booking_date" id="booking_date" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required min="{{ now()->toDateString() }}">
                        <small class="text-gray-500">Available days: {{ implode(', ', $openingDays) }}</small>
                        @error('booking_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Time Picker -->
                    <div class="mb-4">
                        <label for="booking_time" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                        <input type="time" name="booking_time" id="booking_time" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                        <small class="text-gray-500">From {{ $restaurant->opening_time->format('H:i') }} to {{ $restaurant->closing_time->format('H:i') }}</small>
                        @error('booking_time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Table Picker -->
                    <div class="mb-4">
                        <label for="table_id" class="block text-sm font-medium text-gray-700 mb-1">Table</label>
                        <select name="table_id" id="table_id" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                            <option value="">Select a table</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}">{{ $table->name }} ({{ $table->capacity }} people)</option>
                            @endforeach
                        </select>
                        @error('table_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Guests -->
                    <div class="mb-4">
                        <label for="guests_number" class="block text-sm font-medium text-gray-700 mb-1">Number of Guests</label>
                        <input type="number" name="guests_number" id="guests_number" min="1" max="20" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                        @error('guests_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Special Requests -->
                    <div class="mb-4">
                        <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Special Requests (optional)</label>
                        <textarea name="special_requests" id="special_requests" rows="2" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                        @error('special_requests')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md font-semibold hover:bg-blue-700 transition">Book Reservation</button>
                </form>
            </div>
        </main>
    </div>
    <script type="text/javascript">
        var openingDays = {!! json_encode($openingDays) !!};
        var openingTime = "{{ $restaurant->opening_time->format('H:i') }}";
        var closingTime = "{{ $restaurant->closing_time->format('H:i') }}";
        document.getElementById('booking_date').addEventListener('input', function() {
            var date = new Date(this.value);
            var dayName = date.toLocaleDateString('en-US', { weekday: 'long' });
            if (openingDays.indexOf(dayName) === -1) {
                alert('This restaurant is closed on ' + dayName + '. Please pick another date.');
                this.value = '';
            }
        });
        document.getElementById('booking_time').addEventListener('input', function() {
            if (this.value < openingTime || this.value > closingTime) {
                alert('Please select a time within opening hours: ' + openingTime + ' - ' + closingTime);
                this.value = '';
            }
        });
        // TODO: AJAX to update available tables based on date/time
    </script>
</x-app-layout>
