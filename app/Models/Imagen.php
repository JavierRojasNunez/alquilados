<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;

    protected $table = 'images';

    const DEFAULT_IMG = "/anuncios/default.jpg";

    protected $fillable = [
        'user_id', 'anounces_id', 'imageName',
    ];

    protected $hidden = [
        
        'remember_token', 'user_id',
    ];

    protected $appends = ['img_url'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function anounces(){
        return $this->belongsTo(Anounces::class);
    }

    public function getImgUrlAttribute()
    {
        return $this->imageName == null ? url('/images/'. self::DEFAULT_IMG) : url('/images/'. $this->user_id . '/' . $this->imageName);
    }


    
}
