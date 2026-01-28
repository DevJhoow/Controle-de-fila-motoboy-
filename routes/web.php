<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MotoboyController;
use App\Http\Controllers\FilaController;

//teste
Route::get('/', function () {
    return 'Laravel está rodando 🚀';
});

//Cadastro de Motoboy 
// Route::get('/', [MotoboyController::class, 'create'])->name('motoboys.create');
Route::post('/motoboys', [MotoboyController::class, 'store'])->name('motoboys.store');
Route::get('/motoboys/{motoboy}/success', [MotoboyController::class, 'success'])->name('motoboys.success');

Route::get('/motoboys/{motoboy}/dashboard', [MotoboyController::class, 'dashboard'])
    ->name('motoboys.dashboard');

Route::post('/motoboys/{motoboy}/localizacao', 
    [MotoboyController::class, 'verificarDistancia']
)->name('motoboys.localizacao');

Route::post('/fila/verificar', [FilaController::class, 'verificarDistancia']);

Route::post('/motoboys/{motoboy}/localizacao', [MotoboyController::class, 'atualizarLocalizacao']);

Route::get('/fila/{restaurante}', [FilaController::class, 'listar']);







