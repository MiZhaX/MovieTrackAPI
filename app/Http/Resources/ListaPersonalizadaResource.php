<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListaPersonalizadaResource extends JsonResource
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
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'usuario_id' => $this->usuario_id,
            'produccionesListas' => ProduccionListaResource::collection($this->whenLoaded('produccionesListas')),
            'usuario' => new UserResource($this->whenLoaded('usuario'))
        ];
    }
}
