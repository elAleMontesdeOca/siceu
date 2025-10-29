<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        // Ejemplo: datos falsos, luego se conectarán con la DB
        $stats = [
            'eventos' => 12,
            'registros' => 57,
            'asistencias' => 45,
        ];

        return view('dashboard.index', compact('stats'));
    }
}
