@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mt-5">
        @foreach ($sponsorships as $sponsorship)
            <div class="col-3">
                <div class="card">
                    <h3 class="card-title m-3">{{ucfirst($sponsorship->name)}}</h3>
                    <p class="card-text m-3">Questa è una offerta molto bella dovresti assolutamente comprarla e darmi tutti i soldi che hai.</p>
                    <p class="card-text m-3">L' offerta dura: {{$sponsorship->duration}} ore</p>
                    <a href="{{route('payments.index', [$sponsorship, $apartment] )}}" class="btn btn-primary">Vai al pagamento</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
