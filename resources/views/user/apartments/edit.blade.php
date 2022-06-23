@extends('layouts.app')

@section('content')
    <h1 class="text-center mt-3">
        Modifica Appartamento
    </h1>
    <div class="container-fluid edit-container my-3 px-5">
        <div class="edit">
            <div class="col-sm-12">
                <h6>
                    Le foto del tuo appartamento:
                </h6>
            </div>
            @if (session('deleted-message'))
                <script>
                    Swal.fire(
                        'Eliminato!',
                        'La foto è stata eliminata.',
                        'success'
                    )
                </script>
            @endif
            {{-- @dd($apartment->pictures) --}}
            <div class="picsContainer col-12 d-flex flex-wrap mb-4">
                @foreach ($apartment->pictures as $photo)
                    <div class="w-25 p-1 position-relative">
                        <div class="delete position-absolute">
                            <form action="{{ route('picture.destroy', $photo) }}" method="POST"
                                class="picture-form-destroyer">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-1 delete">X</button>
                            </form>
                        </div>
                        @if (str_starts_with($apartment->image, 'https://') || str_starts_with($apartment->image, 'http://'))
                            <img class="rounded-1 w-100" src="{{ $photo->image }}" alt="apartment img">
                        @else
                            <img class="rounded-1 w-100" src="{{ asset('/storage') . '/' . $photo->image }}" alt="">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <form class="w-100" action="{{ route('apartment.update', $apartment) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row gy-sm-5 apartment">
                <div class="col-sm-12">
                    <label for="title">Titolo*</label>
                    <input class="form-control" type="text" name="title" id="title"
                        value="{{ old('title') ?? $apartment->title }}" required autocomplete="on" autofocus
                        minlength="5">
                    @error('title')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-sm-12 mt-3">
                    <label for="image">Carica la foto cover:*</label>
                    <input type="file" name="image" id="image" value="{{ $apartment->image }}">
                    @error('image')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-sm-12">
                    <label for="description">Descrizione*</label>
                    <textarea class="form-control" type="text" name="description" id="description" required autocomplete="on" autofocus
                        minlength="10">{{ old('description') ?? $apartment->description }}</textarea>
                    @error('description')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 col-md-6 col-lg-4 col-xxl-3">
                    <label for="n_rooms">Numero di stanze:*</label>
                    <input type="number" name="n_rooms" id="n_rooms"
                        value="{{ old('n_rooms') ?? $apartment->n_rooms }}" required min="1">
                    @error('n_rooms')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 col-md-6 col-lg-4 col-xxl-3">
                    <label for="n_bedrooms">Numero di stanze da letto:*</label>
                    <input type="number" name="n_bedrooms" id="n_bedrooms"
                        value="{{ old('n_bedrooms') ?? $apartment->n_bedrooms }}" required min="1">
                    @error('n_bedrooms')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 col-md-6 col-lg-4 col-xxl-3">
                    <label for="n_beds">Numero di letti:*</label>
                    <input type="number" name="n_beds" id="n_beds" value="{{ old('n_beds') ?? $apartment->n_beds }}"
                        required min="1">
                    @error('n_beds')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 col-md-6 col-lg-4 col-xxl-3">
                    <label for="n_bathrooms">Numero di bagni:*</label>
                    <input type="number" name="n_bathrooms" id="n_bathrooms"
                        value="{{ old('n_bathrooms') ?? $apartment->n_bathrooms }}" required min="1">
                    @error('n_bathrooms')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 col-md-6 col-lg-4 col-xxl-3">
                    <label for="guests">Numero massimo di ospiti:*</label>
                    <input type="number" name="guests" id="guests" value="{{ old('guests') ?? $apartment->guests }}"
                        required min="1">
                    @error('guests')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-12 col-md-6 col-lg-4 col-xxl-3">
                    <label for="price">Inserisci il prezzo a notte per ospite:* </label>
                    <input type="number" step="0.01" name="price" id="price"
                        value="{{ old('price') ?? $apartment->price }}" required min="1">
                    @error('price')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12 col-md-6 col-lg-4 col-xxl-3 mb-2">
                    <label for="square_meters">Inserisci il numero di metri quadrati: </label>
                    <input type="number" name="square_meters" id="square_meters"
                        value="{{ old('square_meters') ?? $apartment->square_meters }}">
                    @error('square_meters')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-3">
                    <label for="visible">Visibile </label>
                    <input type="checkbox" name="visible" id="visible"
                        @if ($apartment->visible == 1) checked @endif>
                </div>
                <div class="col-3">
                    <label for="available">Disponibile </label>
                    <input type="checkbox" name="available" id="available"
                        @if ($apartment->available == 1) checked @endif>
                </div>
                <div class="col-12">
                    <label for="address">inserisci la via:*</label>
                    <input class="w-100" type="text" name="address" id="address"
                        value="{{ old('address') ?? $apartment->address }}" autocomplete="off" required>
                    @error('address')
                        <div class="alert alert-danger mt-2">
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

                <label for="address_city">Servizi:*</label><br>

                @foreach ($services as $service)
                    <div class="service col-lg-4">
                        <input class="form-check-input ms-2" type="checkbox" name="service[]"
                            value="{{ $service->id }}"
                            {{ old('service') != null && in_array($service->id, old('service')) ? 'checked' : ($apartment->services->contains($service) ? 'checked' : '') }}>
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

                <div class="col-12 mt-3">
                    <label for="image[]">inserisci altre foto del tuo appartamento</label>
                    {{-- @dd($apartment->pictures) --}}
                    <input type="file" class="form-control" name="images[]" id="image[]" multiple>
                </div>
                <div class="col-10 mt-3">
                    <div class="Send my-auto">
                        <button class="btn btn-outline-primary btn-md" type="submit">send</button>
                    </div>

                </div>
            </div>
        </form>
        <div class="delete-button mt-2">
            @if (Auth::user()->id == $apartment->user_id)
                <form action="{{ route('apartment.destroy', $apartment->id) }}" method="POST"
                    class="apartment-form-destroyer">
                    {{-- apartment-title="{{ $apartment->title }}" --}}
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-md ms-auto">Delete</a>
                </form>
            @endif
        </div>
    </div>
@endsection
@section('footer-scripts')
    <script src="{{ asset('js/tipsAddress.js') }}"></script>
    <script defer>
        const deleteForm = document.querySelector('.apartment-form-destroyer');

        deleteForm.addEventListener('submit', function(event) {
            event.preventDefault(); // § blocchiamo l'invio del form
            Swal.fire({
                title: 'Sei Sicuro?',
                text: "Non sarà più possibile tornare indietro!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Elimina!'
            }).then((result) => {
                if (result.isConfirmed) {

                    this.submit();
                }
            })
        });

        const deletePicture = document.querySelector('.picture-form-destroyer');

        deletePicture.addEventListener('submit', function(event) {
            event.preventDefault(); // § blocchiamo l'invio del form
            Swal.fire({
                title: 'Sei Sicuro?',
                text: "Non sarà più possibile tornare indietro!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Elimina!'
            }).then((result) => {
                if (result.isConfirmed) {

                    this.submit();
                }
            })
        });
    </script>
@endsection
