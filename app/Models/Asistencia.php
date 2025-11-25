<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'registro_id',
        'evento_id',
        'fecha_asistencia',
        'confirmado_por',
    ];

    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
