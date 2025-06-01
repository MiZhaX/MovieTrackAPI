<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProduccionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'titulo' => 'required|string|max:255',
                'titulo_original' => 'required|string|max:255',
                'tipo' => ['required', 'string', Rule::in(['pelicula', 'serie'])],
                'genero_id' => 'required|exists:generos,id',
                'sinopsis' => 'required|string|max:1000',
                'duracion' => 'required|integer|min:1',
                'fecha_estreno' => 'required|date',
                'poster' => 'required|string|max:255',
                'puntuacion_critica' => 'required|numeric|min:0|max:10',
                'puntuacion_usuarios' => 'required|numeric|min:0|max:5'
            ];
        } else {
            return [
                'titulo' => 'sometimes|required|string|max:255',
                'titulo_original' => 'sometimes|string|max:255',
                'tipo' => ['sometimes', 'required', 'string', Rule::in(['pelicula', 'serie'])],
                'genero_id' => 'sometimes|required|exists:generos,id',
                'sinopsis' => 'sometimes|required|string|max:1000',
                'duracion' => 'sometimes|required|integer|min:1',
                'fecha_estreno' => 'sometimes|required|date',
                'poster' => 'sometimes|required|string|max:255',
                'puntuacion_critica' => 'sometimes|required|numeric|min:0|max:10',
                'puntuacion_usuarios' => 'sometimes|required|numeric|min:0|max:5'
            ];
        }
    }
}
