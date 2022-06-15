@extends('layouts.app')

@section('content')
    @if(session('deleted-message'))
        <div class="alert alert-warning">
            {{session('deleted-message')}}
        </div>
    @endif
    <div class="d-flex justify-content-center w-100">
        <img class="w-50" src="{{$apartment->image}}" alt="">
    </div>
    <form action="{{route('user.apartment.destroy', $apartment->id)}}" method="POST">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger btn-sm">Delete</a>
    </form>

@endsection