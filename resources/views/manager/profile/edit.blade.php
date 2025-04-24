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
                        <a href="{{ route('manager.profile.show') }}" class="inline-flex items-center text-gray-700 hover:text-amber-600">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Profile
                        </a>
                    </div>
                </div>

                <!-- Edit Profile Form -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Edit Profile</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('manager.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Profile Picture -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                                <div class="flex items-center">
                                    <div class="w-20 h-20 rounded-full overflow-hidden mr-4">
                                        @if($user->profile_picture)
                                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-amber-100 rounded-full text-amber-800 text-2xl">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4 file:rounded-md
                                            file:border-0 file:text-sm file:font-semibold
                                            file:bg-amber-50 file:text-amber-700
                                            hover:file:bg-amber-100">
                                        <p class="mt-1 text-sm text-gray-500">Upload a new profile picture (JPG, PNG, GIF up to 2MB)</p>
                                        @error('profile_picture')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Account Information (Non-editable) -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Account Information</h4>
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                                <p class="text-sm text-gray-500 mt-2">To change your password, please use the <a href="{{ route('manager.profile.password.edit') }}" class="text-amber-600 hover:underline">change password</a> form.</p>
                            </div>

                            <div class="flex justify-end pt-5">
                                <a href="{{ route('manager.profile.show') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 mr-2">
                                    Cancel
                                </a>
                                <button type="submit" class="bg-amber-500 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('resources/js/manager/toggleNav.js') }}"></script>
    @endpush
</x-app-layout>
