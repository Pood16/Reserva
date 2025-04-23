<x-app-layout>
    <div class="w-full min-h-screen bg-cover bg-center flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
        style="background-image: url('https://cdn.pixabay.com/photo/2022/05/22/13/21/healthy-7213383_1280.jpg')">
        <div class="max-w-md w-full space-y-8 bg-white/80 backdrop-blur-sm p-8 rounded-xl shadow-2xl">
            @if (session('success'))
                <div class="mb-6 text-sm text-green-600 text-center">
                    {{ session('success') }}
                </div>
            @endif
            @error('attempt')
                <div class="mb-4 text-sm text-red-600 text-center">
                    {{ $message }}
                </div>
            @enderror

            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome Back</h2>
                <p class="text-gray-600 text-sm mb-6">Sign in to benifit from all our services</p>
            </div>

            <form method="POST" action="{{ route('login.handle') }}" class="mt-8 space-y-6">
                @csrf

                <div class="space-y-5">
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
                                placeholder="Enter your password">
                        </div>
                        @error('password')
                            <span class="mt-1 text-xs text-red-600 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                        class="w-full p-3 mt-6 bg-yellow-500 hover:bg-yellow-600 rounded-lg text-gray-900 font-medium text-sm transition-colors duration-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Sign In
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-700">
                    Don't have an account?
                    <a href="{{ route('register.show') }}" class="text-amber-500 hover:text-amber-600 font-medium">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
