<?php

namespace App\Http\Controllers;

use App\Models\Anounces;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
   

        $anuncios = Anounces::paginate(10);
        $selections = Anounces::select('*')
        ->limit(4)
        ->orderByDesc('id')
        ->get();


        return view('home', [           
            'anuncios' => $anuncios,
            'selections' => $selections,
        ]);

       /* $imagenes = DB::table('images')

            ->groupBy('anounces_id')
            ->get();
            dd($imagenes);  */ 

  
        /*$anuncios = DB::table('anounces')
        ->leftJoin('images', 'anounces.id', '=', 'images.anounces_id')
        ->groupBy('images.anounces_id')
        ->get();*/

       /* $imagenes = DB::table('images')
        ->leftJoin('anounces', 'images.anounces_id', '=', 'anounces.id')
        ->groupBy('images.anounces_id')
        ->get();*/


        
        
    }

    public function detail($anounce_id){

        $anuncio = Anounces::where('id', '=', $anounce_id)->first();
        $selections = Anounces::select('*')
        ->limit(4)
        ->orderByDesc('id')
        ->get();

        return view('anuncios.detail', [           
            'anuncio' => $anuncio,
            'selections' => $selections,
        ]);

       // dd($anuncio);

    }

    public function redirectRegister(){

        $anuncios = Anounces::paginate(5);
        $selections = Anounces::select('*')
        ->limit(4)
        ->orderByDesc('id')
        ->get();

        
        $mensaje = 'Genial!! el registro fué bien. Te hemos enviado un email para que verifiques tu cuenta.';
        return view('home', [           
            'anuncios' => $anuncios,
            'registro_ok' => $mensaje,
            'selections' => $selections,
        ])->with(['statuss_' => $mensaje]);
        
    }
}
