<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListaPersonalizadaRequest extends FormRequest
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
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string|max:1000',
            ];
        }
        else {
            return [
                'nombre' => 'sometimes|string|max:255',
                'descripcion' => 'sometimes|nullable|string|max:1000',
            ];   
        }
    }
}
