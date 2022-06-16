@extends('layouts.app')

@section('content')
    @if (session('deleted-message'))
        <div class="mx-2 alert alert-success">
            {{ session('deleted-message') }}
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-3">
                <h1>I tuoi appartamenti:</h1>
            </div>
            <div class="col-3">
               <a href="{{ route('apartment.index') }}">Vai alla lista di tutti gli appartamenti</a>
            </div>
            <div class="col-3">
                <a href="{{ route('apartment.create') }}">Aggiungi nuovo Appartmanento</a>
             </div>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-center">

        @foreach ($apartments as $apartment)
            <div class="apartment-wrapper mx-3">
                <div class="card">
                    <a href="{{ route('apartment.show', $apartment) }}">
                        <img class="border border-rounded" src="{{ $apartment->image }}" alt="apartment">
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
