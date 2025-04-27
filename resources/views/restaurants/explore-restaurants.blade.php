<x-app-layout>
    <x-header />
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Hero Section -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Discover Amazing Restaurants</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Find your next culinary adventure with our curated selection of the finest restaurants</p>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Side Search with Filters - Collapsible on Mobile -->
            <div class="w-full lg:w-80 shrink-0">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-4">
                    <!-- Mobile Toggle -->
                    <button id="filter-toggle" class="w-full flex justify-between items-center p-4 lg:hidden text-left font-medium text-gray-800">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filters & Search
                        </span>
                        <svg id="filter-arrow" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Filter Content -->
                    <div id="filter-content" class="p-5 border-t border-gray-100 lg:border-t-0 hidden lg:block">
                        <form action="{{ route('restaurants.index') }}" method="GET" class="space-y-6">
                            <!-- Search Section -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="search" name="search" placeholder="Restaurant or cuisine..."
                                        class="pl-10 w-full p-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                                </div>
                            </div>

                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="date" id="date" name="date" class="pl-10 w-full p-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-yellow-500 focus:border-yellow-500" min="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div>
                                <label for="guests" class="block text-sm font-medium text-gray-700 mb-1">Party Size</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <select id="guests" name="guests" class="pl-10 w-full p-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 appearance-none">
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Person' : 'People' }}</option>
                                        @endfor
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4">
                                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Filters</h3>

                                <div class="space-y-4">
                                    <div>
                                        <label for="cuisine" class="block text-sm font-medium text-gray-700 mb-1">Cuisine Type</label>
                                        <div class="relative">
                                            <select id="cuisine" name="cuisine" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 appearance-none">
                                                <option value="">All Cuisines</option>
                                                <option value="italian">Italian</option>
                                                <option value="chinese">Chinese</option>
                                                <option value="indian">Indian</option>
                                                <option value="mexican">Mexican</option>
                                                <option value="japanese">Japanese</option>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                                        <div class="relative">
                                            <select id="price" name="price" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 appearance-none">
                                                <option value="">Any Price</option>
                                                <option value="$">$ (Budget)</option>
                                                <option value="$$">$$ (Moderate)</option>
                                                <option value="$$$">$$$ (Expensive)</option>
                                                <option value="$$$$">$$$$ (Fine Dining)</option>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Minimum Rating</label>
                                        <div class="flex space-x-1">
                                            <label class="rating-option">
                                                <input type="radio" name="rating" value="" class="sr-only" checked>
                                                <span class="px-3 py-2 rounded-lg text-sm bg-gray-50 border border-gray-200 hover:bg-gray-100 cursor-pointer flex-1 text-center">Any</span>
                                            </label>
                                            <label class="rating-option">
                                                <input type="radio" name="rating" value="3" class="sr-only">
                                                <span class="px-3 py-2 rounded-lg text-sm bg-gray-50 border border-gray-200 hover:bg-gray-100 cursor-pointer flex-1 text-center">3+</span>
                                            </label>
                                            <label class="rating-option">
                                                <input type="radio" name="rating" value="4" class="sr-only">
                                                <span class="px-3 py-2 rounded-lg text-sm bg-gray-50 border border-gray-200 hover:bg-gray-100 cursor-pointer flex-1 text-center">4+</span>
                                            </label>
                                            <label class="rating-option">
                                                <input type="radio" name="rating" value="4.5" class="sr-only">
                                                <span class="px-3 py-2 rounded-lg text-sm bg-gray-50 border border-gray-200 hover:bg-gray-100 cursor-pointer flex-1 text-center">4.5+</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full px-4 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-300 flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Find Restaurants
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Restaurant Listings -->
            <div class="flex-1">
                <!-- Chips for active filters (optional) -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">
                        <span>Italian</span>
                        <button class="ml-1 text-yellow-600 hover:text-yellow-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Sorting options -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Featured Restaurants</h2>
                    <div class="relative">
                        <select class="appearance-none bg-gray-50 border border-gray-200 text-gray-700 py-2 px-3 pr-8 rounded-lg focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 text-sm">
                            <option>Sort by: Recommended</option>
                            <option>Rating: High to Low</option>
                            <option>Rating: Low to High</option>
                            <option>Name: A to Z</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Results Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($restaurants as $restaurant)
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 flex flex-col h-full">
                            <div class="relative">
                                <a href="{{ route('restaurants.show', $restaurant->id) }}">
                                    <img src="{{ asset('storage/'.$restaurant->cover_image) ?? asset('images/placeholder-300x200.jpg') }}"
                                         alt="{{ $restaurant->name }}"
                                         class="w-full h-48 object-cover"
                                         onerror="this.src='{{ asset('images/restaurant-placeholder-300x200.jpg') }}'; this.onerror='';">
                                </a>
                                <div class="absolute top-3 right-3 bg-white text-yellow-600 text-sm font-bold px-2 py-1 rounded-lg shadow-sm flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    {{ number_format($restaurant->reviews->avg('rating') ?? 4.5, 1) }}
                                </div>
                            </div>
                            <div class="p-4 flex-1 flex flex-col">
                                <div class="mb-2 flex-1">
                                    <a href="{{ route('restaurants.show', $restaurant->id) }}" class="font-bold text-lg text-gray-900 hover:text-yellow-600 transition duration-200">{{ $restaurant->name }}</a>
                                    <div class="flex items-center mt-1 text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $restaurant->city }}
                                    </div>
                                    <p class="text-sm text-gray-500 mt-2">{{ Str::limit($restaurant->description, 100) }}</p>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                                    <div class="text-xs text-gray-500">
                                        <span class="text-yellow-500 font-semibold">$$</span> • Italian
                                    </div>
                                    <a href="{{ route('restaurants.show', $restaurant->id) }}" class="inline-flex items-center text-sm font-medium text-yellow-600 hover:text-yellow-800">
                                        Reserve
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for filter toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterToggle = document.getElementById('filter-toggle');
            const filterContent = document.getElementById('filter-content');
            const filterArrow = document.getElementById('filter-arrow');

            filterToggle.addEventListener('click', function() {
                filterContent.classList.toggle('hidden');
                filterArrow.classList.toggle('rotate-180');
            });

            // Rating option selection styling
            const ratingOptions = document.querySelectorAll('.rating-option input');
            ratingOptions.forEach(option => {
                option.addEventListener('change', function() {
                    document.querySelectorAll('.rating-option span').forEach(span => {
                        span.classList.remove('bg-yellow-100', 'border-yellow-300', 'text-yellow-800');
                        span.classList.add('bg-gray-50', 'border-gray-200');
                    });

                    if (this.checked) {
                        this.parentElement.querySelector('span').classList.remove('bg-gray-50', 'border-gray-200');
                        this.parentElement.querySelector('span').classList.add('bg-yellow-100', 'border-yellow-300', 'text-yellow-800');
                    }
                });
            });
        });
    </script>

    <x-footer />
</x-app-layout>
