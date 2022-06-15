@extends('layouts.app')

@section('content')
<h1 class="text-center">
    Aggiungi un nuovo Appartamento
</h1>
<div class="container mt-5 w-50">
    <form class="row g-3" action="{{route("apartment.store")}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row apartment">
            <div class="col-12">
                <label for="title">Titolo</label>
                <input class="w-100" type="text" name="title" id="title">
            </div>
            <div class="col-12">
                <label for="image">Carica una foto:</label>
                <input type="file" name="image" id="image">
            </div>
            <div class="col-12">
                <label for="description">Descrizione</label>
                <textarea class="w-100" name="description" id="description"></textarea>
            </div>
            <div class="col-3">
                <label for="n_rooms">Numero di stanze:</label>
                <input type="number" name="n_rooms" id="n_rooms">
            </div>
            <div class="col-3">
                <label for="n_bedrooms">Numero di stanze da letto:</label>
                <input type="number" name="n_bedrooms" id="n_bedrooms">
            </div>
            <div class="col-3">
                <label for="n_beds">Numero di bagni:</label>
                <input type="number" name="n_beds" id="n_beds">
            </div>
            <div class="col-3">
                <label for="guests">Numero massimo di ospiti:</label>
                <input type="number" name="guests" id="guests">
            </div>
            {{-- <div class="col-3">
                <label for="visible">Spuntare la seguente checkbox per rendere l'appartamento visibile </label>
                <input type="number" name="visible" id="visible">
            </div>
            <div class="col-3">
                <label for="available">Spuntare la seguente checkbox per rendere l'appartamento disponibile </label>
                <input type="number" name="available" id="available">
            </div> --}}
            <div class="col-3">
                <label for="visible">Spuntare la seguente checkbox per rendere l'appartamento visibile </label>
                <input type="checkbox" name="visible" id="visible" checked=true>
            </div>
            <div class="col-3">
                <label for="available">Spuntare la seguente checkbox per rendere l'appartamento disponibile </label>
                <input type="checkbox" name="available" id="available" checked=true>
            </div>
            <div class="col-3">
                <label for="price">Inserisci il prezzo a notte per ospite: </label>
                <input type="number" name="price" id="price">
            </div>
            <div class="col-3">
                <label for="square_meters">Inserisci il numero di metri quadrati: </label>
                <input type="number" name="square_meters" id="square_meters">
            </div>
            <div class="col-3">
                <label for="lat">Inserisci la latitudine: </label>
                <input type="number" name="lat" id="lat">
            </div>
            <div class="col-3">
                <label for="long">Inserisci la longitudine:</label>
                <input type="number" name="long" id="long">
            </div>
            <div class="col-12">
                <label for="address">inserisci la via:</label>
                <input class="w-100" type="text" name="address" id="address">
            </div>
            <div class="col-12">
                <button class="btn btn-outline-primary" type="submit">send</button>
            </div>
        </div>
    </form>
</div>
@endsection
