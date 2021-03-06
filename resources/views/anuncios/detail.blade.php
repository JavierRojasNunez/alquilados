@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" >
        <div class="col-12">
        <div class="card-header detail" >{{ __($anuncio->titulo) }}</div>
        </div>
    </div>
    <div class="row"> 
        
        @foreach ($anuncio->imagen as  $imagenes)
        <div class="col-4"  >   
            <a data-fancybox="gallery" id="galeria" href="{{ route('image.file', ['id'=> $anuncio->user_id, 'filename'=> $imagenes->imageName ]) }}" title="{{$anuncio->titulo}}">          
           
            <img  width="100%" style="margin-bottom: 25px" src="{{ route('image.file', ['id'=> $anuncio->user_id, 'filename'=> $imagenes->imageName ]) }}" title="{{$anuncio->titulo}}"  alt="{{$anuncio->titulo}}"> 
            
        </a>
        </div>            
        @endforeach   
    
    </div>
    <div class="row">
        <div class="col-12" >
            <div class="card-header detail">Precio, dirección y contacto</div>
        </div>
        <div class="col-10 detail" >
        <div class="data-1">
            <span class="price-detail">{{$anuncio->price}} € </span> <span class="city">{{$anuncio->city_rent}}</span> - <b>{{$anuncio->province_rent}}</b> - {{$anuncio->type_rent}} en {{$anuncio->type}} {{$anuncio->payment_period}}
            </div>
        
            <div class="data-2">
                 Situada en  {{$anuncio->street_rent}}  {{$anuncio->adress_rent}}   nº{{$anuncio->num_street_rent}} &nbsp;&nbsp;&nbsp; Piso:  {{$anuncio->flat_street_rent}}  &nbsp; &nbsp;&nbsp;cp {{$anuncio->cp_rent}} &nbsp; {{$available}}
            </div>
            <div class="d-flex p-1 data-caracteristicas">
                <img src="../../icons/dormitorio.png" class="icons-small" title="Dormitorios" alt="Dormitorios"> &nbsp; {{$anuncio->num_rooms}} 
                &nbsp; &nbsp; &nbsp; 
                <img src="../../icons/bath.png" class="icons-small" title="Baños" alt="Baños"> &nbsp; {{$anuncio->num_baths}}
                &nbsp; &nbsp; &nbsp; 
                <img src="../../icons/superficie.png" class="icons-small" title="Superficie" alt="Superficie"> &nbsp; {{$anuncio->meter2}} m&sup2;
               
            </div>
            <div class="d-flex p-1 data-caracteristicas">
                
                <a href=""><img src="../../icons/phone.png" class="icons-small contact" id="anouce_phone" title="Télefono" alt="Télefono"></a>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                <a href=""><img src="../../icons/email.png" id="anouce_phone" class="icons-small contact" title="Email" alt="Email"></a>
            </div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-12" >
            <div class="card-header detail">Descripción</div>
        </div>
        <div class="col-12 detail">{!! $anuncio->descripcion !!}</div>
        
    </div>
          
    <div class="row">
        <div class="col-12">
            <div class="card-header detail">Características</div>
        </div>
        <div class="col-12">
        <div class="row">
        @foreach($caracteristics_images as $key => $values)

        
        @if ($values[0] == 1)
            <div class="col-3 caracteristics">
               
              <img src="../../icons/{{$values[1]}}" width="25px" height="25px">
              {{$key}}              
            </div>
            
        @endif

        @endforeach
         </div>   
        </div>
    </div>        

    @if($requeriments)
    <div class="row">
        <div class="col-12">
            <div class="card-header detail">Requisitos</div>
        </div>
        <div class="col-12">
        <div class="row">
        @foreach($requeriments as $key => $values)

        
        
            <div class="col-3 caracteristics">
               
              <img src="../../icons/{{$values[1]}}" width="25px" height="25px">
              {{$key}} {{$values[0]}}             
            </div>
            
        

        @endforeach
         </div>   
        </div>
    </div>
    @endif

    @if($anuncio->observations != null)

    <div class="row">
        <div class="col-12">
            <div class="card-header detail">Observaciones</div>
        </div>
        <div class="col-12">
        <div class="row">
        
        
        
            <div class="col-12 detail">
               
              {{$anuncio->observations}}            
            </div>
            
        

       
         </div>   
        </div>
    </div>

    @endif

</div>
@include('includes.contactModal')





@endsection
