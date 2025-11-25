<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\Registro;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AsistenciaFactory extends Factory
{
    public function definition()
    {
        return [
            'registro_id' => Registro::factory(),
            'evento_id' => Evento::factory(),
            'fecha_asistencia' => now(),
            'confirmado_por' => User::factory(),
        ];
    }
}
