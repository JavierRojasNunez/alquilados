@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1>Tus anuncios publicados.</h1>
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif 

        @foreach ($anuncios as $key =>$anuncio)

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
       
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __($anuncio->titulo) }}</div>

                <div class="card-body">
                    <div class="row">
                    <div class="col-md-4">              
                        
                   
                     <img class="" src="{{ route('image.file',['filename' => $anounceImage,'id' => $anuncio->user_id ]) }}" alt="Card image cap" width="100%" >
                     <img  width="100%" src="../anounces/{{$anuncio->user_id}}/{{$anounceImage}}" alt="Card image cap">
                </div> 
                    <div class="col-md-8">

                        <?php
                        if ($anuncio->payment_period == 'Venta') {
                            $tipo_ = 'a la venta';
                        }else{
                            $tipo_ = 'alquilado';
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-12" style="padding: 10px">
                            <p>Tienes  {{$anuncio->type_rent}} {{$tipo_}}   por {{$anuncio->price}} €. </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="padding: 10px">
                                <p>Esta en   {{$anuncio->city_rent}} en la  {{$anuncio->street_rent}}  {{$anuncio->adress_rent}}   nº {{$anuncio->num_street_rent}}. </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="padding: 10px">
                                <p>Tiene   {{$anuncio->num_rooms}} habitacion/es y  {{$anuncio->num_baths}} baño/s   </p>
                            </div>
                        </div>
                   
                   <div class="row">
                   <div class="col-md-6" style="padding: 20px">
                        <a href="{{ route('edit.anounce', ['id' => $anuncio->id] ) }}" type="buttom" class="btn btn-danger">Editar</a>
                   </div>
                   <div class="col-md-6" style="padding: 20px">
                    <a href="" type="buttom" class="btn btn-danger">Eliminar</a>
                    </div>
                   </div>
                    </div> 

                    </div>              
                </div>
            </div><br />
        </div>
            
@endforeach

    </div>
</div>
@endsection
