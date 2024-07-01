<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ZonePolicy
{
    use HandlesAuthorization;

    public function viewAny(?User $user): bool
    {
        /*// Apenas usuários autenticados podem ver a lista de Zone
        return auth()->check();*/

        //Qualquer usuário pode ver as ZONE
        return true;
    }

    /*public function view(User $user, Zone $zone) {}

    public function create(User $user) {}

    public function update(User $user, Zone $zone) {}

    public function delete(User $user, Zone $zone) {}

    public function restore(User $user, Zone $zone) {}

    public function forceDelete(User $user, Zone $zone) {}*/
}
