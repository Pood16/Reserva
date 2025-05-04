<x-app-layout>
    <x-header />
    <div class="bg-gray-50 min-h-screen">
        <!-- Success message -->
        <x-flash-messages />

        {{-- <!-- Reservation  -->
        @if(session('show_confirmation_modal') && session('reservation_details'))
        <div id="reservation-confirmation-modal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- overlay -->
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <!-- Success icon -->
                                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Reservation Confirmed!
                                </h3>
                                <div class="mt-4">
                                    <div class="border-b border-gray-200 pb-2 mb-4">
                                        <p class="text-sm text-gray-500">
                                            Your reservation has been submitted successfully and is awaiting confirmation from the restaurant.
                                        </p>
                                    </div>

                                    <div class="mb-4">
                                        <div class="flex justify-between py-2 text-sm">
                                            <span class="font-medium text-gray-500">Restaurant:</span>
                                            <span class="text-gray-900">{{ session('reservation_details.restaurant_name') }}</span>
                                        </div>
                                        <div class="flex justify-between py-2 text-sm border-t border-gray-100">
                                            <span class="font-medium text-gray-500">Date:</span>
                                            <span class="text-gray-900">{{ session('reservation_details.booking_date') }}</span>
                                        </div>
                                        <div class="flex justify-between py-2 text-sm border-t border-gray-100">
                                            <span class="font-medium text-gray-500">Time:</span>
                                            <span class="text-gray-900">{{ session('reservation_details.booking_time') }} - {{ session('reservation_details.end_time') }}</span>
                                        </div>
                                        <div class="flex justify-between py-2 text-sm border-t border-gray-100">
                                            <span class="font-medium text-gray-500">Table:</span>
                                            <span class="text-gray-900">{{ session('reservation_details.table_name') }} ({{ session('reservation_details.table_location') }})</span>
                                        </div>
                                        <div class="flex justify-between py-2 text-sm border-t border-gray-100">
                                            <span class="font-medium text-gray-500">Guests:</span>
                                            <span class="text-gray-900">{{ session('reservation_details.guests_number') }} {{ session('reservation_details.guests_number') === 1 ? 'person' : 'people' }}</span>
                                        </div>
                                        <div class="flex justify-between py-2 text-sm border-t border-gray-100">
                                            <span class="font-medium text-gray-500">Status:</span>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                {{ session('reservation_details.status') }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between py-2 text-sm border-t border-gray-100">
                                            <span class="font-medium text-gray-500">Reference Number:</span>
                                            <span class="text-gray-900 font-mono">{{ session('reservation_details.reference_number') }}</span>
                                        </div>
                                        @if(session('reservation_details.special_requests'))
                                        <div class="py-2 text-sm border-t border-gray-100">
                                            <span class="font-medium text-gray-500 block mb-1">Special Requests:</span>
                                            <p class="text-gray-900 italic">{{ session('reservation_details.special_requests') }}</p>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="rounded-md bg-blue-50 p-4 mt-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-blue-800">Note</h3>
                                                <div class="mt-2 text-sm text-blue-700">
                                                    <p>Please save your reference number. You may need it if you contact the restaurant about your reservation.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="close-modal-button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Close
                        </button>
                        <a href="#" id="download-details-button" class="mt-3 sm:mt-0 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Download Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif --}}

        <!-- Custom Notification Popup -->
        <div id="notification-popup" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div id="notification-icon" class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                                <!-- Icon will be inserted here dynamically -->
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="notification-title">
                                    Notification
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500" id="notification-message">
                                        <!-- Message will be inserted here dynamically -->
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="notification-action-button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm hidden">
                            Log in
                        </button>
                        <button type="button" id="notification-close-button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Restaurant Header - Updated design -->
        <div class="relative mb-8">
            <div class="h-[28rem] w-full overflow-hidden">
                <img
                    src="{{ asset('storage/'.$restaurant->cover_image) }}"
                    alt="{{ $restaurant->name }}"
                    class="w-full h-full object-cover restaurant-image"
                    data-fallback="{{ asset('images/restaurant-placeholder-300x200.jpg') }}"
                >
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent p-8">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                        <div>
                            <h1 class="text-4xl font-bold text-white mb-2">{{ $restaurant->name }}</h1>
                            <div class="flex flex-wrap items-center gap-4 text-white/90">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span>{{ number_format($restaurant->reviews->avg('rating') ?? 4.5, 1) }} ({{ $restaurant->reviews->count() }} {{ Str::plural('review', $restaurant->reviews->count()) }})</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/90 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $restaurant->city }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/90 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $restaurant->opening_time->format('g:i A') }} - {{ $restaurant->closing_time->format('g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-2 md:mt-0">
                            <a href="{{ auth()->check() ? route('client.reservations.create', ['restaurant' => $restaurant->id]) : '#' }}"
                               class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-300 flex items-center shadow-lg reservation-btn"
                               data-auth="{{ auth()->check() ? 'true' : 'false' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 pb-16">
            <!-- Quick Info Bar -->
            <div class="bg-white shadow-md rounded-xl p-4 mb-8 flex flex-wrap justify-between items-center gap-4">
                <div class="flex items-center">
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-yellow-100 text-yellow-600 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm text-gray-500">Cuisine</p>
                        <p class="font-medium">
                            @if($restaurant->foodTypes->count() > 0)
                                {{ $restaurant->foodTypes->pluck('name')->join(', ') }}
                            @else
                                Various
                            @endif
                        </p>
                    </div>
                </div>

                <div class="flex items-center">
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-100 text-blue-600 mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm text-gray-500">Reviews</p>
                        <p class="font-medium">{{ $restaurant->reviews->count() }} {{ Str::plural('review', $restaurant->reviews->count()) }}</p>
                    </div>
                </div>

                <div>
                    <button id="favorite-button" data-restaurant-id="{{ $restaurant->id }}" data-is-favorited="false"
                        class="px-4 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-medium rounded-lg transition duration-300 flex items-center">
                        <svg id="favorite-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span id="favorite-text">Save</span>
                    </button>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column -->
                <div class="lg:w-2/3">
                    <!-- Tabbed Navigation -->
                    <div class="mb-8">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8">
                                <a href="#about" class="tab-link active border-yellow-500 text-yellow-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="about">
                                    About
                                </a>
                                <a href="#menu" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="menu">
                                    Menu
                                </a>
                                <a href="#photos" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="photos">
                                    Photos
                                </a>
                                <a href="#reviews" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="reviews">
                                    Reviews
                                </a>
                            </nav>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- About Tab -->
                        <div id="about-tab" class="tab-pane active">
                            <!-- About Section -->
                            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">About {{ $restaurant->name }}</h2>
                                <p class="text-gray-600 mb-8 leading-relaxed">{{ $restaurant->description }}</p>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m-1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                            </svg>
                                            Contact Information
                                        </h3>
                                        <div class="space-y-4">
                                            <div class="flex items-center text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span>{{ $restaurant->address }}, {{ $restaurant->city }}</span>
                                            </div>
                                            <div class="flex items-center text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                <a href="tel:{{ $restaurant->phone }}" class="hover:text-yellow-600">{{ $restaurant->phone }}</a>
                                            </div>
                                            <div class="flex items-center text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <a href="mailto:{{ $restaurant->email }}" class="hover:text-yellow-600">{{ $restaurant->email }}</a>
                                            </div>
                                            @if($restaurant->website)
                                                <div class="flex items-center text-gray-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c-1.657 0-3-4.03-3-9s1.343-9 3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                    </svg>
                                                    <a href="{{ $restaurant->website }}" target="_blank" class="text-yellow-600 hover:text-yellow-800">Visit Website</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Opening Hours
                                        </h3>
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <div class="space-y-2">
                                                @foreach($restaurant->openingDays as $day)
                                                    <div class="flex justify-between text-gray-600">
                                                        <span>{{ $day->day_of_week }}</span>
                                                        <span>
                                                            @if($restaurant->opening_time && $restaurant->closing_time)
                                                                {{ $restaurant->opening_time->format('g:i A') }} - {{ $restaurant->closing_time->format('g:i A') }}
                                                            @else
                                                                Closed
                                                            @endif
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Tab -->
                        <div id="menu-tab" class="tab-pane hidden">
                            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">Menu</h2>

                                @if(($restaurant->menus ?? collect())->count())
                                    <!-- Menu category tabs if multiple menus -->
                                    @if($restaurant->menus->count() > 1)
                                    <div class="mb-6">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($restaurant->menus as $index => $menu)
                                            <button
                                                class="menu-category-tab px-4 py-2 rounded-full text-sm font-medium {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                                                data-target="menu-category-{{ $menu->id }}">
                                                {{ $menu->name }}
                                            </button>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Menu items by category -->
                                    @foreach($restaurant->menus as $index => $menu)
                                    <div id="menu-category-{{ $menu->id }}" class="menu-category {{ $index === 0 ? 'block' : 'hidden' }}">
                                        @if($restaurant->menus->count() === 1)
                                        <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $menu->name }}</h3>
                                        @endif

                                        @if(($menu->items ?? collect())->count())
                                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                            @foreach($menu->items as $item)
                                            <div class="flex gap-4 bg-gray-50 p-4 rounded-lg transition-transform hover:scale-[1.02]">
                                                @if($item->image)
                                                <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0">
                                                    <img
                                                        src="{{ asset('storage/'.$item->image) }}"
                                                        alt="{{ $item->name }}"
                                                        class="w-full h-full object-cover menu-item-image"
                                                        loading="lazy"
                                                        data-fallback="{{ asset('images/placeholder-300x200.jpg') }}"
                                                    >
                                                </div>
                                                @endif
                                                <div class="flex-1">
                                                    <div class="flex justify-between">
                                                        <h4 class="font-semibold text-gray-900">{{ $item->name }}</h4>
                                                        <span class="text-yellow-600 font-semibold">${{ number_format($item->price, 2) }}</span>
                                                    </div>
                                                    <p class="text-sm text-gray-600 mt-1">{{ $item->description }}</p>
                                                    @if($item->is_available)
                                                        <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Available
                                                        </span>
                                                    @else
                                                        <span class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Unavailable
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <p class="text-gray-500 italic">No items available in this menu category.</p>
                                        @endif
                                    </div>
                                    @endforeach
                                @else
                                <div class="text-center py-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                    <p class="text-gray-500 mb-2">No menu available for this restaurant yet.</p>
                                    <p class="text-sm text-gray-400">The restaurant may update their menu soon.</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Photos Tab  -->
                        <div id="photos-tab" class="tab-pane hidden">
                            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                                <h2 class="text-2xl font-bold text-gray-900 mb-6">Restaurant Photos</h2>

                                <!-- Main restaurant image -->
                                <div class="mb-8">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Main View</h3>
                                    <div class="rounded-xl overflow-hidden">
                                        <img
                                            src="{{ asset('storage/'.$restaurant->cover_image) }}"
                                            alt="{{ $restaurant->name }} main image"
                                            class="w-full h-auto object-cover restaurant-image"
                                            data-fallback="{{ asset('images/restaurant-placeholder-300x200.jpg') }}"
                                        >
                                    </div>
                                </div>

                                <!-- Gallery of images -->
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Gallery</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @if(isset($restaurant->images) && count($restaurant->images) > 0)
                                        @foreach($restaurant->images as $image)
                                            <div class="rounded-lg overflow-hidden aspect-w-4 aspect-h-3">
                                                <img
                                                    src="{{ asset('storage/'.$image->image_path) }}"
                                                    alt="{{ $restaurant->name }} gallery image"
                                                    class="w-full h-full object-cover restaurant-image"
                                                    data-fallback="{{ asset('images/restaurant-placeholder-300x200.jpg') }}"
                                                >
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Sample placeholder images if no gallery exists -->
                                        @for($i = 1; $i <= 6; $i++)
                                            <div class="rounded-lg overflow-hidden aspect-w-4 aspect-h-3 bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500 text-sm">Restaurant Image {{ $i }}</span>
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div id="reviews-tab" class="tab-pane hidden">
                            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                                <div class="flex justify-between items-center mb-6">
                                    <h2 class="text-2xl font-bold text-gray-900">Reviews</h2>

                                    <div class="flex items-center">
                                        <div class="flex items-center mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </div>
                                        <span class="text-lg font-semibold">{{ number_format($restaurant->reviews->avg('rating') ?? 0, 1) }}</span>
                                        <span class="text-gray-400 text-sm ml-1">/ 5</span>
                                        <span class="text-gray-500 text-sm ml-2">({{ $restaurant->reviews->count() }} {{ Str::plural('review', $restaurant->reviews->count()) }})</span>
                                    </div>
                                </div>

                                <!-- Rating distribution -->
                                <div class="mb-8">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            @for($i = 5; $i >= 1; $i--)
                                            @php
                                                $count = $restaurant->reviews->where('rating', $i)->count();
                                                $percentage = $restaurant->reviews->count() > 0 ? ($count / $restaurant->reviews->count() * 100) : 0;

                                                // Use fixed width classes based on percentage ranges
                                                if ($percentage <= 0) {
                                                    $widthClass = 'w-0';
                                                } elseif ($percentage < 10) {
                                                    $widthClass = 'w-[5%]';
                                                } elseif ($percentage < 20) {
                                                    $widthClass = 'w-[15%]';
                                                } elseif ($percentage < 30) {
                                                    $widthClass = 'w-[25%]';
                                                } elseif ($percentage < 40) {
                                                    $widthClass = 'w-[35%]';
                                                } elseif ($percentage < 50) {
                                                    $widthClass = 'w-[45%]';
                                                } elseif ($percentage < 60) {
                                                    $widthClass = 'w-[55%]';
                                                } elseif ($percentage < 70) {
                                                    $widthClass = 'w-[65%]';
                                                } elseif ($percentage < 80) {
                                                    $widthClass = 'w-[75%]';
                                                } elseif ($percentage < 90) {
                                                    $widthClass = 'w-[85%]';
                                                } else {
                                                    $widthClass = 'w-[95%]';
                                                }
                                            @endphp
                                            <div class="flex items-center mb-2">
                                                <span class="text-sm text-gray-600 w-10">{{ $i }} star</span>
                                                <div class="flex-1 h-2.5 mx-2 bg-gray-200 rounded-full overflow-hidden">
                                                    @if($percentage > 0)
                                                        <div class="bg-yellow-400 h-full rounded-full {{ $widthClass }}"></div>
                                                    @endif
                                                </div>
                                                <span class="text-sm text-gray-600 w-10 text-right">{{ $count }}</span>
                                            </div>
                                            @endfor
                                        </div>

                                        <div class="flex flex-col justify-center items-center">
                                            <p class="mb-2 text-sm text-gray-500">Have you dined at this restaurant?</p>
                                            <button type="button" id="open-review-modal" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-300 inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Write a Review
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reviews list -->
                                @if($restaurant->reviews->count() > 0)
                                <div class="space-y-6">
                                    @foreach($restaurant->reviews as $review)
                                    <div class="p-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold">
                                                    {{ substr($review->user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center mb-1">
                                                    <span class="font-medium text-gray-800 mr-2">{{ $review->user->name }}</span>
                                                    <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="flex items-center mb-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                         viewBox="0 0 20 20"
                                                         fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    @endfor
                                                </div>
                                                <p class="text-gray-600">{{ $review->comment }}</p>
                                                @if(auth()->check() && auth()->id() === $review->user_id)
                                                <div class="flex space-x-2">
                                                    <button type="button" class="edit-review-btn text-yellow-600 hover:text-yellow-800 text-sm font-medium"
                                                            data-review-id="{{ $review->id }}"
                                                            data-review-rating="{{ $review->rating }}"
                                                            data-review-comment="{{ $review->comment }}">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="delete-review-btn text-red-600 hover:text-red-800 text-sm font-medium"
                                                            data-review-id="{{ $review->id }}"
                                                            data-action="{{ route('reviews.destroy', [$restaurant, $review]) }}">
                                                        Delete
                                                    </button>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="text-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                    <p class="text-gray-500 mb-2">No reviews yet</p>
                                    <p class="text-sm text-gray-400">Be the first to review this restaurant</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="lg:w-1/3">
                    <!-- Reservation Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-8 sticky top-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Make a Reservation</h3>
                        <a href="{{ auth()->check() ? route('client.reservations.create', ['restaurant' => $restaurant->id]) : '#' }}"
                           class="w-full px-4 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-300 flex justify-center items-center reservation-btn"
                           data-auth="{{ auth()->check() ? 'true' : 'false' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Book a Table
                        </a>

                        <div class="mt-6 space-y-4">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-600">Instant confirmation</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-600">No booking fees</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-600">Special requests available</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer />

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image fallback
            document.querySelectorAll('.restaurant-image, .menu-item-image').forEach(img => {
                img.addEventListener('error', function() {
                    this.src = this.getAttribute('data-fallback');
                });
            });

            // Authentication check for reservation buttons
            document.querySelectorAll('.reservation-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const isAuthenticated = this.getAttribute('data-auth') === 'true';
                    if (!isAuthenticated) {
                        e.preventDefault();
                        showNotification(
                            'Authentication Required',
                            'You need to log in or register to make a reservation at this restaurant. Would you like to log in now?',
                            'info',
                            true
                        );
                    }
                });
            });

            // Tabs functionality
            const tabLinks = document.querySelectorAll('.tab-link');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all tabs
                    tabLinks.forEach(tab => {
                        tab.classList.remove('active', 'border-yellow-500', 'text-yellow-600');
                        tab.classList.add('border-transparent', 'text-gray-500');
                    });

                    // Add active class to clicked tab
                    this.classList.add('active', 'border-yellow-500', 'text-yellow-600');
                    this.classList.remove('border-transparent', 'text-gray-500');

                    // Hide all tab panes
                    tabPanes.forEach(pane => {
                        pane.classList.add('hidden');
                        pane.classList.remove('active');
                    });

                    // Show related tab pane
                    const tabId = this.getAttribute('data-tab');
                    const tabPane = document.getElementById(tabId + '-tab');
                    if (tabPane) {
                        tabPane.classList.remove('hidden');
                        tabPane.classList.add('active');
                    }

                    // Update URL hash
                    window.location.hash = tabId;
                });
            });

            // Check for hash in URL to activate the correct tab
            const hash = window.location.hash.substr(1);
            if (hash) {
                const activeTab = document.querySelector(`.tab-link[data-tab="${hash}"]`);
                if (activeTab) {
                    activeTab.click();
                }
            }

            // Menu category tabs
            const menuCategoryTabs = document.querySelectorAll('.menu-category-tab');
            const menuCategories = document.querySelectorAll('.menu-category');

            menuCategoryTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all category tabs
                    menuCategoryTabs.forEach(categoryTab => {
                        categoryTab.classList.remove('bg-yellow-100', 'text-yellow-800');
                        categoryTab.classList.add('bg-gray-100', 'text-gray-700');
                    });

                    // Add active class to clicked category tab
                    this.classList.add('bg-yellow-100', 'text-yellow-800');
                    this.classList.remove('bg-gray-100', 'text-gray-700');

                    // Hide all menu categories
                    menuCategories.forEach(category => {
                        category.classList.add('hidden');
                    });

                    // Show related menu category
                    const targetId = this.getAttribute('data-target');
                    const targetCategory = document.getElementById(targetId);
                    if (targetCategory) {
                        targetCategory.classList.remove('hidden');
                    }
                });
            });

            // Check if restaurant is favorited on page load
            const checkFavoriteStatus = async (restaurantId) => {
                try {
                    const response = await fetch(`/restaurants/${restaurantId}/favorite/status`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        const favoriteButton = document.getElementById('favorite-button');
                        const favoriteIcon = document.getElementById('favorite-icon');
                        const favoriteText = document.getElementById('favorite-text');

                        if (data.isFavorited) {
                            favoriteIcon.classList.remove('text-gray-400');
                            favoriteIcon.classList.add('text-red-500');
                            favoriteIcon.setAttribute('fill', 'currentColor');
                            favoriteText.textContent = 'Saved';
                        } else {
                            favoriteIcon.classList.remove('text-red-500');
                            favoriteIcon.classList.add('text-gray-400');
                            favoriteIcon.setAttribute('fill', 'none');
                            favoriteText.textContent = 'Save';
                        }
                    }
                } catch (error) {
                    console.error('Error checking favorite status:', error);
                }
            };

            // toggleFavorite function
            async function toggleFavorite(restaurantId) {
                try {
                    const response = await fetch(`/restaurants/${restaurantId}/favorite`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    });

                    if (response.status === 401) {
                        showNotification('Login Required', 'Please log in to save restaurants to your favorites.', 'error');
                        return;
                    }

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    const data = await response.json();
                    const favoriteText = document.getElementById('favorite-text');
                    const favoriteIcon = document.getElementById('favorite-icon');

                    if (data.isFavorited) {
                        favoriteIcon.classList.remove('text-gray-400');
                        favoriteIcon.classList.add('text-red-500');
                        favoriteIcon.setAttribute('fill', 'currentColor');
                        favoriteText.textContent = 'Saved';
                    } else {
                        favoriteIcon.classList.remove('text-red-500');
                        favoriteIcon.classList.add('text-gray-400');
                        favoriteIcon.setAttribute('fill', 'none');
                        favoriteText.textContent = 'Save';
                    }

                    showNotification('Success', data.message, 'success');
                } catch (error) {
                    showNotification('Error', 'An error occurred. Please try again.', 'error');
                }
            }

            // Favorite button click
            const favoriteButton = document.getElementById('favorite-button');
            if (favoriteButton) {
                const restaurantId = favoriteButton.dataset.restaurantId;
                // Check initial favorite status
                checkFavoriteStatus(restaurantId);

                // Add click event listener
                favoriteButton.addEventListener('click', function() {
                    toggleFavorite(restaurantId);
                });
            }

            // Custom notification popup functionality
            const notificationPopup = document.getElementById('notification-popup');
            const notificationTitle = document.getElementById('notification-title');
            const notificationMessage = document.getElementById('notification-message');
            const notificationIcon = document.getElementById('notification-icon');
            const notificationCloseButton = document.getElementById('notification-close-button');
            const notificationActionButton = document.getElementById('notification-action-button');

            function showNotification(title, message, type, showLoginButton = false) {
                notificationTitle.textContent = title;
                notificationMessage.textContent = message;

                // Set icon and background color based on type
                notificationIcon.innerHTML = '';
                notificationIcon.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10';
                if (type === 'success') {
                    notificationIcon.classList.add('bg-green-100');
                    notificationIcon.innerHTML = '<svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                } else if (type === 'error') {
                    notificationIcon.classList.add('bg-red-100');
                    notificationIcon.innerHTML = '<svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                } else {
                    notificationIcon.classList.add('bg-blue-100');
                    notificationIcon.innerHTML = '<svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m-1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"></path></svg>';
                }

                // Show or hide login button
                if (showLoginButton) {
                    notificationActionButton.classList.remove('hidden');
                } else {
                    notificationActionButton.classList.add('hidden');
                }

                notificationPopup.classList.remove('hidden');
            }

            if (notificationCloseButton) {
                notificationCloseButton.addEventListener('click', function() {
                    notificationPopup.classList.add('hidden');
                });
            }

            if (notificationActionButton) {
                notificationActionButton.addEventListener('click', function() {
                    window.location.href = "{{ route('login.show') }}";
                });
            }

            // Review modal functionality
            const reviewModal = document.getElementById('review-modal');
            const openReviewModalBtn = document.getElementById('open-review-modal');
            const closeReviewModalBtn = document.getElementById('close-review-modal');
            const submitReviewBtn = document.getElementById('submit-review');
            const reviewForm = document.getElementById('review-form');
            const modalRatingStars = document.querySelectorAll('.modal-rating-star');
            const modalRatingInput = document.getElementById('modal-rating-input');
            const modalRatingText = document.getElementById('modal-rating-text');
            const modalComment = document.getElementById('modal-comment');
            const ratingError = document.getElementById('rating-error');
            const commentError = document.getElementById('comment-error');

            // Open review modal
            if (openReviewModalBtn) {
                openReviewModalBtn.addEventListener('click', function() {
                    // Reset form
                    reviewForm.action = "{{ route('reviews.store', $restaurant) }}";
                    reviewForm.reset();
                    modalRatingInput.value = "0";
                    updateModalStars(0);
                    modalRatingText.textContent = "Click to rate";
                    document.getElementById('review-modal-title').textContent = "Write a Review";
                    submitReviewBtn.textContent = "Submit Review";

                    // Hide errors
                    ratingError.classList.add('hidden');
                    commentError.classList.add('hidden');

                    reviewModal.classList.remove('hidden');
                });
            }

            // Close review modal
            if (closeReviewModalBtn) {
                closeReviewModalBtn.addEventListener('click', function() {
                    reviewModal.classList.add('hidden');
                });
            }

            // Handle rating selection in modal
            modalRatingStars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    modalRatingInput.value = rating;
                    updateModalStars(rating);
                    modalRatingText.textContent = `You rated ${rating} out of 5`;
                });

                star.addEventListener('mouseenter', function() {
                    const hoverRating = parseInt(this.getAttribute('data-rating'));
                    highlightModalStars(hoverRating);
                });

                star.addEventListener('mouseleave', function() {
                    const currentRating = parseInt(modalRatingInput.value) || 0;
                    updateModalStars(currentRating);
                });
            });

            function updateModalStars(rating) {
                modalRatingStars.forEach(star => {
                    const starRating = parseInt(star.getAttribute('data-rating'));
                    const starIcon = star.querySelector('svg');

                    if (starRating <= rating) {
                        starIcon.classList.remove('text-gray-300');
                        starIcon.classList.add('text-yellow-400');
                    } else {
                        starIcon.classList.remove('text-yellow-400');
                        starIcon.classList.add('text-gray-300');
                    }
                });
            }

            function highlightModalStars(rating) {
                modalRatingStars.forEach(star => {
                    const starRating = parseInt(star.getAttribute('data-rating'));
                    const starIcon = star.querySelector('svg');

                    if (starRating <= rating) {
                        starIcon.classList.remove('text-gray-300');
                        starIcon.classList.add('text-yellow-400');
                    } else {
                        starIcon.classList.remove('text-yellow-400');
                        starIcon.classList.add('text-gray-300');
                    }
                });
            }

            // Handle review submission
            if (submitReviewBtn) {
                submitReviewBtn.addEventListener('click', function() {
                    let isValid = true;

                    // Validate rating
                    const rating = parseInt(modalRatingInput.value) || 0;
                    if (rating < 1) {
                        ratingError.classList.remove('hidden');
                        isValid = false;
                    } else {
                        ratingError.classList.add('hidden');
                    }

                    // Validate comment
                    const comment = modalComment.value.trim();
                    if (comment.length < 10) {
                        commentError.classList.remove('hidden');
                        isValid = false;
                    } else {
                        commentError.classList.add('hidden');
                    }

                    // Submit if valid
                    if (isValid) {
                        reviewForm.submit();
                    }
                });
            }

            // Handle edit review buttons
            const editReviewBtns = document.querySelectorAll('.edit-review-btn');
            editReviewBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const reviewId = this.getAttribute('data-review-id');
                    const reviewRating = parseInt(this.getAttribute('data-review-rating'));
                    const reviewComment = this.getAttribute('data-review-comment');

                    // Set form values
                    reviewForm.action = "{{ route('reviews.store', $restaurant) }}";
                    modalRatingInput.value = reviewRating;
                    modalComment.value = reviewComment;
                    updateModalStars(reviewRating);
                    modalRatingText.textContent = `You rated ${reviewRating} out of 5`;

                    // Set title and button text
                    document.getElementById('review-modal-title').textContent = "Edit Your Review";
                    submitReviewBtn.textContent = "Update Review";

                    // Hide errors
                    ratingError.classList.add('hidden');
                    commentError.classList.add('hidden');

                    // Open modal
                    reviewModal.classList.remove('hidden');
                });
            });

            // Delete review modal functionality
            const deleteReviewModal = document.getElementById('delete-review-modal');
            const deleteReviewForm = document.getElementById('delete-review-form');
            const cancelDeleteBtn = document.getElementById('cancel-delete');
            const deleteReviewBtns = document.querySelectorAll('.delete-review-btn');

            // Open delete confirmation modal
            deleteReviewBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const actionUrl = this.getAttribute('data-action');
                    deleteReviewForm.action = actionUrl;
                    deleteReviewModal.classList.remove('hidden');
                });
            });

            // Close delete confirmation modal
            if (cancelDeleteBtn) {
                cancelDeleteBtn.addEventListener('click', function() {
                    deleteReviewModal.classList.add('hidden');
                });
            }
        });
    </script>
    @endpush

    <!-- Review Modal -->
<div id="review-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="review-modal-title">
                            Write a Review
                        </h3>
                        <div class="mt-4">
                            <form id="review-form" action="" method="POST">
                                @csrf
                                <input type="hidden" name="restaurant_id" id="review-restaurant-id" value="{{ $restaurant->id }}">

                                <!-- Rating selection -->
                                <div class="mb-6">
                                    <label class="block text-gray-700 font-medium mb-3">Your Rating</label>
                                    <div class="flex items-center">
                                        <div class="rating-stars flex" id="modal-rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                            <button type="button"
                                                class="modal-rating-star w-12 h-12 flex items-center justify-center focus:outline-none"
                                                data-rating="{{ $i }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-8 w-8 text-gray-300"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            </button>
                                            @endfor
                                        </div>
                                        <input type="hidden" name="rating" id="modal-rating-input" value="0">
                                        <span class="ml-4 text-gray-600" id="modal-rating-text">
                                            Click to rate
                                        </span>
                                    </div>
                                    <div class="text-red-600 text-sm mt-1 hidden" id="rating-error">Please select a rating</div>
                                </div>

                                <!-- Review text -->
                                <div class="mb-6">
                                    <label for="modal-comment" class="block text-gray-700 font-medium mb-2">Your Review</label>
                                    <textarea
                                        id="modal-comment"
                                        name="comment"
                                        rows="5"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50"
                                        placeholder="Share your experience at this restaurant..."
                                    ></textarea>
                                    <p class="text-sm text-gray-500 mt-2">Minimum 10 characters, maximum 500 characters</p>
                                    <div class="text-red-600 text-sm mt-1 hidden" id="comment-error">Please enter a comment (minimum 10 characters)</div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="submit-review" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-500 text-base font-medium text-white hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Submit Review
                </button>
                <button type="button" id="close-review-modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Review Confirmation Modal -->
<div id="delete-review-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <!-- Icon -->
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Delete Review
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete your review? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="delete-review-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                </form>
                <button type="button" id="cancel-delete" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
