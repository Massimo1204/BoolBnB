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
<div class="d-flex flex-wrap justify-content-center">
        @foreach ($apartments as $apartment)
            <div class="apartment-wrapper mx-3">
                <div class="card">
                    <a href="{{route('apartment.show', $apartment)}}">
                        @if (str_starts_with($apartment->image, 'https://') || str_starts_with($apartment->image, 'http://') || str_starts_with($apartment->image, 'uploads/'))
                            <img class="w-50" src="{{ $apartment->image }}" alt="">
                        @else
                            <img class="w-50" src="{{ asset('/storage') . '/' . $apartment->image }}" alt="">
                        @endif
                    </a>
                </div>
            </div>
        @endforeach
        {{ $apartments->links() }}
</div>
@endsection
