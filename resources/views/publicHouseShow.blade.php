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

    @if(session('conferma'))
    <div class="alert alert-success">
        {{ session('conferma') }}
    </div>
    @endif

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
                    <label for="text" class="col-form-label">Scrivi un messaggio</label>
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