<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\DirectorController;

// 🟢 RUTAS PÚBLICAS (solo lectura)
Route::prefix('v1')->group(function () {
    Route::get('producciones', [ProduccionController::class, 'index']);
    Route::get('producciones/{produccion}', [ProduccionController::class, 'show']);

    Route::get('generos', [GeneroController::class, 'index']);
    Route::get('generos/{genero}', [GeneroController::class, 'show']);

    Route::get('personas', [PersonaController::class, 'index']);
    Route::get('personas/{persona}', [PersonaController::class, 'show']);

    Route::get('actores', [ActorController::class, 'index']);

    Route::get('directores', [DirectorController::class, 'index']);
});

// 🔐 RUTAS PROTEGIDAS (requieren auth:sanctum)
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('producciones', ProduccionController::class)->except(['index', 'show']);
    Route::post('producciones/bulk', [ProduccionController::class, 'bulkStore']);

    Route::apiResource('generos', GeneroController::class)->except(['index', 'show']);
    Route::post('generos/bulk', [GeneroController::class, 'bulkStore']);

    Route::apiResource('personas', PersonaController::class)->except(['index', 'show']);
    Route::post('personas/bulk', [PersonaController::class, 'bulkStore']);

    Route::post('directores', [DirectorController::class, 'store']);
    Route::post('directores/bulk', [DirectorController::class, 'bulkStore']);
    // Route::get('directores/{persona_id}/{produccion_id}', [DirectorController::class, 'show']);
    Route::put('directores/{persona_id}/{produccion_id}', [DirectorController::class, 'update']);
    Route::patch('directores/{persona_id}/{produccion_id}', [DirectorController::class, 'update']);
    Route::delete('directores/{persona_id}/{produccion_id}', [DirectorController::class, 'destroy']);

    Route::post('actores', [ActorController::class, 'store']);
    Route::post('actores/bulk', [ActorController::class, 'bulkStore']);
    // Route::get('actores/{persona_id}/{produccion_id}', [ActorController::class, 'show']);
    Route::put('actores/{persona_id}/{produccion_id}', [ActorController::class, 'update']);
    Route::patch('actores/{persona_id}/{produccion_id}', [ActorController::class, 'update']);
    Route::delete('actores/{persona_id}/{produccion_id}', [ActorController::class, 'destroy']);

});
