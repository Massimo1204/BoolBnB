@extends('layouts.app')

@section('content')
    @if(session('deleted-message'))
        <div class="alert alert-warning">
            {{session('deleted-message')}}
        </div>
    @endif
    <div class="d-flex justify-content-center w-100">
        @if(str_starts_with($apartment->image, 'https://') || str_starts_with($apartment->image, 'http://'))
            <img class="w-50" src="{{$apartment->image}}" alt="">
        @else
            <img class="w-50" src="{{ asset('/storage') . '/' . $apartment->image}}" alt="">
        @endif
    </div>
    @if(Auth::user()->id == $apartment->user_id)
        <form action="{{route('user.apartment.destroy', $apartment->id)}}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger btn-sm">Delete</a>
        </form>
    @endif
@endsection