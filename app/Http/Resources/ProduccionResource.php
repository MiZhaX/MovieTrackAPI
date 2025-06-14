<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProduccionResource extends JsonResource
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
            'id' => $this->id,
            'titulo' => $this->titulo,
            'titulo_original' => $this->titulo_original,
            'tipo' => $this->tipo,
            'sinopsis' => $this->sinopsis,
            'duracion' => $this->duracion,
            'fecha_estreno' => $this->fecha_estreno,
            'poster' => $this->poster ? asset('storage/' . $this->poster) : null,
            'puntuacion_critica' => $this->puntuacion_critica,
            'puntuacion_usuarios' => $this->puntuacion_usuarios,
            'genero' => new GeneroResource($this->whenLoaded('genero')),
            'actores' => ActorResource::collection($this->whenLoaded('actores')),
            'directores' => DirectorResource::collection($this->whenLoaded('directores')),
        ];
    }
}
