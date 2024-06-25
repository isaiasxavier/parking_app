<?php

namespace App\Policies;

use App\Models\Parking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParkingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Parking $parking) {}

    public function create(User $user) {}

    public function update(User $user, Parking $parking) {}

    public function delete(User $user, Parking $parking) {}

    public function restore(User $user, Parking $parking) {}

    public function forceDelete(User $user, Parking $parking) {}
}
