<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResenaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('createResena') || $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'usuario_id' => 'required|exists:users,id',
            'produccion_id' => 'required|exists:producciones,id',
            'puntuacion' => 'required|numeric|min:0|max:5',
            'descripcion' => 'sometimes|string|max:1000'
        ];
    }
}
