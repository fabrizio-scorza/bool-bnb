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
            <div class=" d-flex justify-content-evenly gap-3">
                <button><a href="{{route('admin.houses.edit',$house)}}">Modifica</a></button>
                <button data-bs-toggle="modal" data-bs-target="#modal-{{$house->id}}" class="bg_orange">Elimina</button>
            </div>
        </div>
    </div>
    <div class="container ">
        <div class="row ">
            <div class="col-12 col-lg-8">     
                <figure>
                    <img src="{{ asset('storage/' . $house->thumb)}}" alt="Immagine Appartamento">
                </figure> 
                <div class="card my-5">
                    <div class="card-body">
                            <p>{{$house->description}}</p>
                    </div>
                </div>               
            </div>
            <div class="col-12 col-lg-4 group">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-6">
                            <h5>Dettagli</h5>
                            <ul class="list-unstyled">
                                <li>
                                    {{$house->category->name ?? ''}}
                                </li>
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
                                <div>
                                    <a href="" class="me-3 link-underline link-underline-opacity-0"><i class="fa-solid fa-chart-line fs-5"></i></a>
                                    <a href="{{route('admin.plans')}}" class="link-underline link-underline-opacity-0"><i class="fa-regular fa-credit-card fs-5"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="messages mt-5">
                    @foreach ($house->messages as $message) 
                    <div class="card mb-3">
                        <div class="card-header">
                            <div>
                                {{$message->name}} {{$message->surname}} {{substr($message->created_at, 8, 2) . '/' . substr($message->created_at, 5, 2) . '/' . substr($message->created_at, 0, 4) . ' - ' . substr($message->created_at, 11, 5)}}  
                            </div>
                            <div>
                                {{$message->email}}
                            </div>
                        </div>
                        <div class="card-body">
                            <p>{{$message->text}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="my-4">
        <map-component :house='@json($house)'><map-component/>
    </div>
    
    <div class="modal" id="modal-{{$house->id}}" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Elimina</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
              <p>Vuoi spostare questo annuncio nel cestino?</p>
            </div>
            <div class="modal-footer border-0">
              <button type="button" class="" data-bs-dismiss="modal">No</button>
              <form action="{{ route('admin.houses.destroy', $house) }}" method="POST">
                        
                @csrf
                @method('DELETE')
    
                <button class="bg_orange">Si</button>
            
                </form> 
            </div>
          </div>
        </div>
    </div>
</section>
@endsection