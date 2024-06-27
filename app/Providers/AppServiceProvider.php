<?php

namespace App\Providers;

use App\Models\Vehicle;
use App\Observers\VehicleObserver;
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
     *
     * Este método é responsável por inicializar quaisquer serviços de aplicação.
     * Ele é chamado durante o processo de inicialização do aplicativo.
     *
     * Neste caso, ele está registrando o observador 'VehicleObserver' para o modelo 'Vehicle'.
     * Isso significa que o 'VehicleObserver' será notificado sempre que eventos de ciclo de vida relevantes ocorrerem no modelo 'Vehicle'.
     */
    public function boot(): void
    {
        Vehicle::observe(VehicleObserver::class);
    }
}
