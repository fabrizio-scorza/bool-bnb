@extends('layouts.app')

@section('title')
- {{Str::limit($house->title, 10)}} 
@endsection   

@section('content')

<section class="show">
    <div class="container">
        <div class="show_title my-5">
            <h2>
                {{$house->title}}
            </h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8">
                
                
                <figure>
                    <img src="{{ asset('storage/' . $house->thumb)}}" alt="Immagine Appartamento">
                </figure>
                
            </div>
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-6">
                            <h5>Dettagli</h5>
                            <ul class="list-unstyled">
                                <li>
                                    {{$house->category->name ?? ''}}
                                </li>
                                <li>
                                    <span>R</span>
                                    {{$house->rooms}}
                                </li>
                                <li>
                                    <span>L</span>
                                    {{$house->beds}}
                                </li>
                                <li>
                                    <span>B</span>
                                    {{$house->bathrooms}}
                                </li>
                                <li>
                                    <span>Mq</span>
                                    {{$house->square_mt}}
                                </li>                       
                            </ul>
                        </div>                    
                        <div class="col-6">
                            <h5>Servizi Aggiuntivi</h5>
                            <ul class="list-unstyled">
                                @foreach ($house->services as $service)
                                    <li>
                                        {{$service->name}}
                                    </li>                                    
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-12">
                            <p>
                                {{$house->address}}
                            </p>
                            <p class="d-flex justify-content-between">
                                {{$house->price_per_night}}€ / a notte
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container px-5 my-5">
        <p>{{$house->description}}</p>
    </div>
    <div>
        <map-component :house='@json($house)'><map-component/>
    </div>
    
</section>
@endsection