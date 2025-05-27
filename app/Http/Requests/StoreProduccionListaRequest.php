<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduccionListaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        return $user != null || $user->tokenCan('create') && $user->tokenCan('añadirProduccionLista');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'produccion_id' => 'required|exists:producciones,id',
            'lista_personalizada_id' => 'required|exists:listas_personalizadas,id',
        ];
    }
}
