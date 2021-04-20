<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anounces;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function search(Request $request){

            //dd($request);
            if($request->has('city'))
            {
                $search = $request->get('city');
                $anounce = Anounces::where('city_rent', Str::lower($search));

                $selections = DB::table('anounces')
                ->where('city_rent', '=', $search)
                ->limit(4)
                ->join('images', 'anounces_id', '=', 'anounces.id', 'left')
                ->inRandomOrder()
                ->get();
               //dd($selections);                

            }


            if(!$anounce || $anounce == null){

                $mensaje = 'Fallo en la busqueda, intentelo de nuevo';
                return redirect()->route('home')->with(['statuss_' => $mensaje]);

            }

            
                $anounce = $anounce->orderByDesc('id');
                $anounce = $anounce->paginate(10);
                return view('search.search', [
                            'anuncios' => $anounce,
                            'selections' => $selections,
                            'geoCity' => false,
                            'search' => false,
                            ]);

        


           

        

    }
}
