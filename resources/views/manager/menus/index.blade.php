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

                <!-- Back button and title -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <a href="{{ route('restaurant.details', $restaurant->id) }}" class="inline-flex items-center text-gray-700 hover:text-amber-600">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Restaurant
                        </a>
                    </div>
                    <h1 class="text-2xl font-semibold text-gray-800">{{ $restaurant->name }} - Menus</h1>
                </div>

                <!-- Menus List -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Restaurant Menus</h3>
                        <a href="{{ route('manager.menus.create', $restaurant->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white py-2 px-4 rounded inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i> Add New Menu
                        </a>
                    </div>

                    <div class="p-6">
                        @if($restaurant->menus->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($restaurant->menus as $menu)
                                    <div class="bg-white border rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                                        <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                            <h3 class="font-semibold text-gray-800 truncate">{{ $menu->name }}</h3>
                                            <span class="text-xs bg-blue-100 text-blue-800 rounded-full px-2 py-1">
                                                {{ $menu->items->count() }} items
                                            </span>
                                        </div>
                                        <div class="p-4">
                                            <p class="text-sm text-gray-600 mb-4 h-20 overflow-hidden">
                                                {{ Str::limit($menu->description, 100) }}
                                            </p>
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                @foreach($menu->items->take(5) as $item)
                                                    <span class="text-xs bg-amber-100 text-amber-800 rounded-full px-2 py-1">
                                                        {{ $item->name }}
                                                    </span>
                                                @endforeach
                                                @if($menu->items->count() > 5)
                                                    <span class="text-xs bg-gray-200 text-gray-700 rounded-full px-2 py-1">
                                                        +{{ $menu->items->count() - 5 }} more
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="flex justify-between items-center pt-2 border-t">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('manager.menus.edit', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id]) }}" class="text-blue-600 hover:text-blue-800" title="Edit menu">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('manager.menus.destroy', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this menu?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Delete menu">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <a href="{{ route('manager.menus.items', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id]) }}" class="text-amber-600 hover:text-amber-800">
                                                    <i class="fas fa-utensils mr-1"></i> Manage Items
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="text-gray-500 mb-4">You haven't created any menus for this restaurant yet</div>
                                <a href="{{ route('manager.menus.create', $restaurant->id) }}" class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-600 active:bg-amber-700 focus:outline-none focus:border-amber-700 focus:ring focus:ring-amber-300 disabled:opacity-25 transition">
                                    <i class="fas fa-plus mr-2"></i> Create Your First Menu
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    @push('scripts')
    <script src="{{asset('resources/js/manager/toggleNav.js')}}"></script>
    @endpush
</x-app-layout>
