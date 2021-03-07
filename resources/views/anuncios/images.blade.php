@extends('layouts.app')

<?php

if(!$anounce_id ){
  $h1Title = 'Publicar anuncio.';
}else{
  $h1Title = 'Editar anuncio.';
}

?>


@section('content')
<div class="container">
    
  @include('includes.imageModal')
    @include('includes.mensajes')
    <form method="POST" id="form_imagenes" action="{{ route('save.images') }}" enctype="multipart/form-data">
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
        <div class="tituloPrincipal-menu-images" >
          <a href="{{ route('edit.anounce', ['id' => $anounce_id] ) }}">  
          <h5>Datos Principales</h5>
          </a>
          </div>
        </div>
        <div class="col-md-3" style="vertical-align: bottom !important;">
          <div class="tituloPrincipal-menu" >
            
            <h5>Imagenes</h5>
           
          </div>
          </div>
          @endif
        <div class="col-md-9">

            <div class="card" id="form_images">
                <div class="card-header">{{ __('Vamos con las imagenes.') }}</div>

                <div class="card-body">
      
                <div class="form-row">
                
                

                  @if (isset($anounce_id) && $anounce_id)
                    <input type="hidden" value="{{$anounce_id}}" name="anounce_id">
                    <input type="hidden" id="edit-images" value="76345976">
                  @endif

                  
                    <?php $i = 1; 
                    $user_id = Auth::user()->id; 
                    ?>
                    {{--dd($images_)--}}
                  @foreach($images_ as $value)
                  
                    <div class="col-md-4" id="image{{$value->id}}">
                      <img  width="100%" src="{{ route('image.file',['filename' => $value->imageName,'id' => $value->user_id ]) }}" alt="Card image cap">
                  
                      <div class="card-body" style="min-height: 100px">
                        <a href="{{ route('delete.image',['id' => $value->id, 'anounce_id' => $value->anounces_id  ]) }}" class="image_delete" data-anounce="{{$anounce_id}}" value="{{$value->id}}">
                        <h5 class="card-title">Eliminar</h5>
                        </a>         
                      </div>
                    </div>
                   
                    @if($i%3 ==0)
                  
                  <br>
                    
                    @endif
                    
                   <?php  
                    $i++; ?>
                  @endforeach       
                  
                  
                </div>

                
                
                



                <div id="form-images-5"></div>  
                @if($numImages < 5)
                 @include('includes.formImages')
                 <div style="text-align: center; margin-top:20px">       
                <button  type="submit" id="submit1" class="btn btn-primary" style="width: 50%;text-align:center ">{{ __('Enviar') }}</button>
                </div>
                @endif
                
                
        </form>
      </div>       
        
    

@endsection
