<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResenaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'usuario_id' => $this->usuario_id,
            'produccion_id' => $this->produccion_id,
            'usuario' => UserResource::make($this->whenLoaded('usuario')),
            'produccion' => ProduccionResource::make($this->whenLoaded('produccion')),
            'puntuacion' => $this->puntuacion,
            'descripcion' => $this->descripcion
        ];
    }
}
