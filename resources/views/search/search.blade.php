@extends('layouts.app')

@section('content')



<div class="container">
    <div class="row justify-content-center">
       
        
        <div class="col-md-12">
        @include('includes.mensajes')
        </div>
        
        <div class="col-md-10">
        <h1>Resultados de la busqueda.</h1>
        <br>
        </div>
       

       @if(!empty($anuncios->all()))
       
       

        @foreach ($anuncios as $anuncio)

  

         
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __($anuncio->titulo) }}</div>

                <div class="card-body" style="margin-left:5px">
                    <div class="row">
                    <div class="col-md-4">      
              
                        

                        <div class="num-images">
                        <span class="num-images-span">
                            <span id="current-photo{{$anuncio->id}}">1</span> /
                            <span data-total="{{ count($anuncio->imagen) }}" id="total-photo{{$anuncio->id}}">{{ count($anuncio->imagen) }}</span>  &nbsp; 
                            <img src="../icons/photo.png" class="icons-small-2" title="Imagenes" alt="Imagenes"> 
                            </span>
                        </div>
                        <div id="carouselExampleControls{{$anuncio->id}}" class="carousel slide" data-ride="carousel" data-interval="false" style="background-color: white">
                            
                            
                            <div class="carousel-inner" >

                           
                            <?php    $i = 1 ?>
                            @foreach ($anuncio->imagen as  $imagenes)
                            <?php
                            if($i <= 1){
                                $active = 'active';
                            }else{
                                $active = '';
                            }
                            ?>
                              <div class="carousel-item {{$active}} {{$anuncio->id}}"   data-current-photo = {{$i}}>
                                
                                <img  width="100%" src="{{ route('image.file', ['id'=> $anuncio->user_id, 'filename'=> $imagenes->imageName ]) }}" title="{{$anuncio->titulo}}"  alt="{{$anuncio->titulo}}">
                                
                            </div>
                            <?php   $i++ ?>
                              @endforeach
                            
                            </div>
                            
                            <div >
                            <a class="carousel-control-prev {{$anuncio->id}}"    href="#carouselExampleControls{{$anuncio->id}}" onclick="currentPhotoPrev({{$anuncio->id}})" role="button" data-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next {{$anuncio->id}}"   href="#carouselExampleControls{{$anuncio->id}}" onclick="currentPhoto({{$anuncio->id}})" role="button" data-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="sr-only">Next</span>
                            </a>
                          </div>
                        </div>
                        
                        <img  width="100%" src="{{ url('images/'.$anuncio->user_id . '/' . $imagenes->imageName ) }}" title="{{$anuncio->titulo}}" >
                      

                        
                 
                   
                </div> 
                    <div class="col-md-6">

                        <?php
                        if ($anuncio->payment_period == 'Venta') {
                            $tipo_ = 'a la venta';
                        }else{
                            $tipo_ = 'alquilado';
                        }
                        ?>
                    <a href="{{ route('detail.anounce',['anounce' => $anuncio->id ]) }}">
                    <div class="data-1">
                    <span class="price">{{$anuncio->price}} € </span> <span class="city">{{$anuncio->city_rent}}</span>
                    </div>
                    <div class="data-2">
                        {{$anuncio->type_rent}} en {{$anuncio->type}} - <b>{{$anuncio->province_rent}}</b>
                    </div>
                    <div class="d-flex p-1 data-caracteristicas">
                        <img src="../icons/dormitorio.png" class="icons-small" title="Dormitorios" alt="Dormitorios"> &nbsp; {{$anuncio->num_rooms}}
                        &nbsp; &nbsp; &nbsp; 
                        <img src="../icons/bath.png" class="icons-small" title="Baños" alt="Baños"> &nbsp; {{$anuncio->num_baths}}
                        &nbsp; &nbsp; &nbsp; 
                        <img src="../icons/superficie.png" class="icons-small" title="Superficie" alt="Superficie"> &nbsp; {{$anuncio->meter2}} m&sup2;
                    </div>
                    <div class="data-3">
                   Situada en  {{$anuncio->street_rent}}  {{$anuncio->adress_rent}}   nº {{$anuncio->num_street_rent}}. 
                    </div>
                    <div class="data-4">
                   {{ Str::limit($anuncio->descripcion, 250)}}
                    </div>
                    </a>
                </div> 
                <div class="col-md-2 right-card" >
                    
                    <div class="card-phone">
                     
                        <img src="../icons/phone.png" class="icons"  title="Ver teléfono" alt="Ver teléfono">
                    </div>
                   
                    <div class="card-mail">
                      
                        <img src="../icons/email.png" class="icons"  title="Enviar mensaje" alt="Enviar mensaje">
            
                    </div>
                </div>
                    </div>              
                </div>
            </div>
            <br />
        </div>
           
    @endforeach

@else
<div class="row justify-content-center">
    
        <h1>No hay resultados</h1>
    
@endif

<div class="row justify-content-center">
<div class="col-md-10">
    <div id="links-nav">

    {{$anuncios->links()}} 
    </div>
</div>
</div>   
    <div class="col-md-12" style="clear: both" >
           
        <h1>Otros usuarios tambien buscaron... {{ $geoCity }}</h1>
        <br>
    <div class="row">

        
    @foreach ($selections as $anuncio)


    <div class="col-md-3">
    <div class="card-deck">
        <div class="card">
          <img  width="100%" src="{{ route('image.file', ['id'=> $anuncio->user_id, 'filename'=> $anuncio->imageName ]) }}" title="{{$anuncio->titulo}}"  alt="{{$anuncio->titulo}}">
          <div class="card-body">
            <div class="data-1-small">
                <span class="price">{{$anuncio->price}} € </span> <span class="city-small">{{$anuncio->city_rent}}</span>
                </div>
            <p class="card-text">{{ Str::limit($anuncio->descripcion, 100)}}</p>
          </div>
          
            <div class="data-caracteristicas-small">
                <img src="../icons/dormitorio.png" class="icons-small-2" title="Dormitorios" alt="Dormitorios"> &nbsp; {{$anuncio->num_rooms}}
                &nbsp; &nbsp; &nbsp; 
                <img src="../icons/bath.png" class="icons-small-2" title="Baños" alt="Baños"> &nbsp; {{$anuncio->num_baths}}
                &nbsp; &nbsp; &nbsp; 
                <img src="../icons/superficie.png" class="icons-small-2" title="Superficie" alt="Superficie"> &nbsp; {{$anuncio->meter2}} m&sup2;
            </div>
          
        </div>
    </div>
       
    </div>

    @endforeach

    </div>
   

      
</div>
@endsection
