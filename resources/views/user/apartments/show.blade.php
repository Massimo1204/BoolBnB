@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center w-100">
        @if(str_starts_with($apartment->image, 'https://') || str_starts_with($apartment->image, 'http://'))
            <img class="w-50" src="{{$apartment->image}}" alt="">
        @else
            <img class="w-50" src="{{ asset('/storage') . '/' . $apartment->image}}" alt="">
        @endif
        <form action="{{route('apartment.destroy', $apartment)}}" method="post">
            @csrf
            @method('DELETE')

            <input type="submit" class="btn btn-danger btn-large" value="Delete">
        </form>
    </div>

@endsection