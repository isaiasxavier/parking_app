<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ZonePolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): true
    {
        // Qualquer usuário, autenticado ou não, pode ver a lista de Zone
        return true;
    }

    /*public function view(User $user, Zone $zone) {}

    public function create(User $user) {}

    public function update(User $user, Zone $zone) {}

    public function delete(User $user, Zone $zone) {}

    public function restore(User $user, Zone $zone) {}

    public function forceDelete(User $user, Zone $zone) {}*/
}
