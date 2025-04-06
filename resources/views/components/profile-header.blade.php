<div class="flex items-center bg-white rounded-md p-4 shadow-sm">
    <!-- Profile Image -->
    <div class="mr-4">
        <img src="{{ $user->profile_image ?? asset('resources/images/default-profile.png') }}" alt="{{ $user->name ?? 'lahcen' }}" class="w-24 h-28 object-cover rounded-md">
    </div>

    <!-- User Information -->
    <div class="flex-1">
        <div class="flex flex-col">
            <!-- User Name -->
            <h2 class="text-xl font-bold text-gray-900 mb-2">{{ strtoupper($user->name) }}</h2>

            <!-- Contact & Location Info -->
            <div class="space-y-2">
                <!-- Email -->
                <div class="flex items-center">
                    <span class="text-green-600 mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </span>
                    <span class="text-gray-700">{{ $user->email }}</span>
                </div>

                <!-- Location -->
                @if (!is_null($user->location))
                    <div class="flex items-center">
                        <span class="text-green-600 mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span class="text-gray-700">{{ $user->location }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Side Information -->
    <div class="flex flex-col items-end justify-between h-full">
        <!-- Phone Number -->
        @if (!is_null($user->phone))
            <div class="flex items-center mb-4">
                <span class="text-green-600 mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    </svg>
                </span>
                <span class="text-gray-700">{{ $user->phone }}</span>
            </div>
        @endif

        <!-- Restaurant Booked Info -->
        {{-- <div class="flex items-center">
            <span class="text-green-600 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
            </span>
            <span class="text-gray-700">{{ $user->restaurants_booked }} Restaurant Booked</span>
        </div> --}}
    </div>
</div>

