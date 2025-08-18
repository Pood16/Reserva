<x-app-layout>
    <x-header />
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- header -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Discover Amazing Restaurants</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">Find your next adventure with our curated selection of the finest restaurants</p>

            <!-- search + filters -->
            <div class="max-w-3xl mx-auto">
                <form action="{{ route('restaurants.index') }}" method="GET" class="flex flex-col md:flex-row gap-2 md:gap-4 items-center justify-center">
                    <input type="text" name="search" placeholder="Search restaurants..."
                        class="flex-1 p-4 pl-12 bg-white border border-gray-200 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 shadow-sm"
                        value="{{ request('search') }}">
                    <select name="city" class="p-4 bg-white border border-gray-200 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 shadow-sm">
                        <option value="">All Cities</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                    <select name="food_type" class="p-4 bg-white border border-gray-200 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 shadow-sm">
                        <option value="">All Food Types</option>
                        @foreach($foodTypes as $foodType)
                            <option value="{{ $foodType->id }}" {{ request('food_type') == $foodType->id ? 'selected' : '' }}>{{ $foodType->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-6 py-4 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition duration-300">
                        Search
                    </button>
                </form>
            </div>
        </div>
        <!-- Main Content -->
        <div class="flex flex-col gap-8">
            <!-- Restaurant Listings -->
            <div class="flex-1">
                <!-- Active Filters -->
                @if(request()->hasAny(['search', 'city', 'food_type']))
                    <div class="flex flex-wrap gap-2 mb-6 justify-center">
                        @if(request('search'))
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">
                                <span>Search: {{ request('search') }}</span>
                                <a href="{{ route('restaurants.index', request()->except('search')) }}"
                                   class="ml-1 text-yellow-600 hover:text-yellow-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                        @if(request('city'))
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">
                                <span>City: {{ request('city') }}</span>
                                <a href="{{ route('restaurants.index', request()->except('city')) }}"
                                   class="ml-1 text-yellow-600 hover:text-yellow-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                        @if(request('food_type'))
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">
                                <span>Food Type: {{ optional($foodTypes->firstWhere('id', request('food_type')))->name }}</span>
                                <a href="{{ route('restaurants.index', request()->except('food_type')) }}"
                                   class="ml-1 text-yellow-600 hover:text-yellow-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Results Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($restaurants as $restaurant)
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                            <div class="relative">
                                <a href="{{ route('restaurants.show', $restaurant) }}">
                                    <img src="{{ asset('storage/'.$restaurant->cover_image) ?? asset('images/placeholder-300x200.jpg') }}"
                                         alt="{{ $restaurant->name }}"
                                         class="w-full h-48 object-cover"
                                         loading="lazy"
                                         onerror="this.src='{{ asset('images/restaurant-placeholder-300x200.jpg') }}'; this.onerror='';">
                                </a>
                                <div class="absolute top-3 right-3 bg-white text-yellow-600 text-sm font-bold px-2 py-1 rounded-lg shadow-sm flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    {{ number_format($restaurant->reviews->avg('rating') ?? 0.0, 1) }}
                                </div>
                            </div>
                            <div class="p-4">
                                <a href="{{ route('restaurants.show', $restaurant) }}" class="font-bold text-lg text-gray-900 hover:text-yellow-600 transition duration-200">{{ $restaurant->name }}</a>
                                <div class="flex items-center mt-1 text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $restaurant->city }}
                                </div>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach($restaurant->foodTypes as $foodType)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $foodType->name }}</span>
                                    @endforeach
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    <div class="text-sm text-gray-500">
                                        <span class="text-yellow-500 font-semibold">{{ str_repeat('$', $restaurant->price_range ?? 2) }}</span>
                                    </div>
                                    <a href="{{ route('restaurants.show', $restaurant) }}"
                                       class="inline-flex items-center text-sm font-medium text-yellow-600 hover:text-yellow-800">
                                        View Details
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
            <!-- Popular Restaurants Section -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Popular Restaurants</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($popularRestaurants as $restaurant)
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100">
                            <div class="relative">
                                <a href="{{ route('restaurants.show', $restaurant) }}">
                                    <img src="{{ asset('storage/'.$restaurant->cover_image) ?? asset('images/placeholder-300x200.jpg') }}"
                                         alt="{{ $restaurant->name }}"
                                         class="w-full h-48 object-cover"
                                         loading="lazy"
                                         onerror="this.src='{{ asset('images/restaurant-placeholder-300x200.jpg') }}'; this.onerror='';">
                                </a>
                                <div class="absolute top-3 right-3 bg-white text-yellow-600 text-sm font-bold px-2 py-1 rounded-lg shadow-sm flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    {{ number_format($restaurant->reviews->avg('rating') ?? 4.5, 1) }}
                                </div>
                            </div>
                            <div class="p-4">
                                <a href="{{ route('restaurants.show', $restaurant) }}" class="font-bold text-lg text-gray-900 hover:text-yellow-600 transition duration-200">{{ $restaurant->name }}</a>
                                <div class="flex items-center mt-1 text-sm text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $restaurant->city }}
                                </div>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach($restaurant->foodTypes as $foodType)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">{{ $foodType->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <x-footer />
</x-app-layout>
