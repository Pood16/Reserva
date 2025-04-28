<x-app-layout>
    <x-header />
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success message -->
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Profile Settings</h1>
                        <div class="text-sm text-gray-500">
                            Member since {{ auth()->user()->created_at->format('M Y') }}
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-8">
                            <div class="sm:w-1/3">
                                <h2 class="text-lg font-semibold mb-4">Profile Picture</h2>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="mb-4 text-center">
                                        <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border border-gray-200">
                                            <img
                                                src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png') }}"
                                                alt="{{ $user->name }}"
                                                class="w-full h-full object-cover"
                                            >
                                        </div>
                                    </div>
                                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-1">
                                                Update Picture
                                            </label>
                                            <input type="file" name="profile_picture" id="profile_picture"
                                                class="block w-full text-sm text-gray-500 file:py-2 file:px-4
                                                file:rounded-md file:border-0 file:text-sm file:font-medium
                                                file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                                        </div>
                                        <div class="flex justify-between">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:border-yellow-700 focus:ring focus:ring-yellow-200 active:bg-yellow-700 transition">
                                                Update
                                            </button>
                                            @if($user->profile_picture && !str_contains($user->profile_picture, 'default-profile.png'))
                                                <a href="{{ route('profile.delete-picture') }}"
                                                   onclick="event.preventDefault(); document.getElementById('delete-picture-form').submit();"
                                                   class="inline-flex items-center px-4 py-2 bg-red-100 border border-transparent rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest hover:bg-red-200 focus:outline-none focus:border-red-300 focus:ring focus:ring-red-100 active:bg-red-200 transition">
                                                    Remove
                                                </a>
                                                <form id="delete-picture-form" action="{{ route('profile.delete-picture') }}" method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="sm:w-2/3">
                                <!-- Profile Information Form -->
                                <h2 class="text-lg font-semibold mb-4">Personal Information</h2>
                                <form action="{{ route('profile.update') }}" method="POST" class="bg-gray-50 p-4 rounded-lg">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                            Name
                                        </label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                            class="mt-1 focus:ring-yellow-500 focus:border-yellow-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                            Email
                                        </label>
                                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                            class="mt-1 focus:ring-yellow-500 focus:border-yellow-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:border-yellow-700 focus:ring focus:ring-yellow-200 active:bg-yellow-700 transition">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="border-t border-gray-200 pt-8">
                        <h2 class="text-lg font-semibold mb-4">Security</h2>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-md font-medium text-gray-700">Change Password</h3>
                                    <p class="text-sm text-gray-500">Ensure your account is using a secure password.</p>
                                </div>
                                <a href="{{ route('profile.change-password') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:border-yellow-500 focus:ring focus:ring-yellow-200 active:bg-gray-100 transition">
                                    Change Password
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Preferences Section (optional) -->
                    <div class="border-t border-gray-200 pt-8">
                        <h2 class="text-lg font-semibold mb-4">Account</h2>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-md font-medium text-gray-900 text-red-700">Delete Account</h3>
                                    <p class="text-sm text-gray-500">Permanently delete your account and all your data.</p>
                                </div>
                                <button
                                    type="button"
                                    class="inline-flex items-center px-4 py-2 bg-red-100 border border-transparent rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest hover:bg-red-200 focus:outline-none focus:border-red-300 focus:ring focus:ring-red-100 active:bg-red-200 transition"
                                    onclick="if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) { document.getElementById('delete-account-form').submit(); }"
                                >
                                    Delete Account
                                </button>
                                <form id="delete-account-form" action="{{ route('profile.destroy') }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-footer />
</x-app-layout>
