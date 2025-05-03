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
                <x-flash-messages />

                <!-- Page Header -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Reservations Management</h1>
                </div>

                <!-- Reservations Table -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Restaurant
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Customer
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Table
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date & Time
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Guests
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($reservations as $reservation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $reservation->restaurant->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $reservation->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $reservation->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $reservation->table->name }}</div>
                                            <div class="text-sm text-gray-500">Capacity: {{ $reservation->table->capacity }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $reservation->booking_date->format('M j, Y') }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $reservation->booking_date->format('g:i A') }} - {{ $reservation->end_time->format('g:i A') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $reservation->guests_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                                   ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                   ($reservation->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                                   'bg-blue-100 text-blue-800')) }}">
                                                {{ ucfirst($reservation->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ url('manager/reservations/' . $reservation->id) }}"
                                                   class="inline-flex items-center px-2.5 py-1.5 border border-purple-300 shadow-sm text-xs font-medium rounded text-purple-700 bg-purple-50 hover:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    View
                                                </a>

                                                @if($reservation->status === 'pending')
                                                    <form action="{{ route('manager.reservations.approve', $reservation->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                                class="inline-flex items-center px-2.5 py-1.5 border border-emerald-300 shadow-sm text-xs font-medium rounded text-emerald-700 bg-emerald-50 hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Approve
                                                        </button>
                                                    </form>

                                                    <button type="button"
                                                            onclick="openDeclineModal({{ $reservation->id }})"
                                                            class="inline-flex items-center px-2.5 py-1.5 border border-rose-300 shadow-sm text-xs font-medium rounded text-rose-700 bg-rose-50 hover:bg-rose-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        Decline
                                                    </button>
                                                @endif

                                                @if($reservation->status === 'confirmed')
                                                    <form action="{{ route('manager.reservations.complete', $reservation->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                                class="inline-flex items-center px-2.5 py-1.5 border border-amber-300 shadow-sm text-xs font-medium rounded text-amber-700 bg-amber-50 hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Complete
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No reservations found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Decline Modal -->
                <div id="decline-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Decline Reservation</h3>
                            <form id="decline-form" action="" method="POST" class="mt-2">
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
                                        onclick="closeDeclineModal()"
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

    @push('scripts')
    <script src="{{ asset('resources/js/manager/toggleNav.js') }}"></script>

    <script>
        function openDeclineModal(reservationId) {
            const modal = document.getElementById('decline-modal');
            const form = document.getElementById('decline-form');

            form.action = "{{ url('manager/reservations') }}/" + reservationId + "/decline";
            modal.classList.remove('hidden');
        }

        function closeDeclineModal() {
            const modal = document.getElementById('decline-modal');
            modal.classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>
