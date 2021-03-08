@extends('layouts.app')

<?php


/*if(!isset($anuncio) || !$anuncio){
  $anuncio  = false;
}

if(!isset($anounce_id) || !$anounce_id){
  $anounce_id  = false;
}*/

//dd($anuncio)
if(!$anounce_id ){
  $h1Title = 'Publicar anuncio.';
}else{
  $h1Title = 'Editar anuncio.';
}



?>

@section('content')
<div class="container">
    

    @include('includes.mensajes')
    <form method="POST" id="form_anuncio" action="{{ route('save.anounce') }}" enctype="multipart/form-data">
        @csrf
    <div class="row justify-content-center">
      @if(!$anounce_id )
      <div class="col-md-9">
      <div class="tituloPrincipal" >
        <h1>{{$h1Title}}</h1>
        </div>
      </div>
      @else
      <div class="col-md-3">
        <div class="tituloPrincipal" >
          <h1>{{$h1Title}}</h1>
          </div>
        </div>
      <div class="col-md-3">
        <div class="tituloPrincipal-menu" >
          <h5>Datos Principales</h5>
          </div>
        </div>
        <div class="col-md-3" style="vertical-align: bottom !important;">
          <div class="tituloPrincipal-menu-images" >
          <a href="{{ route('edit.images', ['id' => $anounce_id]) }}">  
            <h5>Imagenes</h5>
          </a> 
          </div>
          </div>
          @endif
        <div class="col-md-9">
          @if(isset($numAnounces) && $numAnounces >= 1)
            
          <?php
            if ($numAnounces <= 1)  {
              $publicado = 'publicado' ;
              $anuncio_s = 'anuncio'; 
            }else
            {
              $publicado = 'publicados';
              $anuncio_s = 'anuncios'; 
            } 
          ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert" >
            <strong>{{ Auth::user()->name }}</strong> Ya tienes {{ $publicado }} {{ $numAnounces }} {{ $anuncio_s }} de 2.
      
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
            <div class="card">
                <div class="card-header">{{ __('Empecemos a rellenar los datos.') }}</div>

                <div class="card-body">
                    
                            

        <div class="alert alert-warning alert-dismissible fade show" role="alert" >
            Los campos con un asterisco rojo son obligatorios. Los demas campos puede dejarlos vacios y rellenar solo los que 
            creas que son los mas importantes. A más datos, mas posibilidad de conseguir tu propósito. Hay que incluir minimo una imagen
            y maximo 5.

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>


          
            <div class="form-row">
                
                <div class="form-group col-md-4">

                  @if (isset($anounce_id) && $anounce_id)
                    <input type="hidden" value="{{$anounce_id}}" name="anounce_id">
                  @endif

                  <label for="type_rent">{{ __('Que ofreces') }}<sup style="color:red; font-size:16px">*</sup></label>
                  
                  <select id="type_rent" name="type_rent" class="form-control @error('type_rent') is-invalid @enderror"    required  >
                    <option selected > {{ $anuncio ? $anuncio->type_rent :  old('type_rent') }} </option>                                   
                    <option>{{ __('Piso') }}</option>
                    <option>{{ __('Casa') }}</option>
                    <option>{{ __('Habitación') }}</option>
                    <option>{{ __('Compartir habitación') }}</option>
                    <option>{{ __('Apartamneto') }}</option>
                    <option>{{ __('Compartir apartamento') }}</option>
                    <option>{{ __('Local') }}</option>
                    <option>{{ __('Casa rural') }}</option>
                    <option>{{ __('Apartamento rural') }}</option>
                    <option>{{ __('Terreno') }}</option>
                    <option>{{ __('Loft') }}</option>
                    <option>{{ __('Estudio') }}</option>
                    <option>{{ __('Dúplex') }}</option>
                    <option>{{ __('Ático') }}</option>
                    <option>{{ __('Masía') }}</option>
                    <option>{{ __('Bungalow') }}</option>
                  </select>
                  @error('type_rent')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
                </div>
                <div class="form-group col-md-4">
                  <label for="price">{{ __('Por cuanto (€)') }}<sup style="color:red; font-size:16px">*</sup></label>
                  <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror"   value="{{ $anuncio ? $anuncio->price :   old('price') }}" required autocomplete="price"  >
                  @error('price')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="payment_period">{{ __('Alquiler o Venta') }}<sup style="color:red; font-size:16px">*</sup></label>
                    <select id="payment_period" name="payment_period" class="form-control @error('payment_period') is-invalid @enderror"   value="{{ old('payment_period') }}" required autocomplete="payment_period" >
                      <option   selected>{{  $anuncio ? $anuncio->payment_period :  old('payment_period') }}</option>
                      <option>{{ __('alquiler diario') }}</option>
                      <option>{{ __('alquiler semanal') }}</option>
                      <option> {{ __('alquiler mensual') }}</option>
                      <option> {{ __('alquiler anual') }}</option>
                      <option> {{ __('alquiler de temporada') }}</option>
                      <option> {{ __('aquiler con opción a compra') }}</option>
                      <option> {{ __('traspaso') }}</option>
                      <option>{{ __('venta') }}</option>
                    </select>
                    @error('payment_period')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
                </div>
              </div>
            <div class="form-row">
            <div class="form-group col-md-3">
                <label for="num_rooms">{{ __('Habitaciones totales') }}</label>
                <input type="number"  id="num_rooms" placeholder="0"  name="num_rooms" class="form-control @error('num_rooms') is-invalid @enderror"   value="{{ $anuncio ? $anuncio->num_rooms :   old('num_rooms') }}"  autocomplete="num_rooms" >
                @error('num_rooms')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              </div>
              <div class="form-group col-md-3">
                <label for="num_rooms_for_rent">{{ __('Habitaciones disp.') }}</label>
                <input type="number" id="num_rooms_for_rent" placeholder="0"  name="num_rooms_for_rent" class="form-control @error('num_rooms_for_rent') is-invalid @enderror"   value="{{ $anuncio ? $anuncio->num_roomms_for_rent :   old('num_rooms_for_rent') }}"  autocomplete="num_rooms_for_rent" >
              
                @error('num_rooms_for_rent')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror</div>
              <div class="form-group col-md-3">
                <label for="num_baths">{{ __('Nº baños') }}</label>
                <input type="number"  id="num_baths" placeholder="0"  name="num_baths" class="form-control @error('num_baths') is-invalid @enderror"   value="{{ $anuncio ? $anuncio->num_baths :   old('num_baths') }}"  autocomplete="num_baths" >
                @error('num_baths')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              </div>
              <div class="form-group col-md-3">
                <label for="meter2">{{ __('Superficie ') }}m<sup>2</sup></label>
                <input type="number" id="meter2" placeholder="0"  name="meter2" class="form-control @error('meter2') is-invalid @enderror"   value="{{  $anuncio ? $anuncio->meter2 :   old('meter2') }}"  autocomplete="meter2" >
                @error('meter2')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="minimum_stay">{{ __('Estancia minima ->') }}</label>
                <input type="number"  id="minimum_stay" name="minimum_stay"  class="form-control @error('minimum_stay') is-invalid @enderror"   value="{{  $anuncio ? $anuncio->minimun_stay :   old('minimum_stay') }}"  autocomplete="minimum_stay" >
                @error('minimum_stay')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              </div>
              
              <div class="form-group col-md-3">
                <label for="minimum_stay_type">{{ __('Por') }}</label>
                <select id="minimum_stay_type" name="minimum_stay_type" class="form-control @error('minimum_stay_type') is-invalid @enderror"   value="{{ $anuncio ? $anuncio->minimun_stay_type :   old('minimum_stay_type') }}"  autocomplete="minimum_stay_type"  >
                  <option  selected>{{  $anuncio ? $anuncio->minimum_stay_type :   old('minimum_stay_type') }}</option>
                  <option>Días</option>
                  <option>Semanas</option>
                  <option>Meses</option>
                  <option>Años</option>
                </select>
                @error('minimum_stay_type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              </div>
              <div class="form-group col-md-3">
                <label for="deposit">{{ __('¿Deposito inicial? (€)') }}</label>
                <input type="number"  id="deposit" name="deposit"  class="form-control @error('deposit') is-invalid @enderror"   value="{{ $anuncio ? $anuncio->deposit :   old('deposit') }}"  autocomplete="deposit" >
                @error('deposit')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              </div>
              <div class="form-group col-md-3">
                <label for="available_date">{{ __('Fecha disponibilidad') }}</label>
                <input type="date"  name="available_date" id="available_date" class="form-control @error('available_date') is-invalid @enderror"   value="{{  $anuncio ? $anuncio->available_date :   old('available_date') }}"  autocomplete="available_date" >
                @error('available_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              </div>
              
              <div class="form-group col-md-12">
                <label for="titulo">{{__('Titulo')}}<sup style="color:red; font-size:16px">*</sup></label>
                <input type="text" name="titulo" id="titulo" class="form-control @error('titulo') is-invalid @enderror"   value="{{ $anuncio ? $anuncio->titulo :   old('titulo') }}" required  autocomplete="titulo" >
                @error('titulo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              </div>
              <div class="form-group col-md-12">
                <label for="descripcion">{{__('Descripción')}}</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ $anuncio ? $anuncio->descripcion :   old('descripcion') }} </textarea>
              </div>
            </div>
           
           
          
        {{-- fin nuevo  --}}



                </div>
            </div>
        </div>
                <div class="col-md-9">
                    <br />
                <div class="card">
                    <div class="card-header">{{ __('Perfil de los ocupantes actuales') }}</div>
    
                    <div class="card-body">

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="num_people_in">{{ __('Numero personas ahora') }}</label>
                                
                                <input type="number"  id="num_people_in" name="num_people_in" placeholder="0" class="form-control @error('num_people_in') is-invalid @enderror"   value="{{  $anuncio ? $anuncio->num_people_in :    old('num_people_in') }}"  autocomplete="num_people_in" >
                                @error('num_people_in')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                              </div>
                              
                            <div class="form-group col-md-4">
                              <label for="people_in_sex">{{ __('Quien vive en ella') }}</label>                 
                              <select id="people_in_sex" class="form-control @error('people_in_sex') is-invalid @enderror" name="people_in_sex"  value="{{ old('people_in_sex') }}"  autocomplete="people_in_sex" >
                                <option selected >{{   $anuncio ? $anuncio->people_in_sex :    old('people_in_sex')  }}</option>
                                <option>{{ __('Chicas') }}</option>
                                <option>{{ __('Chicos') }}</option>
                                <option>{{ __('Mixto') }}</option>
                                <option>{{ __('Indiferente') }}</option>
                                <option>{{ __('Nadie') }}</option>
                              </select>
                              @error('people_in_sex')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="people_in_job">{{ __('Ocupación')}}</label>
                                <select id="people_in_job"  class="form-control @error('people_in_job') is-invalid @enderror" name="people_in_job"  value="{{ old('people_in_job') }}"  autocomplete="people_in_job" >
                                  <option selected>{{   $anuncio ? $anuncio->people_in_job :    old('people_in_job') }}</option>
                                  <option>{{ __('Profesional') }}</option>
                                  <option>{{ __('Estudiantes') }}</option>
                                  <option>{{ __('Mixto') }}</option>
                                  <option>{{ __('Indiferente') }}</option>
                                </select>
                                @error('people_in_job')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                              </div>
                              
                          </div>
                          <br /> 
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label class="switchBtn">
                                <input class="form-check-input" type="checkbox" id="people_in_tabaco" {{ ( $anuncio and $anuncio->people_in_tabaco) ? 'checked' : ''}} name="people_in_tabaco" class="form-control @error('people_in_tabaco') is-invalid @enderror"    >
                                                                
                                <div class="slide round">{{ __('Fuman') }}</div>
                            </label>
                                
                              </div>
                              <div class="form-group col-md-6">
                                <label class="switchBtn">
                                  <input class="form-check-input" type="checkbox" id="people_in_pet" {{ ( $anuncio and $anuncio->people_in_pet )? 'checked' : ''}} name="people_in_pet" class="form-control @error('people_in_pet') is-invalid @enderror"    >
                                                                    
                                  <div class="slide round">{{ __('Mascotas') }}</div>
                              </label>
                                
                              </div>
                          </div>

                    </div>
                </div>

            </div>
        
                <div class="col-md-9">
                    <br />
                <div class="card" >
                    <div class="card-header" >{{ __('¿Que perfil buscas?') }}</div>
    
                    <div class="card-body">

                        <div class="form-row">
                            
                            <div class="form-group col-md-6">
                              <label for="lookfor_who_sex">{{ __('¿Que prefieres?') }}</label>
                              
                              <select id="lookfor_who_sex" class="form-control @error('lookfor_who_sex') is-invalid @enderror" name="lookfor_who_sex"  value="{{ old('lookfor_who_sex') }}"  >
                                <option selected> {{  $anuncio ? $anuncio->lookfor_who_sex :  old('lookfor_who_sex')  }}</option>
                                <option>{{ __('Chicas') }}</option>
                                <option>{{ __('Chicos') }}</option>
                                <option>{{ __('Indiferente') }}</option>
                              </select>
                              @error('lookfor_who_sex')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="lookfor_who_job">{{ __('Ocupación')}}</label>
                                <select id="lookfor_who_job" name="lookfor_who_job" class="form-control @error('lookfor_who_job') is-invalid @enderror"  value="{{ old('lookfor_who_job') }}" >
                                  <option selected>{{  $anuncio ? $anuncio->lookfor_who_job :  old('lookfor_who_job')  }}</option>
                                  <option>{{ __('Profesional') }}</option>
                                  <option>{{ __('Estudiantes') }}</option>
                                  <option>{{ __('Indiferente') }}</option>
                                </select>
                                @error('lookfor_who_job')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           <br /> 
                        </div>
                            
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label class="switchBtn">
                                <input class="form-check-input" type="checkbox" id="lookfor_who_tabaco" {{ ( $anuncio and $anuncio->lookfor_who_tabaco) ? 'checked' : ''}} name="lookfor_who_tabaco" class="form-control @error('lookfor_who_tabaco') is-invalid @enderror"   >
                                                          
                                <div class="slide round">{{ __('Fumar') }}</div>
                            </label>
                               
                              </div>
                              <div class="form-group col-md-6">
                                <label class="switchBtn">
                                  <input class="form-check-input" type="checkbox" id="lookfor_who_pet" {{ (  $anuncio and $anuncio->lookfor_who_pet) ? 'checked' : ''}} name="lookfor_who_pet" class="form-control @error('lookfor_who_pet') is-invalid @enderror"    >
                                                              
                                  <div class="slide round">{{ __('Mascotas') }}</div>
                              </label>
                                
                              </div>  
                          </div>

                            </div>
                </div><br />
                <div class="card">
                    <div class="card-header" >{{ __('Dirección y datos extra') }}</div>
    
                    <div class="card-body">

                        <div class="form-row">
                
                            <div class="form-group col-md-6">
                              <label for="province_rent">{{ __('Provincia') }}<sup style="color:red; font-size:16px">*</sup></label>
                                                
                            
                              <select id="province_rent" class="form-control @error('province_rent') is-invalid @enderror" name="province_rent"  value="{{ old('province_rent') }}" required autocomplete="province_rent" >
                                <option selected >{{   $anuncio ? $anuncio->province_rent : old('province_rent') }}</option>
                                @foreach ($provinces as $provincia)
                                <option value="{{ $provincia->id}} - {{$provincia->province_name }}">{{ $provincia->province_name }}</option>
                                @endforeach
                              </select>
                              @error('province_rent')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="city_rent">{{ __('Población') }}<sup style="color:red; font-size:16px">*</sup></label>
                                <select id="city_rent" name="city_rent" class="form-control @error('city_rent') is-invalid @enderror"  value="{{ old('city_rent') }}" required  autocomplete="city_rent" >
                                  <option selected>{{  $anuncio ? $anuncio->city_rent :  old('city_rent') }}</option>
                                  
                                </select>
                                @error('city_rent')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                          </div>
                        <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="street_rent">{{ __('Tipo de vía') }}<sup style="color:red; font-size:16px">*</sup></label>
                                <select id="street_rent" name="street_rent" class="form-control @error('street_rent') is-invalid @enderror"  value="{{ old('street_rent') }}" required  autocomplete="street_rent" >
                                  <option selected>{{ $anuncio ? $anuncio->street_rent :  old('street_rent') }}</option>
                                  <option>{{ __('Calle') }}</option>
                                  <option>{{ __('Avenida') }}</option>
                                  <option>{{ __('Plaza') }}</option>
                                  <option>{{ __('Otros') }}</option>
                                </select>
                                @error('street_rent')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                              </div>
                          <div class="form-group col-md-9">
                            <label for="adress_rent">{{ __('Dirección') }}<sup style="color:red; font-size:16px">*</sup></label>
                            <?php
                            //debido a la forma de tratar php+windows los acentos he tenido que hacer todo esto para
                            //poner en mayusculas las promeras letras solo de la direccion
                            if($anuncio){
                                $direccion = htmlentities($anuncio->adress_rent);
                                $direccion = strtolower($direccion);
                                $direccion = explode(' ', $direccion);
                                $direccionAcentos = [];

                                foreach($direccion as $key => $value){
                                  $direccionAcentos[] =  ucfirst($value);
                                }

                                $direccion = implode(' ', $direccionAcentos);
                                $direccion = html_entity_decode ( $direccion );
                          }

                            ?>
                            <input type="text" id="adress_rent"  name="adress_rent" class="form-control @error('adress_rent') is-invalid @enderror"  value="{{ $anuncio ? $direccion :  old('adress_rent') }}" required  autocomplete="adress_rent" >
                            @error('adress_rent')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div id="suggestions"></div>

                          </div>
                        
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <label for="num_street_rent">{{ __('Número') }}<sup style="color:red; font-size:16px">*</sup></label>
                            <input type="text"  id="num_street_rent" name="num_street_rent" class="form-control @error('num_street_rent') is-invalid @enderror"  value="{{ $anuncio ? $anuncio->num_street_rent :  old('num_street_rent') }}" required  autocomplete="num_street_rent" >
                            @error('num_street_rent')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                          </div>
                          <div class="form-group col-md-4">
                            <label for="flat_street_rent">{{ __('Piso') }}<sup style="color:red; font-size:16px">*</sup></label>
                            <input type="text"  id="flat_street_rent" name="flat_street_rent" class="form-control @error('flat_street_rent') is-invalid @enderror"  value="{{ $anuncio ? $anuncio->flat_street_rent :  old('flat_street_rent') }}" required  autocomplete="flat_street_rent" >
                            @error('flat_street_rent')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                          </div>
                          <div class="form-group col-md-4">
                            <label for="cp_rent">{{ __('Código postal') }}</label>
                            <input type="text" id="cp_rent" name="cp_rent" class="form-control @error('cp_rent') is-invalid @enderror"  value="{{ $anuncio ? $anuncio->cp_rent :  old('cp_rent') }}" autocomplete="cp_rent" >
                            @error('cp_rent')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                            <br />
                         </div>
                          
                          <div class="form-group col-md-3">
                            <label class="switchBtn">
                              <input class="form-check-input" type="checkbox" id="funiture" {{ ( $anuncio and $anuncio->funiture) ? 'checked' : ''}} name="funiture" class="form-control @error('funiture') is-invalid @enderror"  >
                              
                              <div class="slide round">{{ __('Muebles') }}</div>
                          </label>

                            

                          </div>
                          
                          <div class="form-group col-md-3">
                           <label class="switchBtn">
                            <input class="form-check-input" type="checkbox" id="ascensor"  {{( $anuncio and  $anuncio->ascensor) ? 'checked' : ''}} name="ascensor" class="form-control @error('ascensor') is-invalid @enderror"    >
                                
                            <div class="slide round">{{ __('Ascensor') }}</div>
                        </label> 
                          </div>  
                          <div class="form-group col-md-3">
                            <label class="switchBtn">
                              <input class="form-check-input" type="checkbox" id="calefaction"  {{ ( $anuncio and $anuncio->calefaction) ? 'checked' : ''}} name="calefaction" class="form-control @error('calefaction') is-invalid @enderror"   >
                                    
                              <div class="slide round">{{ __('Calefac.') }}</div>
                          </label>
                            
                          </div>
                          <div class="form-group col-md-3">
                            <label class="switchBtn">
                              <input class="form-check-input" type="checkbox" id="balcon" name="balcon"  {{ ( $anuncio and $anuncio->balcon) ? 'checked' : ''}} class="form-control @error('balcon') is-invalid @enderror"    >
                                     
                              <div class="slide round">{{ __('Balcón') }}</div>
                          </label>
                           
                          </div>  
                          <div class="form-group col-md-3">
                            <label class="switchBtn">
                              <input class="form-check-input" type="checkbox" id="terraza" name="terraza"  {{ ( $anuncio and $anuncio->terraza) ? 'checked' : ''}}  class="form-control @error('terraza') is-invalid @enderror"  >
                                       
                              <div class="slide round">{{ __(' Terraza') }}</div>
                          </label>
                            
                          </div>
                          <div class="form-group col-md-3">
                            <label class="switchBtn">
                              <input class="form-check-input" type="checkbox" id="gas" name="gas"   {{ ( $anuncio and $anuncio->gas) ? 'checked' : ''}}  class="form-control @error('gas') is-invalid @enderror"   >
                                         
                              <div class="slide round">{{ __('Gas') }}</div>
                          </label>
                           
                          </div>  
                          <div class="form-group col-md-3">
                            <label class="switchBtn">
                              <input class="form-check-input" type="checkbox" id="swiming" name="swiming"   {{ ( $anuncio and $anuncio->swiming) ? 'checked' : ''}}  class="form-control @error('swiming') is-invalid @enderror"   >
                                           
                              <div class="slide round">{{ __(' Piscina') }}</div>
                          </label>
                            
                              </div>
                          
                          <div class="form-group col-md-3">
                            <label class="switchBtn">
                              <input class="form-check-input" type="checkbox" id="internet" name="internet"  {{ ( $anuncio and $anuncio->internet) ? 'checked' : ''}}  class="form-control @error('internet') is-invalid @enderror"   >
                                             
                              <div class="slide round">{{ __(' Internet') }}</div>
                          </label>
                            
                          </div>
                          <div class="form-group col-md-3">
                          <label class="switchBtn">
                            <input class="form-check-input" type="checkbox" id="washing_machine" name="washing_machine"  {{ ( $anuncio and $anuncio->washing_machine) ? 'checked' : ''}}  class="form-control @error('washing_machine') is-invalid @enderror"  >
                                              
                            <div class="slide round">{{ __('Lavadora') }}</div>
                        </label>
                          </div>
                          <div class="form-group col-md-3">
                            <label class="switchBtn">
                              <input class="form-check-input" type="checkbox" id="fridge" name="fridge"  {{ ( $anuncio and $anuncio->fridge) ? 'checked' : '' }}  class="form-control @error('fridge') is-invalid @enderror"  >
                                                  
                              <div class="slide round">{{ __(' Nevera') }}</div>
                          </label>
                            
                          </div>  
                          <div class="form-group col-md-3">
                            
                              <label class="switchBtn">
                                <input class="form-check-input" type="checkbox" id="kitchen" name="kitchen"  {{ ( $anuncio and $anuncio->kitchen) ? 'checked' : '' }} class="form-control @error('kitchen') is-invalid @enderror"   >
                                                    
                                <div class="slide round">{{ __('Cocina') }}</div>
                            </label>
                            
                          </div>    
                          <div class="form-group col-md-3">
                            <label class="switchBtn">
                              <input class="form-check-input" type="checkbox" id="near_bus" name="near_bus"  {{ ( $anuncio and $anuncio->near_bus) ? 'checked' : '' }}  class="form-control @error('near_bus') is-invalid @enderror"  >
                                                    
                              <div class="slide round">{{ __('C. Bus') }}</div>
                          </label>
                            
                          </div>
                          <div class="form-group col-md-3">
                            <label class="switchBtn">
                              <input class="form-check-input" type="checkbox" id="near_tren" name="near_tren"  {{ ( $anuncio and $anuncio->near_tren) ? 'checked' : '' }}  class="form-control @error('near_tren') is-invalid @enderror" >
                                                      
                              <div class="slide round">{{ __(' C. Tren') }}</div>
                          </label>
                            
                          </div>  
                          <div class="form-group col-md-3">
                            <label class="switchBtn">
                              <input class="form-check-input" type="checkbox" id="near_underground" name="near_underground"  {{ ( $anuncio and $anuncio->near_underground) ? 'checked' : '' }}  class="form-control @error('near_underground') is-invalid @enderror"  >
                                                       
                              <div class="slide round">{{ __('C. Metro') }}</div>
                          </label>
                            
                          </div>
                          <div class="form-group col-md-3">
                            <label class="switchBtn">
                              <input class="form-check-input" type="checkbox" id="near_school"  {{ ( $anuncio and $anuncio->near_school) ? 'checked' : '' }}  name="near_school" class="form-control @error('near_school') is-invalid @enderror"  >
                              <div class="slide round">{{ __('Colegios') }}</div>
                          </label>
                          </div>  
                          <div class="form-group col-md-3">
                            <label class="switchBtn">
                              <input class="form-check-input bg-primary" type="checkbox" id="near_airport"  {{ ( $anuncio and $anuncio->near_airport) ? 'checked' : '' }}  name="near_airport" class="form-control @error('near_airport') is-invalid @enderror"  >
                                                         
                              <div class="slide round">{{ __('C. Aerop.') }}</div>
                          </label>
                            
                          </div>  
                        </div>
                        
                    </div>
                    <div class="form-group col-md-12">
                        <label for="observations">{{__('Observaciones')}}</label>
                        <textarea class="form-control" id="observations" name="observations" rows="3"> {{ ( $anuncio and $anuncio->observations) ? $anuncio->observations : old('observations') }}</textarea>
                    </div>
                </div>
                
                    <br />
                
                          @if(isset($images_)  )
                          @include('includes.formImages')
                          
                          @endif
                          
                          
                  <div style="text-align: center">       
                <button  type="submit" id="submit1" class="btn btn-primary" style="width: 50%;text-align:center ">{{ __('Enviar') }}</button>
                </div> 
                    </div>
                </div>
        </form>
      </div>       
        
    

@endsection
