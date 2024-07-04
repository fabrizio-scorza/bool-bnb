@extends('layouts.app')

@section('content')
<section class="verify">
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">{{ __('Verifica il tuo indirizzo emali.') }}</div>
    
                    <div class="card-body">
                        @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Un nuovo link di verifica è stato inviato al tuo indirizzo email.') }}
                        </div>
                        @endif
    
                        {{ __('Prima di continuare, per favore, controlla la tua email a cui è`stato inviato il link di verifica.') }}
                        {{ __('Se non hai ricevuto la mail') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('clicca qui per riceverne un\'altra') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
