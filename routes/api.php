<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\MarcarProduccionesController;
use App\Http\Controllers\ResenaController;

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

    Route::get('resenas', [ResenaController::class, 'index']);
    Route::get('resenas/{resena}', [ResenaController::class, 'show']);
});

// 🔐 RUTAS PROTEGIDAS (requieren auth:sanctum)
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // PRODUCCIONES
    Route::apiResource('producciones', ProduccionController::class)->except(['index', 'show']);
    Route::post('producciones/bulk', [ProduccionController::class, 'bulkStore']);

    // GENEROS
    Route::apiResource('generos', GeneroController::class)->except(['index', 'show']);
    Route::post('generos/bulk', [GeneroController::class, 'bulkStore']);

    // PERSONAS
    Route::apiResource('personas', PersonaController::class)->except(['index', 'show']);
    Route::post('personas/bulk', [PersonaController::class, 'bulkStore']);

    // DIRECTORES
    Route::post('directores', [DirectorController::class, 'store']);
    Route::post('directores/bulk', [DirectorController::class, 'bulkStore']);
    // Route::get('directores/{persona_id}/{produccion_id}', [DirectorController::class, 'show']);
    Route::put('directores/{persona_id}/{produccion_id}', [DirectorController::class, 'update']);
    Route::patch('directores/{persona_id}/{produccion_id}', [DirectorController::class, 'update']);
    Route::delete('directores/{persona_id}/{produccion_id}', [DirectorController::class, 'destroy']);

    // ACTORES
    Route::post('actores', [ActorController::class, 'store']);
    Route::post('actores/bulk', [ActorController::class, 'bulkStore']);
    // Route::get('actores/{persona_id}/{produccion_id}', [ActorController::class, 'show']);
    Route::put('actores/{persona_id}/{produccion_id}', [ActorController::class, 'update']);
    Route::patch('actores/{persona_id}/{produccion_id}', [ActorController::class, 'update']);
    Route::delete('actores/{persona_id}/{produccion_id}', [ActorController::class, 'destroy']);

    // RESEÑAS
    Route::apiResource('resenas', ResenaController::class)->except(['index', 'show']);

    // MARCAR PRODUCCIONES
    Route::apiResource('marcarProducciones', MarcarProduccionesController::class);
});

// 🛡️ RUTAS DE AUTENTICACIÓN
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest')->name('register');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest')->name('login');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware('guest')->name('password.store');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {return $request->user();});
    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['auth', 'signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
});
