<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('registro_id')->constrained('registros')->cascadeOnDelete();
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();

            // Siempre se guarda cuando se registra asistencia
            $table->timestamp('fecha_asistencia')->useCurrent();

            // Nombre de quien confirma (admin)
            $table->string('confirmado_por')->nullable();

            $table->timestamps();

            // Evita doble asistencia por usuario
            $table->unique(['registro_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
