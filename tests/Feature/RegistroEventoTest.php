<?php

namespace Tests\Feature;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistroEventoTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_permite_registro_en_evento_pasado()
    {
        $user = User::factory()->create();
        $evento = Evento::factory()->create([
            'fecha_inicio' => now()->subDays(2),
            'fecha_fin' => now()->subDay(), // evento pasado
        ]);

        $this->actingAs($user);

        $response = $this->post("/eventos/{$evento->id}/registrarse");

        // 💡 Asegúrate de usar assertRedirect para que la sesión se guarde
        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseCount('registros', 0);
    }

    public function test_usuario_se_registra_correctamente()
    {
        $user = User::factory()->create();
        $evento = Evento::factory()->create([
            'fecha_inicio' => now()->addDay(),
        ]);

        $this->actingAs($user);

        $response = $this->post("/eventos/{$evento->id}/registrarse");

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('registros', [
            'user_id' => $user->id,
            'evento_id' => $evento->id,
            'estado' => 'inscrito',
        ]);
    }
}
