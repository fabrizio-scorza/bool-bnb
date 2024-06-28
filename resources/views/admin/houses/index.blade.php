@extends('layouts.app')

@section('title', '- I Miei Appartamenti')    

@section('content')

<div class="container">
    <div class="d-flex align-items-center my-5">
        <h2 class="fs-4 text-secondary">
            I Miei Appartamenti
        </h2>
        <button class="ms-auto"><a href="{{route('admin.houses.create')}}" class="link-underline link-underline-opacity-0">Crea Nuovo</a></button>
    </div>
</div>
<div class="container py-4">
    <div class="row row-cols-4">
        @foreach ($houses as $house)
         <div class="col d-flex align-items-stretch">
            <div class="card flex-fill">
                <div class="card-header">
                    <a href="{{route('admin.houses.show', $house)}}" class="link-underline link-underline-opacity-0">{{Str::limit($house->title, 60)}}</a>
                </div>                
                <div class="card-body">
                    <img src="{{$house->thumb}}" alt="Immagine Appartamento">
                    <div>
                        {{$house->price_per_night}}€
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <div>
                        <button class="me-3"><a href="{{route('admin.houses.edit',$house)}}">Modifica</a></button>
                        <button>Elimina</button>
                    </div>
                    <div>
                        <a href="" class="me-3 link-underline link-underline-opacity-0">St</a>
                        <a href="" class="link-underline link-underline-opacity-0">Sp</a>
                    </div>    
                </div>
            </div>
        </div>   
        @endforeach        
    </div>
</div>

@endsection