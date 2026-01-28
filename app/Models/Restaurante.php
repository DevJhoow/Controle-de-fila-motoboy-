<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
      protected $fillable = [
        'nome',
        'latitude',
        'longitude',
    ];

    public function motoboys()
    {
        return $this->hasMany(Motoboy::class);
    }

}
