<?php

namespace App\Observers;

use App\Models\Vehicle;

/**
 * Class VehicleObserver
 *
 * Esta classe é responsável por observar os eventos do ciclo de vida do modelo Vehicle.
 * Ela define ações específicas que devem ocorrer quando certos eventos ocorrem no modelo Vehicle.
 */
class VehicleObserver
{
    /**
     * Método 'creating'
     *
     * Este método é acionado antes de um registro do modelo Vehicle ser criado.
     * Ele verifica se o usuário está autenticado e, em caso afirmativo, atribui o ID do usuário autenticado
     * ao campo 'user_id' do modelo Vehicle que está sendo criado.
     *
     * @param  Vehicle  $vehicle  - A instância do modelo Vehicle que está sendo criada.
     */
    public function creating(Vehicle $vehicle): void
    {
        if (auth()->check()) {
            $vehicle->user_id = auth()->id();
        }
    }
}
