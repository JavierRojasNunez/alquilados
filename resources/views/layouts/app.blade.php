<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Alquila') }}</title>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light fixed-top bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Alquila') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest

                        
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                                </li>
                            @endif
                        @else

                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link">Inicio</a>
                            </li>
                            <li class="nav-item">
                               
                            </li>
                            <li class="nav-item">
                                
                            </li>
                            
                            <li class="nav-item">
                                <a href="{{ route('create.anounce') }}" id="anounce-add" class="nav-link">Publicar anuncio</a>
                            </li>
                            
                            <li class="nav-item dropdown">
                                
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('my.anounce') }}">
                                        Mis anuncios
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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
        @include('includes.anounceTypeModal')
        <main class="py-4">
            <div class="search-bar" >
                <div class="row justify-content-center">
                    <div class="col-md-4 text-center buscador-a">
                    Compra               
                    </div>
                    <div class="col-md-4  text-center buscador-a">
                     Vende
                    </div>
                    <div class="col-md-4 text-center buscador-a" >
                     Alquila
                    </div>
                    <div class="col-md-2 text-center buscador-b">
                     
                    </div>
                    <div class="col-md-8 text-center buscador-c" >
                        <form>
                            <div class="row justify-content-center" >
                                
                              <div class="col- md 3"style="padding: 4px">
                                <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Precio</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                  <option selected>Precio</option>
                                  <option value="1">menos de 80.000€</option>
                                  <option value="2">80.000€ a 200.000</option>
                                  <option value="3">mas de 200.000€ </option>
                                </select>
                              </div>
                             
                              <div class="col- md 3"style="padding: 4px">
                                <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Caracteristicas</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                  <option selected>Caracteristicas</option>
                                  <option value="1">Amueblado</option>
                                  <option value="2">Piscina</option>
                                  <option value="3">Fumador</option>
                                  <option value="3">Si mascotas</option>
                                </select>
                              </div>
                              
                              <div class="col- md 3"style="padding: 4px">
                                <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Habitaciones</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                  <option selected>Habitaciones</option>
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                  <option value="6">6</option>
                                </select>
                              </div>
                              
                              <div class="col- md 3"style="padding: 4px">
                                <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Habitaciones</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                  <option selected>Odenado por</option>
                                  <option value="1">Precio mas bajo</option>
                                  <option value="2">Precio mas alto</option>
                                </select>
                              </div>
                            </div>
                            <div class="row justify-content-center" >
                              
                              <div class="col 6" style="padding: 4px">
                                <label class="mr-sm-4 sr-only" for="inlineFormCustomSelect">Que buscas</label>
                                <select class="form-control form-control-lg" id="inlineFormCustomSelect">
                                  <option selected>Que buscas</option>
                                  <option value="1">Precio mas bajo</option>
                                  <option value="2">Precio mas alto</option>
                                </select>
                              </div>
                              <div class="col  6" style="padding: 4px">
                                <label class="mr-sm-6 sr-only" for="inlineFormCustomSelect">Donde</label>
                                <select class="form-control form-control-lg" id="inlineFormCustomSelect">
                                  <option selected>Donde</option>
                                  <option value="1">Precio mas bajo</option>
                                  <option value="2">Precio mas alto</option>
                                </select>
                              
                              </div>
                            </div>
                          </form>
                    </div>
                    <div class="col-md-2 text-center buscador-b">
                     
                    </div>
                </div>
             </div>
            @yield('content')
        </main>
    </div>
</body>
</html>
