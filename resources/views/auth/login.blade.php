<x-app-layout>
    <div class="w-full bg-gray-50 py-20">
        <div class="flex flex-col md:flex-row w-11/12 max-w-5xl mx-auto rounded-lg overflow-hidden shadow-[0px_5px_14px_0px_rgba(8,15,52,0.04)]">
            <!-- Restaurant Image - Hidden on mobile (below md breakpoint) -->
            <div class="hidden md:block md:w-1/2 bg-amber-50">
                <img src="{{asset('resources/images/login.jpeg')}}" alt="Restaurant ambiance" class="w-full h-full object-cover" />
            </div>

            <!-- Login Form -->
            <div class="w-full md:w-1/2 bg-white px-8 py-10">
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

                <h2 class="text-center text-2xl font-semibold text-gray-900 mb-2">Welcome Back</h2>
                <p class="text-center text-gray-600 text-sm mb-8">Sign in to manage your reservations</p>

                <form method="POST" action="{{ route('login.handle') }}">
                    @csrf

                    <div class="space-y-5">
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm text-gray-700 mb-1">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-lg outline-1 outline-offset-[-1px] outline-stone-300 outline-opacity-50 focus:outline-amber-500 focus:outline-2 text-gray-900 text-sm"
                                    placeholder="Enter your email address">
                            </div>
                            @error('email')
                                <span class="mt-1 text-xs text-red-600 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm text-gray-700 mb-1">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="password" type="password" name="password"
                                    class="w-full pl-10 pr-4 py-3 rounded-lg outline-1 outline-offset-[-1px] outline-stone-300 outline-opacity-50 focus:outline-amber-500 focus:outline-2 text-gray-900 text-sm"
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
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register.show') }}" class="text-amber-500 hover:text-amber-600 font-medium">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    </x-app-layout>
