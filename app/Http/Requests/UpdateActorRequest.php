<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActorRequest extends FormRequest
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

        if($method == 'PUT'){
            return [
                'persona_id' => 'required|exists:personas,id',
                'produccion_id' => 'required|exists:producciones,id',
                'rol' => 'required|string|max:255',
            ];
        }
        else {
            return [
                'persona_id' => 'sometimes|exists:personas,id',
                'produccion_id' => 'sometimes|exists:producciones,id',
                'rol' => 'sometimes|string|max:255',
            ];   
        }
    }
}
