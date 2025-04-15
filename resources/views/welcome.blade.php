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

    <!-- Quick Search Section -->
    <div class="relative -mt-10 z-10 max-w-5xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-xl p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Quick Search</h2>
            <form action="{{ route('restaurants.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="date" name="date" class="w-full p-3 border border-gray-300 rounded-md" min="{{ date('Y-m-d') }}">
                </div>
                <div class="flex-1">
                    <select name="guests" class="w-full p-3 border border-gray-300 rounded-md">
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Person' : 'People' }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex-1 md:flex-[2]">
                    <input type="text" name="search" placeholder="Restaurant name or cuisine..." class="w-full p-3 border border-gray-300 rounded-md">
                </div>
                <div>
                    <button type="submit" class="w-full p-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md transition duration-300">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="max-w-7xl mx-auto p-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">How QuickTable Works</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Our platform connects diners with restaurants for a seamless booking experience
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="bg-white p-8 rounded-lg shadow-md text-center">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Search</h3>
                <p class="text-gray-600">Explore restaurants by location, cuisine, or availability to find your perfect dining spot.</p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white p-8 rounded-lg shadow-md text-center">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Book</h3>
                <p class="text-gray-600">Reserve your table in seconds by selecting the date, time, and number of guests.</p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white p-8 rounded-lg shadow-md text-center">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Enjoy</h3>
                <p class="text-gray-600">Receive instant confirmation and enjoy your meal with a guaranteed table waiting for you.</p>
            </div>
        </div>
    </div>

    <!-- Benefits Sections -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto p-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Benefits For Everyone</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    QuickTable provides value for both diners and restaurant owners
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-16">
                <!-- For Diners -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        For Diners
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">24/7 Online Reservations</h4>
                                <p class="text-gray-600">Book tables any time, day or night, without calling the restaurant.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Discover New Restaurants</h4>
                                <p class="text-gray-600">Find new dining experiences through our curated recommendations.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Special Offers</h4>
                                <p class="text-gray-600">Get exclusive deals and discounts from participating restaurants.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Save Your Favorites</h4>
                                <p class="text-gray-600">Create a collection of your favorite restaurants for easy access.</p>
                            </div>
                        </li>
                    </ul>
                    <div class="mt-8 text-center">
                        <a href="{{ route('register.show') }}" class="inline-block px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md transition duration-300">
                            Sign Up as a Diner
                        </a>
                    </div>
                </div>

                <!-- For Restaurant Owners -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        For Restaurant Managers
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Table Management</h4>
                                <p class="text-gray-600">Easily manage your restaurant's tables and availability in real-time.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Reservation Tracking</h4>
                                <p class="text-gray-600">Track and manage all reservations from a single dashboard.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Reduced No-Shows</h4>
                                <p class="text-gray-600">Automated reminders help decrease the number of missed reservations.</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mt-1 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900">Increased Visibility</h4>
                                <p class="text-gray-600">Reach more diners and fill empty tables through our platform.</p>
                            </div>
                        </li>
                    </ul>
                    <div class="mt-8 text-center">
                        <a href="{{ route('register.show') }}" class="inline-block px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md transition duration-300">
                            Register Your Restaurant
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Restaurants Section -->
    <div class="max-w-7xl mx-auto p-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Featured Restaurants</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Discover some of our top-rated dining establishments
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($restaurants->take(4) as $restaurant)
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

        <div class="text-center mt-10">
            <a href="{{ route('restaurants.index') }}" class="inline-block px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md transition duration-300">
                View All Restaurants
            </a>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto p-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">What Our Users Say</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Hear from our satisfied diners and restaurant partners
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="mr-4">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="rounded-full w-14 h-14 object-cover">
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Michael Johnson</h4>
                            <div class="flex text-yellow-400 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "QuickTable has completely changed how I make dinner plans. It's so easy to find and book restaurants now. I love being able to see reviews and photos before I decide."
                    </p>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="mr-4">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User" class="rounded-full w-14 h-14 object-cover">
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Sophia Rodriguez</h4>
                            <div class="flex text-yellow-400 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "As someone who dines out frequently, QuickTable has become my go-to app. I've discovered so many amazing restaurants I wouldn't have found otherwise!"
                    </p>
                </div>

                <!-- Testimonial 3 - Restaurant Owner -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="mr-4">
                            <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Restaurant Owner" class="rounded-full w-14 h-14 object-cover">
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">David Chen</h4>
                            <p class="text-sm text-gray-600">Restaurant Owner</p>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">
                        "Since joining QuickTable, our restaurant has seen a 30% increase in reservations. The platform is easy to manage and has helped us reduce no-shows significantly."
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="relative bg-yellow-500 py-16">
        <div class="max-w-7xl mx-auto p-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Ready to Experience QuickTable?</h2>
            <p class="text-lg text-white opacity-90 max-w-2xl mx-auto mb-8">
                Join thousands of satisfied diners and restaurant owners. Sign up today and transform your dining experience!
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('restaurants.index') }}" class="px-8 py-3 bg-white hover:bg-gray-100 text-yellow-600 font-semibold rounded-md transition duration-300 text-lg">
                    Find Restaurants
                </a>
                <a href="{{ route('register.show') }}" class="px-8 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-md transition duration-300 text-lg">
                    Create Free Account
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
