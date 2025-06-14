<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonaResource extends JsonResource
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
            'nombre' => $this->nombre,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'biografia' => $this->biografia,
            'imagen' => $this->imagen ? asset('storage/' . $this->imagen) : null,

            'actuaciones' => $this->whenLoaded('actores', function () {
                return $this->actores->map(function ($actor) {
                    return [
                        'rol' => $actor->rol,
                        'produccion' => new ProduccionResource($actor->produccion)
                    ];
                });
            }),

            'direcciones' => $this->whenLoaded('directores', function () {
                return $this->directores->map(function ($director) {
                    return new ProduccionResource($director->produccion);
                });
            }),
        ];
    }
}
