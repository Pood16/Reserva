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

                <!-- Back button -->
                <div class="mb-6">
                    <a href="{{ route('manage.restaurants') }}" class="inline-flex items-center text-gray-700 hover:text-amber-600">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Restaurants
                    </a>
                </div>

                <!-- Restaurant Details -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $restaurant->name }}</h3>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Cover Image -->
                            <div class="md:col-span-1">
                                <div class="bg-gray-100 rounded-lg p-4">
                                    <div class="aspect-w-16 aspect-h-9 mb-2">
                                        <img src="{{ asset('storage/' . $restaurant->cover_image) }}"
                                            alt="{{ $restaurant->name }}"
                                            class="object-cover w-full h-full rounded"
                                            onerror="this.src='/resources/images/default-profile.png'">
                                    </div>
                                    <div class="text-sm text-gray-600 mt-2">Cover Image</div>
                                </div>
                            </div>

                            <!-- Restaurant Info -->
                            <div class="md:col-span-2">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <h4 class="font-medium text-gray-800 mb-2">Details</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><span class="text-gray-600">Status:</span>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $restaurant->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $restaurant->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </li>
                                            <li><span class="text-gray-600">Address:</span> {{ $restaurant->address }}</li>
                                            <li><span class="text-gray-600">City:</span> {{ $restaurant->city }}</li>
                                            <li><span class="text-gray-600">Phone:</span> {{ $restaurant->phone }}</li>
                                            <li><span class="text-gray-600">Email:</span> {{ $restaurant->email }}</li>
                                            @if($restaurant->website)
                                                <li><span class="text-gray-600">Website:</span> <a href="{{ $restaurant->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">{{ $restaurant->website }}</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800 mb-2">Business Hours</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><span class="text-gray-600">Opening Time:</span> {{ $restaurant->opening_time->format('h:i A') }}</li>
                                            <li><span class="text-gray-600">Closing Time:</span> {{ $restaurant->closing_time->format('h:i A') }}</li>
                                            <li>
                                                <span class="text-gray-600">Open Days:</span>
                                                <div class="flex flex-wrap mt-1">
                                                    @foreach($restaurant->openingDays as $day)
                                                        <span class="px-2 py-1 mr-1 mb-1 text-xs bg-amber-100 text-amber-800 rounded">{{ $day->day_of_week }}</span>
                                                    @endforeach
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <h4 class="font-medium text-gray-800 mb-2">Description</h4>
                                    <p class="text-sm text-gray-700">{{ $restaurant->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Restaurant Stats -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Restaurant Stats</h3>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Tables -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                                            <i class="fas fa-chair text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Tables</p>
                                            <p class="text-xl font-semibold">{{ $restaurant->tables->count() }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('manager.tables.index', $restaurant->id) }}" class="text-amber-600 hover:text-amber-800">
                                        <i class="fas fa-cog mr-1"></i> Manage Tables
                                    </a>
                                </div>
                            </div>

                            <!-- Reviews -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                                        <i class="fas fa-star text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Reviews</p>
                                        <p class="text-xl font-semibold">{{ $restaurant->reviews->count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Average Rating -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                                        <i class="fas fa-thumbs-up text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Avg. Rating</p>
                                        @php
                                            $reviewCount = $restaurant->reviews->count();
                                            $averageRating = $reviewCount > 0 ? number_format($restaurant->reviews->avg('rating'), 1) : 'N/A';
                                        @endphp
                                        <div class="flex items-center">
                                            <p class="text-xl font-semibold mr-2">{{ $averageRating }}</p>
                                            @if($averageRating != 'N/A')
                                                <div class="flex text-yellow-400 text-sm">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $averageRating)
                                                            <i class="fas fa-star"></i>
                                                        @elseif($i - 0.5 <= $averageRating)
                                                            <i class="fas fa-star-half-alt"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Restaurant Gallery -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Restaurant Gallery</h3>
                        <button id="openImageModal" class="bg-amber-500 hover:bg-amber-600 text-white py-2 px-4 rounded inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i> Add Image
                        </button>
                    </div>

                    <div class="p-6">
                        @if(count($restaurant->images) > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($restaurant->images as $image)
                                    <div class="relative group">
                                        <div class="aspect-w-16 aspect-h-12 mb-2">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                alt="Restaurant Image"
                                                class="object-cover w-full h-full rounded shadow-sm hover:shadow-md transition">
                                        </div>
                                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded">
                                            <form action="{{ route('restaurant.images.delete', ['id' => $restaurant->id, 'imageId' => $image->id]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-white bg-red-600 hover:bg-red-700 rounded-full p-2" title="Delete image">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10">
                                <div class="text-gray-500 mb-4">No images have been added to this restaurant yet</div>
                                <p class="text-sm text-gray-500">Add images to showcase your restaurant</p>
                            </div>
                        @endif
                    </div>
                </div>


            </main>
        </div>
    </div>

    <!-- Add Image Modal -->
    <div id="addImageModal" class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg w-full max-w-md max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center border-b px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-800">Add Restaurant Image</h3>
                <button id="closeImageModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('restaurant.images.add', $restaurant->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Restaurant Image <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex items-center">
                            <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4 file:rounded-md
                                file:border-0 file:text-sm file:font-semibold
                                file:bg-amber-50 file:text-amber-700
                                hover:file:bg-amber-100" required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Upload a high-quality image to showcase your restaurant. Max size 2MB.</p>
                    </div>


                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelImage" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Cancel
                        </button>
                        <button type="submit" class="bg-amber-500 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Upload Image
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="{{asset('resources/js/manager/toggleNav.js')}}"></script>
    <script src="{{asset('resources/js/manager/restaurant-details.js')}}"></script>
    @endpush
</x-app-layout>
