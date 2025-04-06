<x-app-layout>

Welcome {{Auth::user()->name}}
@if(session('unauthorized'))
<x-flash-error message="{{session('unauthorized')}}"/>
@endif

</x-app-layout>
