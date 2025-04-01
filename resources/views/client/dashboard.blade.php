<x-app-layout>
    <!-- unauthorized flash message -->
    @if(session('unauthorized'))
        <div id="unauthorized-flash-message" class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow-md z-50 max-w-sm transition-opacity duration-500">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('unauthorized') }}</span>
            </div>
            <button onclick="document.getElementById('unauthorized-flash-message').remove()" class="absolute top-1 right-1 text-red-700 hover:text-red-900">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    @endif
    <!-- client page -->


    <!-- js section -->
    @section('script')
        <script src="{{ asset('resources/js/client.js') }}"></script>
    @endsection
</x-app-layout>
