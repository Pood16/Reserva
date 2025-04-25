<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">My Reservations</h1>
                <a href="{{ route('restaurants.index') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Home
                </a>
            </div>

           <!-- Flash messages -->
           <x-flash-messages />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex" aria-label="Tabs">
                        <button class="tab-button text-yellow-600 border-yellow-500 whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm w-1/3 text-center active" data-tab="upcoming">
                            Upcoming
                            <span class="bg-yellow-100 text-yellow-600 ml-2 py-0.5 px-2 rounded-full text-xs">
                                {{ count($groupedReservations['upcoming']) }}
                            </span>
                        </button>
                        <button class="tab-button text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-4 border-b-2 border-transparent font-medium text-sm w-1/3 text-center" data-tab="past">
                            Past
                            <span class="bg-gray-100 text-gray-600 ml-2 py-0.5 px-2 rounded-full text-xs">
                                {{ count($groupedReservations['past']) }}
                            </span>
                        </button>
                        <button class="tab-button text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-4 border-b-2 border-transparent font-medium text-sm w-1/3 text-center" data-tab="cancelled">
                            Cancelled
                            <span class="bg-gray-100 text-gray-600 ml-2 py-0.5 px-2 rounded-full text-xs">
                                {{ count($groupedReservations['cancelled']) }}
                            </span>
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div>
                    <!-- Upcoming Reservations Tab -->
                    <div id="upcoming-tab" class="tab-content p-4 block">
                        @if($groupedReservations['upcoming']->isEmpty())
                            <div class="py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No upcoming reservations</h3>
                                <p class="mt-1 text-sm text-gray-500">Start by booking a table at your favorite restaurant.</p>
                                <div class="mt-6">
                                    <a href="{{ route('restaurants.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Find Restaurants
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($groupedReservations['upcoming'] as $reservation)
                                    <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                        <div class="p-5 border-b">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900">{{ $reservation->restaurant->name }}</h3>
                                                    <p class="text-sm text-gray-500">Table: {{ $reservation->table->name }}</p>
                                                </div>
                                                <span class="px-2 py-1 rounded text-xs font-semibold
                                                {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}}">
                                                    {{ ucfirst($reservation->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="px-5 py-4 bg-gray-50">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-xs text-gray-500">Date</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ $reservation->booking_date->format('D, M j, Y') }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Time</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ $reservation->booking_date->format('g:i A') }} - {{ $reservation->end_time->format('g:i A') }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Guests</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ $reservation->guests_number }} people</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Reference #</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ strtoupper(substr(md5($reservation->id), 0, 8)) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-5 py-3 bg-white border-t flex justify-between">
                                            <a href="{{ route('client.reservations.show', $reservation->id) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View Details</a>
                                            <button type="button"
                                                class="text-sm text-red-600 hover:text-red-800 font-medium cancel-button"
                                                data-reservation-id="{{ $reservation->id }}"
                                                data-restaurant-name="{{ $reservation->restaurant->name }}"
                                                data-booking-date="{{ $reservation->booking_date->format('D, M j, Y') }}"
                                                data-booking-time="{{ $reservation->booking_date->format('g:i A') }}">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Past Reservations Tab -->
                    <div id="past-tab" class="tab-content p-4 hidden">
                        @if($groupedReservations['past']->isEmpty())
                            <div class="py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No past reservations</h3>
                                <p class="mt-1 text-sm text-gray-500">Your completed reservations will appear here.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($groupedReservations['past'] as $reservation)
                                    <div class="bg-white border rounded-lg overflow-hidden shadow-sm opacity-75">
                                        <div class="p-5 border-b">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900">{{ $reservation->restaurant->name }}</h3>
                                                    <p class="text-sm text-gray-500">Table: {{ $reservation->table->name }}</p>
                                                </div>
                                                <span class="px-2 py-1 rounded text-xs font-semibold bg-gray-100 text-gray-700">
                                                    Completed
                                                </span>
                                            </div>
                                        </div>
                                        <div class="px-5 py-4 bg-gray-50">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-xs text-gray-500">Date</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ $reservation->booking_date->format('D, M j, Y') }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Time</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ $reservation->booking_date->format('g:i A') }} - {{ $reservation->end_time->format('g:i A') }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Guests</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ $reservation->guests_number }} people</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Reference #</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ strtoupper(substr(md5($reservation->id), 0, 8)) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-5 py-3 bg-white border-t">
                                            <a href="{{ route('client.reservations.show', $reservation->id) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Cancelled Reservations Tab -->
                    <div id="cancelled-tab" class="tab-content p-4 hidden">
                        @if($groupedReservations['cancelled']->isEmpty())
                            <div class="py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No cancelled reservations</h3>
                                <p class="mt-1 text-sm text-gray-500">Your cancelled reservations will appear here.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($groupedReservations['cancelled'] as $reservation)
                                    <div class="bg-white border rounded-lg overflow-hidden shadow-sm opacity-75">
                                        <div class="p-5 border-b">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900">{{ $reservation->restaurant->name }}</h3>
                                                    <p class="text-sm text-gray-500">Table: {{ $reservation->table->name }}</p>
                                                </div>
                                                <span class="px-2 py-1 rounded text-xs font-semibold bg-red-100 text-red-700">
                                                    Cancelled
                                                </span>
                                            </div>
                                        </div>
                                        <div class="px-5 py-4 bg-gray-50">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-xs text-gray-500">Date</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ $reservation->booking_date->format('D, M j, Y') }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Time</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ $reservation->booking_date->format('g:i A') }} - {{ $reservation->end_time->format('g:i A') }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Guests</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ $reservation->guests_number }} people</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Reference #</p>
                                                    <p class="text-sm font-medium text-gray-900">{{ strtoupper(substr(md5($reservation->id), 0, 8)) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-5 py-3 bg-white border-t">
                                            <a href="{{ route('client.reservations.show', $reservation->id) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Reservation Modal -->
    <div id="cancelModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Cancel Reservation</h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="mb-5">
                    <p class="text-gray-600 mb-3">Are you sure you want to cancel this reservation?</p>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3">
                        <p class="font-medium text-gray-800" id="restaurantName"></p>
                        <div class="mt-1 text-sm text-gray-600">
                            <p id="bookingDateTime"></p>
                        </div>
                    </div>
                </div>

                <form id="cancelForm" method="POST" class="mt-5">
                    @csrf
                    @method('PUT')
                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelButton" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            No, Keep It
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Yes, Cancel Reservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all buttons
                    tabButtons.forEach(btn => {
                        btn.classList.remove('text-yellow-600', 'border-yellow-500');
                        btn.classList.add('text-gray-500', 'border-transparent');
                    });

                    // Add active class
                    button.classList.remove('text-gray-500', 'border-transparent');
                    button.classList.add('text-yellow-600', 'border-yellow-500');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Show the selected tab content
                    const tabId = button.getAttribute('data-tab') + '-tab';
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });

            // Modal functionality
            const cancelModal = document.getElementById('cancelModal');
            const cancelForm = document.getElementById('cancelForm');
            const cancelButtons = document.querySelectorAll('.cancel-button');
            const closeModalButton = document.getElementById('closeModal');
            const cancelButtonInModal = document.getElementById('cancelButton');
            const restaurantNameEl = document.getElementById('restaurantName');
            const bookingDateTimeEl = document.getElementById('bookingDateTime');

            // Open modal when cancel button is clicked
            cancelButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const reservationId = button.getAttribute('data-reservation-id');
                    const restaurantName = button.getAttribute('data-restaurant-name');
                    const bookingDate = button.getAttribute('data-booking-date');
                    const bookingTime = button.getAttribute('data-booking-time');

                    // Update form action URL
                    cancelForm.action = `/client/reservations/${reservationId}/cancel`;

                    // Update modal content
                    restaurantNameEl.textContent = restaurantName;
                    bookingDateTimeEl.textContent = `${bookingDate} at ${bookingTime}`;

                    // Show modal
                    cancelModal.classList.remove('hidden');
                });
            });

            // Close modal when close button is clicked
            closeModalButton.addEventListener('click', () => {
                cancelModal.classList.add('hidden');
            });

            // Close modal when "No, Keep It" button is clicked
            cancelButtonInModal.addEventListener('click', () => {
                cancelModal.classList.add('hidden');
            });

            // Close modal when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target === cancelModal) {
                    cancelModal.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
