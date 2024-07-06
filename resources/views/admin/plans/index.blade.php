@extends('layouts.app')

@section('title','Piani')

@section('content')
<section class="plans">
    <div class="container">
        <h2 class="text-center my-5">
            I nostri piani di sponsorizzazione
        </h2>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            @foreach ($plans as $plan)
            <div class="col-3">
                <div class="card mb-3">
                    <div class="card-header">
                        Piano n°{{$plan->id}}
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">Livello <strong class="plan_name">{{$plan->name}}</strong></h5>
                        <p class="card-text my-1"><strong>Prezzo: </strong>{{$plan->price}} €</p>
                        <p class="card-text"><strong>Durata: </strong>{{$plan->length}} ore</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
  </section>
@endsection