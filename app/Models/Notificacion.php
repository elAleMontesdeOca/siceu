<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones'; // ← FIX IMPORTANTE

    protected $fillable = [
        'evento_id',
        'titulo',
        'mensaje',
        'fecha_envio',
        'tipo',
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_notificaciones', 'notificacion_id', 'user_id')
            ->withPivot('leido_at')
            ->withTimestamps();
    }
}
