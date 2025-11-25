<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias')->insert([
            [
                'nombre' => 'Académico',
                'descripcion' => 'Eventos educativos, conferencias, talleres y seminarios.',
            ],
            [
                'nombre' => 'Cultural',
                'descripcion' => 'Actividades artísticas, exposiciones, obras, festivales.',
            ],
            [
                'nombre' => 'Deportivo',
                'descripcion' => 'Torneos, competencias y actividades físicas.',
            ],
        ]);
    }
}
