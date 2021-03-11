<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Anounces;
use App\Models\Imagen;
use App\Http\Controllers\ProvincesController;


class AnuncioController extends Controller
{

    //proteger controlador
    public function __construct(){
        $this->middleware('verified');
    }


	public function create(){

        if (Auth::user()){
            $user_id = Auth::user()->id;
            $provincias = provincesController::getProvinces();
            $countAnounces = Anounces::where('user_id', $user_id )->count();
        }else{
            $provincias = [];
            $countAnounces = false;
            return redirect()->route('home');

        }
        //setear variables del metodos edit a false para que no de conflictos con las variables pasadas por el metodo editar a la vista
        $anuncio = false;
        $anounceId = false;
        $images_ = false;

        return View::make('anuncios.create', [
            'provinces' => $provincias,
            'numAnounces' =>  $countAnounces,
            'anuncio' =>  $anuncio,
            'anounce_id' => $anounceId,
            'images_' => $images_,
            ]);

	}

    public function getAnounces(){

        if (Auth::user()){

            $user_id = Auth::user()->id;
            $anuncios = Anounces::all()->where('user_id', '=', $user_id);

            /*$anuncios = DB::table('anounces')
            ->leftJoin('images', 'anounces.id', '=', 'images.anounces_id')
            ->where()
            ->groupBy('images.anounces_id')
            ->get();*/

        }

        if ( isset($user_id) && $user_id && $anuncios ){
            return view('user.anounces', [
                'anuncios' =>$anuncios
            ] );
        }else{
            return redirect()->route('home');
        }
    }



    public function edit($anounceId){

        $provincias = provincesController::getProvinces();

        if (!$provincias){
            $provincias = [];
        }

        if (!$anounceId){
            $anounceId = false;
        }else{


           $anuncio = Anounces::all()->where('id', '=', $anounceId)->first();

           if( !isset($anuncio->user_id) || !isset(Auth::user()->id) || $anuncio->user_id != Auth::user()->id){
            return redirect()->route('home');
           }



        }


        if ( Auth::user() && $anuncio ){
            return view('anuncios.create', [
                'anuncio' => $anuncio,
                'provinces' => $provincias,
                'anounce_id' => $anounceId,

            ] );
        }else{
            return redirect()->route('home')->with(['status' => 'Problemas al editar el anuncio, intentalo de nuevo por favor.']);
        }

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


        if ( Auth::user()->id === $anuncio->user_id && $anuncio ){
            dd($imagenes);
            return view('anuncios.images', [
                'anuncio' => $anuncio,
                'anounce_id' => $anounceId,
            ] );
        }else{
            echo 'no hay anuncio';
            dd($anuncio);
            return redirect()->route('home')->with(['status' => 'Problemas al editar el anuncio, intentalo de nuevo por favor.']);
        }

    }

    public function save( Request $request ){


    $id = Auth::user()->id;
    $anuncio = new Anounces();

    $countAnounces = Anounces::where('user_id', $id )->count();

    if($countAnounces >= 2 && !$request->filled('anounce_id')){
        return redirect()->route('create.anounce')
        ->with([
            'errores_' =>
            'Ya ha publicado dos anuncios y no se permiten mas, si quier publicar mas pongase en contacto con el administrador
             en info@azimutweb.es'
        ]);
    }

        if ($request->isMethod('post') && Auth::user() )
        {

            $verify = Validator::make($request->except('foto1', 'foto2', 'foto3', 'foto4', 'foto5'), [

                'type_rent' => 'required|string|max:100',
                'price' => 'required|numeric|max:100000000',
                'payment_period' => 'required|string|max:20',
                'num_rooms' => 'nullable|numeric|max:100',
                'num_rooms_for_rent' => 'nullable|numeric|max:100',
                'num_baths' => 'nullable|numeric|max:100',
                'meter2' => 'nullable|numeric|max:10000000',
                'minimum_stay' => 'nullable|numeric|max:100',
                'minimum_stay_type' => 'nullable|string|max:100',
                'deposit' => 'nullable|numeric|max:100000000',
                'available_date' => 'nullable|date',
                'titulo' => 'nullable|string|max:255',
                'descripcion' => 'max:3500',
                'num_people_in' => 'nullable|numeric|max:1000',
                'people_in_sex' => 'nullable|string|max:100',
                'people_in_job' => 'nullable|string|max:100',
                'lookfor_who_sex' => 'nullable|string|max:100',
                'lookfor_who_job' => 'nullable|string|max:100',
                'province_rent' => 'required|string|max:255',
                'city_rent' => 'required|string|max:255',
                'street_rent' => 'nullable|string|max:100',
                'adress_rent' => 'required|string|max:255',
                'num_street_rent' => 'required|string|max:255',
                'phone' => 'required|numeric|max:999999999',
                'observations' => 'max:3500',


            ])->validate();

            $anuncio->user_id             = Auth::user()->id;
            $anuncio->type_rent           = $request->input('type_rent');
            $anuncio->price               = $request->input('price');
            $anuncio->min_time_ocupation  = $request->input('min_time_ocupation');
            $anuncio->payment_period      = $request->input('payment_period');
            $anuncio->meter2              = $request->input('meter2');
            $anuncio->min_time_ocupation  = $request->input('minimum_stay');
            $anuncio->num_roomms_for_rent = $request->input('num_rooms_for_rent');
            $anuncio->num_rooms           = $request->input('num_rooms');
            $anuncio->num_baths           = $request->input('num_baths');
            $anuncio->deposit             = $request->input('deposit');
            $anuncio->phone               = $request->input('phone');
            $anuncio->available_date      = $request->input('available_date');
            $anuncio->titulo              = $request->input('titulo');
            $anuncio->descripcion         = $request->input('descripcion');
            $anuncio->num_people_in       = $request->input('num_people_in');
            $anuncio->people_in_job       = $request->input('people_in_job');
            $anuncio->people_in_sex       = $request->input('people_in_sex');

            if ($request->filled('people_in_tabaco') && $request->input('people_in_tabaco') == 'on') {
                $anuncio->people_in_tabaco = true;
            }else{
                $anuncio->people_in_tabaco = false;
            }

            if ($request->filled('people_in_pet') && $request->input('people_in_pet') == 'on') {
                $anuncio->people_in_pet = true;
            }else{
                $anuncio->people_in_pet = false;
            }

            $anuncio->lookfor_who_job = $request->input('lookfor_who_job');
            $anuncio->lookfor_who_sex = $request->input('lookfor_who_sex');

            if ($request->filled('lookfor_who_tabaco') && $request->input('lookfor_who_tabaco') == 'on') {
                $anuncio->lookfor_who_tabaco = true;
            }else{
                $anuncio->lookfor_who_tabaco = false;
            }

            if ($request->filled('lookfor_who_pet') && $request->input('lookfor_who_pet') == 'on') {
                $anuncio->lookfor_who_pet = true;
            }else{
                $anuncio->lookfor_who_pet = false;
            }

            $anuncio->cauntry_rent = 'España';

            if (preg_match_all('/-/', $request->input('province_rent'))){
                $province_ = (explode( '-', $request->input('province_rent') ));
                $province_ = trim($province_[1]);
            }else{
                $province_ = $request->input('province_rent');
            }

            $anuncio->province_rent    = $province_;
            $anuncio->city_rent        = $request->input('city_rent');
            $anuncio->street_rent      = $request->input('street_rent');
            
                       
            $direccion = htmlentities($request->input('adress_rent'));
            $direccion = strtolower($direccion);
            $direccion = explode(' ', $direccion);
            $direccionAcentos = [];

            foreach($direccion as $key => $value){
                $direccionAcentos[] =  ucfirst($value);
            }

            $direccion = implode(' ', $direccionAcentos);
            $direccion = html_entity_decode ( $direccion );

            $anuncio->adress_rent      = $direccion;

            $anuncio->num_street_rent  = $request->input('num_street_rent');
            $anuncio->flat_street_rent = $request->input('flat_street_rent');
            $anuncio->cp_rent          = $request->input('cp_rent');

            if ($request->filled('funiture') && $request->input('funiture') == 'on') {
                $anuncio->funiture = true;
            }else{
                $anuncio->funiture = false;
            }

            if ($request->filled('ascensor') && $request->input('ascensor') == 'on') {
                $anuncio->ascensor = true;
            }else{
                $anuncio->ascensor = false;
            }

            if ($request->filled('calefaction') && $request->input('calefaction') == 'on') {
                $anuncio->calefaction = true;
            }else{
                $anuncio->calefaction = false;
            }


            if ($request->filled('balcon') && $request->input('balcon') == 'on') {
                $anuncio->balcon = true;
            }else{
                $anuncio->balcon = false;
            }

            if ($request->filled('terraza') && $request->input('terraza') == 'on') {
                $anuncio->terraza = true;
            }else{
                $anuncio->terraza = false;
            }

            if ($request->filled('gas') && $request->input('gas') == 'on') {
                $anuncio->gas = true;
            }else{
                $anuncio->gas = false;
            }

            if ($request->filled('swiming') && $request->input('swiming') == 'on') {
                $anuncio->swiming = true;
            }else{
                $anuncio->swiming = false;
            }

            if ($request->filled('internet') && $request->input('internet') == 'on') {
                $anuncio->internet = true;
            }else{
                $anuncio->internet = false;
            }

            if ($request->filled('washing_machine') && $request->input('washing_machine') == 'on') {
                $anuncio->washing_machine = true;
            }else{
                $anuncio->washing_machine = false;
            }

            if ($request->filled('fridge') && $request->input('fridge') == 'on') {
                $anuncio->fridge = true;
            }else{
                $anuncio->fridge = false;
            }

            if ($request->filled('kitchen') && $request->input('kitchen') == 'on') {
                $anuncio->kitchen = true;
            }else{
                $anuncio->kitchen = false;
            }

            if ($request->filled('near_bus') && $request->input('near_bus') == 'on') {
                $anuncio->near_bus = true;
            }else{
                $anuncio->near_bus = false;
            }

            if ($request->filled('near_underground') && $request->input('near_underground') == 'on') {
                $anuncio->near_underground = true;
            }else{
                $anuncio->near_underground = false;
            }

            if ($request->filled('near_tren') && $request->input('near_tren') == 'on') {
                $anuncio->near_tren = true;
            }else{
                $anuncio->near_tren = false;
            }

            if ($request->filled('near_school') && $request->input('near_school') == 'on') {
                $anuncio->near_school = true;
            }else{
                $anuncio->near_school = false;
            }

            if ($request->filled('near_airport') && $request->input('near_airport') == 'on') {
                $anuncio->near_airport = true;
            }else{
                $anuncio->near_airport = false;
            }

            $anuncio->observations = $request->input('observations');

               //si viene $request->input('anounce_id')es que se esta editando y no se ha de hacer save()
                if ($request->filled('anounce_id')) {
                    $anounceId = $request->input('anounce_id');
                }else{
                    $anounceId  = NULL;
                }

            //vamos a guardar los datos en caso de que  venga $request->file('foto1') o $anounceId si no editar anncio
            if( $request->file('foto1') !== NULL || $anounceId === NULL) {

            //guardamos datos form en bd y subimos files e introducimos en su tabla images
            if($anuncio->save()){

                $lastInsertId = $anuncio->id;

                //subir imagenes al server y no se esta editando
                $files = $request->file('foto1');
                $dir = public_path( '/anounces/' .Auth::user()->id . '/');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $totalImages = count($files);
                for($i = 0; $i < $totalImages; $i++){

                       // $fileUpName = $files[$i]->getClientOriginalName();
                        $mimeType = $files[$i]->getClientMimeType();
                       /* $arrayListaNegra = ['/.php/','/.php3/','/.php4/','/.exe/','/.aspx/','/.asp/','/.bat/', '/.htaccess/','/.sql/'];


                        for ($h = 0; $h < count($arrayListaNegra); $h++){
                            $noGoog = preg_match_all($arrayListaNegra[$h], $fileUpName);
                            if($noGoog){
                                return redirect()->route('create.anounce')->with(['errores_' => 'Alguno de los archivos ( '. $fileUpName.' ) que intenta  subir no son válidos tienen nombres o extensiones no permitidas'])->withInput();
                            }
                        }*/

                    if ($files[$i]->isValid() && ($mimeType == 'image/png' || $mimeType == 'image/jpg'  || $mimeType == 'image/jpeg'  || $mimeType == 'image/gif') ) {

                        $newName = uniqid() . '-' . ($i + 1) . '.' . $files[$i]->extension();

                        $img = Image::make($files[$i])
                        ->fit(800, 600, function ($constraint) {
                            $constraint->upsize();
                        })->orientate()
                        ->save(   public_path  ('/anounces/' . Auth::user()->id . '/' .$newName), 80 );
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
                        $images->anounces_id = $lastInsertId;
                        $images->imageName = $newName;
                        $ok = $images->save();

                            if(!$ok){
                                $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso. Intentelo de nuevo.';
                                $succes = 'errores_';
                                return redirect()->route('create.anounce')->with([$succes => $mensaje_])->withInput();
                            }


                    }else
                    {
                        return redirect()->route('create.anounce')->with(['errores_' => 'Alguno de los archivos que intenta subir no son válidos'])->withInput();
                    }

                }

            $mensaje_ = 'Perfecto!! Todo se guardo con éxito y el anuncio se ha creado correctamente.';
            $succes = 'statuss_';
            return redirect()->route('create.anounce')->with([$succes => $mensaje_]);

            }else{


                $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso. Intentelo de nuevo.';
                $succes = 'errores_';
                return redirect()->route('create.anounce')->with([$succes => $mensaje_])->withInput();
            }

    }else{
        //editar el anuncio


                if($anuncio->user_id !== Auth::user()->id){
                    return redirect()->route('home');
                }
                //dd($values = $anuncio->toArray());
                $values = $anuncio->toArray();
                $anuncio = false;
                $anuncio = Anounces::findOrFail($anounceId);

                $i =1;
                foreach($values as $key => $value){

                    $updateData = [$key => $value];
                    

                    $ok = $anuncio->update($updateData);
                        if(!$ok){
                            $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso: '.$i.' Intentelo de nuevo.';
                            $succes = 'errores_';
                            return redirect()->route('create.anounce')->with([$succes => $mensaje_])->withInput();
                        }

                    $i++;

                }


        $mensaje_ = 'Perfecto!! Todos los cambios se han efectuado correctamente.';
        $succes = 'statuss_';
        return redirect()->route('edit.anounce', ['id' => $anounceId])->with([$succes => $mensaje_]);


    }

}else{
    $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso. Intentelo de nuevo.';
    $succes = 'errores_';
    return redirect()->route('create.anounce')->with([$succes => $mensaje_]);
}

}
}



