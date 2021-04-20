<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anounces;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function search(Request $request){

        //$search = false;
        //$anounce = false;
        //$q = false;

        if(! $request->has('province_rent') ||  $request->input('province_rent') == 'Donde' ||  $request->input('province_rent') == ''  ){

            $mensaje = 'Por favor indique una provincia para la busqueda';
            return redirect()->route('home')->with(['statuss_' => $mensaje])->withInput(['province_rent']);

        }        

                   
        $search = $request->input('province_rent');
        $q = Anounces::where('province_rent', Str::lower($search));            
                      
        

        if($request->has('caracteristics') && $request->input('caracteristics') != '' && $request->input('caracteristics') != 'Caracteristicas' )
        {
            $search = $request->input('caracteristics');
            $anounce = $q->where($search, 1);            

        }

        $selections = DB::table('anounces');

        if ($search) $selections = $selections->where('city_rent', '=', $search);

        $selections = $selections->limit(4);
        $selections = $selections->join('images', 'anounces_id', '=', 'anounces.id', 'left');
        $selections = $selections->inRandomOrder();
        $selections = $selections->get();

        $anounce = $q->orderBy('id', 'DESC');
        $anounce = $q->paginate(10);


        if($anounce == null){

            $mensaje = 'Fallo en la busqueda, intentelo de nuevo';
            return redirect()->route('home')->with(['statuss_' => $mensaje]);

        }       
        
        return view('search.search', [
                    'anuncios' => $anounce,
                    'selections' => $selections,
                    'geoCity' => false,
                    'search' => false,
                    ]);

        


           

        

    }
}
