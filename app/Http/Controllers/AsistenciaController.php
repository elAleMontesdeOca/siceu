<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Evento;
use App\Models\Registro;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    /**
     * ================================
     * VALIDAR QR Y REGISTRAR ASISTENCIA
     * ================================
     */
    public function validar(Request $request)
    {
        $qr_token = $request->token;

        if (! $qr_token) {
            return response()->json([
                'status' => 'error',
                'message' => 'El QR no contiene información.',
            ], 400);
        }

        // Buscar el registro con ese token
        $registro = Registro::where('qr_token', $qr_token)->first();

        if (! $registro) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR inválido. No pertenece a ningún registro.',
            ], 404);
        }

        $evento = $registro->evento;

        // Validar: evento finalizado
        if ($evento->estaFinalizado()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se puede registrar asistencia. El evento ya finalizó.',
            ]);
        }

        // Validar: asistencia previa
        if (Asistencia::where('registro_id', $registro->id)->exists()) {
            return response()->json([
                'status' => 'warning',
                'message' => "El usuario {$registro->user->name} ya tiene asistencia registrada.",
            ]);
        }

        // Registrar asistencia
        Asistencia::create([
            'registro_id' => $registro->id,
            'evento_id' => $evento->id,
            'fecha_asistencia' => now(),
            'confirmado_por' => Auth::id(), // ← guarda el ID del admin
        ]);

        return response()->json([
            'status' => 'success',
            'message' => "Asistencia registrada con éxito para {$registro->user->name}.",
            'usuario' => $registro->user->name,
            'evento' => $evento->titulo,
        ]);
    }

    /**
     * ================================
     * PANEL DE ASISTENCIAS DEL EVENTO
     * ================================
     */
    public function panel(Evento $evento)
    {
        $asistencias = Asistencia::with('registro.user')
            ->where('evento_id', $evento->id)
            ->get();

        // Cálculos del reporte
        $total_registrados = $evento->registros()->count();
        $total_asistencias = $asistencias->count();

        $porcentaje = $total_registrados > 0
            ? round(($total_asistencias / $total_registrados) * 100, 2)
            : 0;

        $cupo_usado = $evento->cupo_max
            ? round(($total_registrados / $evento->cupo_max) * 100, 2)
            : 0;

        return view('asistencias.panel', compact(
            'evento',
            'asistencias',
            'total_registrados',
            'total_asistencias',
            'porcentaje',
            'cupo_usado'
        ));
    }

    /**
     * ================================
     * EXPORTAR EXCEL (CSV)
     * ================================
     */
    public function exportExcel(Evento $evento)
    {
        $asistencias = Asistencia::with('registro.user')
            ->where('evento_id', $evento->id)
            ->get();

        $fileName = "asistencia_evento_{$evento->id}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columnas = ['ID Usuario', 'Nombre', 'Correo', 'Fecha Asistencia'];

        $callback = function () use ($asistencias, $columnas) {

            $file = fopen('php://output', 'w');

            // Encabezados
            fputcsv($file, $columnas);

            // Filas
            foreach ($asistencias as $asis) {
                fputcsv($file, [
                    $asis->registro->user->id,
                    $asis->registro->user->name,
                    $asis->registro->user->email,
                    $asis->fecha_asistencia,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * ================================
     * EXPORTAR PDF
     * ================================
     */
    public function exportPDF(Evento $evento)
    {
        $asistencias = Asistencia::with('registro.user')
            ->where('evento_id', $evento->id)
            ->get();

        $pdf = Pdf::loadView('asistencias.reporte-pdf', [
            'evento' => $evento,
            'asistencias' => $asistencias,
        ]);

        return $pdf->download("asistencia_evento_{$evento->id}.pdf");
    }
}
