<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\MiCuentaController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ReporteController;
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
    Route::post('/eventos/{evento}/registrarse', [RegistroController::class, 'registrarse'])->name('eventos.registrarse');
    Route::post('/eventos/{evento}/cancelar', [RegistroController::class, 'cancelar'])->name('eventos.cancelar');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
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

// Lista de eventos públicos con filtros
Route::get('/eventos', [DashboardController::class, 'eventosPublicos'])->name('eventos.public');
Route::get('/eventos/{evento}', [DashboardController::class, 'verEvento'])->name('eventos.ver');

Route::middleware('auth')->get('/notificaciones/mias', [NotificacionController::class, 'mias'])->name('notificaciones.mias');

Route::delete('/notificaciones/{notificacion}', [NotificacionController::class, 'eliminar'])
    ->name('notificaciones.eliminar');

// Vista del escáner
Route::get('/asistencias/escanear', function () {
    return view('asistencias.scan');
})->middleware('auth')->name('asistencias.escanear');

// Validación vía POST
Route::post('/asistencias/validar', [AsistenciaController::class, 'validar'])
    ->middleware('auth')
    ->name('asistencias.validar');

// MI CUENTA
Route::middleware('auth')->group(function () {

    Route::get(
        '/mi-cuenta/mis-registros',
        [MiCuentaController::class, 'misRegistros']
    )
        ->name('miCuenta.registros');

    Route::get(
        '/mi-cuenta/qr/{registro}',
        [MiCuentaController::class, 'verQR']
    )
        ->name('miCuenta.qr');

});

Route::get('/eventos/{evento}/asistencias',
    [AsistenciaController::class, 'panel'])
    ->name('asistencias.panel');

Route::get('/eventos/{evento}/asistencias/excel',
    [AsistenciaController::class, 'exportExcel'])
    ->name('asistencias.export.excel');

Route::get('/eventos/{evento}/asistencias/pdf',
    [AsistenciaController::class, 'exportPDF'])
    ->name('asistencias.export.pdf');

// EXPORTAR LISTA DE ASISTENCIA
Route::get('/asistencias/{evento}/export-excel', [AsistenciaController::class, 'exportExcel'])
    ->name('asistencias.excel')
    ->middleware('auth');

Route::get('/asistencias/{evento}/export-pdf', [AsistenciaController::class, 'exportPDF'])
    ->name('asistencias.pdf')
    ->middleware('auth');

// REPORTE POR EVENTO
Route::get('/reportes/evento/{evento}', [ReporteController::class, 'reporteEvento'])
    ->name('reportes.evento')
    ->middleware('auth');

require __DIR__.'/auth.php';
