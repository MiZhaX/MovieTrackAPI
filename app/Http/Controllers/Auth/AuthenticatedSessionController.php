<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $user = Auth::user();

        $token = $user->createToken('loggedUser', ['updateResenas','createResena'])->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'user' => $user,
            'token' => $token,
        ]);
    }


    public function destroy(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete(); // Revoca todos los tokens

        return response()->json([
            'message' => 'Sesión cerrada correctamente',
        ]);
    }
}
