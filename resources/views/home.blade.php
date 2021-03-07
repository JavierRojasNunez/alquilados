@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
       
        
        <div class="col-md-8">
        <h1>Últimas publicaciones interesantes.</h1>
        </div>
        
  
        {{--dd($anuncios)--}}
       
         
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

         {{--dd($anuncio)--}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __($anuncio->titulo) }}</div>

                <div class="card-body">
                    <div class="row">
                    <div class="col-md-4">      
              
                        

                        <div style="margin-bottom:30px" >
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
                              <img  width="100%" src="anounces/{{$anuncio->user_id}}/{{$imagenes->imageName}}" alt="{{$anuncio->titulo}}">
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
                     </div>
                        <img  width="100%" src="anounces/{{$anuncio->user_id}}/{{$imagenes->imageName}}" alt="Card image cap">
                 
                   
                </div> 
                    <div class="col-md-8">

                        <?php
                        if ($anuncio->payment_period == 'Venta') {
                            $tipo_ = 'a la venta';
                        }else{
                            $tipo_ = 'alquilado';
                        }
                        ?>

                   <p>{{$anuncio->type_rent}} {{$tipo_}}   por {{$anuncio->price}} €. </p>
                   <p>Esta en   {{$anuncio->city_rent}} en la  {{$anuncio->street_rent}}  {{$anuncio->adress_rent}}   nº {{$anuncio->num_street_rent}}. </p>
                   <p>Tiene   {{$anuncio->num_rooms}} habitacion/es y  {{$anuncio->num_baths}} baño/s   </p>
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
