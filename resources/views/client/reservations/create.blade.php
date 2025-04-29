<x-app-layout>
    <div class="min-h-screen bg-orange-50 flex flex-col">
        <main class="flex-1 p-4 sm:p-6 bg-orange-50">
            <div class="max-w-xl mx-auto bg-orange-50 rounded-lg shadow-md p-6 border border-gray-200">
                <div class="text-center mb-6">
                    <div class="inline-block mb-2">
                        <div class="relative">
                            <div class="inline-flex items-center justify-center p-2 bg-white rounded-lg border-2 border-gray-800">
                                <span class="font-bold text-gray-800">restaurant</span>
                            </div>
                            <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                                <svg class="w-6 h-6 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"></path>
                                    <path d="M10 8a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                            </div>
                            <div class="absolute -bottom-1 left-1/4 transform -translate-x-1/2">
                                <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="absolute -bottom-1 right-1/4 transform translate-x-1/2">
                                <svg class="w-4 h-4 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Reserve Your Table at {{ $restaurant->name }}</h2>
                </div>

                <form id="reservationForm" action="{{ route('client.reservations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

                    <!-- Customer Info -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <div class="flex space-x-2">
                            <input type="text" name="first_name" placeholder="First Name" class="w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                            <input type="text" name="last_name" placeholder="Last Name" class="w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" placeholder="example@example.com" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" name="phone" id="phone" placeholder="(XXX) XXX-XXXX" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                        <small class="text-gray-500">Please enter a valid phone number</small>
                    </div>

                    <!-- Guests -->
                    <div class="mb-4">
                        <label for="guests_number" class="block text-sm font-medium text-gray-700 mb-1">Number of guests</label>
                        <select name="guests_number" id="guests_number" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" required>
                            <option value="">Please Select</option>
                            @for ($i = 1; $i <= 20; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Reservation Date & Time -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Reservation Date & Time</label>
                        <div class="border border-gray-300 rounded-md overflow-hidden">
                            <div class="bg-gray-100 p-2 flex justify-between items-center border-b border-gray-300">
                                <div id="selected-date-display" class="text-sm font-medium">Select a date</div>
                                <button type="button" id="calendar-toggle" class="text-gray-600 hover:text-gray-800">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>

                            <div id="calendar-container" class="p-3">
                                <!-- Calendar Header -->
                                <div class="flex justify-between items-center mb-2">
                                    <button type="button" id="prev-month" class="text-blue-600 hover:text-blue-800">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <div id="current-month-display" class="text-sm font-medium"></div>
                                    <button type="button" id="next-month" class="text-blue-600 hover:text-blue-800">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Calendar Grid -->
                                <div class="grid grid-cols-7 gap-1 text-center text-xs">
                                    <div class="font-medium text-gray-500">Sun</div>
                                    <div class="font-medium text-gray-500">Mon</div>
                                    <div class="font-medium text-gray-500">Tue</div>
                                    <div class="font-medium text-gray-500">Wed</div>
                                    <div class="font-medium text-gray-500">Thu</div>
                                    <div class="font-medium text-gray-500">Fri</div>
                                    <div class="font-medium text-gray-500">Sat</div>
                                </div>

                                <div id="calendar-days" class="grid grid-cols-7 gap-1 mt-1">
                                    <!-- Days will be filled with JavaScript -->
                                </div>
                            </div>

                            <!-- Time Slots -->
                            <div id="time-slots" class="grid grid-cols-2 gap-2 p-3 border-t border-gray-300">
                                <button type="button" class="time-slot py-1 px-2 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">9:00 AM</button>
                                <button type="button" class="time-slot py-1 px-2 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">10:00 AM</button>
                                <button type="button" class="time-slot py-1 px-2 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">11:00 AM</button>
                                <button type="button" class="time-slot py-1 px-2 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">12:00 PM</button>
                                <button type="button" class="time-slot py-1 px-2 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">1:00 PM</button>
                                <button type="button" class="time-slot py-1 px-2 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">2:00 PM</button>
                                <button type="button" class="time-slot py-1 px-2 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">3:00 PM</button>
                                <button type="button" class="time-slot py-1 px-2 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">4:00 PM</button>
                                <button type="button" class="time-slot py-1 px-2 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">5:00 PM</button>
                                <button type="button" class="time-slot py-1 px-2 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">6:00 PM</button>
                                <button type="button" class="time-slot py-1 px-2 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">7:00 PM</button>
                                <button type="button" class="time-slot py-1 px-2 bg-blue-100 text-blue-800 rounded-md text-sm hover:bg-blue-200">8:00 PM</button>
                            </div>
                        </div>

                        <!-- Hidden inputs to store actual values -->
                        <input type="hidden" name="booking_date" id="booking_date" required>
                        <input type="hidden" name="booking_time" id="booking_time" required>
                    </div>

                    <!-- Table Picker (Hidden, we'll select based on guests) -->
                    <input type="hidden" name="table_id" id="table_id">

                    <!-- Special Requests -->
                    <div class="mb-4">
                        <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Special Notes</label>
                        <textarea name="special_requests" id="special_requests" rows="3" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-gray-800 text-white py-2 px-4 rounded-md font-semibold hover:bg-gray-900 transition">Reserve</button>
                </form>
            </div>
        </main>
    </div>

    <script type="text/javascript">
        // Get restaurant data
        var openingDays = {!! json_encode($openingDays) !!};
        var openingTime = "{{ $restaurant->opening_time->format('H:i') }}";
        var closingTime = "{{ $restaurant->closing_time->format('H:i') }}";
        var tables = {!! json_encode($tables) !!};

        // Calendar functionality
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            let currentMonth = today.getMonth();
            let currentYear = today.getFullYear();
            const calendarDays = document.getElementById('calendar-days');
            const currentMonthDisplay = document.getElementById('current-month-display');
            const prevMonthBtn = document.getElementById('prev-month');
            const nextMonthBtn = document.getElementById('next-month');
            const selectedDateDisplay = document.getElementById('selected-date-display');
            const timeSlots = document.querySelectorAll('.time-slot');

            // Hidden form fields
            const bookingDateInput = document.getElementById('booking_date');
            const bookingTimeInput = document.getElementById('booking_time');
            const tableIdInput = document.getElementById('table_id');

            // Initialize calendar
            renderCalendar(currentMonth, currentYear);

            // Event listeners for month navigation
            prevMonthBtn.addEventListener('click', function() {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar(currentMonth, currentYear);
            });

            nextMonthBtn.addEventListener('click', function() {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                renderCalendar(currentMonth, currentYear);
            });

            // Time slot selection
            timeSlots.forEach(slot => {
                slot.addEventListener('click', function() {
                    // Remove selection from all time slots
                    timeSlots.forEach(s => s.classList.remove('bg-blue-500', 'text-white'));
                    // Add selection to clicked time slot
                    this.classList.add('bg-blue-500', 'text-white');
                    // Set the time value in the hidden input
                    const timeText = this.textContent.trim();
                    const timeParts = timeText.match(/(\d+):(\d+) (AM|PM)/);
                    if (timeParts) {
                        let hours = parseInt(timeParts[1]);
                        const minutes = timeParts[2];
                        const period = timeParts[3];

                        if (period === 'PM' && hours < 12) {
                            hours += 12;
                        } else if (period === 'AM' && hours === 12) {
                            hours = 0;
                        }

                        const formattedTime = `${hours.toString().padStart(2, '0')}:${minutes}`;
                        bookingTimeInput.value = formattedTime;
                    }
                });
            });

            // Function to render the calendar
            function renderCalendar(month, year) {
                // Clear calendar days
                calendarDays.innerHTML = '';

                // Update month display
                const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                currentMonthDisplay.textContent = `${monthNames[month]} ${year}`;

                // Get first day of month and number of days
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                // Add empty cells for days before first of month
                for (let i = 0; i < firstDay; i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.classList.add('text-center', 'py-1');
                    calendarDays.appendChild(emptyDay);
                }

                // Add days of the month
                for (let day = 1; day <= daysInMonth; day++) {
                    const date = new Date(year, month, day);
                    const dayOfWeek = date.toLocaleDateString('en-US', { weekday: 'long' });
                    const isOpenDay = openingDays.includes(dayOfWeek);
                    const isPastDate = date < new Date(today.setHours(0,0,0,0));

                    const dayCell = document.createElement('div');
                    dayCell.textContent = day;
                    dayCell.classList.add('text-center', 'py-1', 'rounded');

                    if (isPastDate) {
                        dayCell.classList.add('text-gray-400', 'cursor-not-allowed');
                    } else if (!isOpenDay) {
                        dayCell.classList.add('text-gray-500', 'cursor-not-allowed');
                    } else {
                        dayCell.classList.add('hover:bg-blue-100', 'cursor-pointer');

                        // Check if it's today
                        if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                            dayCell.classList.add('bg-blue-100', 'text-blue-800');
                        } else {
                            dayCell.classList.add('text-gray-800');
                        }

                        // Add click event
                        dayCell.addEventListener('click', function() {
                            // Remove selection from all days
                            document.querySelectorAll('#calendar-days div.bg-blue-500').forEach(el => {
                                el.classList.remove('bg-blue-500', 'text-white');

                                // Restore today's styling if needed
                                if (el.textContent == today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                                    el.classList.add('bg-blue-100', 'text-blue-800');
                                } else {
                                    el.classList.add('text-gray-800');
                                }
                            });

                            // Add selection to clicked day
                            this.classList.remove('text-gray-800', 'bg-blue-100', 'text-blue-800');
                            this.classList.add('bg-blue-500', 'text-white');

                            // Set the date value in the hidden input and display
                            const selectedDate = new Date(year, month, day);
                            const formattedDate = selectedDate.toISOString().split('T')[0];
                            bookingDateInput.value = formattedDate;
                            selectedDateDisplay.textContent = selectedDate.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' });
                        });
                    }

                    calendarDays.appendChild(dayCell);
                }
            }

            // Set appropriate table based on guests
            document.getElementById('guests_number').addEventListener('change', function() {
                const guestsNumber = parseInt(this.value);
                if (guestsNumber) {
                    // Find the smallest table that can accommodate the guests
                    const suitableTables = tables.filter(table => table.capacity >= guestsNumber);
                    suitableTables.sort((a, b) => a.capacity - b.capacity);

                    if (suitableTables.length > 0) {
                        tableIdInput.value = suitableTables[0].id;
                    } else {
                        alert('We don\'t have tables that can accommodate this number of guests.');
                        this.value = '';
                    }
                }
            });

            // Form validation before submit
            document.getElementById('reservationForm').addEventListener('submit', function(e) {
                if (!bookingDateInput.value) {
                    e.preventDefault();
                    alert('Please select a reservation date.');
                    return false;
                }

                if (!bookingTimeInput.value) {
                    e.preventDefault();
                    alert('Please select a reservation time.');
                    return false;
                }

                if (!tableIdInput.value) {
                    e.preventDefault();
                    alert('Please select the number of guests to determine an appropriate table.');
                    return false;
                }

                return true;
            });
        });
    </script>
</x-app-layout>
