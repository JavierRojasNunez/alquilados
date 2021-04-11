<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Anounces;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class ImagenController extends Controller
{

    public function editImages($anounceId, $type){
        
        

        if (!$anounceId || !Auth::user()){
            $anounceId = false;
            return redirect()->route('home'); 
        }else{

            $imagenes = Imagen::all()->where('anounces_id', '=', $anounceId)->where('user_id', '=', Auth::user()->id);  
            $numImages = Imagen::where('anounces_id', '=', $anounceId)->count();

        }               

        if ( Auth::user() && $imagenes ){
            return view('anuncios.images', [              
                'images_' => $imagenes,
                'anounce_id' => $anounceId,
                'numImages' => $numImages,
                'type' => $type,
            ] );
        }else{
            return redirect()->route('home')->with(['status' => 'Problemas al editar el anuncio, intentalo de nuevo por favor.']); 
        }
        
    }

    public function getImage($id, $filename){
           
        
        //$file = public_path('anounces/' . $id . '/' .$filename);
        $file = Storage::disk('images')->get('anuncios/'. $id . '/' .  $filename);
        return new Response($file, 200);
                  
	}

    public function saveImages(Request $request)
    {
        $anounce_id = $request->input('anounce_id');
        $type = $request->input('type');

       
        if ((!$request->isMethod('post') && Auth::user() ) || !$request->hasFile('foto1'))
        {
            $mensaje_ = 'Upss! Ha de seleccionar una imagen como minimo.';
            $succes = 'errores_';
            return redirect()->route('edit.images', ['id' => $anounce_id, 'type' => $type])->with([$succes => $mensaje_])->withInput(); 
        }

      
      $numImages_baseDatos = Imagen::where('anounces_id', '=', $anounce_id)->count();
      $numImages_form = count($request->file('foto1'));
      $maxImages = 5;
      $numImagesAllow = ($maxImages - $numImages_baseDatos);

     
        if($numImages_form > $numImagesAllow){
            $plural = ($numImagesAllow == 1) ? 'imagen' : 'imagenes';
            $mensaje_ ="Upss! No se subieron las imagenes, solo puedes subir $numImagesAllow $plural mas.";
            $succes = 'errores_';
            return redirect()->route('edit.images', ['id' => $anounce_id, 'type' => $type])->with([$succes => $mensaje_]); 
        }

      
        
      
        $anuncio = Anounces::findOrFail($anounce_id);
      
        if (!$request->isMethod('post') || Auth::user()->id !==  $anuncio->user_id) 
        {
            $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso. Intentelo de nuevo.';
            $succes = 'errores_';
            return redirect()->route('edit.images', ['id' => $anounce_id, 'type' => $type])->with([$succes => $mensaje_]); 
        }
      
        
        $files = $request->file('foto1');

        $dir = 'anuncios/' . Auth::user()->id;
        Storage::disk('images')->makeDirectory($dir);


        //vamos a fijar a cuatro las imagenes que se puedan subir si o si
        $totalImages = (is_array($files) || is_object($files)) 
        ? count($files) 
        : 0 ;

        for($i = 0; $i < $totalImages; $i++){

            // $fileUpName = $files[$i]->getClientOriginalName();
            $mimeType = $files[$i]->getClientMimeType();

            if ($files[$i]->isValid() && ($mimeType == 'image/png' || $mimeType == 'image/jpg'  || $mimeType == 'image/jpeg'  || $mimeType == 'image/gif') ) {
                
                $newName = uniqid() . '-' . rand(0,10000000) . '-' .($i + 1) . '.' . $files[$i]->extension();
                
                $img = Image::make($files[$i])                       
                ->fit(800, 600, function ($constraint) {
                    $constraint->upsize();
                })
                ->orientate()
                ->stream();

                $finalName = $dir . '/' . $newName;

                Storage::disk('images')->put($finalName, $img );
                
                $images = new Imagen();
                $images->user_id = Auth::user()->id;
                $images->anounces_id = $anounce_id;
                $images->imageName = $newName;
                $ok = $images->save();
                
                    if(!$ok){
                        
                        $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso. Intentelo de nuevo.';
                        $succes = 'errores_';
                        return redirect()->route('edit.images', ['id' => $anounce_id, 'type' => $type])->with([$succes => $mensaje_])->withInput(); 
                    }


            }else
            {
                return redirect()->route('edit.images', ['id' => $anounce_id, 'type' => $type])->with(['errores_' => 'Alguno de los archivos que intenta subir no son válidos'])->withInput();
            } 

        }

            $mensaje_ = 'Perfecto!! Las imagenes se guardaron con éxito.';
            $succes = 'statuss_';
            return redirect()->route('edit.images', ['id' => $anounce_id, 'type' => $type])->with([$succes => $mensaje_]); 
    /*else{
        $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso. Intentelo de nuevo.';
        $succes = 'errores_';
        return redirect()->route('edit.images', ['id' => $anounce_id])->with([$succes => $mensaje_]); 
    }*/


    }


    public function deleteImage($image_id, $anounce_id){

       
        $response = 0;
        $imagen = Imagen::findOrFail($image_id);
        
        //obtenemos numero imagenes y no dejamos eliminar si solo tiene una
        $numImages = Imagen::where('anounces_id', '=', $anounce_id)->count();
        
        if( $numImages > 1 ){
        
            if (Auth::id() === $imagen->user_id){

                
                if ($imagen->delete()){



                    $ok = Storage::disk('images')->delete('anuncios/'. Auth::id() . '/' .  $imagen->imageName);

                    if($ok){

                        $response = 1; 

                    }else{

                        $response = 0;

                    }
                    
                }else{

                    $response = 0;
                }

            }else{

                $response = 0;
            }

    }else{
        //solo le queda una imagen, no deja borrarla
        $response = 2;
    }
        

          return response()->json([
            'respuesta' => $response,
            'numImages' => $numImages,
        ]);
        
    }
}
