<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificacionController extends Controller
{
    /**
     * Mostrar notificaciones del usuario
     * y marcarlas como leídas al entrar
     */
    public function mias()
    {
        $user = Auth::user();

        // Obtener notificaciones ordenadas más nuevas primero
        $notificaciones = $user->notificaciones()
            ->orderBy('notificaciones.created_at', 'desc')
            ->paginate(12);

        // MARCAR TODAS COMO LEÍDAS
        DB::table('user_notificaciones')
            ->where('user_id', $user->id)
            ->whereNull('leido_at')
            ->update(['leido_at' => now()]);

        return view('notificaciones.mias', compact('notificaciones'));
    }

    /**
     * Eliminar notificación (solo la relación del usuario)
     */
    public function eliminar(Notificacion $notificacion)
    {
        $userId = Auth::id();

        DB::table('user_notificaciones')
            ->where('user_id', $userId)
            ->where('notificacion_id', $notificacion->id)
            ->delete();

        return back()->with('success', 'Notificación eliminada.');
    }
}
