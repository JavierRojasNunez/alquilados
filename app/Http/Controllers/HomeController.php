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

    /*public function __construct()
    {
        $this->middleware('verified');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
   


        $anuncios = Anounces::paginate(5);


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

        //dd($imagenes);

        //$images = Imagen::

        //$imagenes = Imagen::all();
        //$imagenes = Imagen::orderBy('id', 'desc')->get();
        //$imagenes = Imagen::all()->groupBy('anounces_id');
        //dd($anuncios);
        //return view('home');
        //return View::View('home',compact('users'));
        return view('home', [           
            'anuncios' =>$anuncios,
        ] );
        
    }
}
