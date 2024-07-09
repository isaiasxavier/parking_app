<?php

namespace App\Policies;

use App\Models\Parking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * ParkingPolicy Class
 *
 * Defines authorization rules for actions related to Parking models.
 * This includes permissions for viewing any parking record, viewing a specific parking record,
 * creating new parking records, and updating existing parking records.
 */
class ParkingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any parking records.
     *
     * @param  User  $user  The user attempting the action.
     * @return bool True if the user is authenticated, otherwise false.
     */
    public function viewAny(User $user): bool
    {

        return auth()->check();
    }

    /**
     * Determine whether the user can view a specific parking record.
     *
     * @param  User  $user  The user attempting the action.
     * @param  Parking  $parking  The parking record being accessed.
     * @return bool True if the user's ID matches the parking record's user_id, otherwise false.
     */
    public function view(User $user, Parking $parking): bool
    {

        return $user->id === $parking->user_id;
    }

    /**
     * Determine whether the user can create a parking record.
     *
     * @param  User  $user  The user attempting the action.
     * @return bool True if the user is authenticated, otherwise false.
     */
    public function create(User $user): true
    {

        return auth()->check();
    }

    /**
     * Determine whether the user can update a specific parking record.
     *
     * @param  User  $user  The user attempting the action.
     * @param  Parking  $parking  The parking record being updated.
     * @return bool True if the user's ID matches the parking record's user_id, otherwise false.
     */
    public function update(User $user, Parking $parking): bool
    {

        return $user->id === $parking->user_id;
    }
}
