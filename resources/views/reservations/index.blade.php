<x-app-layout>
    <x-header/>
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">My Reservations</h1>

        @if($reservations->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-gray-600 text-lg">You have no reservations yet.</p>
                <a href="{{ route('restaurants.index') }}" class="mt-6 inline-block px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md transition duration-300">Book a Table</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Restaurant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guests</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                            <tr class="border-b">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('restaurants.show', $reservation->restaurant->id) }}" class="text-yellow-600 hover:underline font-semibold">
                                        {{ $reservation->restaurant->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->booking_date->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->booking_date->format('H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->guests_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 rounded text-xs font-semibold {{
                                        $reservation->status === 'confirmed' ? 'bg-green-100 text-green-700' :
                                        ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                        ($reservation->status === 'cancelled' ? 'bg-red-100 text-red-700' :
                                        'bg-gray-100 text-gray-700'))
                                    }}">
                                        {{ ucfirst($reservation->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('reservations.show', $reservation->id) }}" class="text-blue-600 hover:underline text-sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
