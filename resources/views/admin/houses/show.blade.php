@extends('layouts.app')

@section('title')
- {{Str::limit($house->title, 10)}} 
@endsection   

@section('content')

<div class="container">
    <div class="d-flex align-items-center my-5">
        <h2 class="fs-4 text-secondary pe-5">
            {{$house->title}}
        </h2>
        <button class="ms-auto me-3">Modifica</button>
        <button >Elimina</button>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-8">
            <img src="{{$house->thumb}}" alt="Immagine Appartamento">  
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body row">
                    <div class="col-6">
                        <span>Dettagli</span>
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
                        <span>Servizi Aggiuntivi</span>
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
                            <span>
                                <a href="" class="me-3 link-underline link-underline-opacity-0">Messaggi</a>
                                <a href="" class="me-3 link-underline link-underline-opacity-0">St</a>
                                <a href="" class="me-3 link-underline link-underline-opacity-0">Sp</a>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <p>{{$house->description}}</p>
</div>
<div>
    <map-component></map-component>
</div>
@endsection