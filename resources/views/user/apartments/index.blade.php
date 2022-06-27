@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('deleted-message'))
        <script>
            Swal.fire(
                'Eliminato!',
                'Il tuo annuncio è stato eliminato.',
                'success'
            )
        </script>
    @endif
    @if (session('sponsor-success-message'))
    {{-- <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                {{session('sponsor-success-message')}}
            </div>
        </div>
    </div> --}}
    <script>
        Swal.fire(
            'Sponsorizzato!',
            'Il tuo annuncio è stato sponsorizzato.',
            'success'
        )
    </script>
    @endif
    <div class="add-apartment-jumbo row justify-content-center mb-3">
        <div class="col-12 px-3 py-5 d-flex align-items-center text-white justify-content-between add-apartment-cont">
            <div class="title-add-apartment">
                <h2 class="text-white">BoolBnb - Host</h2>
                <p>Aggiungi nuovi annunci o gestisci quelli già presenti</p>
            </div>
            <a href="{{ route('apartment.create') }}" class="btn btn-light">Crea annuncio</a>
        </div>
    </div>
    @if (count($apartments) == 0)
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mt-5" style="color: grey">
                    Non ci sono appartamenti
                </h1>
            </div>
        </div>
    @endif
    @if ($apartments->total())
        <div class="row py-5 justify-content-between g-3">
            @foreach ($apartments as $apartment)
                <div class="col-12 col-lg-6 d-flex justify-content-between my-apartments">
                    <div class="apartment-img">
                        <a href="{{url('/apartment/'.$apartment->id)}}">
                            @if (str_starts_with($apartment->image, 'https://') || str_starts_with($apartment->image, 'http://'))
                                <img src="{{ $apartment->image }}" alt="apartment">
                            @else
                                <img src="{{ asset('/storage') . '/' . $apartment->image }}" alt="apartment">
                            @endif
                        </a>
                    </div>
                    <div class="apartment-info overflow-hidden">
                        <h3>{{ $apartment->title }}</h3>
                        <h5>{{ $apartment->address }}</h5>
                    </div>
                </div>
                <div class="col-12 col-lg-6 d-flex justify-content-around align-items-center px-2 mb-4">
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
                            href="{{ route('sponsorship.index', $apartment) }}">Sponsorizza</a>
                    </div>
                    <form action="{{ route('apartment.destroy', $apartment->id) }}" method="POST"
                        class="apartment-form-destroyer me-2" apartment-title="{{ $apartment->title }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger text-white">Elimina</a>
                    </form>
                </div>
                @if (!$loop->last)
                    <hr>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('footer-scripts')
    {{-- <script src="{{ asset('js/tipsAddress.js') }}"></script> --}}
    <script defer>
        const deleteForms = document.querySelectorAll('.apartment-form-destroyer');

        deleteForms.forEach(singleForm => {
            singleForm.addEventListener('submit', function(event) {
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
            })
        });
        document.addEventListener("DOMContentLoaded", function(event) { 
        function toggleDarkMode() {
            if(document.querySelector('html').classList.contains("dark"))
                enableDarkMode(false)
            else
                enableDarkMode(true)
        }
        function enableDarkMode(status = true) {
            if(status)
                document.querySelector('html').classList.add('dark')
            else
                document.querySelector('html').classList.remove('dark')
        }
        document.getElementById('theme-toggler').addEventListener('click', function() { 
            toggleDarkMode();
        }, false);
    });
    </script>
@endsection
