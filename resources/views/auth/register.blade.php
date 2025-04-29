<x-app-layout>
    <div class="w-full min-h-screen bg-cover bg-center flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
         style="background-image: url('https://cdn.pixabay.com/photo/2022/05/22/13/21/healthy-7213383_1280.jpg')">
        <div class="max-w-md w-full space-y-8 bg-white/80 backdrop-blur-sm p-8 rounded-xl shadow-2xl">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Join Our Table</h2>
                <p class="text-gray-600 text-sm mb-6">Create your account to start making reservations</p>
            </div>

            <form method="POST" action="{{ route('register.handle') }}" class="mt-8 space-y-6">
                @csrf

                <div class="space-y-5">
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}"
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent text-gray-900 text-sm bg-white/80"
                                placeholder="Enter your full name">
                        </div>
                        @error('name')
                            <span class="mt-1 text-xs text-red-600 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent text-gray-900 text-sm bg-white/80"
                                placeholder="Enter your email address">
                        </div>
                        @error('email')
                            <span class="mt-1 text-xs text-red-600 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password"
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent text-gray-900 text-sm bg-white/80"
                                placeholder="Create a password">
                        </div>
                        @error('password')
                            <span class="mt-1 text-xs text-red-600 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Register Button -->
                    <button type="submit"
                        class="w-full p-3 mt-6 bg-yellow-500 hover:bg-yellow-600 rounded-lg text-gray-900 font-medium text-sm transition-colors duration-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                            <path d="M16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                        </svg>
                        Create Account
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-700">
                    Already have an account?
                    <a href="{{ route('login.show') }}" class="text-amber-500 hover:text-amber-600 font-medium">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
