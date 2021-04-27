<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Carbon;



class Anounces extends Model
{
    use HasFactory;

    protected $table = 'anounces';
    
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type_rent', 'price', 'min_time_ocupation', 'payment_period', 'meter2', 'num_roomms_for_rent', 'num_rooms',
        'num_baths', 'deposit', 'phone' ,'available_date', 'titulo', 'descripcion', 'num_people_in', 'people_in_job', 'people_in_sex',
        'people_in_tabaco', 'people_in_pet', 'lookfor_who_job', 'lookfor_who_sex', 'lookfor_who_tabaco', 'lookfor_who_pet',
        'cauntry_rent', 'province_rent', 'city_rent', 'street_rent', 'adress_rent', 'num_street_rent', 'flat_street_rent',
        'cp_rent', 'funiture', 'ascensor', 'calefaction', 'balcon', 'terraza', 'gas', 'swiming', 'internet', 'washing_machine',
        'fridge', 'kitchen', 'near_bus', 'near_underground', 'near_tren', 'near_school', 'near_airport', 'observations',
        'type', 'foto2', 'foto3', 'foto4', 'foto5',

    ];

    protected $with = [
        'imagen',
        'user',
    ];

    protected $caracteristics = [
        'funiture', 'ascensor', 'calefaction', 'balcon', 'terraza', 'gas', 'swiming', 'internet', 
        'fridge', 'kitchen', 'near_bus', 'near_underground', 'near_tren', 'near_school', 'near_airport',
    ];

    protected $requirements = [
        'deposit', 'lookfor_who_job', 'lookfor_who_sex','lookfor_who_tabaco', 'lookfor_who_pet',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comment(){
        return $this->hasMany(Comments::class);
    }

    public function favorites(){
        return $this->hasMany(Favorites::class);
    }

    public function imagen(){
        return $this->hasMany(Imagen::class);
    }


    public function getRequeriments(){

        $requeriments = DB::table('anounces')
        ->select($this->requirements)
        ->where('id', $this->id)
        ->first();
        return $requeriments;

    }

    public function setAvailabe($date_){

        $now = Carbon::now()->locale('es');
        $available = Carbon::create($date_)->locale('es');
        $nowTimeStamp = $now->timestamp;
        $availableTimeStamp = $available->timestamp;

        if($nowTimeStamp >= $availableTimeStamp){
            return 'Disponible';
        }
           
        return 'Disponible a partir del ' . $available->isoFormat('LL');

    }

    public function getCaracteristics()
    {
        $caracteristics = DB::table('anounces')
        ->select($this->caracteristics)
        ->where('id', $this->id)
        ->first();

        $caracteristics = (array) $caracteristics;//pasamos de objeto a arrray
        $icons = Config::get('caracteristics_images');//recuperamos el array con las imagenes de las caracteristicas de la carpeta config archivo caracteristics_images.php
 
        //mezclamos los dos arrays para obtener las caracteristicas con su valos 1 o 0 de la bbdd y su imagen
        //definida en config/caracteristics_images.
        
        if($caracteristics != null)
        {
           foreach($caracteristics as $key => $value)
           {
               if($key == 'funiture') $index = 'Amueblado';
               if($key == 'ascensor') $index = 'Ascensor'; 
               if($key == 'calefaction') $index = 'Calefacción'; 
               if($key == 'balcon') $index = 'Balcón'; 
               if($key == 'gas') $index = 'Gas'; 
               if($key == 'swiming') $index = 'Piscina'; 
               if($key == 'internet') $index = 'Wifi'; 
               if($key == 'fridge') $index = 'Nevera'; 
               if($key == 'kitchen') $index = 'Cocina'; 
               if($key == 'near_bus') $index = 'Cerca de bus'; 
               if($key == 'near_underground') $index = 'Cerca del metro'; 
               if($key == 'near_tren') $index = 'Cerca del tren'; 
               if($key == 'near_school') $index = 'Cerca de colegios'; 
               if($key == 'near_airport') $index = 'Cerca del aeropuerto';  
               //asignamos la imagen correspondiente a cada caracteristica
               //y cambiamos el nombre de las keys para las vistas para no enseñar los campos de las tablas.
               //y lo metemos todo en un array
               $result[$index] = [ $value, $icons[$key] ] ;              
           }

           return $result;
        }       

        return false;
    }
}
