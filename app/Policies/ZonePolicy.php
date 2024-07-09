<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ZonePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether any user can view any zones.
     *
     * @param  User|null  $user  The user attempting the action.
     * @return bool True if the action is allowed, otherwise false.
     */
    public function viewAny(?User $user): bool
    {
        // Assuming all users can view any zone
        return true;
    }
}
