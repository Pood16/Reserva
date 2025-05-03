<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-yellow-50 to-amber-100 flex flex-col">
        <main class="flex-1 p-4 sm:p-6 bg-gradient-to-r from-yellow-50 to-amber-100 ">
            <!-- Flash Messages -->
            <x-flash-messages />

            <!-- back button -->
            <div class="mb-4 flex items-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-gray-700 hover:text-blue-600 text-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Home
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden w-full max-w-2xl mx-auto">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex space-x-4">
                    <button type="button" class="tab-btn text-sm font-semibold text-blue-600 focus:outline-none" data-tab="details">Profile Details</button>
                    <button type="button" class="tab-btn text-sm font-semibold text-gray-600 hover:text-blue-600 focus:outline-none" data-tab="edit">Update Profile Details</button>
                    <button type="button" class="tab-btn text-sm font-semibold text-gray-600 hover:text-blue-600 focus:outline-none" data-tab="password">Update Password</button>
                </div>
                <div class="p-4">
                    <!-- Profile Details Section -->
                    <div class="tab-section" id="tab-details">
                        <div class="flex flex-col items-center mb-6">
                            <div class="w-24 h-24 rounded-full bg-white p-1 shadow-lg mb-2">
                                @if($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="rounded-full w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-blue-100 rounded-full text-blue-800 text-4xl">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <h1 class="text-xl font-bold text-gray-800 mb-1">{{ $user->name }}</h1>
                            <p class="text-gray-500 text-sm mb-1">{{ $user->email }}</p>
                            <p class="bg-blue-600 inline-block px-2 py-1 rounded text-xs text-white mb-2">Client</p>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500">Full Name</p>
                                <p class="font-medium text-base">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Email Address</p>
                                <p class="font-medium text-base">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Account Type</p>
                                <p class="font-medium text-base">Client</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Account Created</p>
                                <p class="font-medium text-base">{{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Update Profile Section -->
                    <div class="tab-section hidden" id="tab-edit">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                                <div class="flex items-center">
                                    <div class="w-16 h-16 rounded-full overflow-hidden mr-4">
                                        @if($user->profile_picture)
                                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-blue-100 rounded-full text-blue-800 text-xl">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="profile_picture" id="profile_picture" accept="image/*" class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4 file:rounded-md
                                            file:border-0 file:text-sm file:font-semibold
                                            file:bg-blue-50 file:text-blue-700
                                            hover:file:bg-blue-100">
                                        <p class="mt-1 text-xs text-gray-500">Upload a new profile picture (JPG, PNG, GIF up to 2MB)</p>
                                        @error('profile_picture')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <h4 class="text-xs font-medium text-gray-700 mb-2">Account Information</h4>
                                <div class="bg-gray-50 p-3 rounded-md">
                                    <div class="grid grid-cols-1 gap-2">
                                        <div>
                                            <p class="text-xs text-gray-500">Account Type</p>
                                            <p class="font-medium text-sm">Client</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Account Created</p>
                                            <p class="font-medium text-sm">{{ $user->created_at->format('F d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">To change your password, please use the <span class="text-blue-600">Update Password</span> tab.</p>
                            </div>
                            <div class="flex flex-col sm:flex-row justify-end pt-4 gap-2">
                                <button type="submit" class="bg-blue-500 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Update Password Section -->
                    <div class="tab-section hidden" id="tab-password">
                        <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                <input type="password" name="current_password" id="current_password" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" name="password" id="password" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                                @error('password_confirmation')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="bg-gray-50 p-3 rounded-md">
                                <h4 class="text-xs font-medium text-gray-700 mb-2">Password Requirements:</h4>
                                <ul class="text-xs text-gray-600 list-disc pl-5 space-y-1">
                                    <li>Minimum 8 characters</li>
                                    <li>Different from your current password</li>
                                    <li>Should contain a mix of letters, numbers, and symbols for best security</li>
                                </ul>
                            </div>
                            <div class="flex flex-col sm:flex-row justify-end pt-4 gap-2">
                                <button type="submit" class="bg-blue-500 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        // Simple tab switching logic
        document.addEventListener('DOMContentLoaded', function () {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabSections = document.querySelectorAll('.tab-section');
            tabBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    tabBtns.forEach(b => b.classList.remove('text-blue-600'));
                    tabBtns.forEach(b => b.classList.add('text-gray-600'));
                    this.classList.add('text-blue-600');
                    this.classList.remove('text-gray-600');
                    const tab = this.getAttribute('data-tab');
                    tabSections.forEach(section => {
                        section.classList.add('hidden');
                    });
                    document.getElementById('tab-' + tab).classList.remove('hidden');
                });
            });
        });
    </script>
</x-app-layout>
