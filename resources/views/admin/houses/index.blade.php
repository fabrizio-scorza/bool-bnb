@extends('layouts.app')
{{-- I miei appartamenti --}}
@section('title', '- I Miei Appartamenti')    

@section('content')

<section class="index">

<div class="container">
    <div class="d-flex align-items-center py-5">
        @if(request('trash'))
        <h2>
            I Miei Appartamenti Eliminati
        </h2>
        @else
        <h2>
            I Miei Appartamenti
        </h2>
        @endif
       
        {{-- <button class="ms-auto"><a href="{{route('admin.houses.create')}}" class="link-underline link-underline-opacity-0">Crea Nuovo</a></button> --}}
        <div class="ms-auto d-flex gap-3"> 
            @if(request('trash'))
            <button><a href="{{route( 'admin.houses.index')}}" class="link-underline link-underline-opacity-0">Torna alla pagina</a></button>
            @else 
            <button><a href="{{route( 'admin.houses.index', ['trash' => 1 ])}}" class="link-underline link-underline-opacity-0">Cestino ({{$trashed}})</a></button>
            <button class=""><a href="{{route('admin.houses.create')}}" class="link-underline link-underline-opacity-0">Crea Nuovo</a></button>
            @endif
        </div>
       
        
            
    </div>
</div>
<div class="container py-4">
    <div class="row row-cols-4 row-gap-4">
        @foreach ($houses as $house)
         <div class="col d-flex align-items-stretch">
            <div class="card flex-fill">
                <div class="card-header">
                    @if(request('trash'))
                    <p>{{Str::limit($house->title, 60)}}</p>
                    @else 
                    <a href="{{route('admin.houses.show', $house)}}" class="link-underline link-underline-opacity-0">{{Str::limit($house->title, 60)}}</a>
                    @endif
                    
                </div>                
                <div class="card-body text-center">
                    <img src="{{$house->thumb}}" alt="Immagine Appartamento">
                    <div class="text-start my-1">
                        {{$house->price_per_night}}€ a notte
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <div>
                        @auth
                            @if($house->user_id === Auth::id() && !$house ->trashed())
                                <button class="me-3"><a href="{{route('admin.houses.edit',$house)}}">Modifica</a></button>
                            @elseif($house->user_id === Auth::id() && $house ->trashed())
                            <form action="{{ route('admin.houses.restore', $house)}}" method="POST">
                                @csrf
                                <button>Ripristina</button>
                            </form>
                            @endif    
                        @endauth

                        @auth
                            @if($house->user_id === Auth::id() && !$house ->trashed())
                                 <button class="bg_orange" data-bs-toggle="modal" data-bs-target="#modal-{{$house->id}}" class="">Elimina</button>
                            @elseif($house->user_id === Auth::id() && $house ->trashed())
                                 <button class="bg_orange" data-bs-toggle="modal" data-bs-target="#trash_house-{{$house->id}}" class="text-start">Elimina</button>
                            @endif    
                        @endauth
                        
                        
                    </div>
                    <div>
                        <a href="" class="me-3 link-underline link-underline-opacity-0">St</a>
                        <a href="" class="link-underline link-underline-opacity-0">Sp</a>
                    </div>    
                </div>
            </div>
        </div>   

        <div class="modal" id="modal-{{$house->id}}" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Elimina</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                  <p>Cliccando su "Si" sposterai l'annuncio nel cestino, confermi? </p>
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

        <div class="modal" id="trash_house-{{$house->id}}" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Elimina</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                  <p>Cliccando su "Si" cancellerai DEFINITIVAMENTE il tuo annuncio, confermi? </p>
                </div>
                <div class="modal-footer border-0">
                  <button type="button" class="" data-bs-dismiss="modal">No</button>
                  <form action="{{ route('admin.houses.forceDestroy', $house) }}" method="POST">
                            
                    @csrf
                    @method('DELETE')
    
                    <button class="bg_orange">Si</button>
                
                    </form> 
                </div>
              </div>
            </div>
        </div>
        @endforeach        
    </div>
</div>

</section>
@endsection