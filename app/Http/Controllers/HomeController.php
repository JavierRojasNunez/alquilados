<?php

namespace App\Http\Controllers;

use Illuminate\View\View;


use App\Models\User;
use App\Models\Anounces;
use App\Models\Imagen;
use Illuminate\Support\Facades\DB;
use Database\Seeders\users;
use Illuminate\Http\Request;


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
   

        $anuncios = Anounces::paginate(5);
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
