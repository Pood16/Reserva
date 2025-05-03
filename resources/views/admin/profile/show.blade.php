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

                <!-- Breadcrumbs and back button -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-700 hover:text-blue-600">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                        </a>
                    </div>
                </div>

                <!-- Profile Header -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-blue-50 border-b border-blue-100 px-6 py-12">
                        <div class="flex flex-col md:flex-row items-center justify-between">
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-blue-50 p-1 border border-blue-200 shadow-lg mb-4 md:mb-0 md:mr-6">
                                    @if($user->profile_picture)
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="rounded-full w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-blue-100 rounded-full text-blue-800 text-4xl">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="text-center md:text-left">
                                    <h1 class="text-2xl font-bold text-blue-900">{{ $user->name }}</h1>
                                    <p class="text-blue-800">{{ $user->email }}</p>
                                    <p class="bg-blue-200 inline-block px-2 py-1 rounded text-xs text-blue-800 mt-2 border border-blue-300">{{ ucfirst($user->role) }}</p>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0 flex space-x-2">
                                <a href="{{ route('admin.profile.edit') }}" class="bg-blue-100 text-blue-800 border border-blue-200 px-4 py-2 rounded-md hover:bg-blue-200">
                                    <i class="fas fa-user-edit mr-2"></i> Edit Profile
                                </a>
                                <a href="{{ route('admin.profile.password.edit') }}" class="bg-blue-100 text-blue-800 border border-blue-200 px-4 py-2 rounded-md hover:bg-blue-200">
                                    <i class="fas fa-key mr-2"></i> Change Password
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Profile Details</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Account Information</h4>

                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Full Name</p>
                                        <p class="font-medium">{{ $user->name }}</p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-500">Email Address</p>
                                        <p class="font-medium">{{ $user->email }}</p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-500">Account Type</p>
                                        <p class="font-medium">{{ ucfirst($user->role) }}</p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-500">Account Created</p>
                                        <p class="font-medium">{{ $user->created_at->format('F d, Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">System Statistics</h4>

                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Total Users</p>
                                        <p class="font-medium">{{ \App\Models\User::count() }}</p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-500">Registered Restaurants</p>
                                        <p class="font-medium">{{ \App\Models\Restaurant::count() }}</p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-500">Restaurant Managers</p>
                                        <p class="font-medium">{{ \App\Models\User::where('role', 'manager')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity (Admin-specific) -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Admin Activities</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="border-l-4 border-blue-500 pl-4 py-2">
                                <p class="text-sm text-gray-600">
                                    Pending manager requests:
                                    <a href="{{ route('admin.manager-requests.index') }}" class="text-blue-600 hover:underline">
                                        {{ \App\Models\ManagerRequest::where('status', 'pending')->count() }}
                                    </a>
                                </p>
                            </div>

                            <div class="border-l-4 border-green-500 pl-4 py-2">
                                <p class="text-sm text-gray-600">
                                    Quick access to <a href="{{ route('admin.restaurants.index') }}" class="text-blue-600 hover:underline">restaurant management</a> or
                                    <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline">user management</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('resources/js/manager/toggleNav.js') }}"></script>
    @endpush
</x-app-layout>
