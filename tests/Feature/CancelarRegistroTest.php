<?php

namespace Tests\Feature;

use App\Models\Registro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CancelarRegistroTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_cancelar_registro()
    {
        $user = User::factory()->create();
        $registro = Registro::factory()->create([
            'user_id' => $user->id,
            'estado' => 'inscrito',
        ]);

        $this->actingAs($user);

        $response = $this->post("/eventos/{$registro->evento_id}/cancelar");

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('registros', [
            'id' => $registro->id,
            'estado' => 'cancelado',
        ]);
    }
}
