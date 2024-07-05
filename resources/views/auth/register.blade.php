@extends('layouts.app')

@section('content')
<section class="register">
    <div class="container pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">{{ __('Registrazione') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" id="registrationForm">
                            @csrf
    
                            <div class="mb-4 row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
    
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
    
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="mb-4 row">
                                <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Cognome') }}</label>
    
                                <div class="col-md-6">
                                    <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}">
    
                                    @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="mb-4 row">
                                <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">Data di nascita</label>
    
                                <div class="col-md-6">
                                    <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" value="{{ old('date_of_birth') }}" >
                                    @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="mb-4 row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo email*') }}</label>
    
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
    
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="mb-4 row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password*') }}</label>
    
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
    
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="mb-4 row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password*') }}</label>
    
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <ul id="errorList" class="text-danger"></ul>
                            </div>
    
                            <div class="mx-5 text-center">
                                <div>
                                    <button type="submit">
                                        {{ __('Registrati') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('registrationForm');
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            validateForm();
        });

        function validateForm() {
            const name = document.getElementById('name').value;
            const surname = document.getElementById('surname').value;
            const dateOfBirth = document.getElementById('date_of_birth').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password-confirm').value;

            let errors = [];

            if (!email.trim()) {
                errors.push('Il campo Indirizzo email è obbligatorio.');
            } else if (!isValidEmail(email)) {
                errors.push('Inserisci un indirizzo email valido.');
            }

            if (!password.trim()) {
                errors.push('Il campo Password è obbligatorio.');
            } else if (password.length < 8) {
                errors.push('La password deve contenere almeno 8 caratteri.');
            }

            if (password !== confirmPassword) {
                errors.push('Le password non corrispondono.');
            }

            if (errors.length > 0) {
                showErrors(errors);
            } else {
                form.submit();
            }
        }

        function isValidEmail(email) {
            const re = /\S+@\S+\.\S+/;
            return re.test(email);
        }

        function showErrors(errors) {
            const errorList = document.getElementById('errorList');
            errorList.innerHTML = '';

            errors.forEach(error => {
                const li = document.createElement('li');
                li.textContent = error;
                errorList.appendChild(li);
            });
        }
    });
</script>

@endsection
