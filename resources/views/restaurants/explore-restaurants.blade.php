<x-app-layout>
    <x-header/>
    <!-- Hero Section -->
    <div class="relative">
        <div class="max-w-7xl mx-auto p-4">
            <div class="rounded-lg overflow-hidden">
                <div class="relative h-[600px] bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80');">
                    <div class="absolute inset-0 bg-black/50"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center p-6">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-4">
                            Restaurant Reservations <span class="text-yellow-400">Simplified</span>
                        </h1>
                        <p class="text-lg md:text-xl max-w-2xl mb-8">
                            Book tables at the best restaurants in your city with just a few clicks.
                            No phone calls, no waiting on hold.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('restaurants.index') }}" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md transition duration-300 text-lg">
                                Find Restaurants
                            </a>
                            <a href="{{ route('register.show') }}" class="px-6 py-3 bg-white hover:bg-gray-100 text-gray-900 font-semibold rounded-md transition duration-300 text-lg">
                                Create Account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Quick Search Section with Filters -->
    <div class="relative -mt-10 z-10 max-w-6xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-xl p-6">
            <form action="{{ route('restaurants.index') }}" method="GET">
                <!-- Basic Search Section -->
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Search</h2>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" id="date" name="date" class="w-full p-3 border border-gray-300 rounded-md" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="flex-1">
                            <label for="guests" class="block text-sm font-medium text-gray-700 mb-1">Party Size</label>
                            <select id="guests" name="guests" class="w-full p-3 border border-gray-300 rounded-md">
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Person' : 'People' }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="flex-1 md:flex-[2]">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" id="search" name="search" placeholder="Restaurant name or cuisine..." class="w-full p-3 border border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>

                <!-- Filter Options -->
                <div class="mt-4 mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-md font-medium text-gray-700">Advanced Filters</h3>
                        <button type="button" id="toggle-filters" class="text-sm text-yellow-600 font-medium flex items-center">
                            <span id="filter-text">Show Filters</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="filter-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>

                    <div id="filter-section" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3" style="display: none;">
                        <div>
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

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                            <select id="price" name="price" class="w-full p-3 border border-gray-300 rounded-md">
                                <option value="">Any Price</option>
                                <option value="$">$ (Budget)</option>
                                <option value="$$">$$ (Moderate)</option>
                                <option value="$$$">$$$ (Expensive)</option>
                                <option value="$$$$">$$$$ (Fine Dining)</option>
                            </select>
                        </div>

                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Minimum Rating</label>
                            <select id="rating" name="rating" class="w-full p-3 border border-gray-300 rounded-md">
                                <option value="">Any Rating</option>
                                <option value="3">3+ Stars</option>
                                <option value="4">4+ Stars</option>
                                <option value="4.5">4.5+ Stars</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="px-8 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-md transition duration-300">
                        Search Restaurants
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Restaurant Listings -->
    <div class="max-w-7xl mx-auto p-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Browse Our Restaurants</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Find your next favorite dining experience
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($restaurants as $restaurant)
                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="relative">
                        <a href="{{ route('restaurants.show', $restaurant->id) }}">
                            <img src="{{ $restaurant->cover_image ?? asset('images/placeholder-300x200.jpg') }}"
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

    <!-- CTA Section -->
    <div class="bg-yellow-500 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to Dine?</h2>
            <p class="text-white text-lg mb-8 max-w-2xl mx-auto">
                Create an account to save your favorite restaurants and track your reservations.
            </p>
            <a href="{{ route('register.show') }}" class="inline-block px-8 py-3 bg-white hover:bg-gray-50 text-yellow-600 font-semibold rounded-md transition duration-300 text-lg">
                Sign Up Now
            </a>
        </div>
    </div>

    <!-- JavaScript for filter toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggle-filters');
            const filterSection = document.getElementById('filter-section');
            const filterText = document.getElementById('filter-text');
            const filterIcon = document.getElementById('filter-icon');

            toggleButton.addEventListener('click', function() {
                if (filterSection.style.display === 'none') {
                    filterSection.style.display = 'grid';
                    filterText.textContent = 'Hide Filters';
                    filterIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />';
                } else {
                    filterSection.style.display = 'none';
                    filterText.textContent = 'Show Filters';
                    filterIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />';
                }
            });
        });
    </script>
</x-app-layout>
