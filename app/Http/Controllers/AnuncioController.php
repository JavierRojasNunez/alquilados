<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Anounces;
use App\Models\Imagen;
use App\Http\Controllers\ProvincesController;
use Illuminate\Support\Str;



class AnuncioController extends Controller
{

    const TYPE_RENT = 'alquiler';
    const TYPE_SELL = 'venta';
    
    public function __construct(){
        $this->middleware(['auth','verified']);
    }



	public function create($type = false){

       
        $user_id = Auth::user()->id;
        $provincias = provincesController::getProvinces();
        $countAnounces = Anounces::where('user_id', $user_id )->count();

        $type = Str::lower($type);

        if($type == self::TYPE_RENT){
            //si el tipo anuncio a publicar es alquiler $alquilar_ a true para cargar form de alquiler
            $alquilar_ = true;
            $value = self::TYPE_RENT;               
        }else if ($type == self::TYPE_SELL){
            //si el tipo anuncio a publicar es venta a false
            $alquilar_ = false;
            $value = self::TYPE_SELL;   
        }else{
            return redirect()->route('home')->with(['errores_' => Config::get('errors_azimut.' . 2010)]);
        }
        
        //setear variables del metodos edit a false para que no de conflictos con las variables pasadas por el metodo editar a la vista create
        $anuncio = false;
        $anounceId = false;
        //$images_ = false;

        return View::make('anuncios.create', [
            'provinces' => $provincias,
            'numAnounces' =>  $countAnounces,
            'anuncio' =>  $anuncio,
            'anounce_id' => $anounceId,
           // 'images_' => $images_,
            'type' => $alquilar_ ,
            'value'=> $value,
            ]);

	}

    

    public function getAnounces(){

        if (Auth::user()){


            $user_id = Auth::user()->id;
            $anuncios = Anounces::all()->where('user_id', '=', $user_id);

            if($anuncios == null){
                return view('errors.404');
            } 

        }

        if ( isset($user_id) && $user_id && $anuncios ){
            return view('user.anounces', [
                'anuncios' =>$anuncios
            ] );
        }else{
            return redirect()->route('home');
        }
    }



    public function edit( $anounceId, $type){

        $type = Str::lower($type);

        if($type == self::TYPE_RENT){
            //si el tipo anuncio a publicar es alquiler $alquilar_ a true para cargar form de alquiler
            $alquilar_ = true; 
            $value = self::TYPE_RENT;           
        }else if ($type == self::TYPE_SELL){
            //si el tipo anuncio a publicar es venta a false
            $alquilar_ = false;
            $value = self::TYPE_SELL; 
        }else{
            return redirect()->route('home')->with(['errores_' => Config::get('errors_azimut.' . 2010)]);
        }
      
        $provincias = provincesController::getProvinces();

        if ($provincias == null){

            $provincias = [];

        }

           $anuncio = Anounces::all()->where('id', '=', $anounceId)->first();
           
           if($anuncio == null ){

                return view('errors.404');

            } 


           if($anuncio->user_id != Auth::user()->id){

                Auth::logout();

                return redirect()->route('home');

           }
                
            return view('anuncios.create', [

                'anuncio' => $anuncio,
                'provinces' => $provincias,
                'anounce_id' => $anounceId,
                'type' => $alquilar_,
                'value'=> $value,

            ]);
        

    }

    public function delete($anounceId){



        if (!$anounceId){
            $anounceId = false;
            return redirect()->route('home')->with(['status' => 'Problemas al editar el anuncio, intentalo de nuevo por favor.']);
        }

        $anuncio = Anounces::findOrFail($anounceId);

        if($anuncio){
             $imagenes = Imagen::all()->where( 'anounces_id', '=', $anounceId )->where('user_id', '=', Auth::user()->id);
        }

        if($imagenes && Auth::user()->id === $anuncio->user_id){

            $dir = public_path() . '/anounces/' . Auth::user()->id . '/' ;
            $errores_ = true;
            foreach($imagenes as $imagen){

                $imageDelete = $dir . $imagen->imageName;
                //buscamos la imagen
                $imagenEliminar = Imagen::findOrFail($imagen->id);


                //eliminamos primero las imagenes de la carpeta y despues de la bbdd
                if (file_exists($imageDelete)) {
                    $ok = unlink($imageDelete);
                    if($ok){
                        $imagenEliminar->delete();
                        $errores_ = false;
                    }
                }else{
                    $errores_ = true;
                }


            }

            if(!$errores_){

                if($anuncio->delete()){

                    return redirect()->route('my.anounce', ['id' => Auth::user()->id ])->with(['status' => 'Bien!! Anuncio eliminado correctamente!!.']);
                }else{
                    return redirect()->route('my.anounce', ['id' => Auth::user()->id ])->with(['status' => 'Hubo algún problema y el anuncio no se elimino.']);
                }


            }else{
                return redirect()->route('my.anounce', ['id' => Auth::user()->id ])->with(['status' => 'Hubo algún problema y el anuncio no se elimino.']);
            }
        }

    }

    
}



