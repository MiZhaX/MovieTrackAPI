<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarcarProduccionesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        return $user != null && auth()->user()->id === $this->input('usuario_id') || $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'usuario_id' => 'required|integer|exists:users,id',
            'produccion_id' => 'required|integer|exists:producciones,id',
            'marca' => 'sometimes|int|in:0,1,2',
            'favorita' => 'sometimes|int|in:0,1'
        ];
    }
}
