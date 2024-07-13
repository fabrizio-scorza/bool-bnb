@extends('layouts.app')
{{-- I miei appartamenti --}}
@section('title', '- I miei annunci')    

@section('content')

<section class="index">

    <div class="container">
        <div class="index_title  py-5">
            @if(request('trash'))
            <h2>
                I miei annunci eliminati
            </h2>
            @else
            <h2>
                I miei annunci
            </h2>
            @endif
        
            <div class=" d-flex justify-content-evenly gap-3"> 
                @if(request('trash'))
                <button><a href="{{route( 'admin.houses.index')}}" class="link-underline link-underline-opacity-0">Torna alla pagina</a></button>
                @else 
                <button><a href="{{route( 'admin.houses.index', ['trash' => 1 ])}}" class="link-underline link-underline-opacity-0">Cestino ({{$trashed}})</a></button>
                <button class=""><a href="{{route('admin.houses.create')}}" class="link-underline link-underline-opacity-0">Crea nuovo</a></button>
                @endif
            </div>
        
            
                
        </div>
    </div>
    <div class="container py-4">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4  row-gap-4 center">
            @foreach ($houses as $house)
            <div class="col-8 m-auto m-sm-0 d-flex align-items-stretch">
                <div class="card flex-fill">
                    <div class="card-header">
                        @if(request('trash'))
                            <p class="mb-0">{{Str::limit($house->title, 60)}}</p>
                        @else 
                            <a href="{{route('admin.houses.show', $house)}}" class="link-underline link-underline-opacity-0">{{Str::limit($house->title, 60)}}</a>
                        @endif
                        
                    </div>                
                    <div class="card-body position-relative">
                        @if($house->thumb)
                        <figure>
                            <img src="{{ asset('storage/' . $house->thumb)}}" alt="Immagine Appartamento">
                        </figure>
                        @endif
                        @foreach ($house->plans as $plan)
                        @if($plan->pivot->expires_at > $now)
                        <div class="position-absolute badge rounded-pill my_sponsor">
                            <i class="fa-solid fa-trophy"></i>
                        </div>
                        @endif
                        @endforeach
                        <div class="mt-3">
                            {{ $house->address }}
                        </div>
                        <div class="d-flex gap-5 mt-1">
                            <span>Stanze: {{ $house->rooms }}</span>
                            <span><i class="fa-solid fa-bed"></i> {{ $house->beds }}</span>
                        </div>
                        <div class="mt-1">
                            <strong>{{ $house->price_per_night }}€</strong> notte
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            @foreach ($house->services as $service)
                            @if($service->id === 1)
                            <div>
                                <i class="fa-solid fa-wifi"></i>
                            </div>
                            @elseif($service->id === 2)
                            <div>
                                <i class="fa-solid fa-car"></i>
                            </div>
                            @elseif($service->id === 3)
                            <div>
                                <i class="fa-solid fa-person-swimming"></i>
                            </div>
                            @elseif($service->id === 4)
                            <div>
                                <i class="fa-solid fa-bell-concierge"></i>
                            </div>
                            @elseif($service->id === 5)
                            <div>
                                <i class="fa-solid fa-temperature-full"></i>
                            </div>
                            @elseif($service->id === 6)
                            <div>
                                <i class="fa-solid fa-umbrella-beach"></i>
                            </div>
                            @elseif($service->id === 7)
                            <div>
                                <i class="fa-regular fa-snowflake"></i>
                            </div>
                            @elseif($service->id === 8)
                            <div>
                                <i class="fa-solid fa-hot-tub-person"></i>
                            </div>
                            @elseif($service->id === 9)
                            <div>
                                <i class="fa-solid fa-martini-glass"></i>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-2 ">
                            @auth
                                @if($house->user_id === Auth::id() && !$house ->trashed())
                                    <button><a href="{{route('admin.houses.edit',$house)}}">Modifica</a></button>
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
                                @endif    
                            @endauth
                            
                            
                        </div>
                        <div class="fs-4">
                            {{-- <a href="" class="me-3 link-underline link-underline-opacity-0"><i class="fa-solid fa-chart-line"></i></a> --}}
                            <a href="{{ route('admin.plans', ['house_id' => $house->id]) }}" class="link-underline link-underline-opacity-0"><i class="fa-regular fa-credit-card"></i></a>
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
                    <p>Cliccando su "Sì" sposterai l'annuncio nel cestino, confermi? </p>
                    </div>
                    <div class="modal-footer border-0">
                    <button type="button" class="" data-bs-dismiss="modal">No</button>
                    <form action="{{ route('admin.houses.destroy', $house) }}" method="POST">
                                
                        @csrf
                        @method('DELETE')
        
                        <button class="bg_orange">Sì</button>
                    
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