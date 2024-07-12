<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BoolBnB @yield('title') </title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])

    <link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.5.0/maps/maps.css'>
</head>

<body class="d-flex flex-column vh-100">

    <nav class="navbar navbar-expand-md py-3 ">
        <div class="container">        
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto d-lg-flex align-items-lg-center">
                    <li class="nav-item ">
                        <a class="nav-link mb-lg-1" href="{{url('/') }}">
                            <img src="{{asset('/img/Logo_BoolBnB.png')}}" alt="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/advanced-search') }}">{{ __('Ricerca avanzata') }}</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Accedi') }}</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Registrati') }}</a>
                    </li>
                    @endif
                    @else

                    <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.houses.index') }}">{{__('I miei annunci')}}</a>
                    </li>                       

                    <li class="nav-item">
                        <a class=" nav-link" href="{{route('admin.messages')}}">I miei messaggi</a>                    
                    </li>

                    <li class="nav-item">
                        <a class=" nav-link" href="{{route('admin.plans')}}">Piani</a>                    
                    </li>

                    <li class="nav-item"> 
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                {{ __('Esci') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>

                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 pb-5" id="app">
        @yield('content')
    </main>
    
    <footer>
        <div class="container">
            <div class="d-flex justify-content-center align-items-baseline gap-4 flex-wrap">
                <p>Sviluppato per Boolean - Team #4 :</p>
                <a href="https://www.linkedin.com/in/domenico-de-salvo-3328a0192"> Domenico De Salvo </a>
                <a href="https://www.linkedin.com/in/fabrizio-antonio-scorza-76b570100"> Fabrizio Scorza </a>
                <a href="https://www.linkedin.com/in/francesco-matteucci-44a120315"> Francesco Matteucci </a>
                <a href="https://www.linkedin.com/in/mattia-angelo-turini-40211a315/"> Mattia Turini </a>
                <a href="https://www.linkedin.com/in/vincenzo-speciale-1a2119315/"> Vincenzo Speciale </a>
            </div>   
        </div>
        
    </footer>
</body>

</html>
