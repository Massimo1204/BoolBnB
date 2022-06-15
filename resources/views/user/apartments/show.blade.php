@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <img src="{{$apartment->image}}" alt="">
            </div>
        </div>
    </div>
</div>
@endsection