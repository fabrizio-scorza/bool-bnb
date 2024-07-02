@extends('layouts.app')

@section('title','Piani')

@section('content')
    <div class="container">
        <h2 class="text-center mt-2 mb-5">
            I nostri piani di sponsorizzazione
        </h2>
    </div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            @foreach ($plans as $plan)
            <div class="col-3">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{$plan->name}}</h5>
                        <p class="card-text my-1"><strong>Prezzo: </strong>{{$plan->price}} €</p>
                        <p class="card-text"><strong>Durata: </strong>{{$plan->length}} ore</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection