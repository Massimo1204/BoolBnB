@extends('layouts.app')

@section('content')
@if (session('deleted-message'))
    <div class="mx-2 alert alert-success">
        {{session('deleted-message')}}
    </div>
@endif
@if (session('error-message'))
    <div class="mx-2 alert alert-danger">
        {{session('error-message')}}
    </div>
@endif
{{-- <div class="d-flex flex-wrap justify-content-center">
    @foreach ($apartments as $apartment)
        <div class="apartment-wrapper mx-3">
            <div class="card">
                <a href="{{route('guest.show', $apartment)}}">
                    <img class="border border-rounded" src="{{$apartment->image}}" alt="apartment">
                </a>
            </div>
        </div>
    @endforeach
</div>
<div class="mx-auto">
    {{ $apartments->links() }}
</div> --}}
{{-- <div id="root"></div> --}}
@endsection
@section('footer-scripts')
    {{-- <script >
        
    document.addEventListener("DOMContentLoaded", function(event) { 
        function toggleDarkMode() {
            if(document.querySelector('html').classList.contains("dark"))
                enableDarkMode(false)
            else
                enableDarkMode(true)
        }
        function enableDarkMode(status = true) {
            if(status)
                document.querySelector('html').classList.add('dark')
            else
                document.querySelector('html').classList.remove('dark')
        }
        document.getElementById('theme-toggler').addEventListener('click', function() { 
        toggleDarkMode();
        }, false);
    });
    </script> --}}
    {{-- <script src="{{ asset('js/darkmode.js') }}"></script> --}}

@endsection