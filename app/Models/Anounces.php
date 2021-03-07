<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'num_baths', 'deposit', 'available_date', 'titulo', 'descripcion', 'num_people_in', 'people_in_job', 'people_in_sex',
        'people_in_tabaco', 'people_in_pet', 'lookfor_who_job', 'lookfor_who_sex', 'lookfor_who_tabaco', 'lookfor_who_pet',
        'cauntry_rent', 'province_rent', 'city_rent', 'street_rent', 'adress_rent', 'num_street_rent', 'flat_street_rent',
        'cp_rent', 'funiture', 'ascensor', 'calefaction', 'balcon', 'terraza', 'gas', 'swiming', 'internet', 'washing_machine',
        'fridge', 'kitchen', 'near_bus', 'near_underground', 'near_tren', 'near_school', 'near_airport', 'observations',
        'foto1', 'foto2', 'foto3', 'foto4', 'foto5',

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
}
