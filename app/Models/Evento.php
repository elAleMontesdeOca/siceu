<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'hora',
        'lugar',
        'cupo_max',
        'imagen',
        'user_id',
        'categoria_id',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function registros()
    {
        return $this->hasMany(\App\Models\Registro::class);
    }

    /* ==========================================================
     * MÉTODOS PARA VALIDAR ESTADO REAL DEL EVENTO
     * ========================================================== */

    // Fecha + hora exacta de inicio
    public function inicioCompleto()
    {
        return $this->fecha_inicio->setTimeFromTimeString($this->hora);
    }

    // Fin estimado → 23:59 del último día
    public function finEstimado()
    {
        $fin = $this->fecha_fin ?? $this->fecha_inicio;

        return $fin->setTime(23, 59, 59);
    }

    // Ha iniciado: hoy a partir de la hora o en fechas pasadas
    public function yaComenzo()
    {
        return now()->gte($this->inicioCompleto());
    }

    // No ha comenzado aún
    public function noHaComenzado()
    {
        return now()->lt($this->inicioCompleto());
    }

    // Ya terminó oficialmente
    public function estaFinalizado()
    {
        return now()->gte($this->finEstimado());
    }

    // Valida cupo máximo
    public function cupoLleno()
    {
        if (! $this->cupo_max) {
            return false;
        }

        $inscritos = $this->registros()
            ->where('estado', 'inscrito')
            ->count();

        return $inscritos >= $this->cupo_max;
    }
}
