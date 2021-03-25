@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row md-8" >
        <div class="col-8">{{ __($anuncio->titulo) }}</div>
    </div>
    <div class="row justify-content-center">
    
    
    
        <div class="row md-8" > 
   
        
            @foreach ($anuncio->imagen as  $imagenes)
            <div class="col-4" >             
             <img  width="100%" style="margin-bottom: 25px" src="../anounces/{{$anuncio->user_id}}/{{$imagenes->imageName}}" title="{{$anuncio->titulo}}"  alt="{{$anuncio->titulo}}">
            </div>            
            @endforeach
          
    
    
    </div>
    </div>
    <div class="row">
        <div class="col-10" >Descripción</div>
    </div> 
    <div class="row" >
        <div class="col-10">{{ __($anuncio->descripcion) }}</div>
    </div>     
         
</div>






@endsection
