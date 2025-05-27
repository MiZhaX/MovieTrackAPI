<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduccionListaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method = $this->method();

        if($method == 'PUT'){
            return [
                'produccion_id' => 'required|exists:producciones,id',
                'lista_personalizada_id' => 'required|exists:listas_personalizadas,id',
            ];
        }
        else {
            return [
                'produccion_id' => 'sometimes|exists:producciones,id',
                'lista_personalizada_id' => 'sometimes|exists:listas_personalizadas,id',
            ];   
        }
    }
}
