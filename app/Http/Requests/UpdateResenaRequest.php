<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResenaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('updateResenas') || $user->tokenCan('update');
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
                'puntuacion' => 'required|numeric|min:0|max:5',
                'descripcion' => 'sometimes|string|max:1000'
            ];
        }
        else {
            return [
                'puntuacion' => 'sometimes|numeric|min:0|max:5',
                'descripcion' => 'sometimes|string|max:1000'
            ];   
        }
    }
}
