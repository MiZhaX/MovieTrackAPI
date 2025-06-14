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
        $nombreUsuario = $request->input('nombre_usuario');
        $correoUsuario = $request->input('correo_usuario');
        $correoDestino = env('MAIL_RECOMENDACION_DESTINO');

        $html = "
        <html>
        <head>
          <title>Nueva recomendación de película</title>
        </head>
        <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
          <div style='background: #fff; border-radius: 8px; max-width: 500px; margin: auto; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.05)'>
            <h2 style='color: #2d3748'>¡Nueva recomendación de película!</h2>
            <p><strong>Película recomendada:</strong> $nombrePelicula</p>
            <table style='margin-top: 20px'>
              <tr>
                <td style='font-weight: bold'>Nombre de usuario:</td>
                <td>$nombreUsuario</td>
              </tr>
              <tr>
                <td style='font-weight: bold'>Correo electrónico:</td>
                <td>$correoUsuario</td>
              </tr>
            </table>
          </div>
        </body>
        </html>
        ";

        Mail::send([], [], function ($message) use ($correoDestino, $html) {
            $message->to($correoDestino)
                    ->subject('Nueva recomendación de película')
                    ->html($html);
        });

        return response()->json([
            'message' => '¡Gracias por tu recomendación! La hemos enviado correctamente.',
        ]);
    }
}