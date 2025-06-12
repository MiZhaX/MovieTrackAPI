<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Recibe el nombre de una película recomendada y envía un correo electrónico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recomendarPelicula(Request $request)
    {
        $request->validate([
            'nombre_pelicula' => 'required|string|max:255',
        ]);

        $nombrePelicula = $request->input('nombre_pelicula');
        $correoDestino = env('MAIL_RECOMENDACION_DESTINO');

        Mail::raw("Han recomendado la película: $nombrePelicula", function ($message) use ($correoDestino) {
            $message->to($correoDestino)
                    ->subject('Nueva recomendación de película');
        });

        return response()->json([
            'message' => '¡Gracias por tu recomendación! La hemos enviado correctamente.',
        ]);
    }
}