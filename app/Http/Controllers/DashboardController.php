<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Evento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /* ===============================
       PANEL ADMIN
       =============================== */
    public function index()
    {
        $stats = [
            'eventos' => Evento::count(),
            'proximos' => Evento::where('fecha_inicio', '>=', today())->count(),
            'finalizados' => Evento::where('fecha_fin', '<', today())->count(),
            'categorias' => Categoria::count(),
        ];

        return view('dashboard.index', compact('stats'));
    }

    /* ===============================
       VISTAS PÚBLICAS (EVENTOS)
       =============================== */
    public function eventosPublicos(Request $request)
    {
        $categorias = Categoria::all();

        $query = Evento::orderBy('fecha_inicio', 'asc');

        // Buscador
        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('titulo', 'like', '%'.$request->buscar.'%')
                    ->orWhere('descripcion', 'like', '%'.$request->buscar.'%')
                    ->orWhere('lugar', 'like', '%'.$request->buscar.'%');
            });
        }

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        // Filtro por fecha
        if ($request->filled('fecha')) {
            $query->whereDate('fecha_inicio', $request->fecha);
        }

        $eventos = $query->paginate(9);

        return view('eventos.index', compact('eventos', 'categorias'));
    }

    public function verEvento(Evento $evento)
    {
        return view('eventos.show', compact('evento'));
    }
}
