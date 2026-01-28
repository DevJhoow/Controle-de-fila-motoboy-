<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motoboy;
use App\Models\Restaurante;
use App\Models\Fila;

class FilaController extends Controller
{
    public function verificarDistancia(Request $request)
    {
        $motoboy = Motoboy::findOrFail($request->motoboy_id);
        $restaurante = Restaurante::findOrFail($motoboy->restaurante_id);

        $distancia = $this->calcularDistancia(
            $request->latitude,
            $request->longitude,
            $restaurante->latitude,
            $restaurante->longitude
        );

        if ($distancia <= 20) {
            $this->entrarFila($motoboy, $restaurante);
            $status = 'entrou';
        } else {
            $this->sairFila($motoboy, $restaurante);
            $status = 'saiu';
        }

        return response()->json([
            'status' => $status,
            'distancia' => $distancia
        ]);
    }

    private function entrarFila($motoboy, $restaurante)
    {
        $existe = Fila::where('motoboy_id', $motoboy->id)
            ->where('restaurante_id', $restaurante->id)
            ->where('ativo', true)
            ->exists();

        if ($existe) return;

        $ultimaPosicao = Fila::where('restaurante_id', $restaurante->id)
            ->where('ativo', true)
            ->max('posicao');

        Fila::create([
            'motoboy_id' => $motoboy->id,
            'restaurante_id' => $restaurante->id,
            'posicao' => $ultimaPosicao ? $ultimaPosicao + 1 : 1,
            'ativo' => true,
        ]);
    }

    private function sairFila($motoboy, $restaurante)
    {
        $fila = Fila::where('motoboy_id', $motoboy->id)
        ->where('ativo', true)
        ->first();

        if (!$fila) {
            return;
        }

        $posicaoRemovida = $fila->posicao;
        $restauranteId = $fila->restaurante_id;

        // remove o motoboy da fila
        $fila->update(['ativo' => false]);

        // ajusta posições de quem estava atrás
        Fila::where('restaurante_id', $restauranteId)
            ->where('ativo', true)
            ->where('posicao', '>', $posicaoRemovida)
            ->decrement('posicao');
    }

    // Fórmula de Haversine
    private function calcularDistancia($lat1, $lon1, $lat2, $lon2)
    {
        $raioTerra = 6371000; // metros

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $raioTerra * $c;
    }

    public function listar(Restaurante $restaurante)
    {
       $fila = Fila::where('restaurante_id', $restaurante->id)
            ->where('ativo', true)
            ->orderBy('posicao')
            ->with('motoboy:id,nome,sobrenome')
            ->get()
            ->map(function ($item) {
                return [
                    'posicao' => $item->posicao,
                    'nome' => $item->motoboy->nome,
                    'sobrenome' => $item->motoboy->sobrenome,
                ];
            });

        return response()->json($fila);
    }

}
