<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nombre' => 'Administrador', 'descripcion' => 'Acceso completo al sistema'],
            ['nombre' => 'Estudiante', 'descripcion' => 'Registro y asistencia a eventos'],
        ]);
    }
}
