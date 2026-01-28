<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fila extends Model
{
     protected $fillable = [
        'motoboy_id',
        'restaurante_id',
        'posicao',
        'ativo'
    ];

    public function motoboy()
    {
        return $this->belongsTo(Motoboy::class);
    }

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }
    
}
