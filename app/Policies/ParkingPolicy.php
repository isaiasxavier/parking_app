<?php

namespace App\Policies;

use App\Models\Parking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParkingPolicy
{
    use HandlesAuthorization;

    /*public function viewAny(User $user)
    {
        //
    }*/

    public function view(User $user, Parking $parking): bool
    {
        // O usuário só pode ver os detalhes do Parking se ele for o criador
        return $user->id === $parking->user_id;
    }

    public function create(User $user): true
    {
        // Qualquer usuário autenticado pode criar um Parking
        return true;
    }

    public function update(User $user, Parking $parking): bool
    {
        // O usuário só pode atualizar o Parking se ele for o criador
        return $user->id === $parking->user_id;
    }

    /*public function delete(User $user, Parking $parking) {}

    public function restore(User $user, Parking $parking) {}

    public function forceDelete(User $user, Parking $parking) {}*/
}
