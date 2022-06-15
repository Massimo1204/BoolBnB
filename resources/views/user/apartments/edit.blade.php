@extends('layouts.app')

@section('content')
<h1 class="text-center">
    Modifica Appartamento
</h1>
<div class="container mt-5 w-50">
    <form class="row g-3" action="{{route("apartment.update",$apartment)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row apartment">
            <div class="col-12">
                <label for="title">Titolo</label>
                <input class="w-100" type="text" name="title" id="title" value="{{$apartment->title}}">
            </div>
            <div class="col-12">
                <label for="image">Carica una foto:</label>
                <input type="file" name="image" id="image" value="{{$apartment->image}}">
            </div>
            <div class="col-12">
                <label for="description">Descrizione</label>
                <input class="w-100" type="text" name="description" id="description" value="{{$apartment->description}}">
            </div>
            <div class="col-12">
                <label for="n_rooms">Numero di stanze:</label>
                <input type="number" name="n_rooms" id="n_rooms" value="{{$apartment->n_rooms}}">
            </div>
            <div class="col-12">
                <label for="n_bedrooms">Numero di stanze da letto:</label>
                <input type="number" name="n_bedrooms" id="n_bedrooms" value="{{$apartment->n_bedrooms}}">
            </div>
            <div class="col-12">
                <label for="n_beds">Numero di bagni:</label>
                <input type="number" name="n_beds" id="n_beds" value="{{$apartment->n_beds}}">
            </div>
            <div class="col-12">
                <label for="n_bathrooms">Numero di bagni:</label>
                <input type="number" name="n_bathrooms" id="n_bathrooms" value="{{$apartment->n_bathrooms}}">
            </div>
            <div class="col-12">
                <label for="guests">Numero massimo di ospiti:</label>
                <input type="number" name="guests" id="guests" value="{{$apartment->guests}}">
            </div>
            <div class="col-12">
                <label for="visible">Spuntare la seguente checkbox per rendere l'appartamento visibile </label>
                <input type="checkbox" name="visible" id="visible" checked=true @if ($apartment->visible)checked
                @endif>
            </div>
            <div class="col-12">
                <label for="available">Spuntare la seguente checkbox per rendere l'appartamento disponibile </label>
                <input type="checkbox" name="available" id="available" checked=true @if ($apartment->available)checked
                @endif>
            </div>
            <div class="col-12">    
                <label for="price">Inserisci il prezzo a notte per ospite: </label>
                <input type="number" name="price" id="price" value="{{$apartment->price}}">
            </div>
            <div class="col-12">
                <label for="square_meters">Inserisci il numero di metri quadrati: </label>
                <input type="number" name="square_meters" id="square_meters" value="{{$apartment->square_meters}}">
            </div>
            <div class="col-12">
                <label for="address">inserisci la via:</label>
                <input class="w-100" type="text" name="address" id="address" value="{{$apartment->address}}">
            </div>
            <div class="col-12">
                <button class="btn btn-outline-primary" type="submit">send</button>
            </div>
        </div>
    </form>
</div>
@endsection