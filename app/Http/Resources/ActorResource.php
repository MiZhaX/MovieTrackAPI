<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'persona_id' => $this->persona_id, // solo el ID
            'produccion_id' => $this->produccion_id, // solo el ID
            
            'actor' => PersonaResource::make($this->whenLoaded('persona')),
            'produccion' => ProduccionResource::make($this->whenLoaded('produccion')),
            'rol' => $this->rol,
        ];
    }
}
