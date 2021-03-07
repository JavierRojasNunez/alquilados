<?php

namespace App\Http\Controllers;

use App\Models\Provinces;

class ProvincesController extends Controller
{
    public static function getProvinces(){

        $provincias = Provinces::all();
        return $provincias;

    }

    

    
}
