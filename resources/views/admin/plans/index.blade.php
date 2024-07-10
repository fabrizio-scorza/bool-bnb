@extends('layouts.app')

@section('title', 'Piani')

@section('content')
<section class="plans">
    <div class="container">
        <h2 class="text-center my-5">
            I nostri piani di sponsorizzazione
        </h2>
    </div>
    <div class="container">
        <div class="form-group mb-4">
            <div class="row row-cols-1 row-cols-md-3 d-flex justify-content-center">
                @foreach ($plans as $plan)
                <div class="col">
                    <div class="card mb-3">
                        <div class="card-header">
                            Piano n°{{ $plan->id }}
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">Livello <strong class="plan_name">{{ $plan->name }}</strong></h5>
                            <p class="card-text my-1"><strong>Prezzo: </strong>{{ $plan->price }} €</p>
                            <p class="card-text"><strong>Durata: </strong>{{ $plan->length }} ore</p>
                            <input type="radio" id="plan-{{ $plan->id }}" name="plan" value="{{ $plan->price }}" v-model="selectedAmount">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="form-group">
            <label class="mb-4" for="house_id">Seleziona l'appartamento da sponsorizzare</label>
            <select class="form-control" name="house_id" id="house_id">
            <option value="">-- Appartamento--</option>
            @foreach($houses as $house) 
                <option @selected( $house->id == old('house_id') ) value="{{ $house->id }}"> {{ $house->title }}</option>
            @endforeach
            </select>
        </div>
    </div>

        <payment-component :amount="selectedAmount"></payment-component>
</section>


@endsection
