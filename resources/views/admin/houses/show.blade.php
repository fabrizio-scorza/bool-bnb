@extends('layouts.app')

@section('title')
- {{Str::limit($house->title, 10)}} 
@endsection   

@section('content')

<section class="show">
    <div class="container">
        <div class="d-flex align-items-center my-5">
            <h2 class="pe-5">
                {{$house->title}}
            </h2>
            <button class="ms-auto me-3"><a href="{{route('admin.houses.edit',$house)}}">Modifica</a></button>
            <button data-bs-toggle="modal" data-bs-target="#modal-{{$house->id}}" class="bg_orange">Elimina</button>
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
    <div class="container px-5 my-5">
        <p>{{$house->description}}</p>
    </div>
    <div>
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