<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/eventos', function () {
    $eventos = [
        (object) ['id' => 1, 'titulo' => 'Congreso de Innovación', 'descripcion' => 'Evento académico...', 'imagen' => null, 'fecha_inicio' => now()],
        (object) ['id' => 2, 'titulo' => 'Carrera deportiva', 'descripcion' => 'Corre con nosotros...', 'imagen' => null, 'fecha_inicio' => now()->addDays(2)],
    ];

    return view('eventos.index', compact('eventos'));
});

// Rutas públicas
Route::get('/eventos', function () {
    $eventos = \App\Models\Evento::orderBy('fecha_inicio')->paginate(9);

    return view('eventos.index', compact('eventos'));
});

// Rutas del dashboard (admin)
Route::middleware(['auth'])->group(function () {
    Route::resource('/dashboard/eventos', EventoController::class)->names('eventos');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

require __DIR__.'/auth.php';
