<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MarcarProduccionesResource extends JsonResource
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
            
            'actor' => PersonaResource::make($this->whenLoaded('persona')),
            'produccion' => ProduccionResource::make($this->whenLoaded('produccion')),
            'marca' => $this->marca,
            'favorita' => $this->favorita
        ];
    }
}
