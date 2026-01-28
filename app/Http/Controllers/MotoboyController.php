<?php

namespace App\Http\Controllers;

use App\Models\Fila;
use App\Models\Motoboy;
use App\Models\Restaurante;
use Illuminate\Http\Request;

class MotoboyController extends Controller
{
    // tela de cadastro
    public function create()
    {
        $restaurantes = Restaurante::all();
        return view('motoboys.create', compact('restaurantes'));
    }

    // salvar cadastro
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'sobrenome' => 'required',
            'restaurante_id' => 'required|exists:restaurantes,id',
        ]);

        $motoboy = Motoboy::create([
            'nome' => $request->nome,
            'sobrenome' => $request->sobrenome,
            'restaurante_id' => $request->restaurante_id,
        ]);

        return redirect()->route('motoboys.success', [
            'motoboy' => $motoboy->id
        ]);
    }

    // tela de sucesso
    public function success(Motoboy $motoboy)
    {
        return view('motoboys.success', compact('motoboy'));
    }

    private function calcularDistancia(
        $lat1, $lon1,
        $lat2, $lon2
    ) {
        $raioTerra = 6371000; // metros

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $raioTerra * $c; // metros
    }

    public function verificarDistancia(Request $request, Motoboy $motoboy)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $restaurante = $motoboy->restaurante;

        $distancia = $this->calcularDistancia(
            $request->latitude,
            $request->longitude,
            $restaurante->latitude,
            $restaurante->longitude
        );

        $raioPermitido = 30; // metros

        return response()->json([
            'distancia_metros' => round($distancia, 2),
            'pode_entrar_fila' => $distancia <= $raioPermitido
        ]);
    }

    public function dashboard(Motoboy $motoboy)
    {
         $fila = Fila::where('restaurante_id', $motoboy->restaurante_id)
        ->where('ativo', true)
        ->orderBy('posicao')
        ->with('motoboy')
        ->get();

        return view('motoboys.dashboard', [
            'motoboy' => $motoboy,
            'fila' => $fila
        ]);
    }

    public function atualizarLocalizacao(Request $request, Motoboy $motoboy)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $motoboy->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'ativo' => true,
        ]);

        return response()->json(['ok' => true]);
    }



}
