@extends('layouts.app')

@section('content')
@if (session('deleted-message'))
    <div class="mx-2 alert alert-success">
        {{session('deleted-message')}}
    </div>
@endif
<div class="d-flex flex-wrap justify-content-center">
        @foreach ($apartments as $apartment)
            <div class="apartment-wrapper mx-3">
                <div class="card">
                    <a href="{{route('apartment.show', $apartment)}}">
                        <img class="border border-rounded" src="{{$apartment->image}}" alt="apartment">
                    </a>
                </div>
            </div>
        @endforeach
</div>
@endsection
