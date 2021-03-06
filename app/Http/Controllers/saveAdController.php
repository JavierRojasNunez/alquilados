<?php

namespace App\Http\Controllers;

use App\Events\newAdd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Anounces;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;

class saveAdController extends Controller
{
    public function save(Request $request)
    {


        $anuncio = new Anounces();

        $countAnounces = Anounces::where('user_id', Auth::id())->count();

        if ($countAnounces >= 2 && !$request->filled('anounce_id')) {
            return redirect()->route('create.anounce')
                ->with([
                    'errores_' =>
                    'Ya ha publicado dos anuncios y no se permiten mas, si quier publicar mas pongase en contacto con el administrador
                 en info@azimutweb.es'
                ]);
        }

        if ($request->isMethod('post') && Auth::user()) {

            $verify = Validator::make($request->except('foto2', 'foto3', 'foto4', 'foto5'), [

                'type_rent'          => 'required|string|max:100',
                'price'              => 'required|numeric|max:100000000',
                'payment_period'     => 'nullable|string|max:20',
                'num_rooms'          => 'nullable|numeric|max:100',
                'num_rooms_for_rent' => 'nullable|numeric|max:100',
                'num_baths'          => 'nullable|numeric|max:100',
                'meter2'             => 'nullable|numeric|max:10000000',
                'minimum_stay'       => 'nullable|numeric|max:100',
                'minimum_stay_type'  => 'nullable|string|max:100',
                'deposit'            => 'nullable|numeric|max:100000000',
                'available_date'     => 'nullable|date',
                'titulo'             => 'nullable|string|max:255',
                'descripcion'        => 'max:3500',
                'num_people_in'      => 'nullable|numeric|max:1000',
                'people_in_sex'      => 'nullable|string|max:100',
                'people_in_job'      => 'nullable|string|max:100',
                'lookfor_who_sex'    => 'nullable|string|max:100',
                'lookfor_who_job'    => 'nullable|string|max:100',
                'province_rent'      => 'required|string|max:255',
                'city_rent'          => 'required|string|max:255',
                'street_rent'        => 'nullable|string|max:100',
                'adress_rent'        => 'required|string|max:255',
                'num_street_rent'    => 'required|string|max:255',
                'phone'              => 'required|numeric|max:999999999',
                'observations'       => 'max:3500',
                'type'               => 'required|string|max:10',


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
            $anuncio->type                = $request->input('type');
            $type = $anuncio->type;

            if ($request->filled('people_in_tabaco') && $request->input('people_in_tabaco') == 'on') {
                $anuncio->people_in_tabaco = true;
            } else {
                $anuncio->people_in_tabaco = false;
            }

            if ($request->filled('people_in_pet') && $request->input('people_in_pet') == 'on') {
                $anuncio->people_in_pet = true;
            } else {
                $anuncio->people_in_pet = false;
            }

            $anuncio->lookfor_who_job = $request->input('lookfor_who_job');
            $anuncio->lookfor_who_sex = $request->input('lookfor_who_sex');

            if ($request->filled('lookfor_who_tabaco') && $request->input('lookfor_who_tabaco') == 'on') {
                $anuncio->lookfor_who_tabaco = true;
            } else {
                $anuncio->lookfor_who_tabaco = false;
            }

            if ($request->filled('lookfor_who_pet') && $request->input('lookfor_who_pet') == 'on') {
                $anuncio->lookfor_who_pet = true;
            } else {
                $anuncio->lookfor_who_pet = false;
            }

            $anuncio->cauntry_rent = 'Espa??a';

            if (preg_match_all('/-/', $request->input('province_rent'))) {
                $province_ = explode('-', $request->input('province_rent'));
                $province_ = trim($province_[1]);
            } else {
                $province_ = $request->input('province_rent');
            }

            $anuncio->province_rent    = $province_;
            $anuncio->city_rent        = $request->input('city_rent');
            $anuncio->street_rent      = $request->input('street_rent');

            //esto hay que hacer para que el dichoso windows no meta caracteres extra??os y poder pasar de mayusculas a minusculas           
            $direccion = htmlentities($request->input('adress_rent'));
            $direccion = strtolower($direccion);
            $direccion = explode(' ', $direccion);
            $direccionAcentos = [];

            foreach ($direccion as $key => $value) {
                $direccionAcentos[] =  ucfirst($value);
            }

            $direccion = implode(' ', $direccionAcentos);
            $direccion = html_entity_decode($direccion);

            $anuncio->adress_rent      = $direccion;

            $anuncio->num_street_rent  = $request->input('num_street_rent');
            $anuncio->flat_street_rent = $request->input('flat_street_rent');
            $anuncio->cp_rent          = $request->input('cp_rent');

            if ($request->filled('funiture') && $request->input('funiture') == 'on') {
                $anuncio->funiture = true;
            } else {
                $anuncio->funiture = false;
            }

            if ($request->filled('ascensor') && $request->input('ascensor') == 'on') {
                $anuncio->ascensor = true;
            } else {
                $anuncio->ascensor = false;
            }

            if ($request->filled('calefaction') && $request->input('calefaction') == 'on') {
                $anuncio->calefaction = true;
            } else {
                $anuncio->calefaction = false;
            }


            if ($request->filled('balcon') && $request->input('balcon') == 'on') {
                $anuncio->balcon = true;
            } else {
                $anuncio->balcon = false;
            }

            if ($request->filled('terraza') && $request->input('terraza') == 'on') {
                $anuncio->terraza = true;
            } else {
                $anuncio->terraza = false;
            }

            if ($request->filled('gas') && $request->input('gas') == 'on') {
                $anuncio->gas = true;
            } else {
                $anuncio->gas = false;
            }

            if ($request->filled('swiming') && $request->input('swiming') == 'on') {
                $anuncio->swiming = true;
            } else {
                $anuncio->swiming = false;
            }

            if ($request->filled('internet') && $request->input('internet') == 'on') {
                $anuncio->internet = true;
            } else {
                $anuncio->internet = false;
            }

            if ($request->filled('washing_machine') && $request->input('washing_machine') == 'on') {
                $anuncio->washing_machine = true;
            } else {
                $anuncio->washing_machine = false;
            }

            if ($request->filled('fridge') && $request->input('fridge') == 'on') {
                $anuncio->fridge = true;
            } else {
                $anuncio->fridge = false;
            }

            if ($request->filled('kitchen') && $request->input('kitchen') == 'on') {
                $anuncio->kitchen = true;
            } else {
                $anuncio->kitchen = false;
            }

            if ($request->filled('near_bus') && $request->input('near_bus') == 'on') {
                $anuncio->near_bus = true;
            } else {
                $anuncio->near_bus = false;
            }

            if ($request->filled('near_underground') && $request->input('near_underground') == 'on') {
                $anuncio->near_underground = true;
            } else {
                $anuncio->near_underground = false;
            }

            if ($request->filled('near_tren') && $request->input('near_tren') == 'on') {
                $anuncio->near_tren = true;
            } else {
                $anuncio->near_tren = false;
            }

            if ($request->filled('near_school') && $request->input('near_school') == 'on') {
                $anuncio->near_school = true;
            } else {
                $anuncio->near_school = false;
            }

            if ($request->filled('near_airport') && $request->input('near_airport') == 'on') {
                $anuncio->near_airport = true;
            } else {
                $anuncio->near_airport = false;
            }

            $anuncio->observations = $request->input('observations');

            //si viene $request->input('anounce_id')es que se esta editando y no se ha de hacer save()
            if ($request->filled('anounce_id')) {

                $anounceId = $request->input('anounce_id');
            } else {

                $anounceId  = NULL;
            }




            //vamos a guardar los datos en caso de que  venga $request->file('foto1') o $anounceId si no editar anncio
            if ($request->file('foto1') !== NULL || $anounceId === NULL) {

                //guardamos datos form en bd y subimos files e introducimos en su tabla images

                if ($anuncio->save()) {

                    //lanzamos evento de creacion de nuevo anuncio
                    event(new newAdd($anuncio));
                    $lastInsertId = $anuncio->id;

                    //subir imagenes al server y no se esta editando
                    $files = $request->file('foto1');

                    if ($files == null) {
                        return view('errors.404');
                    }


                    $dir = 'anuncios/' . Auth::user()->id;
                    Storage::disk('images')->makeDirectory($dir);

                    $totalImages = (is_array($files) || is_object($files))
                        ? count($files)
                        : 0;

                    for ($i = 0; $i < $totalImages; $i++) {

                        $mimeType = $files[$i]->getClientMimeType();


                        if ($files[$i]->isValid() && ($mimeType == 'image/png' || $mimeType == 'image/jpg'  || $mimeType == 'image/jpeg'  || $mimeType == 'image/gif')) {

                            $newName = uniqid() . '-' . rand(0, 10000000) . '-' . ($i + 1) . '.' . $files[$i]->extension();

                            $img = Image::make($files[$i])
                                ->fit(800, 600, function ($constraint) {
                                    $constraint->upsize();
                                })
                                ->orientate()
                                ->stream();

                            $finalName = $dir . '/' . $newName;

                            Storage::disk('images')->put($finalName, $img);

                            $images = new Imagen();
                            $images->user_id = Auth::user()->id;
                            $images->anounces_id = $lastInsertId;
                            $images->imageName = $newName;
                            $ok = $images->save();

                            if (!$ok) {
                                $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso. Intentelo de nuevo.';
                                $succes = 'errores_';
                                $anuncio->delete();
                                return redirect()->route('create.anounce', ['type' => $type])->with([$succes => $mensaje_])->withInput();
                            }
                        } else {
                            return redirect()->route('create.anounce', ['type' => $type])->with(['errores_' => 'Alguno de los archivos que intenta subir no son v??lidos'])->withInput();
                        }
                    }

                    $mensaje_ = 'Perfecto!! Todo se guardo con ??xito y el anuncio se ha creado correctamente.';
                    $succes = 'statuss_';
                    return redirect()->route('create.anounce', ['type' => $type])->with([$succes => $mensaje_]);
                } else {


                    $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso. Intentelo de nuevo.';
                    $succes = 'errores_';
                    return redirect()->route('create.anounce', ['type' => $type])->with([$succes => $mensaje_])->withInput();
                }
            } else {

                //editar el anuncio
                if ($anuncio->user_id !== Auth::user()->id) {

                    Auth::logout();

                    return redirect()->route('home');
                }

                $values = $anuncio->toArray();
                $anuncio = false;
                $anuncio = Anounces::findOrFail($anounceId);

                $i = 1;
                foreach ($values as $key => $value) {

                    $updateData = [$key => $value];

                    $ok = $anuncio->update($updateData);

                    if (!$ok) {
                        $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso: ' . $i . ' Intentelo de nuevo.';
                        $succes = 'errores_';
                        return redirect()->route('create.anounce', ['type' => $type])->with([$succes => $mensaje_])->withInput();
                    }

                    $i++;
                }


                $mensaje_ = 'Perfecto!! Todos los cambios se han efectuado correctamente.';
                $succes = 'statuss_';
                return redirect()->route('edit.anounce', ['id' => $anounceId, 'type' => $type])->with([$succes => $mensaje_]);
            }
        } else {
            $mensaje_ = 'Upss! Lo sentimos hubo algun error durante el proceso. Intentelo de nuevo.';
            $succes = 'errores_';
            return redirect()->route('create.anounce')->with([$succes => $mensaje_]);
        }
    }
}