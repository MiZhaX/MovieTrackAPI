<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProduccionListaResource extends JsonResource
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
            'lista_personalizada_id' => $this->lista_personalizada_id,
            'produccion_id' => $this->produccion_id,
            'listaPersonalizada' => new ListaPersonalizadaResource($this->whenLoaded('listaPersonalizada')),
            'produccion' => new ProduccionResource($this->whenLoaded('produccion'))
        ];
    }
}
