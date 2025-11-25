<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Evento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventoFactory extends Factory
{
    protected $model = Evento::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(4),
            'descripcion' => $this->faker->paragraph(),
            'fecha_inicio' => now()->addDays(2),
            'fecha_fin' => now()->addDays(3),
            'hora' => '10:00',
            'lugar' => $this->faker->address(),
            'cupo_max' => 50,
            'categoria_id' => Categoria::factory(),
            'user_id' => User::factory(),
        ];
    }
}
