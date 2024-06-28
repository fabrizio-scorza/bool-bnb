@extends('layouts.app')

@section('title', '- Nuovo Annuncio')


@section('content')

<div class="container">
    <h3>Crea Un Nuovo Annuncio</h3>
</div>
<div class="container">
    <form action="" method="post">
        @csrf

        <div class="form-group">
            <label for="title">Titolo Annuncio</label>
            <input type="text" class="form-control" id="title" placeholder="Il titolo del tuo alloggio" name="title" value="{{ old('title') }}">
        </div>

          <div class="form-group">
            <label for="description">Descrizione</label>
            <textarea name="description" id="description" cols="80" rows="5" placeholder="Scrivi un annuncio accattivante per rendere il tuo alloggio più..." class="form-control">{{ old('description') }}"</textarea>
          </div>

        <div class="form-group">
            <label for="rooms">Inserisci il numero di stanze</label>
            <input type="number" min="1" max="30" class="form-control" id="rooms" name="rooms" placeholder="1-30" value="{{ old('rooms') }}">
        </div>

        <div class="form-group">
            <label for="beds">Inserisci il numero di posti letto</label>
            <input type="number" min="1" max="90" class="form-control" id="beds" name="beds" placeholder="1-90" value="{{ old('beds') }}">
        </div>

        <div class="form-group">
            <label for="bathrooms">Inserisci il numero di bagni</label>
            <input type="number" min="1" max="10" class="form-control" id="bathrooms" name="bathrooms" placeholder="1-10" value="{{ old('bathrooms') }}">
        </div>

        <div class="form-group">
            <label for="square-mt">Inserisci i metri quadri</label>
            <input type="number" min="30" max="1000" class="form-control" id="square-mt" name="square-mt" placeholder="30-1000" value="{{ old('square-mt') }}">
        </div>

        <div class="form-group">
            <label for="address">Inserici l'indirizzo</label>
            <input type="text" class="form-control" id="address" placeholder="indirizzo del tuo alloggio" name="address" value="{{ old('address') }}">
        </div>

        <div class="form-group">
            <label for="thumb">Inserisci l'immagine di copertina</label>
            <input type="url" class="form-control" id="thumb" placeholder="http://..." name="thumb"
            value="{{ old('thumb') }}">
        </div>

        <div class="form-group">
            <label for="price_per_night">Inserisci il prezzo per notte</label>
            <input type="number" min="1" max="9999" class="form-control" id="price_per_night" name="price_per_night" placeholder="1-9999 €" value="{{ old('price_per_night') }}">
        </div>

        <div class="form-group">
            <label for="category" class="form-label">Categoria</label>
            <select class="form-control" name="category" id="category">
              <option value="">-- Seleziona Categoria--</option>
              @foreach($categories as $category) 
                <option @selected( $category->id == old('category_id') ) value="{{ $category->id }}"> {{ $category->name }}</option>
              @endforeach
            </select>
          </div>

        </select>
        
        <div class="form-group mb-3" id="checklist">
            <label for="checklist">Servizi Aggiuntivi</label>
            <div class="d-flex gap-3 py-2">
              @foreach ($services as $service)
                  <div class="form-check">
                    <input @checked(in_array($service->id, old('services',[]))) name="services[]" class="form-check-input" type="checkbox" value="{{$service->id}}" id="service-{{$service->id}}">
                    <label class="form-check-label" for="service-{{$service->id}}"> {{$service->name}}</label>
                  </div>
              @endforeach
            </div>
          </div>
          
        <button type="submit" class="btn btn-primary">Crea</button>

    </form>
    <div class="container"> 
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
   
</div>

@endsection   