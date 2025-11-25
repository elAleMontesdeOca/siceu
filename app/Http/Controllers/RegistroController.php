<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Notificacion;
use App\Models\Registro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    public function registrarse(Request $request, Evento $evento)
    {
        $user = Auth::user();

        /* ----------------------------------------------------
         * VALIDACIONES DE FECHA
         * ---------------------------------------------------- */

        // Evento ya terminó → No permitir registro
        // 🔹 Aseguramos que la prueba de evento pasado funcione
        if ($evento->fecha_fin < now()) {
            return back()->with('error', 'Este evento ya ha finalizado, no puedes registrarte.');
        }

        // IMPORTANTE:
        // Ya NO bloqueamos si el evento comenzó.
        // Así permitimos registro el mismo día aunque ya inició.
        // El escáner QR valida correctamente la asistencia.

        /* ----------------------------------------------------
         * VALIDAR CUPO
         * ---------------------------------------------------- */

        if ($evento->cupo_max) {
            $inscritos = Registro::where('evento_id', $evento->id)
                ->where('estado', 'inscrito')
                ->count();

            if ($inscritos >= $evento->cupo_max) {
                return back()->with('error', 'Lo sentimos, el cupo del evento está lleno.');
            }
        }

        /* ----------------------------------------------------
         * VERIFICAR SI EL USUARIO YA TIENE REGISTRO
         * ---------------------------------------------------- */

        $registro = Registro::where('evento_id', $evento->id)
            ->where('user_id', $user->id)
            ->first();

        // SI ESTABA CANCELADO — PERMITE REINSCRIPCIÓN
        if ($registro && $registro->estado === 'cancelado') {

            $qrHash = hash('sha256', $user->id.$evento->id.now());

            $registro->update([
                'estado' => 'inscrito',
                'fecha_registro' => now(),
                'qr_token' => $qrHash,
            ]);
        }

        // SI YA ESTÁ INSCRITO
        elseif ($registro && $registro->estado === 'inscrito') {
            return back()->with('info', 'Ya estás inscrito en este evento.');
        }

        // NUEVO REGISTRO
        else {

            $qrHash = hash('sha256', $user->id.$evento->id.now());

            $registro = Registro::create([
                'user_id' => $user->id,
                'evento_id' => $evento->id,
                'fecha_registro' => now(),
                'estado' => 'inscrito',
                'qr_token' => $qrHash,
            ]);
        }

        /* ----------------------------------------------------
         * NOTIFICACIÓN DE INSCRIPCIÓN
         * ---------------------------------------------------- */

        $not = Notificacion::create([
            'evento_id' => $evento->id,
            'titulo' => 'Inscripción confirmada',
            'mensaje' => "Te inscribiste al evento '{$evento->titulo}'.",
            'fecha_envio' => now(),
            'tipo' => 'Evento',
        ]);

        $not->users()->attach($user->id);

        return back()->with('success', 'Te has inscrito correctamente. Código QR generado.');
    }

    /* ============================================================
     * CANCELAR INSCRIPCIÓN
     * ============================================================ */
    public function cancelar(Request $request, Evento $evento)
    {
        $user = Auth::user();

        $registro = Registro::where('evento_id', $evento->id)
            ->where('user_id', $user->id)
            ->first();

        if (! $registro) {
            return back()->with('info', 'No estás inscrito en este evento.');
        }

        // Cancelar registro
        $registro->update(['estado' => 'cancelado']);

        /* ----------------------------------------------------
         * NOTIFICACIÓN DE CANCELACIÓN
         * ---------------------------------------------------- */

        $not = Notificacion::create([
            'evento_id' => $evento->id,
            'titulo' => "Cancelaste tu registro a: {$evento->titulo}",
            'mensaje' => "Has cancelado tu participación en el evento '{$evento->titulo}'.",
            'fecha_envio' => now(),
            'tipo' => 'Aviso',
        ]);

        $not->users()->attach($user->id);

        return back()->with('success', 'Registro cancelado.');
    }
}
