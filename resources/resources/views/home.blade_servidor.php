@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if (session('status'))
        <div class="row">
        <div class="alert alert-success"  role="alert">
            {{ session('status') }}
        </div>
        </div>
        @endif 
        <div class="row">
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
                        <img  width="100%" src="anounces/{{$anuncio->user_id}}/{{$anounceImage}}" alt="Card image cap">
                   
                   
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
    <div>
    {{--$anuncios->links()--}}
</div>
</div>
@endsection
