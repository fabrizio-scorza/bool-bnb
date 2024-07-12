@extends('layouts.app')

@section('title')
- {{Str::limit($house->title, 10)}} 
@endsection   

@section('content')

@if(session('conferma'))
    <div class="alert alert-success container fs-3 mt-5">
        {{ session('conferma') }}
    </div>
@endif

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
                @if($house->description) 
                <div class="card mb-5">     
                    <figure>
                        <img src="{{ asset('storage/' . $house->thumb)}}" alt="Immagine Appartamento">
                    </figure>                                    
                    <div class="card-body">
                        <p>{{$house->description}}</p>
                    </div>
                </div>  
            @else                
            <figure>
                <img src="{{ asset('storage/' . $house->thumb)}}" alt="Immagine Appartamento">
            </figure>
            @endif                  
            </div>
            <div class="col-12 col-lg-4">
                <div class="card mb-5">
                    <div class="card-body row">
                        <div class="col-6">
                            <h5>Dettagli</h5>
                            <ul class="list-unstyled">
                                <li>
                                    <span><i class="fa-solid fa-door-closed"></i></span>
                                    {{$house->rooms}}
                                </li>
                                <li>
                                    <span><i class="fa-solid fa-bed"></i></span>
                                    {{$house->beds}}
                                </li>
                                <li>
                                    <span><i class="fa-solid fa-toilet"></i></span>
                                    {{$house->bathrooms}}
                                </li>
                                <li>
                                    <span><i class="fa-solid fa-ruler-combined"></i></span>
                                    {{$house->square_mt}}
                                </li>                       
                            </ul>
                        </div>                    
                        <div class="col-6">
                            <h5>Servizi Aggiuntivi</h5>
                            <ul class="list-unstyled">
                                @foreach ($house->services as $service)
                                <li>                                
                                    @if($service->id === 1)
                                        <i class="fa-solid fa-wifi"></i>
                                    @elseif($service->id === 2)                                
                                        <i class="fa-solid fa-car"></i>                                
                                    @elseif($service->id === 3)                                
                                        <i class="fa-solid fa-person-swimming"></i>                                
                                    @elseif($service->id === 4)                                
                                        <i class="fa-solid fa-bell-concierge"></i>                                
                                    @elseif($service->id === 5)                                
                                        <i class="fa-solid fa-temperature-full"></i>                                
                                    @elseif($service->id === 6)                                
                                        <i class="fa-solid fa-umbrella-beach"></i>                               
                                    @elseif($service->id === 7)                                
                                        <i class="fa-regular fa-snowflake"></i>                               
                                    @elseif($service->id === 8)                                
                                        <i class="fa-solid fa-hot-tub-person"></i>                                
                                    @elseif($service->id === 9)                                
                                        <i class="fa-solid fa-martini-glass"></i>                                
                                    @endif
                                    {{$service->name}}
                                </li>                                     
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-12">
                            <p>
                                {{$house->address}}
                            </p>
                            <div class="d-flex justify-content-between">
                                <div><strong>{{$house->price_per_night}}€</strong> notte</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <map-component :house='@json($house)'><map-component/>
    </div>

    <div class="container my-5">
        <form action="{{route('store')}}" method="POST" >
            @csrf

            <div class="row">

                <div class="mb-4 col-6">
                    <label for="name" class=" col-form-label text-md-right">Nome</label>
    
                    <div >
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>
                </div>
    
                <div class="mb-4 col-6">
                    <label for="surname" class=" col-form-label text-md-right">Cognome</label>
    
                    <div >
                        <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}">
                    </div>
                </div>
    
                <div class="mb-4 col-12">
                    <label for="email" class=" col-form-label text-md-right">Indirizzo email*</label>
    
                    <div>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
                    </div>
                </div>
    
                <div class="form-group mb-4 col-12">
                    <label for="text" class="col-form-label">Scrivi un messaggio* </label>
                    <div>
                        <textarea name="text" id="text" cols="80" rows="5" placeholder="Scrivi qui il tuo messaggio" required class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>

                <input type="hidden" id="house_id" name="house_id" readonly value="{{$house->id}}">

            </div>
            <button>Invia</button>
        </form>
    </div>
    
</section>
@endsection