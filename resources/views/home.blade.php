@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       
        
        <div class="col-md-10">
        <h1>Últimos anuncios.</h1>
        </div>
       
        @foreach ($anuncios as $anuncio)

        <?php     

        //vamos a recorrer el array de imagenes del anuncio y si no hay ponemos por defecto
            foreach ($anuncio->imagen as $key2 => $imagenes){
                
                if(isset($imagenes->imageName) && $imagenes->imageName !== NULL && $imagenes->imageName != ''){

                    $anounceImage = $imagenes->imageName;
                    break;

                }else{

                    //incluir imagen defecto
                    $anounceImage = 'sin_imagen';
                }
                
            }  
        
        ?>

         
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __($anuncio->titulo) }}</div>

                <div class="card-body">
                    <div class="row">
                    <div class="col-md-4">      
              
                        

                        
                        <div id="carouselExampleControls{{$anuncio->id}}" class="carousel slide" data-ride="carousel" data-interval="false" style="background-color: white">
                            
                            <div class="carousel-inner" >

                            <?php    $i = 1 ?>
                            @foreach ($anuncio->imagen as  $imagenes)
                            <?php
                            if($i == 1){
                                $active= 'active';
                            }else{
                                $active= '';
                            }
                            ?>
                              <div class="carousel-item {{$active}}">
                              <img  width="100%" src="anounces/{{$anuncio->user_id}}/{{$imagenes->imageName}}" title="{{$anuncio->titulo}}"  alt="{{$anuncio->titulo}}">
                              </div>
                            <?php   $i++ ?>
                              @endforeach
                            
                            </div>

                            <div >
                            <a class="carousel-control-prev" style="margin-top:105px; margin-left:3px" href="#carouselExampleControls{{$anuncio->id}}" role="button" data-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" style="margin-top:105px; margin-right:3px" href="#carouselExampleControls{{$anuncio->id}}" role="button" data-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="sr-only">Next</span>
                            </a>
                          </div>
                        </div>
                        <img  width="100%" style="margin-bottom: 25px" src="anounces/{{$anuncio->user_id}}/{{$imagenes->imageName}}" title="{{$anuncio->titulo}}"  alt="{{$anuncio->titulo}}">
                 
                   
                </div> 
                    <div class="col-md-6">

                        <?php
                        if ($anuncio->payment_period == 'Venta') {
                            $tipo_ = 'a la venta';
                        }else{
                            $tipo_ = 'alquilado';
                        }
                        ?>

                    <div class="data-1">
                    <span class="price">{{$anuncio->price}} € </span> <span class="city">{{$anuncio->city_rent}}</span>
                    </div>
                    <div class="data-2">
                        {{$anuncio->type_rent}} en {{$anuncio->payment_period}} - <b>{{$anuncio->province_rent}}</b>
                    </div>
                    <div class="d-flex p-1 data-caracteristicas">
                        <img src="icons/dormitorio.png" class="icons-small" title="Dormitorios" alt="Dormitorios"> &nbsp; {{$anuncio->num_rooms}}
                        &nbsp; &nbsp; &nbsp; 
                        <img src="icons/bath.png" class="icons-small" title="Baños" alt="Baños"> &nbsp; {{$anuncio->num_baths}}
                        &nbsp; &nbsp; &nbsp; 
                        <img src="icons/superficie.png" class="icons-small" title="Superficie" alt="Superficie"> &nbsp; {{$anuncio->meter2}} m&sup2;
                    </div>
                    <div class="data-3">
                   Situada en  {{$anuncio->street_rent}}  {{$anuncio->adress_rent}}   nº {{$anuncio->num_street_rent}}. 
                    </div>
                    <div class="data-4">
                   {{ Str::limit($anuncio->descripcion, 250)}}
                    </div>
                </div> 
                <div class="col-md-2 right-card" >
                    
                    <div class="card-phone">
                     
                        <img src="icons/phone.png" class="icons"  title="Ver teléfono" alt="Ver teléfono">
                    </div>
                   
                    <div class="card-mail">
                      
                        <img src="icons/email.png" class="icons"  title="Enviar mensaje" alt="Enviar mensaje">
            
                    </div>
                </div>
                    </div>              
                </div>
            </div>
            <br />
        </div>
           
@endforeach
 
    </div>
    <div id="links-nav">
    {{$anuncios->links()}}
</div>
</div>
@endsection
