@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center ">
      @foreach ($apartments as $apartment)
        <div class="col-3">
          <div class="card">
                <a href="{{route('apartment.show', $apartment)}}">
                    <img src="{{$apartment->image}}" alt="">
                </a>
            </div>
          </div>
      @endforeach
    </div>
</div>
@endsection
