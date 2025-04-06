<x-app-layout>

    @if(session('unauthorized'))
        <x-flash-error message="{{session('unauthorized')}}"/>
    @endif

    <!-- Filter section -->
    <div class="relative">
        <!-- Background container with border -->
        <div class="max-w-7xl mx-auto p-4">
            <div class="rounded-lg overflow-hidden">
                <div class="relative h-[500px] bg-cover bg-center" style="background-image: url('{{asset('resources/images/home-2.avif')}}');">
                    <!-- search bar -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="bg-amber-500 p-4 w-11/12 max-w-4xl rounded-lg shadow-lg">
                            <div class="flex flex-col md:flex-row gap-4">
                                <!-- Date picker -->
                                <div class="flex-1">
                                    <div class="bg-white rounded flex items-center p-3 shadow h-12">
                                        <i class="far fa-calendar-alt text-gray-500 mr-2"></i>
                                        <input type="date" class="w-full outline-none text-gray-700">
                                    </div>
                                </div>



                                <!-- Time picker -->
                                <div class="flex-1">
                                    <div class="bg-white rounded flex items-center p-3 shadow h-12">
                                        <input type="time" class="outline-none" id="time" min="09:00" max="18:00" value="00:00" required>
                                    </div>
                                </div>

                                <!-- People picker -->
                                <div class="flex-1">
                                    <div class="bg-white rounded flex items-center p-3 shadow h-12">
                                        <select class="w-full outline-none text-gray-700">
                                            <option value="1">1 Person</option>
                                            <option value="2">2 People</option>
                                            <option value="3">3 People</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Search input -->
                                <div class="flex-1 md:flex-[2]">
                                    <div class="bg-white rounded flex items-center p-3 shadow h-12">
                                        <i class="fas fa-search text-gray-500 mr-2"></i>
                                        <input type="text" placeholder="Search restaurant here..." class="w-full outline-none text-gray-700">
                                    </div>
                                </div>

                                <!-- Find table button -->
                                <div>
                                    <button class="bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded shadow transition duration-200 h-12">
                                        Find table
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Restaurants section -->
    <div class="max-w-7xl mx-auto p-4">
        <!-- Popular Cuisines Section -->
        <div class="mb-8">
            <h2 class="text-xl font-medium text-green-600 mb-4">Popular Cusines for you</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Restaurant Card 1 -->


                <!-- Restaurant Card 2 -->
                @foreach($restaurants as $restaurant)
                    <div class="bg-white rounded-lg overflow-hidden shadow">
                        <div class="relative">
                            <a href="#" class="cursor-pointer">
                                <img src="{{ $restaurant->cover_image ?? asset('images/placeholder-300x200.jpg') }}"
                                     alt="{{ $restaurant->name }}"
                                     class="w-full h-32 object-cover"
                                     onerror="this.src='{{ asset('images/restaurant-placeholder-300x200.jpg') }}'; this.onerror='';">
                            </a>
                            <div class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded">
                                {{ number_format($restaurant->reviews->avg('rating') ?? 4.5, 1) }}
                            </div>
                        </div>
                        <div class="p-2">
                            <a href="#" class="font-medium text-sm hover:text-green-600 cursor-pointer transition duration-200">{{ $restaurant->name }}</a>
                            <p class="text-xs text-gray-600">{{ $restaurant->city }}</p>
                            <span class="text-xs text-gray-500 mt-1">{{ Str::limit($restaurant->description, 50) }}</span>
                        </div>
                    </div>
                @endforeach

            </div>
            <!-- See All Button -->
            <div class="flex justify-center mt-6">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-10 rounded-md transition duration-200">
                    See all
                </button>
            </div>
        </div>

        <!-- Best Deals Section -->
        <div class="mb-8">
            <h2 class="text-xl font-medium text-green-600 mb-4">Best deals</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Deal Card 1 -->
                <div class="bg-gradient-to-r from-amber-800 to-amber-700 rounded-lg overflow-hidden shadow relative flex items-center">
                    <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=120&q=80"
                         alt="Restaurant logo"
                         class="h-24 w-24 object-cover m-2 rounded-full">
                    <div class="p-2 text-white">
                        <h3 class="font-bold text-3xl">10%<span class="text-sm font-normal">OFF</span></h3>
                        <p class="text-xs">ON ONLINE BOOKING</p>
                    </div>
                </div>

                <!-- Deal Card 2 -->
                <div class="bg-gradient-to-r from-green-800 to-green-600 rounded-lg overflow-hidden shadow relative flex items-center">
                    <img src="https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=120&q=80"
                         alt="Food image"
                         class="h-24 w-24 object-cover m-2 rounded-full">
                    <div class="p-2 text-white">
                        <h3 class="font-bold text-3xl">20%<span class="text-sm font-normal">OFF</span></h3>
                        <p class="text-xs">ON COMPLETE ORDER</p>
                    </div>
                </div>

                <!-- Deal Card 3 -->
                <div class="bg-gradient-to-r from-red-800 to-red-600 rounded-lg overflow-hidden shadow relative">
                    <img src="https://images.unsplash.com/photo-1544148103-0773bf10d330?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=320&q=80"
                         alt="Food offer"
                         class="w-full h-32 object-cover">
                    <div class="absolute top-4 right-4 bg-white bg-opacity-90 rounded-full p-2">
                        <p class="text-red-600 font-bold text-sm">20<span class="text-xs">%</span><br><span class="text-xs font-normal">OFF</span></p>
                    </div>
                </div>

                <!-- Deal Card 4 -->
                <div class="bg-yellow-400 rounded-lg overflow-hidden shadow relative p-4 flex flex-col justify-center items-center">
                    <div class="bg-black p-2 mb-2 transform -rotate-6">
                        <p class="text-yellow-400 font-bold text-xl">SPECIAL</p>
                    </div>
                    <div class="bg-black p-2 transform -rotate-6">
                        <p class="text-yellow-400 font-bold text-xl">OFFER</p>
                    </div>
                </div>
            </div>

            <!-- See More Button -->
            <div class="flex justify-center mt-6">
                <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-10 rounded-md transition duration-200">
                    See more
                </button>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <x-footer/>
</x-app-layout>
