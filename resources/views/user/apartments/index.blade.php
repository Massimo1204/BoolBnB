@extends('layouts.app')

@section('content')
    @if (session('deleted-message'))
        <script>
            Swal.fire(
                'Eliminato!',
                'Il tuo annuncio è stato eliminato.',
                'success'
            )
        </script>
    @endif
    <div class="add-apartment-jumbo">
        <div class="container">
            <div class="row">
                <div class="col-12 py-5 d-flex align-items-center text-white justify-content-between">
                    <div class="title-add-apartment">
                        <h2 class="text-white">BoolBnb - Host</h2>
                        <p>Aggiungi nuovi annunci o gestisci quelli già presenti</p>
                    </div>
                    <a href="{{ route('apartment.create') }}" class="btn btn-light">Crea annuncio</a>
                </div>
            </div>
        </div>
    </div>
    @if ($apartments->total())
        <div class="container py-5">
            <div class="row py-5 justify-content-between">
                @foreach ($apartments as $apartment)
                    <div class="col-6 d-flex justify-content-between my-apartments">
                        <div class="apartment-img">
                            <a href="{{ route('apartment.show', $apartment) }}">
                                @if (str_starts_with($apartment->image, 'https://') || str_starts_with($apartment->image, 'http://'))
                                    <img src="{{ $apartment->image }}" alt="apartment">
                                @else
                                    <img src="{{ asset('/storage') . '/' . $apartment->image }}" alt="apartment">
                                @endif
                            </a>
                        </div>
                        <div class="apartment-info">
                            <h3>{{ $apartment->title }}</h3>
                            <h5>{{ $apartment->address }}</h5>
                        </div>
                    </div>
                    <div class="col-6 d-flex justify-content-start align-items-start p-5">
                        <div class="btn btn-primary me-2">
                            <a class="text-white text-decoration-none"
                                href="{{ route('apartment.edit', $apartment) }}">Modifica</a>
                        </div>
                        <div class="btn btn-primary me-2">
                            <a class="text-white text-decoration-none"
                            href="{{url('/apartment/statistics/'.$apartment->id)}}">Statistiche</a>
                        </div>
                        <div class="me-2">
                            <a type="button" class="btn btn-success"
                                href="{{ route('sponsorship.index', $apartment) }}">Attiva sponsorizzazione</a>
                        </div>
                        <form action="{{ route('apartment.destroy', $apartment->id) }}" method="POST"
                            class="apartment-form-destroyer me-2" apartment-title="{{ $apartment->title }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger text-white">Elimina</a>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection

@section('footer-scripts')
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
    </script>
@endsection
