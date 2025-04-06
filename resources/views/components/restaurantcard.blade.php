{{-- <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition-shadow duration-300">
    <div class="relative">
        <img src="{{ $restaurant->cover_image }}"
             alt="{{ $restaurant->name }} restaurant"
             class="w-full h-32 object-cover transition-transform duration-300 hover:scale-105">
        <div class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded">
            {{ $restaurant->reviews->avg('rating') ?? 'N/A' }}
        </div>
    </div>
    <div class="p-3">
        <h3 class="font-medium text-sm">{{ $restaurant->name }}</h3>
        <p class="text-xs text-gray-600">{{ $restaurant->address }}, {{ $restaurant->city }}</p>
        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1">
            <span>{{ $restaurant->opening_time->format('g:i A') }} - {{ $restaurant->closing_time->format('g:i A') }}</span>
            <span>•</span>
            <span>{{ $restaurant->is_active ? 'Open' : 'Closed' }}</span>
        </div>
    </div>
        </div>
    </div>
</div> --}}
