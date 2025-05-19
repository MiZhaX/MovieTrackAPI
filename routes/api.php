<?php

use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\GeneroController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('producciones', [ProduccionController::class, 'index']);
    Route::get('producciones/{produccion}', [ProduccionController::class, 'show']);

    Route::get('generos', [GeneroController::class, 'index']);
    Route::get('generos/{genero}', [GeneroController::class, 'show']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::apiResource('producciones', ProduccionController::class)->except(['index', 'show']);
    Route::apiResource('generos', GeneroController::class)->except(['index', 'show']);
});
