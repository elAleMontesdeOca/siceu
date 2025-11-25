<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                $notisNoLeidas = $user->notificaciones()
                    ->whereNull('user_notificaciones.leido_at')
                    ->orderBy('notificaciones.created_at', 'desc')
                    ->get();

                $ultimas = $user->notificaciones()
                    ->orderBy('notificaciones.created_at', 'desc')
                    ->take(5)
                    ->get();

                $view->with([
                    'notif_no_leidas' => $notisNoLeidas,
                    'notif_ultimas' => $ultimas,
                ]);
            }
        });
    }
}
