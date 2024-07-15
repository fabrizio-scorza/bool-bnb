@extends('layouts.app')

@section('title', '- Modifica annuncio')


@section('content')

    <section class="edit">
       <div class="container">
           <h3>Modifica il tuo annuncio</h3>
       </div>
       <div class="container">
           <form id="edit-form" action="{{route('admin.houses.update', $house)}}" method="POST" enctype="multipart/form-data">
               @csrf
               @method('PUT')
       
               <div class="form-group mb-4">
                   <label for="title">Titolo annuncio *</label>
                   <input type="text" required class="form-control" id="title" placeholder="Il titolo del tuo alloggio" name="title" value="{{ old('title', $house->title) }}" maxlength="255">
               </div>
       
               <div class="form-group mb-4">
               <label for="description">Descrizione</label>
               <textarea name="description" id="description" cols="80" rows="5" placeholder="Scrivi un annuncio accattivante per rendere il tuo alloggio più..." class="form-control">{{ old('description', $house->description) }}</textarea>
               </div>
       
       
               <div class="row row-cols-2 row-cols-lg-4 mb-4">
                   <div class="form-group mb-4">
                       <label for="rooms">Numero di stanze *</label>
                       <input type="number" required min="1" max="30" class="form-control" id="rooms" name="rooms" placeholder="1-30" value="{{ old('rooms', $house->rooms) }}">
                   </div>
           
                   <div class="form-group mb-4">
                       <label for="beds">Numero di posti letto *</label>
                       <input type="number" required min="1" max="90" class="form-control" id="beds" name="beds" placeholder="1-90" value="{{ old('beds', $house->beds) }}">
                   </div>
           
                   <div class="form-group mb-4">
                       <label for="bathrooms">Numero di bagni *</label>
                       <input type="number" required min="1" max="10" class="form-control" id="bathrooms" name="bathrooms" placeholder="1-10" value="{{ old('bathrooms', $house->bathrooms) }}">
                   </div>
           
                   <div class="form-group mb-4">
                       <label for="square_mt">Metri quadri *</label>
                       <input type="number" required min="30" max="1000" class="form-control" id="square_mt" name="square_mt" placeholder="30-1000" value="{{ old('square_mt', $house->square_mt) }}">
                   </div>
               </div>  
               <div class="form-group mb-4">
                    <label for="address">Indirizzo *</label>
                    <address-component
                        :initial-address="'{{ old('address', $house->address) }}'"
                        :initial-latitude="{{ old('latitude', $house->latitude) }}"
                        :initial-longitude="{{ old('longitude', $house->longitude) }}"
                    ></address-component>
                </div>

               <div class="form-group mb-4">
                <label for="thumb" class="form-label">Immagine annuncio *</label>
                <input class="form-control" type="file" id="thumb" name="thumb" >
              </div>
               
               <div class="row row-cols-2 row-cols-xl-3 row-gap-3">
                   <div class="form-group">
                       <label for="price_per_night">Prezzo per notte *</label>
                       <input type="number" required min="1" max="9999.99" step="0.01" class="form-control" id="price_per_night" name="price_per_night" placeholder="1-9999.99 €" value="{{ old('price_per_night', $house->price_per_night) }}">
                   </div>
           
                   <div class="form-group">
                       <label for="category_id">Categoria</label>
                       <select class="form-control" name="category_id" id="category_id">
                         <option value="">-- Seleziona categoria--</option>
                         @foreach($categories as $category) 
                           <option @selected( $category->id == old('category_id', $house->category_id) ) value="{{ $category->id }}"> {{ $category->name }}</option>
                         @endforeach
                       </select>
                     </div>
           
                   <div class="form-group col-10 m-auto m-xl-0 col-xl mb-4" id="checklist">
                       <label for="checklist">Servizi aggiuntivi</label>
                       <div class="row row-cols-2 row-cols-md-3 row-cols-xl-2 row-cols-xxl-3">
                         @foreach ($services as $service)
                             <div class="form-check">
                               <input @checked(in_array($service->id, old('services', $house->services->pluck('id')->all()))) name="services[]" class="form-check-input" type="checkbox" value="{{$service->id}}" id="service-{{$service->id}}">
                               <label class="form-check-label" for="service-{{$service->id}}"> {{$service->name}}</label>
                             </div>
                         @endforeach
                       </div>
                       <span id="services-error" class="text-danger fw-bold" style="display: none;">Devi selezionare almeno un servizio aggiuntivo.</span>
                     </div>
               </div>
       
                <div class="form-group mb-4">
                   <h4>Visibilità annuncio nella ricerca</h4>
                   <div class="d-flex gap-3">
                    <div class="d-flex gap-1">
                        <input type="radio"  id="1" name="available" value="1" {{ old('available', $house->available) == '1' ? 'checked' : '' }}>
                        <label for="1">Visibile</label>
                    </div>
                    <div class="d-flex gap-1">
                        <input type="radio"  id="0" name="available" value="0" {{ old('available', $house->available) == '0' ? 'checked' : '' }}>
                        <label for="0">Non visibile</label>            
                    </div>
                   </div>
                </div>
       
               <div class="mb-4 fw-lighter">
                   <p>
                       I campi contrassegnati con l'asterisco (*) sono obbligatori
                   </p>
               </div>
               
               <button type="submit">Salva</button>
       
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
   </section>

   <script>
        document.addEventListener("DOMContentLoaded", function() {
            function validateCheckboxes() {
                const checkboxes = document.querySelectorAll('input[name="services[]"]');
                const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

                const errorSpan = document.getElementById('services-error');

                if (!isChecked) {
                    errorSpan.style.display = 'block';
                    return false;
                }else{
                    errorSpan.style.display = 'none';
                    return true;
                }

            }

            const form = document.querySelector('#edit-form');

            if (form) {
                form.addEventListener('submit', function(event) {
                    if (!validateCheckboxes()) {
                        event.preventDefault();
                    }
                });
            }
        });
    </script>

@endsection   