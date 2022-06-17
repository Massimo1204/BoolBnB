@extends('layouts.app')

@section('content')
    @if (session('deleted-message'))
        <div class="mx-2 alert alert-success">
            {{ session('deleted-message') }}
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-12 mb-5">
                <a href="{{ route('apartment.create') }}" class=" text-black">Aggiungi nuovo Appartmanento <i class="fa-solid fa-plus"></i> </a>
            </div>
        </div>
    </div>
    @if ($apartments->total())
        <div class="d-flex flex-wrap justify-content-center">
            <div class="col-12 text-center">
                <h1>I tuoi appartamenti</h1>
            </div>
            @foreach ($apartments as $apartment)
                <div class="apartment-wrapper mx-3">
                    <div class="card">
                        <a href="{{ route('apartment.show', $apartment) }}">
                            @if (str_starts_with($apartment->image, 'https://') || str_starts_with($apartment->image, 'http://'))
                                <img class="border border-rounded" src="{{ $apartment->image }}" alt="apartment">
                            @else
                                <img class="border border-rounded" src="{{ asset('/storage') . '/' . $apartment->image }}"
                                    alt="apartment">
                            @endif
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
