@extends('layouts.app')

@section('content')

    <h1 class="text-center">
        Modifica Appartamento
    </h1>
    <div class="container mt-5 w-50 ">
        <form class="row g-3" action="{{ route('apartment.update', $apartment) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row apartment">
                <div class="col-12">
                    <label for="title">Titolo</label>
                    <input class="w-100" type="text" name="title" id="title" value="{{ $apartment->title }}">
                    @error('title')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="image">Carica una foto:</label>
                    <input type="file" name="image" id="image" value="{{ $apartment->image }}">
                    @error('image')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="description">Descrizione</label>
                    <input class="w-100" type="text" name="description" id="description"
                        value="{{ $apartment->description }}">
                    @error('description')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="n_rooms">Numero di stanze:</label>
                    <input type="number" name="n_rooms" id="n_rooms" value="{{ $apartment->n_rooms }}">
                    @error('n_rooms')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="n_bedrooms">Numero di stanze da letto:</label>
                    <input type="number" name="n_bedrooms" id="n_bedrooms" value="{{ $apartment->n_bedrooms }}">
                    @error('n_bedrooms')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="n_beds">Numero di bagni:</label>
                    <input type="number" name="n_beds" id="n_beds" value="{{ $apartment->n_beds }}">
                    @error('n_beds')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="n_bathrooms">Numero di bagni:</label>
                    <input type="number" name="n_bathrooms" id="n_bathrooms" value="{{ $apartment->n_bathrooms }}">
                    @error('n_bathrooms')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="guests">Numero massimo di ospiti:</label>
                    <input type="number" name="guests" id="guests" value="{{ $apartment->guests }}">
                    @error('guests')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="visible">Spuntare la seguente checkbox per rendere l'appartamento visibile </label>
                    <input type="checkbox" name="visible" id="visible" @if ($apartment->visible == 1) checked @endif>
                </div>
                <div class="col-12">
                    <label for="available">Spuntare la seguente checkbox per rendere l'appartamento disponibile </label>
                    <input type="checkbox" name="available" id="available" @if ($apartment->available == 1) checked @endif>
                </div>
                <div class="col-12">
                    <label for="price">Inserisci il prezzo a notte per ospite: </label>
                    <input type="number" name="price" id="price" value="{{ $apartment->price }}">
                    @error('price')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="square_meters">Inserisci il numero di metri quadrati: </label>
                    <input type="number" name="square_meters" id="square_meters" value="{{ $apartment->square_meters }}">
                    @error('square_meters')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="address">inserisci la via:</label>
                    <input class="w-100" type="text" name="address" id="address"
                        value="{{ $apartment->address }}">
                    @error('address')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="address_number">inserisci in numero:</label>
                    <input class="w-100" type="text" name="address_number" id="address_number"
                        value="{{ $apartment->address_number }}">
                    @error('address_number')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="address_city">inserisci la città:</label>
                    <input class="w-100" type="text" name="address_city" id="address_city"
                        value="{{ $apartment->address_city }}">
                    @error('address_city')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 mb-3">
                    @foreach ($services as $service)
                        <input class="form-check-input" type="checkbox" name="service[]" value="{{ $service->id }}"
                            {{ $apartment->services->contains($service) ? 'checked' : '' }}>
                        <label for="categories">
                            {{ $service->name }}
                        </label>
                    @endforeach
                </div>
                <div class="col-12">
                    <label for="image[]">inserisci altre foto del tuo appartamento</label>
                    {{-- @dd($apartment->pictures) --}}
                    <input type="file" class="form-control" name="images[]" id="image[]"  multiple>
                </div>
                <div class="col-12">
                    @foreach ($sponsorships as $sponsorship)
                        <div class="col-3">
                            <label for="sponsorship">{{$sponsorship->name}}</label>
                            <input type="radio" name="sponsorship" id="sponsorship" value="{{$sponsorship->id}}">
                        </div>
                    @endforeach       
                    <button class="btn btn-outline-primary" type="submit">send</button>
                </div>
            </div>
        </form>
        <div class="delete-button">
            @if (Auth::user()->id == $apartment->user_id)
                <form action="{{ route('user.apartment.destroy', $apartment->id) }}" method="POST" class="apartment-form-destroyer"
                    apartment-title="{{ $apartment->title }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</a>
                </form>    
            @endif
        </div>
    </div>



    <div class="edit row">
        <div class="col-12">
            <h1 class="text-center">
                Le foto del tuo appartamento:
            </h1>
        </div>
        @if (session('deleted-message'))
            <div class="mx-2 alert alert-success">
                {{session('deleted-message')}}
            </div>
            @endif
            {{-- @dd($apartment->pictures) --}}
        @foreach ($apartment->pictures as $photo)
            <div class="col-4 my-2 position-relative">
                <div class="delete position-absolute">
                    <form action="{{route('picture.destroy',$photo)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="fas fa-x"></i></button>
                    </form>
                </div>
                <img src="{{$photo->image}}" alt="apartment img" >
            </div>
        @endforeach
    </div>
@endsection

            

