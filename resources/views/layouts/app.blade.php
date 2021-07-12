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
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-white shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
          {{ config('app.name', 'Alquila') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
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

              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('my.anounce') }}">
                  Mis anuncios
                </a>
                <a class="dropdown-item" href="{{ route('profile') }}">
                  Mi perfil
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
      <div class="search-bar">
        <div class="row justify-content-center">
          <div class="col-md-4 text-center buscador-a">
            Compra
          </div>
          <div class="col-md-4  text-center buscador-a">
            Vende
          </div>
          <div class="col-md-4 text-center buscador-a">
            Alquila
          </div>
          <div class="col-md-2 text-center buscador-b">

          </div>
          <div class="col-md-6 text-center buscador-c">
            <form method="POST" action="{{ route('search') }}">
              @csrf
              <div class="form-row justify-content-center">

                <div class="form-group col-md 2" style="padding: 4px">
                  <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Precio</label>
                  <select class="custom-select mr-sm-2 options" id="inlineFormCustomSelect" name="price">
                    <option selected value="{{                                  
                                    isset($value_price)  ? $value_price : ( Cookie::has('value_price')
                                    ? Cookie::get('value_price')
                                    : '0')  
                                    }}">{{                                  
                                    isset($price)  ? $price : ( Cookie::has('price')
                                    ? Cookie::get('price')
                                    : 'Precio')  
                                    }}</option>

                    <option value="alquiler-1-500">Menos de 500€ - Alquiler</option>
                    <option value="alquiler-500-800">500€ a 800€ - Alquiler</option>
                    <option value="alquiler-800-1000">800€ a 1000€ - Alquiler</option>
                    <option value="alquiler-1000-1150">1000€ a 1150€ - Alquiler</option>
                    <option value="alquiler-1150-1299">1150€ a 1299€ - Alquiler</option>
                    <option value="alquiler-1300-1000000">Mas de 1300€ - Alquiler</option>
                    <option value="venta-1-80000">Menos de 80.000€ - Venta</option>
                    <option value="venta-80000-200000">80.000€ a 200.000€ - Venta</option>
                    <option value="venta-200000-1000000000">Mas de 200.000€ - Venta</option>


                  </select>
                </div>

                <div class="form-group col-md 2" style="padding: 4px">
                  <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Caracteristicas</label>
                  <select class="custom-select mr-sm-2 options" id="inlineFormCustomSelect" name="caracteristics">
                    <option selected value="
                                   {{                                   
                                    isset($caracteristics)  ? $caracteristics : ( Cookie::has('caracteristics')
                                    ? Cookie::get('caracteristics')
                                    : 'Caracteristicas')
  
                                    }}">
                      {{                                  
                                    isset($caracteristics)  ? $caracteristics : ( Cookie::has('caracteristics')
                                    ? Cookie::get('caracteristics')
                                    : 'Características')  
                                    }}</option>
                    <option value="Amueblado">Amueblado</option>
                    <option value="Calefacción">Calefacción</option>
                    <option value="Gas">Gas</option>
                    <option value="Piscina">Piscina</option>
                    <option value="Fumador">Fumador</option>
                    <option value="Mascotas">Mascotas</option>
                  </select>
                </div>

                <div class="form-group col-md 2" style="padding: 4px">
                  <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Habitaciones</label>
                  <select class="custom-select mr-sm-2 options" id="inlineFormCustomSelect" name="room">
                    <option selected value="{{                                   
                                    isset($room_value)  ? $room_value : ( Cookie::has('room_value')
                                    ? Cookie::get('room_value')
                                    : 0 )
  
                                    }}">{{                                  
                                    isset($room)  ? $room : ( Cookie::has('room')
                                    ? Cookie::get('room')
                                    : 'Habitaciones')  
                                    }}</option>
                    <option value="1">1 Habitacion</option>
                    <option value="2">2 Habitaciones</option>
                    <option value="3">3 Habitaciones</option>
                    <option value="4">4 Habitaciones</option>
                    <option value="5">5 Habitaciones</option>
                    <option value="6">6 Habitaciones</option>
                  </select>
                </div>

                <div class="form-group col-md 2" style="padding: 4px">
                  <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Habitaciones</label>
                  <select class="custom-select mr-sm-2 options" id="inlineFormCustomSelect" name="order_by">
                    <option selected value="{{                                  
                                    isset($order_by_value)  ? $order_by_value : ( Cookie::has('order_by_value')
                                    ? Cookie::get('order_by_value')
                                    : 0 )  
                                    }}">{{                                  
                                    isset($order_by)  ? $order_by : ( Cookie::has('order_by')
                                    ? Cookie::get('order_by')
                                    : 'Ordenar por')  
                                    }}</option>
                    <option value="1">Precio mas bajo</option>
                    <option value="2">Precio mas alto</option>
                  </select>
                </div>
              </div>
              <div class="form-row justify-content-center" style="margin-bottom:-25px !important">

                <div class="form-group col-md-4">
                  <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Que buscas</label>
                  <select class="custom-select principal" id="inlineFormCustomSelect" name="what">
                    <option selected value="{{                                  
                                      isset($what_value)  ? $what_value : ( Cookie::has('what_value')
                                      ? Cookie::get('what_value')
                                      : 0 )  
                                      }}">{{                                  
                                      isset($what_value)  ? $what_value : ( Cookie::has('what_value')
                                      ? Cookie::get('what_value')
                                      : 'Qué buscas')  
                                      }}</option>
                    <option value="Todo">{{ __('Todo') }}</option>
                    <option value="Piso">{{ __('Piso') }}</option>
                    <option value="Casa">{{ __('Casa') }}</option>
                    <option value="Habitación">{{ __('Habitación') }}</option>
                    <option value="Apartamento">{{ __('Apartamento') }}</option>
                    <option value="Compartir apartamento">{{ __('Compartir apartamento') }}</option>
                    <option value="Local">{{ __('Local') }}</option>
                    <option value="Casa rural">{{ __('Casa rural') }}</option>
                    <option value="Apartamento rural">{{ __('Apartamento rural') }}</option>
                    <option value="Loft">{{ __('Loft') }}</option>
                    <option value="Estudio">{{ __('Estudio') }}</option>
                    <option value="Dúplex">{{ __('Dúplex') }}</option>
                    <option value="Ático">{{ __('Ático') }}</option>
                    <option value="Masía">{{ __('Masía') }}</option>
                    <option value="Bungalow">{{ __('Bungalow') }}</option>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label class="mr-lg sr-only" for="inlineFormCustomSelect">Donde</label>
                  <select class="custom-select principal" id="inlineFormCustomSelect" name="province_rent"
                    id="province_rent">
                    <option selected>{{ 

                                  isset($province)  ? $province : ( Cookie::has('province_rent')
                                  ? Cookie::get('province_rent')
                                  : 'Dónde')

                                  }}</option>
                    @foreach(Config::get('provinces') as $provinces)
                    <option value="{{$provinces}}">{{$provinces}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-2">
                  <button type="submit" id="submit1" class="btn-search">{{ __('Buscar') }}</button>
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

    @include('footer')

  </div>
</body>

</html>