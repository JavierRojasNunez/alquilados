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
                    <div class="col-md-6 text-center buscador-c" >
                        <form method="POST"  action="{{ route('search') }}">
                            @csrf
                            <div class="form-row justify-content-center" >
                                
                              <div class="form-group col-md 2"style="padding: 4px">
                                <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Precio</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                  <option selected>Precio</option>
                                  <option value="1">menos de 80.000€</option>
                                  <option value="2">80.000€ a 200.000</option>
                                  <option value="3">mas de 200.000€ </option>
                                </select>
                              </div>
                             
                              <div class="form-group col-md 2"style="padding: 4px">
                                <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Caracteristicas</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="caracteristics">
                                  <option selected>Caracteristicas</option>
                                  <option value="funiture">Amueblado</option>
                                  <option value="calefaction">Calefacción</option>
                                  <option value="gas">Gas</option>
                                  <option value="swiming">Piscina</option>
                                  <option value="lookfor_who_tabaco ">Fumador</option>
                                  <option value="lookfor_who_pet">Si mascotas</option>
                                </select>
                              </div>
                              
                              <div class="form-group col-md 2"style="padding: 4px">
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
                              
                              <div class="form-group col-md 2"style="padding: 4px">
                                <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Habitaciones</label>
                                <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                  <option selected>Odenado por</option>
                                  <option value="1">Precio mas bajo</option>
                                  <option value="2">Precio mas alto</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-row justify-content-center" >
                                
                              <div class="form-group col-md-4" style="padding: 4px">
                                <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Que buscas</label>
                                <select class="custom-select" id="inlineFormCustomSelect">
                                    <option selected>Que buscas</option>
                                    <option>{{ __('Todo') }}</option>
                                    <option>{{ __('Piso') }}</option>
                                    <option>{{ __('Casa') }}</option>
                                    <option>{{ __('Habitación') }}</option>
                                    <option>{{ __('Apartamento') }}</option>
                                    <option>{{ __('Compartir apartamento') }}</option>
                                    <option>{{ __('Local') }}</option>
                                    <option>{{ __('Casa rural') }}</option>
                                    <option>{{ __('Apartamento rural') }}</option>
                                    <option>{{ __('Loft') }}</option>
                                    <option>{{ __('Estudio') }}</option>
                                    <option>{{ __('Dúplex') }}</option>
                                    <option>{{ __('Ático') }}</option>
                                    <option>{{ __('Masía') }}</option>
                                    <option>{{ __('Bungalow') }}</option>
                                </select>
                              </div>
                             
                              <div class="form-group col-md-8" style="padding: 4px">
                                <label class="mr-lg sr-only" for="inlineFormCustomSelect">Donde</label>
                                <select class="custom-select" id="inlineFormCustomSelect" name="province_rent" id="province_rent">
                                  <option selected>Donde</option>
                                  @foreach(Config::get('provinces') as $provinces)
                                  <option value="{{$provinces}}">{{$provinces}}</option>
                                  @endforeach
                                </select>
                              </div>
                                    
                                <button  type="submit" id="submit1" class="btn btn-primary" style="width: 50%;text-align:center ">{{ __('Enviar') }}</button>
                                
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
