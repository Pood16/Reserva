<x-app-layout >
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="max-w-2xl w-full mx-4">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="bg-red-600 px-6 py-4">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <h2 class="text-xl font-semibold text-white">Unauthorized Access</h2>
                    </div>
                </div>

                <div class="px-6 py-8">
                    <div class="text-center">
                        <h4 class="text-xl font-medium text-gray-800 mb-4">
                            {{ session('error') ?? 'You do not have permission to access this page.' }}
                        </h4>
                        <p class="text-gray-600 mb-6">
                            This area requires <span class="font-semibold">{{Auth::user()->role}}</span> privileges.
                        </p>

                        <a href="{{ route('home') }}"
                           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Go Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout >
