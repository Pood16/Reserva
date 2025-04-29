<x-app-layout>
    <x-header />
    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('client.reservations.index') }}" class="flex items-center text-sm text-gray-600 hover:text-yellow-600 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to My Reservations
                </a>
            </div>
            <!-- Flash Messages -->
            <x-flash-messages />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <h1 class="text-2xl font-bold text-gray-900">Reservation Details</h1>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                        {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-700' :
                           ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                           ($reservation->status === 'cancelled' ? 'bg-red-100 text-red-700' :
                           'bg-gray-100 text-gray-700')) }}">
                            {{ ucfirst($reservation->status) }}
                        </span>
                    </div>

                    <div class="mt-6">
                        <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 border-b border-gray-200">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900">{{ $reservation->restaurant->name }}</h2>
                                <div class="flex items-center mt-1">
                                    <svg class="w-4 h-4 text-gray-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ $reservation->restaurant->address }}</span>
                                </div>
                                <div class="flex items-center mt-1">
                                    <svg class="w-4 h-4 text-gray-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ $reservation->restaurant->phone }}</span>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="{{ route('restaurants.show', $reservation->restaurant_id) }}" class="inline-flex items-center px-4 py-2 bg-blue-100 border border-transparent rounded-md font-semibold text-xs text-blue-700 uppercase tracking-widest hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    View Restaurant
                                </a>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 rounded-lg p-5">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Reservation Information</h3>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500">Reference #</p>
                                        <p class="text-sm font-medium text-gray-900">{{ strtoupper(substr(md5($reservation->id), 0, 8)) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Table</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $reservation->table->name }}</p>
                                    </div>
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
                                        <p class="text-xs text-gray-500">Reserved On</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $reservation->created_at->format('M j, Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-5">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Table Information</h3>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500">Table Name</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $reservation->table->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Location</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $reservation->table->location ?? 'Not specified' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Capacity</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $reservation->table->capacity }} people</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($reservation->special_requests)
                            <div class="mt-6 bg-gray-50 rounded-lg p-5">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Special Requests</h3>
                                <p class="text-sm text-gray-700">{{ $reservation->special_requests }}</p>
                            </div>
                        @endif

                        @if(in_array($reservation->status, ['pending', 'confirmed']) && $reservation->booking_date > now())
                            <div class="mt-8 flex justify-end">
                                <form action="{{ route('client.reservations.cancel', $reservation->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-100 border border-transparent rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Cancel Reservation
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($reservation->status === 'confirmed' && $reservation->booking_date > now())
                <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Important Information</h2>

                        <div class="bg-blue-50 rounded-lg p-4 text-blue-700 text-sm">
                            <ul class="list-disc list-inside space-y-2">
                                <li>Please arrive 10 minutes before your reservation time.</li>
                                <li>If you need to cancel, please do so at least 2 hours in advance.</li>
                                <li>Your table will be held for up to 15 minutes after your reservation time.</li>
                                <li>For any questions, please contact the restaurant directly.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
