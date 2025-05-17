<?php

namespace Database\Factories;

use App\Models\Genero;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produccion>
 */
class ProduccionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {           
        return [
            //
            'titulo' => $this->faker->sentence(3),
            'tipo' => $this->faker->randomElement(['Película', 'Serie']),
            'genero_id' => Genero::inRandomOrder()->first()->id ?? Genero::factory(),
            'sinopsis' => $this->faker->paragraph(),
            'duracion' => $this->faker->numberBetween(30, 240),
            'fecha_estreno' => $this->faker->date(),
            'poster' => $this->faker->imageUrl(640, 480, 'movies', true, 'Movie'),
            'puntuacion_critica' => $this->faker->randomFloat(1, 0, 10),
            'puntuacion_usuarios' => $this->faker->randomFloat(1, 0, 10)

        ];
    }
}
