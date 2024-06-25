<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Zone;
use Illuminate\Auth\Access\HandlesAuthorization;

class ZonePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Zone $zone) {}

    public function create(User $user) {}

    public function update(User $user, Zone $zone) {}

    public function delete(User $user, Zone $zone) {}

    public function restore(User $user, Zone $zone) {}

    public function forceDelete(User $user, Zone $zone) {}
}
