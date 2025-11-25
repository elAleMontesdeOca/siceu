<?php

namespace App\Console\Commands;

use App\Models\Evento;
use App\Models\Notificacion;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

class EnviarRecordatoriosEventos extends Command
{
    public static string $defaultName = 'eventos:enviar-recordatorios';

    protected $signature = 'eventos:enviar-recordatorios';

    protected $description = 'Envía recordatorios automáticos de los eventos.';

    /**
     * Laravel 11 scheduler
     */
    public function schedule(Schedule $schedule): void
    {
        $schedule->command(self::$defaultName)->everyMinute();
    }

    public function handle(): int
    {
        $hoy = Carbon::today();

        // 2 días antes
        $this->procesarEventos(
            Evento::whereDate('fecha_inicio', $hoy->copy()->addDays(2))->get(),
            'Recordatorio: el evento comienza en 2 días'
        );

        // 1 día antes
        $this->procesarEventos(
            Evento::whereDate('fecha_inicio', $hoy->copy()->addDay())->get(),
            'Recordatorio: el evento es mañana'
        );

        // 3 horas antes (rango de 60 minutos)
        $this->procesarEventos(
            Evento::whereDate('fecha_inicio', $hoy)
                ->whereTime('hora', '>=', now()->copy()->addHours(3)->subMinutes(30)->format('H:i'))
                ->whereTime('hora', '<=', now()->copy()->addHours(3)->addMinutes(30)->format('H:i'))
                ->get(),
            'Recordatorio: el evento comienza pronto'
        );

        $this->info('Recordatorios enviados correctamente.');

        return Command::SUCCESS;
    }

    /**
     * Crear notificaciones para usuarios inscritos
     */
    private function procesarEventos($eventos, string $titulo)
    {
        foreach ($eventos as $evento) {

            $inscritos = $evento->registros()
                ->where('estado', 'inscrito')
                ->with('user')
                ->get();

            foreach ($inscritos as $registro) {
                $usuario = $registro->user;

                // Evitar notificaciones duplicadas del mismo tipo para ese evento
                $yaExiste = Notificacion::where('evento_id', $evento->id)
                    ->where('titulo', $titulo)
                    ->whereDate('fecha_envio', today())
                    ->exists();

                if ($yaExiste) {
                    continue;
                }

                // Crear notificación válida
                $not = Notificacion::create([
                    'evento_id' => $evento->id,
                    'titulo' => $titulo,
                    'mensaje' => "El evento '{$evento->titulo}' comenzará pronto.",
                    'fecha_envio' => now(),
                    'tipo' => 'Aviso', // <-- TIPO VÁLIDO
                ]);

                // Asignar al usuario
                $not->users()->attach($usuario->id);
            }
        }
    }
}
