<?php

namespace Tests\Feature;

use App\Models\Registro;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AsistenciaQrTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_registra_asistencia_con_qr_invalido()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post('/asistencias/validar', [
            'token' => 'token-falso',
        ]);

        $response->assertJson([
            'status' => 'error',
        ]);
    }

    public function test_registra_asistencia_correctamente()
    {
        $admin = User::factory()->create();
        $registro = Registro::factory()->create([
            'qr_token' => 'token123',
            'estado' => 'inscrito',
        ]);

        $this->actingAs($admin);

        $response = $this->post('/asistencias/validar', [
            'token' => 'token123',
        ]);

        $response->assertJson([
            'status' => 'success',
        ]);

        $this->assertDatabaseHas('asistencias', [
            'registro_id' => $registro->id,
            'evento_id' => $registro->evento_id,
        ]);
    }
}
