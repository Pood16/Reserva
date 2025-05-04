<x-app-layout>
    <div class="flex">
        <x-admin-manager-nav />

        <div class="flex flex-col flex-1 lg:ml-64">
            <x-dashboard-header />

            <main class="flex-1 overflow-y-auto p-6">
                <x-flash-messages />

                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center space-x-2">
                        <h1 class="text-xl font-semibold text-gray-800">Reservation #00{{$reservation->id}}</h1>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                            {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                               ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                               ($reservation->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                               'bg-blue-100 text-blue-800')) }}">
                            {{ ucfirst($reservation->status) }}
                        </span>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('manager.reservations') }}" class="bg-gray-500 text-white px-3 py-1 text-sm rounded hover:bg-gray-600 flex items-center">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </a>
                        <button onclick="window.print()" class="bg-blue-500 text-white px-3 py-1 text-sm rounded hover:bg-blue-600 flex items-center">
                            <i class="fas fa-print mr-1"></i> Print
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-1">
                        <div class="bg-white rounded-lg shadow-md mb-4 overflow-hidden border-t-4 border-blue-500">
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h2 class="text-md font-semibold text-gray-800">Customer</h2>
                                    <i class="fas fa-user text-blue-500"></i>
                                </div>
                                <div class="space-y-2">
                                    <div>
                                        <p class="text-xs text-gray-500">Name</p>
                                        <p class="text-sm font-medium">{{ $reservation->user->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Email</p>
                                        <p class="text-sm">{{ $reservation->user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-amber-500">
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h2 class="text-md font-semibold text-gray-800">Date & Time</h2>
                                    <i class="far fa-calendar-alt text-amber-500"></i>
                                </div>
                                <div class="space-y-2">
                                    <div>
                                        <p class="text-xs text-gray-500">Date</p>
                                        <p class="text-sm font-medium">{{ $reservation->booking_date->format('l, F j, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Time</p>
                                        <p class="text-sm font-medium">{{ $reservation->booking_date->format('g:i A') }} - {{ $reservation->end_time->format('g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="bg-white rounded-lg shadow-md mb-4 overflow-hidden border-t-4 border-green-500">
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h2 class="text-md font-semibold text-gray-800">Restaurant Information</h2>
                                    <i class="fas fa-utensils text-green-500"></i>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500">Name</p>
                                        <p class="text-sm font-medium">{{ $reservation->restaurant->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Location</p>
                                        <p class="text-sm">{{ $reservation->restaurant->address }}, {{ $reservation->restaurant->city }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-md mb-4 overflow-hidden border-t-4 border-purple-500">
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h2 class="text-md font-semibold text-gray-800">Reservation Details</h2>
                                    <i class="fas fa-clipboard-list text-purple-500"></i>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500">Guests</p>
                                        <div class="flex items-center mt-1">
                                            <i class="fas fa-users text-gray-400 mr-1"></i>
                                            <p class="text-sm font-medium">{{ $reservation->guests_number }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Table</p>
                                        <div class="flex items-center mt-1">
                                            <i class="fas fa-chair text-gray-400 mr-1"></i>
                                            <p class="text-sm font-medium">{{ $reservation->table->name }} (Cap: {{ $reservation->table->capacity }})</p>
                                        </div>
                                    </div>
                                </div>

                                @if($reservation->special_requests)
                                <div class="mt-3">
                                    <p class="text-xs text-gray-500">Special Requests</p>
                                    <p class="text-sm mt-1 p-2 bg-gray-50 rounded border border-gray-200">{{ $reservation->special_requests }}</p>
                                </div>
                                @endif

                                @if($reservation->status === 'cancelled' && $reservation->decline_reason)
                                <div class="mt-3">
                                    <p class="text-xs text-gray-500">Decline Reason</p>
                                    <p class="text-sm mt-1 p-2 bg-red-50 text-red-700 rounded border border-red-200">{{ $reservation->decline_reason }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white rounded-lg shadow-md overflow-hidden border-t-4 border-gray-500">
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h2 class="text-md font-semibold text-gray-800">Management Actions</h2>
                                    <i class="fas fa-cogs text-gray-500"></i>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-500">
                                        <p>Current status: <span class="font-semibold">{{ ucfirst($reservation->status) }}</span></p>
                                        <p class="text-xs mt-1">Last updated: {{ $reservation->updated_at->format('M j, Y g:i A') }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        @if($reservation->status === 'pending')
                                            <form action="{{ route('manager.reservations.approve', $reservation->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="bg-green-500 text-white px-3 py-1 text-sm rounded hover:bg-green-600">
                                                    <i class="fas fa-check mr-1"></i> Approve
                                                </button>
                                            </form>
                                            <button type="button"
                                                class="bg-red-500 text-white px-3 py-1 text-sm rounded hover:bg-red-600"
                                                onclick="document.getElementById('decline-modal').classList.remove('hidden')">
                                                <i class="fas fa-times mr-1"></i> Decline
                                            </button>
                                        @endif
                                        @if($reservation->status === 'confirmed')
                                            <form action="{{ route('manager.reservations.complete', $reservation->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="bg-blue-500 text-white px-3 py-1 text-sm rounded hover:bg-blue-600">
                                                    <i class="fas fa-check-circle mr-1"></i> Complete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="decline-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Decline Reservation</h3>
                            <form action="{{ route('manager.reservations.decline', $reservation->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Reason for Declining</label>
                                    <textarea
                                        name="reason"
                                        id="reason"
                                        rows="4"
                                        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:border-amber-500 focus:ring-amber-500"
                                        required
                                        placeholder="Please explain why this reservation is being declined..."></textarea>
                                    <p class="text-xs text-gray-500 mt-1">
                                        This reason will be sent to the customer in the notification email.
                                    </p>
                                </div>
                                <div class="flex justify-end space-x-3">
                                    <button
                                        type="button"
                                        onclick="document.getElementById('decline-modal').classList.add('hidden')"
                                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                        Decline
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>


<script src="{{ asset('resources/js/manager/toggleNav.js') }}"></script>
