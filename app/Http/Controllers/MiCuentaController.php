<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use Illuminate\Support\Facades\Auth;

class MiCuentaController extends Controller
{
    // Mostrar registros del usuario
    public function misRegistros()
    {
        $user = Auth::user();

        $registros = Registro::with('evento')
            ->where('user_id', $user->id)
            ->orderBy('fecha_registro', 'desc')
            ->get();

        return view('mi-cuenta.mis-registros', compact('registros'));
    }

    // Mostrar QR individual
    public function verQR(Registro $registro)
    {
        if ($registro->user_id !== Auth::id()) {
            abort(403); // seguridad
        }

        return view('mi-cuenta.qr', compact('registro'));
    }
}
