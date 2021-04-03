<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
//use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
class GetApiDataController extends Controller
{

    public function getAll($limit){

        $limit =  (integer)$limit;
        $url = 'http://localhost/alquilados/public/api/v1/anuncios/' . $limit;


        $response = Http::withHeaders([

            'Content-Type' => 'application/json',
            
        ])->get( $url );
        $responses = $response->collect();
        dd($responses);
    }
    

}
