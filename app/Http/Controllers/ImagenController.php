<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Anounces;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;


class ImagenController extends Controller
{

    public function editImages($anounceId){
        
        

        if (!$anounceId || !Auth::user()){
            $anounceId = false;
            return redirect()->route('home'); 
        }else{
            //$anuncio = Imagen::where('anounces_id', '=', $anounceId)->get()->all();  
            //$anuncio = Imagen::select(['imageName', 'user_id'])->where('anounces_id', '=', $anounceId)->get();  
            $imagenes = Imagen::all()->where('anounces_id', '=', $anounceId)->where('user_id', '=', Auth::user()->id);  
            $numImages = Imagen::where('anounces_id', '=', $anounceId)->count();
            //$anuncio = Imagen::find($id);                         
                   
        }               

        if ( Auth::user() && $imagenes ){
            return view('anuncios.images', [              
                'images_' => $imagenes,
                'anounce_id' => $anounceId,
                'numImages' => $numImages
            ] );
        }else{
            return redirect()->route('home')->with(['status' => 'Problemas al editar el anuncio, intentalo de nuevo por favor.']); 
        }
        
    }

    public function getImage($id, $filename){
           
        $file = public_path('anounces/' . $id . '/' .$filename);            
        return new Response($file, 200);
                  
	}

    public function saveImages(Request $request)
    {

      $anounce_id = $request->input('anounce_id');
      $numImages_baseDatos = Imagen::where('anounces_id', '=', $anounce_id)->count();
      $numImages_form = count($request->file('foto1'));
      $maxImages = 5;
      $numImagesAllow = ($maxImages - $numImages_baseDatos);

     
      if($numImages_form > $numImagesAllow){
            $plural = ($numImagesAllow == 1) ? 'imagen' : 'imagenes';
        $mensaje_ ="Upss! No se subieron las imagenes, solo puedes subir $numImagesAllow $plural mas.";
        $succes = 'errores_';
        return redirect()->route('edit.images', ['id' => $anounce_id])->with([$succes => $mensaje_]); 
      }

      
        
      
      $anuncio = Anounces::find($anounce_id);
      
      if (!$request->isMethod('post') && Auth::user()->id !==  $anuncio->user_id) 
      {
        $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso. Intentelo de nuevo.';
        $succes = 'errores_';
        return redirect()->route('edit.images', ['id' => $anounce_id])->with([$succes => $mensaje_]); 
      }
        
        
        $files = $request->file('foto1');
        $dir = public_path( '/anounces/' .Auth::user()->id . '/');
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        //vamos a fijar a cuatro las imagenes que se puedan subir si o si
        $totalImages = count($files);
        //$totalImages = 4;

        for($i = 0; $i < $totalImages; $i++){

            // $fileUpName = $files[$i]->getClientOriginalName();
            $mimeType = $files[$i]->getClientMimeType();

            if ($files[$i]->isValid() && ($mimeType == 'image/png' || $mimeType == 'image/jpg'  || $mimeType == 'image/jpeg'  || $mimeType == 'image/gif') ) {
                
                $newName = uniqid() . '-' . ($i + 1) . '.' . $files[$i]->extension();
                
                $img = Image::make($files[$i])                       
                ->fit(800, 600, function ($constraint) {
                    $constraint->upsize();
                })
                ->save(   public_path  ('/anounces/' . Auth::user()->id . '/' .$newName), 90 );
                /*
                ->resize(650, 650, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->orientate()
                ->save(   public_path  ('/anounces/' . Auth::user()->id . '/' .$newName), 90 ); 
                */
                
                $images = new Imagen();
                $images->user_id = Auth::user()->id;
                $images->anounces_id = $anounce_id;
                $images->imageName = $newName;
                $ok = $images->save();
                
                    if(!$ok){
                        
                        $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso. Intentelo de nuevo.';
                        $succes = 'errores_';
                        return redirect()->route('edit.images', ['id' => $anounce_id])->with([$succes => $mensaje_])->withInput(); 
                    }


            }else
            {
                return redirect()->route('edit.images', ['id' => $anounce_id])->with(['errores_' => 'Alguno de los archivos que intenta subir no son válidos'])->withInput();
            } 

        }

            $mensaje_ = 'Perfecto!! Las imagenes se guardaron con éxito.';
            $succes = 'statuss_';
            return redirect()->route('edit.images', ['id' => $anounce_id])->with([$succes => $mensaje_]); 
    /*else{
        $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso. Intentelo de nuevo.';
        $succes = 'errores_';
        return redirect()->route('edit.images', ['id' => $anounce_id])->with([$succes => $mensaje_]); 
    }*/


    }


    public function deleteImage($image_id, $anounce_id){

        //dd($image_id);
        $response = 0;
        $imagen = Imagen::findOrFail($image_id);
        $user_id = Auth::user()->id;
        
        //obtenemos numero imagenes y no dejamos eliminar si solo tiene una
        $numImages = Imagen::where('anounces_id', '=', $anounce_id)->count();
        
        if( $numImages > 1 ){
        
            if (Auth::user()->id === $user_id && $imagen){

                
                if ($imagen->delete()){

                    $imageDelete = public_path() . '/anounces/' . Auth::user()->id . '/' . $imagen->imageName;
                    if (file_exists($imageDelete)) {
                        $ok = unlink($imageDelete);
                    }
                
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
