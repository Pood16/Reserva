<x-app-layout>
    <x-header />
    <div class="bg-gray-100 min-h-screen">
        <!-- Success message -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Reservation Confirmation Modal -->
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
        @endif

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
                        <button type="button" id="notification-close-button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Restaurant Header - Cover Image -->
        <div class="relative h-64 sm:h-80 md:h-96 w-full bg-gray-300">
            <img src="{{ $restaurant->cover_image ? asset($restaurant->cover_image) : asset('images/restaurant-placeholder-cover.jpg') }}"
                alt="{{ $restaurant->name }}" class="w-full h-full object-cover">
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black to-transparent p-4 md:p-6">
                <div class="max-w-7xl mx-auto">
                    <h1 class="text-white text-2xl md:text-4xl font-bold">{{ $restaurant->name }}</h1>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center text-white">
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

                        <!-- Favorite Button -->
                        @auth
                        <button id="favorite-button"
                                class="flex items-center bg-white bg-opacity-90 px-3 py-1.5 rounded-full shadow-sm transition duration-200 hover:bg-opacity-100"
                                data-restaurant-id="{{ $restaurant->id }}"
                                data-is-favorited="{{ $isFavorited ? 'true' : 'false' }}">
                            <svg id="favorite-icon" class="{{ $isFavorited ? 'text-red-500' : 'text-gray-400' }} w-5 h-5 mr-1.5 transition duration-200"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            <span id="favorite-text" class="text-sm font-medium {{ $isFavorited ? 'text-red-500' : 'text-gray-700' }}">
                                {{ $isFavorited ? 'Favorited' : 'Add to Favorites' }}
                            </span>
                        </button>
                        @else
                        <a href="{{ route('login.show') }}" class="flex items-center bg-white bg-opacity-90 px-3 py-1.5 rounded-full shadow-sm transition duration-200 hover:bg-opacity-100">
                            <svg class="text-gray-400 w-5 h-5 mr-1.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Add to Favorites</span>
                        </a>
                        @endauth
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9-3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                    <a href="{{ $restaurant->website }}" target="_blank" class="text-blue-600 hover:underline">{{ $restaurant->website }}</a>
                                </div>
                                @endif
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2">Opening Hours</h3>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    @php
                                        // Default days of the week
                                        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

                                        // Format time once for reuse
                                        $openTime = $restaurant->opening_time->format('g:i A');
                                        $closeTime = $restaurant->closing_time->format('g:i A');

                                        // Set default values for each day (closed by default)
                                        $schedule = array_fill_keys($weekDays, false);

                                        // Handle various formats that might be in the database
                                        if (!empty($restaurant->opening_days)) {
                                            if (is_array($restaurant->opening_days)) {
                                                // If it's already an array
                                                foreach ($restaurant->opening_days as $day) {
                                                    // Find matching day regardless of case
                                                    foreach ($weekDays as $weekDay) {
                                                        if (strtolower($day) === strtolower($weekDay)) {
                                                            $schedule[$weekDay] = true;
                                                            break;
                                                        }
                                                    }
                                                }
                                            } elseif (is_string($restaurant->opening_days)) {
                                                // If it's a string (comma-separated or JSON string)
                                                $daysList = explode(',', str_replace(['"', '[', ']', ' '], '', $restaurant->opening_days));
                                                foreach ($daysList as $day) {
                                                    // Find matching day regardless of case
                                                    foreach ($weekDays as $weekDay) {
                                                        if (strtolower($day) === strtolower($weekDay)) {
                                                            $schedule[$weekDay] = true;
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    @endphp

                                    <div class="border-b border-gray-200 pb-2 mb-2">
                                        <div class="text-gray-700 font-medium">Hours of Operation</div>
                                    </div>

                                    <table class="w-full">
                                        <tbody>
                                            @foreach($weekDays as $day)
                                                <tr class="border-b border-gray-100 last:border-0">
                                                    <td class="py-1.5 pr-2 text-gray-600 font-medium w-1/3">{{ $day }}</td>
                                                    <td class="py-1.5">
                                                        @if($schedule[$day])
                                                            <span class="text-gray-800">{{ $openTime }} - {{ $closeTime }}</span>
                                                        @else
                                                            <span class="text-gray-400">Closed</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

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
                                        max="{{ $restaurant->closing_time->subHours(2)->format('H:i') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        required>
                                    <p class="text-xs text-gray-500 mt-1">Available from {{ $restaurant->opening_time->format('g:i A') }} to {{ $restaurant->closing_time->subHours(2)->format('g:i A') }}</p>
                                    @error('booking_time')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                                    <input type="time" id="end_time" name="end_time"
                                        min="{{ $restaurant->opening_time->addHours(2)->format('H:i') }}"
                                        max="{{ $restaurant->closing_time->format('H:i') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                        required>
                                    <p class="text-xs text-gray-500 mt-1">Minimum 2-hour reservation</p>
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
    <x-footer />

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
                    showNotification('Error', `This table can only accommodate ${tableCapacity} guests. Please select a different table or reduce the number of guests.`, 'error');
                    tableSelect.value = '';
                }
            }
        }

        guestsSelect.addEventListener('change', validateCapacity);
        tableSelect.addEventListener('change', validateCapacity);

        // Ensure end time is after start time with a 2-hour minimum
        const bookingTimeInput = document.getElementById('booking_time');
        const endTimeInput = document.getElementById('end_time');

        function calculateEndTime() {
            if (bookingTimeInput.value) {
                // Parse the start time
                const [startHours, startMinutes] = bookingTimeInput.value.split(':').map(Number);

                // Calculate end time (start time + 2 hours)
                let endHours = startHours + 2;
                const endMinutes = startMinutes;

                // Format end time properly with leading zeros
                const formattedEndHours = endHours.toString().padStart(2, '0');
                const formattedEndMinutes = endMinutes.toString().padStart(2, '0');

                // Set the end time value
                endTimeInput.value = `${formattedEndHours}:${formattedEndMinutes}`;

                // Validate that the end time isn't past closing
                const maxTime = "{{ $restaurant->closing_time->format('H:i') }}";
                if (endTimeInput.value > maxTime) {
                    endTimeInput.value = maxTime;
                    showNotification('Error', `The restaurant closes at ${maxTime.split(':')[0]}:${maxTime.split(':')[1]}. Your end time has been adjusted accordingly.`, 'error');
                }
            }
        }

        function validateTimeRange() {
            if (bookingTimeInput.value && endTimeInput.value) {
                // Calculate time difference in minutes
                const [startHours, startMinutes] = bookingTimeInput.value.split(':').map(Number);
                const [endHours, endMinutes] = endTimeInput.value.split(':').map(Number);

                const startTotalMinutes = (startHours * 60) + startMinutes;
                const endTotalMinutes = (endHours * 60) + endMinutes;
                const diffMinutes = endTotalMinutes - startTotalMinutes;

                if (diffMinutes <= 0) {
                    showNotification('Error', 'End time must be after start time', 'error');
                    calculateEndTime(); // Reset to valid end time
                    return false;
                }

                if (diffMinutes < 120) {
                    showNotification('Error', 'Reservation must be at least 2 hours long', 'error');
                    calculateEndTime(); // Reset to valid end time
                    return false;
                }
            }
            return true;
        }

        // Set up event listeners
        bookingTimeInput.addEventListener('change', function() {
            calculateEndTime();
        });

        endTimeInput.addEventListener('change', validateTimeRange);

        // Reservation confirmation modal functionality
        const closeModalButton = document.getElementById('close-modal-button');
        const downloadDetailsButton = document.getElementById('download-details-button');
        const reservationModal = document.getElementById('reservation-confirmation-modal');

        if (closeModalButton) {
            closeModalButton.addEventListener('click', function() {
                reservationModal.classList.add('hidden');
            });
        }

        if (downloadDetailsButton) {
            downloadDetailsButton.addEventListener('click', function(e) {
                e.preventDefault();

                // Create content for download
                const restaurantName = "{{ session('reservation_details.restaurant_name') }}";
                const bookingDate = "{{ session('reservation_details.booking_date') }}";
                const bookingTime = "{{ session('reservation_details.booking_time') }}";
                const endTime = "{{ session('reservation_details.end_time') }}";
                const tableName = "{{ session('reservation_details.table_name') }}";
                const tableLocation = "{{ session('reservation_details.table_location') }}";
                const guestsNumber = "{{ session('reservation_details.guests_number') }}";
                const status = "{{ session('reservation_details.status') }}";
                const reference = "{{ session('reservation_details.reference_number') }}";
                const specialRequests = "{{ session('reservation_details.special_requests') }}";

                let content = "RESERVATION DETAILS\n\n";
                content += `Restaurant: ${restaurantName}\n`;
                content += `Date: ${bookingDate}\n`;
                content += `Time: ${bookingTime} - ${endTime}\n`;
                content += `Table: ${tableName} (${tableLocation})\n`;
                content += `Guests: ${guestsNumber}\n`;
                content += `Status: ${status}\n`;
                content += `Reference Number: ${reference}\n`;

                if (specialRequests) {
                    content += `\nSpecial Requests: ${specialRequests}\n`;
                }

                content += "\nThank you for choosing our service!";

                // Create a downloadable file
                const element = document.createElement('a');
                element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(content));
                element.setAttribute('download', `reservation-${reference}.txt`);
                element.style.display = 'none';

                document.body.appendChild(element);
                element.click();
                document.body.removeChild(element);
            });
        }

        // Favorite button functionality
        const favoriteButton = document.getElementById('favorite-button');
        if (favoriteButton) {
            favoriteButton.addEventListener('click', function() {
                const restaurantId = this.dataset.restaurantId;
                const isFavorited = this.dataset.isFavorited === 'true';
                const favoriteIcon = document.getElementById('favorite-icon');
                const favoriteText = document.getElementById('favorite-text');

                // Send AJAX request to toggle favorite status
                fetch(`/restaurants/${restaurantId}/favorite`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update the button's appearance based on the new favorite status
                    if (data.isFavorited) {
                        favoriteIcon.classList.remove('text-gray-400');
                        favoriteIcon.classList.add('text-red-500');
                        favoriteText.classList.remove('text-gray-700');
                        favoriteText.classList.add('text-red-500');
                        favoriteText.textContent = 'Favorited';
                        favoriteButton.dataset.isFavorited = 'true';
                    } else {
                        favoriteIcon.classList.remove('text-red-500');
                        favoriteIcon.classList.add('text-gray-400');
                        favoriteText.classList.remove('text-red-500');
                        favoriteText.classList.add('text-gray-700');
                        favoriteText.textContent = 'Add to Favorites';
                        favoriteButton.dataset.isFavorited = 'false';
                    }

                    // Show a temporary success message
                    showNotification('Success', data.message, 'success');
                })
                .catch(error => {
                    console.error('Error:', error);

                    // Show error message
                    showNotification('Error', 'An error occurred. Please try again.', 'error');
                });
            });
        }

        // Custom notification popup functionality
        const notificationPopup = document.getElementById('notification-popup');
        const notificationTitle = document.getElementById('notification-title');
        const notificationMessage = document.getElementById('notification-message');
        const notificationIcon = document.getElementById('notification-icon');
        const notificationCloseButton = document.getElementById('notification-close-button');

        function showNotification(title, message, type) {
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
                notificationIcon.classList.add('bg-yellow-100');
                notificationIcon.innerHTML = '<svg class="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"></path></svg>';
            }

            notificationPopup.classList.remove('hidden');
        }

        notificationCloseButton.addEventListener('click', function() {
            notificationPopup.classList.add('hidden');
        });
    });
</script>
@endpush


</x-app-layout>
