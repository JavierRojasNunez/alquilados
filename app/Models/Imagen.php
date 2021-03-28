<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'user_id', 'anounces_id', 'imageName',
    ];

    protected $hidden = [
        
        'remember_token', 'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function anounces(){
        return $this->belongsTo(Anounces::class);
    }

    


    
}
