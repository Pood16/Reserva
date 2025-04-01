<x-app-layout>
    <!-- unauthorized flash message -->
    @if(session('unauthorized'))
        <x-flash-error message="{{session('unauthorized')}}"/>
    @endif
    <!-- client page -->


    <!-- js section -->
    @section('script')
        <script src="{{ asset('resources/js/client.js') }}"></script>
    @endsection
</x-app-layout>
