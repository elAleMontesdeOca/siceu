<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::orderBy('fecha_inicio', 'desc')->paginate(6);

        return view('admin.eventos.index', compact('eventos'));
    }

    public function create()
    {
        return view('admin.eventos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:1000',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'hora' => 'required',
            'lugar' => 'required|string|max:150',
            'cupo_max' => 'nullable|integer|min:1',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('eventos', 'public');
        }

        $data['user_id'] = Auth::id();
        Evento::create($data);

        return redirect()->route('eventos.index')->with('success', 'Evento creado correctamente.');
    }

    public function edit(Evento $evento)
    {
        return view('admin.eventos.edit', compact('evento'));
    }

    public function update(Request $request, Evento $evento)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:1000',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'hora' => 'required',
            'lugar' => 'required|string|max:150',
            'cupo_max' => 'nullable|integer|min:1',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($evento->imagen) {
                Storage::disk('public')->delete($evento->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('eventos', 'public');
        }

        $evento->update($data);

        return redirect()->route('eventos.index')->with('success', 'Evento actualizado.');
    }

    public function destroy(Evento $evento)
    {
        if ($evento->imagen) {
            Storage::disk('public')->delete($evento->imagen);
        }
        $evento->delete();

        return redirect()->route('eventos.index')->with('success', 'Evento eliminado.');
    }
}
