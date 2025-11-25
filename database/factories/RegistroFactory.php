<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\Registro;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistroFactory extends Factory
{
    protected $model = Registro::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'evento_id' => Evento::factory(),
            'qr_token' => $this->faker->unique()->regexify('[A-Za-z0-9]{10}'),
            'estado' => 'inscrito',
        ];
    }
}
