<?php

namespace App\Http\Controllers;

use App\Models\Anounces;
use App\Models\User;

//use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
    public function index(Request $request)
    {

        if ($request->hasCookie('city')) {

            $city = $request->cookie('city');
            $selections = Anounces::where('city_rent', Str::lower($city))
                ->limit(4)
                ->orderByDesc('id')
                ->get();
        } else {

            $city = false;
            $selections = Anounces::select('*')
                ->limit(4)
                ->orderByDesc('id')
                ->get();
        }

        $anuncios = Anounces::simplePaginate(6);

        //dd($anuncios);

        if ($anuncios == null || $selections == null) {
            return view('errors.404');
        }

        return view('home', [
            'anuncios' => $anuncios,
            'selections' => $selections,
            'geoCity' => $city,
            'search' => false,
        ]);
    }

    public function detail(Anounces $anounce)
    {

        //obtenemos las caracteristicas del anuncio para las vistas
        $caracteristics = $anounce->getCaracteristics();
        //obtenemos los requisitos y los formateamos para las vistas
        $requeriments = $anounce->getRequeriments();
        //vamos a ver si esta disponible consultando la fecha
        $availabe = $anounce->setAvailabe($anounce->available_date);

        $selections = Anounces::select('*')
            ->limit(4)
            ->orderByDesc('id')
            ->get();

        if ($anounce == null || $selections == null) {
            return view('errors.404');
        }

        return view('anuncios.detail', [
            'anuncio' => $anounce,
            'selections' => $selections,
            'geoCity' => false,
            'search' => false,
            'caracteristics_images' => $caracteristics,
            'available' => $availabe,
            'requeriments' => $requeriments,
        ]);
    }

    public function redirectRegister()
    {

        $anuncios = Anounces::paginate(6);
        $selections = Anounces::select('*')
            ->limit(4)
            ->orderByDesc('id')
            ->get();


        $mensaje = 'Genial!! el registro fu?? bien. Te hemos enviado un email para que verifiques tu cuenta.';
        return view('home', [
            'anuncios' => $anuncios,
            'registro_ok' => $mensaje,
            'selections' => $selections,
            'search' => false,
        ])->with(['statuss_' => $mensaje]);
    }
}