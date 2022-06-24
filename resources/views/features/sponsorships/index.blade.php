@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pb-5">
        <div class="col-12">
            <h1 class="text-center fw-bold text-success mt-5">Attiva Sponsorizzazione</h1>
        </div>
        @foreach ($sponsorships as $sponsorship)
            <div class="col-12 col-lg-4 col-md-10 mt-4">
                <div class="card">
                    <h2 class="card-title m-3">{{ucfirst($sponsorship->name)}}</h2>
                    <p class="card-text m-3">Questa è una offerta molto bella dovresti assolutamente comprarla e darmi tutti i soldi che hai.</p>
                    <p class="card-text m-3">L' offerta dura: {{$sponsorship->duration}} ore</p>
                    <h1 class="card-text pb-2 mx-auto" style="color: rgb({{rand(0,255)}},{{rand(0,255)}},{{rand(0,255)}});">{{$sponsorship->price}}$</h1>
                    <a href="{{route('payments.index', [$sponsorship, $apartment] )}}" class="btn btn-primary">Vai al pagamento</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
