<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProduccionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'titulo' => 'required|string|max:255',
            'titulo_original' => 'required|string|max:255',
            'tipo' => ['required', 'string', Rule::in(['pelicula', 'serie'])],
            'genero_id' => 'required|exists:generos,id',
            'sinopsis' => 'required|string|max:1000',
            'duracion' => 'required|integer|min:1',
            'fecha_estreno' => 'required|date',
            'poster' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'puntuacion_critica' => 'required|numeric|min:0|max:10',
            'puntuacion_usuarios' => 'required|numeric|min:0|max:5'
        ];
    }
}
