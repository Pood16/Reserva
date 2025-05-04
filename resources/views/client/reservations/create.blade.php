<x-app-layout>
    <x-header />
    <x-flash-messages />
    <div class="min-h-screen bg-orange-50 flex flex-col">
        <main class="flex-1 p-4 sm:p-6 bg-orange-50">
            <div class="max-w-xl mx-auto bg-white rounded-lg shadow-lg p-6 border border-gray-200">
                <div class="text-center mb-6">
                    <a href="{{ route('restaurants.show', $restaurant->id) }}" class="flex items-center text-sm text-gray-600 hover:text-yellow-600 transition-colors mb-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Restaurant
                    </a>
                    <div class="inline-block mb-2">
                        <div class="relative">
                            <div class="inline-flex items-center justify-center p-2 bg-yellow-50 rounded-lg border-2 border-yellow-500">
                                <span class="font-bold text-yellow-800">{{ $restaurant->name }}</span>
                            </div>
                            <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"></path>
                                    <path d="M10 8a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Reserve Your Table</h2>
                    <p class="text-sm text-gray-600 mt-1">Fill out this form to book your reservation</p>
                </div>

                <!-- Bar -->
                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-6">
                    <div id="progress-bar" class="bg-yellow-500 h-2.5 rounded-full" style="width: 0%"></div>
                </div>

                <form id="reservationForm" action="{{ route('client.reservations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

                    <!-- Customer Info -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Your Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <div class="flex space-x-2">
                                    <input type="text" name="first_name" placeholder="First Name" class="w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 text-sm" required>
                                    <input type="text" name="last_name" placeholder="Last Name" class="w-1/2 border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 text-sm" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" id="email" placeholder="example@example.com" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 text-sm" required>
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" name="phone" id="phone" placeholder="06********" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 text-sm" required>
                                <small class="text-gray-500">We'll only contact you about your reservation</small>
                            </div>
                        </div>
                    </div>

                    <!-- Guests -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Party Size</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label for="guests_number" class="block text-sm font-medium text-gray-700 mb-2">How many people?</label>
                            <select name="guests_number" id="guests_number" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 text-sm" required>
                                <option value="">Select number of guests</option>
                                @for ($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'person' : 'people' }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Reservation Date and Time -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Date & Time</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="border border-gray-300 rounded-md overflow-hidden bg-white">
                                <div class="bg-yellow-50 p-3 flex justify-between items-center border-b border-gray-300">
                                    <div id="selected-date-display" class="text-sm font-medium text-gray-800">Select a date</div>
                                    <div class="flex items-center">
                                        <span class="text-xs text-gray-500 mr-2">Hours: {{ $restaurant->opening_time->format('g:i A') }} - {{ $restaurant->closing_time->format('g:i A') }}</span>
                                        <button type="button" id="calendar-toggle" class="text-gray-600 hover:text-gray-800">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div id="calendar-container" class="p-3">
                                    <!-- Calendar Header -->
                                    <div class="flex justify-between items-center mb-2">
                                        <button type="button" id="prev-month" class="text-yellow-600 hover:text-yellow-800 focus:outline-none">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <div id="current-month-display" class="text-sm font-medium"></div>
                                        <button type="button" id="next-month" class="text-yellow-600 hover:text-yellow-800 focus:outline-none">
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
                                        <!-- Days -->
                                    </div>
                                </div>

                                <!-- Time Slots -->
                                <div id="time-slots-container" class="border-t border-gray-300">
                                    <div class="px-3 py-2 bg-yellow-50 border-b border-gray-300">
                                        <h4 class="text-sm font-medium text-gray-800">Available Time Slots</h4>
                                    </div>
                                    <div id="time-slots" class="grid grid-cols-3 gap-2 p-3">
                                        <p class="col-span-3 text-sm text-gray-500">Please select a date first</p>
                                    </div>
                                </div>
                            </div>


                            <input type="hidden" name="booking_date" id="booking_date" required>
                            <input type="hidden" name="booking_time" id="booking_time" required>
                        </div>
                    </div>

                    <!-- Table Selection  -->
                    <div class="mb-6" id="table-selection-container" style="opacity: 0.5; pointer-events: none;">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Select a Table</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-4">Please select your preferred table for your reservation. Tables shown are suitable for your party size.</p>

                            <div id="tables-loading" class="text-center py-4">
                                <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-yellow-500"></div>
                                <p class="mt-2 text-sm text-gray-500">Finding available tables...</p>
                            </div>

                            <div id="tables-container" class="hidden">
                                <div id="no-tables-message" class="hidden p-4 bg-red-50 rounded-md text-red-800 text-sm">
                                    <div class="flex items-center mb-2">
                                        <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        <span class="font-medium">No tables available</span>
                                    </div>
                                    <p>No tables are available for your party size at the selected time.</p>
                                </div>

                                <div id="tables-grid" class="grid grid-cols-1 gap-3 sm:grid-cols-2"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Special Requests -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Special Requests <span class="text-sm font-normal text-gray-500">(Optional)</span></h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <textarea name="special_requests" id="special_requests" rows="3" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 text-sm" placeholder="Allergies, special occasions, seating preferences..."></textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                        <a href="{{ route('restaurants.show', $restaurant->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Cancel
                        </a>
                        <button type="submit" id="submit-btn" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <span>Complete Reservation</span>
                            <svg class="ml-2 -mr-1 h-4 w-4 hidden" id="loading-spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // restaurant data
    var openingDays = {!! json_encode($openingDays) !!};
    console.log(openingTime);
    var openingTime ='{{ $restaurant->opening_time->format('H:i') }}';
    var closingTime = '{{ $restaurant->closing_time->format('H:i') }}';
    var tables = {!! json_encode($tables) !!};
    var maxBookingDaysAhead = {{ $restaurant->max_booking_days_ahead ?? 30 }};
    var selectedTableId = null;

    // Update progress bar
    function updateProgress() {
        const progressBar = document.getElementById('progress-bar');
        let progress = 0;

        // Calculate progress based on completed steps
        if (document.getElementById('booking_date').value) progress += 25;
        if (document.getElementById('booking_time').value) progress += 25;
        if (document.getElementById('guests_number').value) progress += 25;
        if (selectedTableId) progress += 25;

        // Update progress bar
        if (progressBar) {
            progressBar.style.width = progress + '%';
        }
    }

    // Calendar functionality
    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();
    const calendarDays = document.getElementById('calendar-days');
    const currentMonthDisplay = document.getElementById('current-month-display');
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');
    const selectedDateDisplay = document.getElementById('selected-date-display');
    const timeSlotsCont = document.getElementById('time-slots');
    const loadingSpinner = document.getElementById('loading-spinner');
    const tableSelectionContainer = document.getElementById('table-selection-container');
    const tablesContainer = document.getElementById('tables-container');
    const tablesLoading = document.getElementById('tables-loading');
    const noTablesMessage = document.getElementById('no-tables-message');
    const tablesGrid = document.getElementById('tables-grid');

    // Hidden form fields
    const bookingDateInput = document.getElementById('booking_date');
    const bookingTimeInput = document.getElementById('booking_time');
    const guestsNumberInput = document.getElementById('guests_number');

    // Initialize calendar
    renderCalendar(currentMonth, currentYear);

    // Render calendar based on the next and prev buttons
    if (prevMonthBtn) {
        prevMonthBtn.addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentMonth, currentYear);
        });
    }

    if (nextMonthBtn) {
        nextMonthBtn.addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentMonth, currentYear);
        });
    }

    // Listen for guest number changes
    if (guestsNumberInput) {
        guestsNumberInput.addEventListener('change', function() {
            updateProgress();
            // Reset table selection if we have date and time selected
            if (bookingDateInput.value && bookingTimeInput.value) {
                findAvailableTables();
            }
        });
    }

    // time slotes
    function generateTimeSlots(selectedDate) {
        if (!timeSlotsCont) return;

        // Clear existing time slots
        timeSlotsCont.innerHTML = '';

        // Reset table selection when date changes
        resetTableSelection();

        // Parse opening and closing hours
        const openHour = parseInt(openingTime.split(':')[0]);
        const openMinute = parseInt(openingTime.split(':')[1]);
        const closeHour = parseInt(closingTime.split(':')[0]);
        const closeMinute = parseInt(closingTime.split(':')[1]);

        // Set the starting and ending times
        let startTime = new Date(selectedDate);
        startTime.setHours(openHour, openMinute, 0);

        let endTime = new Date(selectedDate);
        endTime.setHours(closeHour, closeMinute, 0);

        // If today is selected, adjust start time to now + 1 hour
        if (selectedDate.toDateString() === new Date().toDateString()) {
            const now = new Date();
            now.setHours(now.getHours() + 1, 0, 0);
            if (now > startTime) {
                startTime = now;
            }
        }

        // Generate slots in 30 minute increments
        const timeSlots = [];
        const currentTime = new Date(startTime);


        const lastSlotTime = new Date(endTime);
        lastSlotTime.setHours(lastSlotTime.getHours() - 1);

        while (currentTime <= lastSlotTime) {
            timeSlots.push(new Date(currentTime));
            currentTime.setMinutes(currentTime.getMinutes() + 30);
        }

        // No available time slots
        if (timeSlots.length === 0) {
            const noSlots = document.createElement('p');
            noSlots.className = 'col-span-3 text-sm text-gray-500';
            noSlots.textContent = 'No available time slots for this date.';
            timeSlotsCont.appendChild(noSlots);
            return;
        }

        // Create buttons for each time slot
        timeSlots.forEach(slot => {
            const timeBtn = document.createElement('button');
            timeBtn.type = 'button';
            timeBtn.className = 'time-slot py-2 px-3 bg-white border border-gray-300 text-gray-700 rounded-md text-sm hover:bg-yellow-50 focus:outline-none';
            timeBtn.textContent = slot.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });

            // Add click event for time selection
            timeBtn.addEventListener('click', function() {
                // Remove selection from all time slots
                document.querySelectorAll('.time-slot').forEach(s =>
                    s.classList.remove('bg-yellow-500', 'text-white', 'border-yellow-500'));

                // Add selection to clicked time slot
                this.classList.add('bg-yellow-500', 'text-white', 'border-yellow-500');

                // Set the booking time value
                const hours = slot.getHours();
                const minutes = slot.getMinutes();
                bookingTimeInput.value = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;

                // Check available tables for this timeslot
                findAvailableTables();

                updateProgress();
            });

            timeSlotsCont.appendChild(timeBtn);
        });
    }

    // render the calendar
    function renderCalendar(month, year) {
        if (!calendarDays || !currentMonthDisplay) return;

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
            emptyDay.classList.add('text-center', 'py-2');
            calendarDays.appendChild(emptyDay);
        }

        // Add days of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            const dayOfWeek = date.toLocaleDateString('en-US', { weekday: 'long' });
            const isOpenDay = openingDays.includes(dayOfWeek);
            const isPastDate = date < new Date(today.setHours(0,0,0,0));

            // Check if date is beyond max booking days ahead
            const maxDate = new Date();
            maxDate.setDate(maxDate.getDate() + maxBookingDaysAhead);
            const isFutureDate = date > maxDate;

            const dayCell = document.createElement('div');
            dayCell.textContent = day;
            dayCell.classList.add('text-center', 'py-2', 'rounded', 'relative');

            if (isPastDate) {
                dayCell.classList.add('text-gray-400', 'cursor-not-allowed', 'bg-gray-100');
            } else if (isFutureDate) {
                dayCell.classList.add('text-gray-400', 'cursor-not-allowed');
            } else if (!isOpenDay) {
                dayCell.classList.add('text-gray-500', 'cursor-not-allowed');

                // Add closed indicator
                const closedIndicator = document.createElement('span');
                closedIndicator.classList.add('absolute', 'bottom-0', 'left-0', 'right-0', 'text-xs', 'text-gray-400');
                closedIndicator.textContent = 'Closed';
                dayCell.appendChild(closedIndicator);
            } else {
                dayCell.classList.add('hover:bg-yellow-100', 'cursor-pointer', 'border', 'border-gray-200');

                // Check if it's today
                if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    dayCell.classList.add('bg-yellow-50', 'text-yellow-800', 'font-semibold');
                } else {
                    dayCell.classList.add('text-gray-800');
                }

                // Add click event
                dayCell.addEventListener('click', function() {
                    // Remove selection from all days
                    document.querySelectorAll('#calendar-days div.bg-yellow-500').forEach(el => {
                        el.classList.remove('bg-yellow-500', 'text-white');

                        // Restore today's styling if needed
                        if (el.textContent == today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                            el.classList.add('bg-yellow-50', 'text-yellow-800', 'font-semibold');
                        } else {
                            el.classList.add('text-gray-800');
                        }
                    });

                    // Add selection to clicked day
                    this.classList.remove('text-gray-800', 'bg-yellow-50', 'text-yellow-800');
                    this.classList.add('bg-yellow-500', 'text-white');

                    // Set the date value in the hidden input and display
                    const selectedDate = new Date(year, month, day);
                    const formattedDate = selectedDate.toISOString().split('T')[0];

                    if (bookingDateInput) {
                        bookingDateInput.value = formattedDate;
                    }

                    if (selectedDateDisplay) {
                        selectedDateDisplay.textContent = selectedDate.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' });
                    }

                    // Generate time slots for the selected date
                    generateTimeSlots(selectedDate);

                    updateProgress();
                });
            }

            calendarDays.appendChild(dayCell);
        }
    }

    // Find available tables based on guests, date and time
    function findAvailableTables() {
        if (!guestsNumberInput || !bookingDateInput || !bookingTimeInput) return;

        const guestsNumber = parseInt(guestsNumberInput.value);
        const bookingDate = bookingDateInput.value;
        const bookingTime = bookingTimeInput.value;

        if (!guestsNumber || !bookingDate || !bookingTime) {
            return;
        }

        if (!tableSelectionContainer || !tablesContainer || !tablesLoading) return;

        // Enable table selection UI
        tableSelectionContainer.style.opacity = '1';
        tableSelectionContainer.style.pointerEvents = 'auto';

        // Show loading state
        tablesContainer.classList.add('hidden');
        tablesLoading.classList.remove('hidden');




        setTimeout(() => {
            if (!noTablesMessage || !tablesGrid) return;

            // Find suitable tables based on capacity
            const suitableTables = tables.filter(table =>
                table.capacity >= guestsNumber &&
                table.is_active &&
                table.is_available
            );

            console.log('Suitable tables found:', suitableTables);

            // Hide loading
            tablesLoading.classList.add('hidden');
            tablesContainer.classList.remove('hidden');

            // Reset selected table
            selectedTableId = null;

            if (suitableTables.length === 0) {
                // No tables available
                noTablesMessage.classList.remove('hidden');
                tablesGrid.classList.add('hidden');
                updateProgress();
                return;
            }

            // Tables are available
            noTablesMessage.classList.add('hidden');
            tablesGrid.classList.remove('hidden');

            // Clear previous tables
            tablesGrid.innerHTML = '';

            // Add table selection cards
            suitableTables.forEach(table => {
                // Create the table card
                const tableCard = document.createElement('div');
                tableCard.className = 'table-card border border-gray-300 rounded-md overflow-hidden cursor-pointer hover:border-yellow-500 transition-colors';
                tableCard.dataset.tableId = table.id;

                // Add table header
                const tableHeader = document.createElement('div');
                tableHeader.className = 'p-3 border-b border-gray-200 bg-white';
                tableHeader.innerHTML = `
                    <div class="flex justify-between items-center">
                        <h4 class="font-medium text-gray-900">${table.name}</h4>
                        <span class="text-sm text-gray-500">Seats ${table.capacity}</span>
                    </div>
                    ${table.location ? `<p class="text-xs text-gray-500">Location: ${table.location}</p>` : ''}
                `;

                // Add table body
                const tableBody = document.createElement('div');
                tableBody.className = 'p-3 bg-gray-50';
                tableBody.innerHTML = `
                    <div class="flex items-center mb-2">
                        <div class="flex-shrink-0 h-8 w-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="h-5 w-5 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-2">
                            <p class="text-sm font-medium text-gray-900">Available</p>
                            <p class="text-xs text-gray-500">Perfect for your party of ${guestsNumber}</p>
                        </div>
                    </div>
                    ${table.description ? `<p class="text-xs text-gray-600">${table.description}</p>` : ''}
                `;

                // Add the selection indicator
                const selectionIndicator = document.createElement('div');
                selectionIndicator.className = 'table-selected-indicator hidden bg-yellow-500 h-1.5 w-full';

                // Append all elements
                tableCard.appendChild(tableHeader);
                tableCard.appendChild(tableBody);
                tableCard.appendChild(selectionIndicator);

                // Add click event for selection
                tableCard.addEventListener('click', function() {
                    // Update selected table
                    selectedTableId = table.id;

                    // Update UI
                    document.querySelectorAll('.table-card').forEach(card => {
                        card.classList.remove('border-yellow-500', 'ring-2', 'ring-yellow-500', 'ring-offset-2');
                        const indicator = card.querySelector('.table-selected-indicator');
                        if (indicator) indicator.classList.add('hidden');
                    });

                    this.classList.add('border-yellow-500', 'ring-2', 'ring-yellow-500', 'ring-offset-2');
                    const thisIndicator = this.querySelector('.table-selected-indicator');
                    if (thisIndicator) thisIndicator.classList.remove('hidden');

                    // Create hidden input for table_id if it doesn't exist
                    let tableIdInput = document.getElementById('table_id');
                    if (!tableIdInput) {
                        tableIdInput = document.createElement('input');
                        tableIdInput.type = 'hidden';
                        tableIdInput.name = 'table_id';
                        tableIdInput.id = 'table_id';
                        document.getElementById('reservationForm').appendChild(tableIdInput);
                    }

                    tableIdInput.value = selectedTableId;
                    updateProgress();
                });

                tablesGrid.appendChild(tableCard);
            });

        }, 800);
    }

    // Reset table selection when date or time changes
    function resetTableSelection() {
        selectedTableId = null;

        if (!tableSelectionContainer) return;

        tableSelectionContainer.style.opacity = '0.5';
        tableSelectionContainer.style.pointerEvents = 'none';

        // Reset table_id input
        const tableIdInput = document.getElementById('table_id');
        if (tableIdInput) {
            tableIdInput.value = '';
        }
    }

    // Form validation and submission
    const reservationForm = document.getElementById('reservationForm');
    if (reservationForm) {
        reservationForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validation checks
            let isValid = true;
            let errorMessage = '';

            if (!bookingDateInput || !bookingDateInput.value) {
                isValid = false;
                errorMessage = 'Please select a reservation date.';
            } else if (!bookingTimeInput || !bookingTimeInput.value) {
                isValid = false;
                errorMessage = 'Please select a reservation time.';
            } else if (!document.getElementById('table_id') || !document.getElementById('table_id').value) {
                isValid = false;
                errorMessage = 'Please select a table for your reservation.';
            }

            if (!isValid) {
                alert(errorMessage);
                return;
            }

            // Show loading state
            if (loadingSpinner) {
                loadingSpinner.classList.remove('hidden');
            }

            const submitBtn = document.getElementById('submit-btn');
            if (submitBtn) {
                submitBtn.disabled = true;
            }

            // Submit the form
            this.submit();
        });
    }
});
    </script>
</x-app-layout>
