@extends('layouts.app')

@section('title','Piani')

@section('content')
    <div class="container">
        <h2 class="text-center">
            I nostri piani di sponsorizzazione
        </h2>
    </div>
    <div class="container">
        <div class="row row-cols-3">
            @foreach ($plans as $plan)
            <div class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{$plan->name}}</h5>
                        <p class="card-text"><strong class="important_text">Prezzo: </strong>{{$plan->price}} €</p>
                        <p class="card-text"><strong class="important_text">Durata: </strong>{{$plan->length}} ore</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection