<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonaRequest extends FormRequest
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
                'nombre' => 'required|string|max:255',
                'fecha_nacimiento' => 'required|date',
                'biografia' => 'required|string|max:1000'
            ];
        }
        else {
            return [
                'nombre' => 'sometimes|string|max:255',
                'fecha_nacimiento' => 'sometimes|date',
                'biografia' => 'sometimes|string|max:1000'
            ];   
        }
    }
}
