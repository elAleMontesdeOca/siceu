<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Evento;
use App\Models\Registro;

class ReporteController extends Controller
{
    public function reporteEvento(Evento $evento)
    {
        $inscritos = Registro::where('evento_id', $evento->id)
            ->where('estado', 'inscrito')
            ->count();

        $asistentes = Asistencia::where('evento_id', $evento->id)->count();

        $porcentaje = $inscritos > 0
            ? round(($asistentes / $inscritos) * 100, 2)
            : 0;

        $cupoUsado = $evento->cupo_max
            ? round(($inscritos / $evento->cupo_max) * 100, 2)
            : null;

        return view('reportes.evento', compact(
            'evento',
            'inscritos',
            'asistentes',
            'porcentaje',
            'cupoUsado'
        ));
    }
}
