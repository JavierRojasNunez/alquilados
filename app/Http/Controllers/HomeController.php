<?php

namespace App\Http\Controllers;

use App\Models\Anounces;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $anuncios = Anounces::paginate(10)->onEachSide(0);

        $selections = Anounces::select('*')       
        ->limit(4)
        ->orderByDesc('id')
        ->get();

        if($anuncios == null || $selections == null){
            return view('errors.404');
        } 

        return view('home', [           
            'anuncios' => $anuncios,
            'selections' => $selections,
        ]);
      
        
    }

    public function detail(Anounces $anounce){

        

        /*$anuncio = Anounces::where('id', '=', $anounce->id)->first();*/
        
        $selections = Anounces::select('*')
        ->limit(4)
        ->orderByDesc('id')
        ->get();

        if($anounce == null || $selections == null){
            return view('errors.404');
        }       

        return view('anuncios.detail', [           
            'anuncio' => $anounce,
            'selections' => $selections,
        ]);


    }

    public function redirectRegister(){

        $anuncios = Anounces::paginate(10);
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
