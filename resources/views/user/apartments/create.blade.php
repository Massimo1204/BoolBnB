@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="create-container my-3 pt-5">
            <h1 class="text-center">
                Aggiungi un nuovo Appartamento
            </h1>
            <form class="container-fluid px-5 mt-4" action="{{ route('apartment.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row gy-2 gx-4 px-4 apartment">
                    <div class="col-12">
                        <label for="title">Titolo*</label>
                        <input class="form-control" type="text" name="title" id="title"
                            value="{{ old('title') ?? '' }}" required autocomplete="on" autofocus minlength="5">
                        @error('title')
                            <div class="alert alert-danger mt-2">
                                Il titolo
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="image">Carica la foto cover:*</label>
                        <input class="form-control" type="file" name="image" id="image" required autocomplete="on"
                            autofocus>
                        @error('image')
                            <div class="alert alert-danger mt-2">
                                L'immagine
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="description">Descrizione*</label>
                        <textarea class="form-control" name="description" id="description" required autocomplete="on" autofocus minlength="10">{{ old('description') ?? '' }}</textarea>
                        @error('description')
                            <div class="alert alert-danger mt-2">
                                La descrizione
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-xl-6">
                        <label for="n_rooms">Numero di stanze:*</label>
                        <input class="float-end" type="number" name="n_rooms" id="n_rooms" value="{{ old('n_rooms') ?? '' }}" required
                            min="1">
                        @error('n_rooms')
                            <div class="alert alert-danger mt-2">
                                IL N. di stanze
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-xl-6">
                        <label for="n_bedrooms">Numero di stanze da letto:*</label>
                        <input class="float-end" type="number" name="n_bedrooms" id="n_bedrooms" value="{{ old('n_bedrooms') ?? '' }}" required
                            min="1">
                        @error('n_bedrooms')
                            <div class="alert alert-danger mt-2">
                                Il Numero di stanze da letto
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-xl-6">
                        <label for="n_bathrooms">Numero di bagni:*</label>
                        <input class="float-end" type="number" name="n_bathrooms" id="n_bathrooms" value="{{ old('n_bathrooms') ?? '' }}"
                            required min="1">
                        @error('n_bathrooms')
                            <div class="alert alert-danger mt-2">
                                Il N. di bagni
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-xl-6">
                        <label for="guests">Numero massimo di ospiti:*</label>
                        <input class="float-end" type="number" name="guests" id="guests" value="{{ old('guests') ?? '' }}" required
                            min="1">
                        @error('guests')
                            <div class="alert alert-danger mt-2">
                                Il Numero massimo di ospiti
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-xl-6">
                        <label for="n_beds">Numero di letti:*</label>
                        <input class="float-end" type="number" name="n_beds" id="n_beds" value="{{ old('n_beds') ?? '' }}" required
                            min="1">
                        @error('n_beds')
                            <div class="alert alert-danger mt-2">
                                Il N. di letti
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 col-xl-6">
                        <label for="price">Prezzo per ospite:*</label>

                        <input class="float-end" type="number" name="price" id="price" value="{{ old('price') ?? '' }}" required>
                        @error('price')
                            <div class="alert alert-danger mt-2">
                                Il prezzo
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-xl-6">
                        <label for="square_meters">Numero di metri quadrati: </label>
                        <input class="float-end" type="number" name="square_meters" id="square_meters"
                            value="{{ old('square_meters') ?? '' }}">
                    </div>
                    <div class="col-3">
                        <label for="visible">Visibile </label>
                        <input type="checkbox" name="visible" id="visible" checked=true>
                    </div>
                    <div class="col-3">
                        <label for="available">Disponibile </label>
                        <input type="checkbox" name="available" id="available" checked=true>
                    </div>
                    <div class="col-12">
                        <label for="address">Inserisci la via:*</label>
                        <input class="w-100" type="text" name="address" id="address"
                            value="{{ old('address') ?? '' }}" autocomplete="off" required>
                        @error('address')
                            <div class="alert alert-danger mt-2">
                                Il nome della via
                                {{ $message }}
                            </div>
                        @enderror
                        <ul class="list-group" id="results">
                            <li class="list-group-item active d-none" id="1-result"></li>
                            <li class="list-group-item active d-none" id="2-result"></li>
                            <li class="list-group-item active d-none" id="3-result"></li>
                            <li class="list-group-item active d-none" id="4-result"></li>
                            <li class="list-group-item active d-none" id="5-result"></li>
                        </ul>
                    </div>

                    <label for="address_city">Servizi:*</label>
                    @foreach ($services as $service)
                        <div class="service col-lg-6">
                            <input class="form-check-input" type="checkbox" name="service[]" value="{{ $service->id }}"
                                {{ (is_array(old('service')) and in_array($service->id, old('service'))) ? ' checked' : '' }}>
                            <label for="categories">
                                {{ $service->name }}
                            </label>
                        </div>
                    @endforeach
                    @error('service')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="col-12 mt-4">
                        <div class="w-100">
                            <label class="mb-1" for="image[]">Inserisci altre foto del tuo appartamento</label>
                            <input type="file" class="form-control" name="images[]" id="image[]" multiple>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button class="btn btn-outline-primary" type="submit">Invia</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer-scripts')
    <script src="{{ asset('js/tipsAddress.js') }}"></script>
@endsection
