<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotificacion extends Model
{
    use HasFactory;

    protected $table = 'user_notificaciones';

    protected $fillable = ['user_id', 'notificacion_id', 'leido_at'];
}
