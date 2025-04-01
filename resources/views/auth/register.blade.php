<x-app-layout>
<div class="w-full bg-gray-50 py-12">
    <div class="w-11/12 max-w-md mx-auto px-8 py-10 bg-white rounded-lg shadow-[0px_5px_14px_0px_rgba(8,15,52,0.04)]">
        <h2 class="text-center text-2xl font-semibold text-gray-900 mb-8">Create an Account</h2>



        <form method="POST" action="{{ route('register.handle') }}">
            @csrf

            <div class="space-y-5">
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm text-gray-700 mb-1">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 rounded-lg outline-1 outline-offset-[-1px] outline-stone-300 outline-opacity-50 focus:outline-amber-500 focus:outline-2 text-gray-900 text-sm"
                        placeholder="Enter your full name">
                    @error('name')
                        <span class="mt-1 text-xs text-red-600 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm text-gray-700 mb-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 rounded-lg outline-1 outline-offset-[-1px] outline-stone-300 outline-opacity-50 focus:outline-amber-500 focus:outline-2 text-gray-900 text-sm"
                        placeholder="Enter your email address">
                    @error('email')
                        <span class="mt-1 text-xs text-red-600 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm text-gray-700 mb-1">Password</label>
                    <input id="password" type="password" name="password"
                        class="w-full px-4 py-3 rounded-lg outline-1 outline-offset-[-1px] outline-stone-300 outline-opacity-50 focus:outline-amber-500 focus:outline-2 text-gray-900 text-sm"
                        placeholder="Create a password">
                    @error('password')
                        <span class="mt-1 text-xs text-red-600 block">{{ $message }}</span>
                    @enderror
                </div>



                <!-- Register Button -->
                <button type="submit"
                    class="w-full p-3 mt-6 bg-yellow-500 hover:bg-yellow-600 rounded-lg text-gray-900 font-medium text-sm transition-colors duration-300">
                    Create Account
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login.show') }}" class="text-amber-500 hover:text-amber-600 font-medium">Sign in</a>
            </p>
        </div>
    </div>
</div>
</x-app-layout>
