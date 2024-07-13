@extends('layouts.app')

@section('title', 'Piani')

@section('content')
<section class="plans">
    <div class="container">
        <h2 class="text-center my-5">
            I nostri piani di sponsorizzazione
        </h2>
    </div>
        <payment-component :houses='@json($houses)' :plans='@json($plans)' :house_id='@json($house_id)'></payment-component>
</section>


@endsection
