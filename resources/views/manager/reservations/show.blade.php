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
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Page Header -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Reservation Details</h1>
                    <a href="{{ route('manager.reservations') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                        Back to List
                    </a>
                </div>

                <!-- Reservation Details -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <!-- Status Badge -->
                        <div class="mb-6">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full
                                {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                   ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                   ($reservation->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                   'bg-blue-100 text-blue-800')) }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </div>

                        <!-- Restaurant Information -->
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">Restaurant Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Name</p>
                                    <p class="text-base text-gray-900">{{ $reservation->restaurant->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Location</p>
                                    <p class="text-base text-gray-900">{{ $reservation->restaurant->address }}, {{ $reservation->restaurant->city }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">Customer Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Name</p>
                                    <p class="text-base text-gray-900">{{ $reservation->user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Email</p>
                                    <p class="text-base text-gray-900">{{ $reservation->user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Reservation Details -->
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">Reservation Details</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Date</p>
                                    <p class="text-base text-gray-900">{{ $reservation->booking_date->format('l, F j, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Time</p>
                                    <p class="text-base text-gray-900">
                                        {{ $reservation->booking_date->format('g:i A') }} - {{ $reservation->end_time->format('g:i A') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Number of Guests</p>
                                    <p class="text-base text-gray-900">{{ $reservation->guests_number }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Table</p>
                                    <p class="text-base text-gray-900">{{ $reservation->table->name }} (Capacity: {{ $reservation->table->capacity }})</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-sm text-gray-600">Special Requests</p>
                                    <p class="text-base text-gray-900">{{ $reservation->special_requests ?: 'None' }}</p>
                                </div>

                                @if($reservation->status === 'cancelled' && $reservation->decline_reason)
                                <div class="col-span-3">
                                    <p class="text-sm text-gray-600">Decline Reason</p>
                                    <p class="text-base text-gray-900">{{ $reservation->decline_reason }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex justify-end space-x-4">
                            @if($reservation->status === 'pending')
                                <form action="{{ route('manager.reservations.approve', $reservation->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                        Approve Reservation
                                    </button>
                                </form>
                                <button type="button"
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600"
                                    onclick="document.getElementById('decline-modal').classList.remove('hidden')">
                                    Decline Reservation
                                </button>
                            @endif
                            @if($reservation->status === 'confirmed')
                                <form action="{{ route('manager.reservations.complete', $reservation->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                        Mark as Completed
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Decline Modal -->
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
                                        placeholder="Please explain why this reservation is being declined..."
                                    ></textarea>
                                    <p class="text-xs text-gray-500 mt-1">
                                        This reason will be sent to the customer in the notification email.
                                    </p>
                                </div>
                                <div class="flex justify-end space-x-3">
                                    <button
                                        type="button"
                                        onclick="document.getElementById('decline-modal').classList.add('hidden')"
                                        class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600"
                                    >
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
