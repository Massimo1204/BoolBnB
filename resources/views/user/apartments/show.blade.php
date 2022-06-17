@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if (session('sponsor-success-message'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success">
                    {{session('sponsor-success-message')}}
                </div>
            </div>
        </div>
    @endif

    <div class="row mb-3">
        <div class="col-12 text-center">
            <h1>{{ ucfirst($apartment->title) }}</h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-8 show-img mb-3">
            @if (str_starts_with($apartment->image, 'https://') || str_starts_with($apartment->image, 'http://'))
                <img class="rounded-1 w-100" src="{{ $apartment->image }}" alt="{{ $apartment->title }}">
            @else
                <img class="rounded-1 w-100" src="{{ asset('/storage') . '/' . $apartment->image }}" alt="{{ $apartment->title }}">
            @endif
        </div>
        <div class="col-12 mb-3">
            <div class="row justify-content-center">
                @foreach ($apartment->pictures as $photo)
                    <div class="col-2 show-thumbnails">
                        @if (str_starts_with($apartment->image, 'https://') || str_starts_with($apartment->image, 'http://'))
                            <img class="rounded-1 w-100" src="{{$photo->image}}" alt="apartment img" >
                        @else
                            <img class="rounded-1 w-100" src="{{ asset('/storage') . '/' . $photo->image }}" alt="apartment img">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-10">
            <p class="fs-3">{{ $apartment->description }}</p>
        </div>
    </div>
</div>
    @if (Auth::user()->id == $apartment->user_id)
        <div class="d-flex justify-content-evenly mt-3">
            <div class="btn btn-primary btn-sm">
                <a class="text-white text-decoration-none" href="{{ route('apartment.edit', $apartment) }}">Edit</a>
            </div>
            <div>
                <a type="button" class="btn btn-success" href="{{route('sponsorship.index', $apartment)}}">Attiva sponsorizzazione</a>
            </div>
            <form action="{{ route('apartment.destroy', $apartment->id) }}" method="POST" class="apartment-form-destroyer"
                apartment-title="{{ $apartment->title }}">
                @csrf
                @method('DELETE')
    
                <button type="submit" class="btn btn-danger btn-sm text-white">Delete</a>
            </form>
        </div>
    @endif
@endsection

@section('footer-scripts')
    <script defer>
        const deleteForm = document.querySelector('.apartment-form-destroyer');

        deleteForm.addEventListener('submit', function(event) {
            event.preventDefault(); // § blocchiamo l'invio del form
            userConfirmation = window.confirm(
                `Sei sicuro di voler eliminare ${this.getAttribute('apartment-title')}?`);
            if (userConfirmation) {
                this.submit();
            }
        });
    </script>
@endsection
