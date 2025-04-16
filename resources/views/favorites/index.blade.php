<x-app-layout>
    <x-header/>
    <div class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">My Favorite Restaurants</h1>

        @if($favorites->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-gray-600 text-lg">You have not added any favorite restaurants yet.</p>
                <a href="{{ route('restaurants.index') }}" class="mt-6 inline-block px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md transition duration-300">Find Restaurants</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($favorites as $restaurant)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col">
                        <a href="{{ route('restaurants.show', $restaurant->id) }}">
                            <img src="{{ $restaurant->cover_image ?? asset('images/placeholder-300x200.jpg') }}"
                                 alt="{{ $restaurant->name }}"
                                 class="w-full h-48 object-cover"
                                 onerror="this.src='{{ asset('images/restaurant-placeholder-300x200.jpg') }}'; this.onerror='';">
                        </a>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <a href="{{ route('restaurants.show', $restaurant->id) }}" class="font-medium text-lg text-gray-900 hover:text-yellow-600 transition duration-200">{{ $restaurant->name }}</a>
                                <p class="text-sm text-gray-600 mt-1">{{ $restaurant->city }}</p>
                                <p class="text-sm text-gray-500 mt-2">{{ Str::limit($restaurant->description, 80) }}</p>
                            </div>
                            <form action="{{ route('favorites.destroy', $restaurant->id) }}" method="POST" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm font-medium transition">Remove</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
