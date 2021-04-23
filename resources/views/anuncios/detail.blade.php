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
            <div class="card-header detail">Descripción</div>
        </div>
        <div class="col-12 detail">{{ __($anuncio->descripcion) }}</div>
        
    </div>
          
    <div class="row">
        <div class="col-12" >
            <div class="card-header detail">Caracteristicas</div>
        </div>
        <div class="col-12">


            
        </div>
    </div>        
</div>






@endsection
