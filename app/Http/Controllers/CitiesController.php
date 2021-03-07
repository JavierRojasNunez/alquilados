<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Cities;

class CitiesController extends Controller
{
    protected $geoApiKey = '9fa3078bcede6cd5f69741fd0b198a36c440b8d0e920a3872c6264305e8f6487'; 
    protected $url;

    public function __construct(){
        $this->middleware('auth');
    }

    public static function getCities($city_id){


        
        //$ciudades = Cities::all()->where('province_id', '=', $city_id);
        $ciudades = DB::table('cities')->where('province_id', '=', $city_id)->get();
        


        return response()->json([
            'ciudades' => $ciudades,
        ]);

    }

    public function getAdress($char, $province_id){

        $char = str_replace(' ', '%20', $char);



        $this->url = 'https://apiv1.geoapi.es/qcalles?QUERY=' . $char . '&type=JSON&key=' . $this->geoApiKey ;
        
        $adress = json_decode(file_get_contents($this->url));

        for($i = 0; $i < count($adress->data); $i++){
            
           // dd ($adress->data[$i]);

          

            if ($adress->data[$i]->CPRO != $province_id){

                $adress->data[$i] = '';
                
            }
        }
        $adress = array_filter($adress->data);
        
        

        if(!$adress || empty($adress) ){
            $adress = false;
        }

        return response()->json([
            'calles' => $adress,
        ]);
        
    }
}
