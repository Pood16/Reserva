<x-app-layout>
    <x-header />
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <x-flash-messages />

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Favorite Restaurants</h1>
                <p class="mt-2 text-gray-600">Restaurants you've saved for future reference.</p>
            </div>

            @if($favorites->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($favorites as $restaurant)
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <div class="h-48 overflow-hidden">
                                <img
                                    src="{{ asset('storage/'.$restaurant->cover_image) }}"
                                    alt="{{ $restaurant->name }}"
                                    class="w-full h-full object-cover restaurant-image"
                                    data-fallback="{{ asset('images/restaurant-placeholder-300x200.jpg') }}"
                                >
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h2 class="text-xl font-semibold text-gray-900 hover:text-yellow-600">
                                        <a href="{{ route('restaurants.show', $restaurant->id) }}">{{ $restaurant->name }}</a>
                                    </h2>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span>{{ number_format($restaurant->reviews->avg('rating') ?? 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="flex items-center text-gray-600 text-sm mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ $restaurant->city }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        @if($restaurant->opening_time && $restaurant->closing_time)
                                            <span>{{ $restaurant->opening_time->format('g:i A') }} - {{ $restaurant->closing_time->format('g:i A') }}</span>
                                        @else
                                            <span>Hours not available</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('restaurants.show', $restaurant->id) }}"
                                       class="text-yellow-600 hover:text-yellow-700 font-medium text-sm">
                                        View Details
                                    </a>
                                    <button type="button"
                                            class="flex items-center text-red-500 hover:text-red-700 text-sm"
                                            onclick="openRemoveModal('{{ $restaurant->id }}', '{{ $restaurant->name }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $favorites->links() }}
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No favorites yet</h3>
                    <p class="text-gray-500 mb-4">You haven't added any restaurants to your favorites list.</p>
                    <a href="{{ route('restaurants.index') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse Restaurants
                    </a>
                </div>
            @endif
        </div>
    </div>
    <x-footer />

    <!-- Modal for confirming removal from favorites -->
    <div id="remove-favorite-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Remove from favorites?</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to remove <span id="restaurant-name" class="font-medium"></span> from your favorites?</p>
            <div class="flex justify-end space-x-4">
                <button type="button" id="cancel-remove" class="px-4 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors">
                    Cancel
                </button>
                <form id="remove-favorite-form" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg transition-colors">
                        Remove
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Modal
            const modal = document.getElementById('remove-favorite-modal');
            const cancelButton = document.getElementById('cancel-remove');

            cancelButton.addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            // Close modal
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });

        function openRemoveModal(restaurantId, restaurantName) {
            const modal = document.getElementById('remove-favorite-modal');
            const form = document.getElementById('remove-favorite-form');
            const nameElement = document.getElementById('restaurant-name');

            nameElement.textContent = restaurantName;
            form.action = '{{ route("favorites.destroy", "") }}/' + restaurantId;
            modal.classList.remove('hidden');
        }
    </script>
    @endpush
</x-app-layout>
