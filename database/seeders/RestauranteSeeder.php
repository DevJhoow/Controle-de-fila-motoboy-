<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurante;

class RestauranteSeeder extends Seeder
{
    public function run(): void
    {
         Restaurante::create([
        'nome' => 'Rancho Colonial Grill',
        'latitude' => -22.919825,
        'longitude' => -47.085843,
        ]);

        Restaurante::create([
            'nome' => 'Pizza Express',
            'latitude' => -10.920644,
            'longitude' => -20.0851366,
        ]);

    }
}
