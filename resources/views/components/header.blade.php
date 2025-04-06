<div class="w-full px-4 bg-gray-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 bg-gray-10 shadow-[0px_5px_14px_0px_rgba(8,15,52,0.04)] flex flex-wrap justify-between items-center">
        <div class="flex justify-center items-center gap-2.5">
            <div class="text-center text-amber-500 text-2xl sm:text-4xl font-normal font-['Architects_Daughter'] leading-10">Reserva</div>
        </div>

        <div class="flex flex-wrap items-center gap-3 mt-4 sm:mt-0">
            <!-- Location drop down -->
            <div data-label="on" class="px-3 py-2 bg-gray-10 rounded-lg outline-1 outline-offset-[-1px] outline-stone-300 outline-opacity-50 flex items-center gap-4 cursor-pointer">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C8.686 2 6 4.686 6 8c0 5.25 6 12 6 12s6-6.75 6-12c0-3.314-2.686-6-6-6zm0 8a2 2 0 110-4 2 2 0 010 4z" />
                    </svg>
                    <div class="flex flex-col">
                        <div class="text-gray-90 text-[8px] font-normal leading-none">Your Location</div>
                        <select class="text-gray-90 text-xs font-normal bg-transparent border-none focus:outline-none cursor-pointer">
                            <option value="Nador">Nador</option>
                            <option value="Casablanca">Casablanca</option>
                            <option value="Rabat">Rabat</option>
                            <option value="Marrakech">Marrakech</option>
                        </select>
                    </div>
                </div>
            </div>
            @auth
            <!-- Notification -->
            <div class="w-12 p-3 bg-yellow-500 rounded-lg flex justify-center items-center hover:bg-yellow-600 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405C18.79 14.79 18 13.42 18 12V8c0-3.314-2.686-6-6-6S6 4.686 6 8v4c0 1.42-.79 2.79-1.595 3.595L3 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
            <!-- Profile icon -->
            <div class="w-12 h-12 p-3 bg-yellow-500 rounded-lg flex justify-center items-center hover:bg-yellow-600 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
            </div>
            @else
            <div class="flex items-center gap-x-2">
                <!-- Login button -->
                <a href="{{ route('login.show') }}" class="px-5 py-3 bg-white border-yellow-500 hover:bg-yellow-50 rounded-lg text-gray-900 font-medium text-sm transition-colors duration-300">
                    Login
                </a>
                <!-- Register button -->
                <a href="{{ route('register.show') }}" class="px-5 py-3 rounded-lg text-gray-900 font-medium text-sm bg-yellow-500 border transition-colors duration-300">
                    Register
                </a>
            </div>
            @endauth
        </div>
    </div>
</div>


