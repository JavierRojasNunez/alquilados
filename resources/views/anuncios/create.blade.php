@extends('layouts.app')

<?php
//si viene $anounce id es que la vista es llamada por el metodo editar y no create. Cambiamos el titulo
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
        <input type="hidden" value="{{$value}}" name="type">
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
          <a href="{{ route('edit.images', ['id' => $anounce_id, 'type' => $value]) }}">  
            <h5>Imágenes</h5>
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

          <div class="alert alert-warning alert-dismissible fade show" role="alert" >
            Los campos con un asterisco rojo son obligatorios. Los demás campos puede dejarlos vacíos y rellenar solo los que 
            creas que son los más importantes. A más datos, más posibilidad de conseguir tu propósito. Hay que incluir mínimo 1 imagen
            y máximo 5.
        
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>


          @if ($type)
          @include('includes.anounceRent')
          @else
          @include('includes.anounceSell')
          @endif

<br>
      <div class="card">
        <div class="card-header">{{ __('El título y la descripción hacen más atractivo tu anuncio.') }}</div>

<div class="card-body">
<div class="form-row">       
      
      <div class="form-group col-md-12">
        <label for="titulo">{{__('Título')}}<sup style="color:red; font-size:16px">*</sup></label>
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
        
 </div>
    </div>





</div>
@if ($type)
    

<div class="col-md-9">
<br />
<div class="card" >
<div class="card-header" >{{ __('¿Qué perfil buscas?') }}</div>

<div class="card-body">

<div class="form-row">
    
    <div class="form-group col-md-6">
      <label for="lookfor_who_sex">{{ __('¿Qué prefieres?') }}</label>
      
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
</div>
</div>
@endif



<div class="col-md-9">

<br />
<div class="card">
<div class="card-header" >{{ __('Dirección y otros datos') }}</div>

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
    //quitar en produccion               
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
                  <div class="form-group col-md-3">
                    <label for="num_street_rent">{{ __('Número') }}<sup style="color:red; font-size:16px">*</sup></label>
                    <input type="text"  id="num_street_rent" name="num_street_rent" class="form-control @error('num_street_rent') is-invalid @enderror"  value="{{ $anuncio ? $anuncio->num_street_rent :  old('num_street_rent') }}" required  autocomplete="num_street_rent" >
                    @error('num_street_rent')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                  </div>
                  <div class="form-group col-md-3">
                    <label for="flat_street_rent">{{ __('Piso') }}<sup style="color:red; font-size:16px">*</sup></label>
                    <input type="text"  id="flat_street_rent" name="flat_street_rent" class="form-control @error('flat_street_rent') is-invalid @enderror"  value="{{ $anuncio ? $anuncio->flat_street_rent :  old('flat_street_rent') }}" required  autocomplete="flat_street_rent" >
                    @error('flat_street_rent')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                  </div>
                  <div class="form-group col-md-3">
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
                    <label for="phone">{{ __('Tu teléfono') }}<sup style="color:red; font-size:16px">*</sup></label>
                    <input type="text"  id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"  value="{{ $anuncio ? $anuncio->phone :  old('phone') }}" required  autocomplete="phone" >
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
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
        
                  @if(!$anounce_id)
                  @include('includes.formImages')                 
                  @endif
                 @if (!isset ($numAnounces) || $numAnounces < 2)
            <div class="row justify-content-center">       
            <button  type="submit" id="submit1" class="btn btn-primary" style="width: 50%;text-align:center ">{{ __('Enviar') }}</button>
            </div> 
            @endif             
            </div>
            
           
                
            
        
        </div>
</form>
</div>       



@endsection
