<x-app-layout>
    <x-header />
    <div class="max-w-7xl mx-auto p-4">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Side Search with Filters -->
            <div class="w-full md:w-80 shrink-0">
                <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Find Restaurants</h2>

                    <form action="{{ route('restaurants.index') }}" method="GET">
                        <!-- Search Section -->
                        <div class="mb-4">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" id="search" name="search" placeholder="Restaurant name or cuisine..." class="w-full p-3 border border-gray-300 rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" id="date" name="date" class="w-full p-3 border border-gray-300 rounded-md" min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="mb-4">
                            <label for="guests" class="block text-sm font-medium text-gray-700 mb-1">Party Size</label>
                            <select id="guests" name="guests" class="w-full p-3 border border-gray-300 rounded-md">
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Person' : 'People' }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="border-t border-gray-200 my-4 pt-4">
                            <h3 class="text-md font-medium text-gray-700 mb-3">Filters</h3>

                            <div class="mb-4">
                                <label for="cuisine" class="block text-sm font-medium text-gray-700 mb-1">Cuisine Type</label>
                                <select id="cuisine" name="cuisine" class="w-full p-3 border border-gray-300 rounded-md">
                                    <option value="">All Cuisines</option>
                                    <option value="italian">Italian</option>
                                    <option value="chinese">Chinese</option>
                                    <option value="indian">Indian</option>
                                    <option value="mexican">Mexican</option>
                                    <option value="japanese">Japanese</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                                <select id="price" name="price" class="w-full p-3 border border-gray-300 rounded-md">
                                    <option value="">Any Price</option>
                                    <option value="$">$ (Budget)</option>
                                    <option value="$$">$$ (Moderate)</option>
                                    <option value="$$$">$$$ (Expensive)</option>
                                    <option value="$$$$">$$$$ (Fine Dining)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Minimum Rating</label>
                                <select id="rating" name="rating" class="w-full p-3 border border-gray-300 rounded-md">
                                    <option value="">Any Rating</option>
                                    <option value="3">3+ Stars</option>
                                    <option value="4">4+ Stars</option>
                                    <option value="4.5">4.5+ Stars</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="w-full px-4 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md transition duration-300">
                            Search Restaurants
                        </button>
                    </form>
                </div>
            </div>

            <!-- Restaurant Listings -->
            <div class="flex-1">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Our Restaurants</h1>
                    <p class="text-gray-600 mt-2">Find your next favorite dining experience</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($restaurants as $restaurant)
                        <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="relative">
                                <a href="{{ route('restaurants.show', $restaurant->id) }}">
                                    <img src="{{ asset('storage/'.$restaurant->cover_image) ?? asset('images/placeholder-300x200.jpg') }}"
                                         alt="{{ $restaurant->name }}"
                                         class="w-full h-48 object-cover"
                                         onerror="this.src='{{ asset('images/restaurant-placeholder-300x200.jpg') }}'; this.onerror='';">
                                </a>
                                <div class="absolute top-3 right-3 bg-green-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    {{ number_format($restaurant->reviews->avg('rating') ?? 4.5, 1) }}
                                </div>
                            </div>
                            <div class="p-4">
                                <a href="{{ route('restaurants.show', $restaurant->id) }}" class="font-medium text-lg text-gray-900 hover:text-yellow-600 transition duration-200">{{ $restaurant->name }}</a>
                                <p class="text-sm text-gray-600 mt-1">{{ $restaurant->city }}</p>
                                <p class="text-sm text-gray-500 mt-2">{{ Str::limit($restaurant->description, 80) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <x-footer />
</x-app-layout>
