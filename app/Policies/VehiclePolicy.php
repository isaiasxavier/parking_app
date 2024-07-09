<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * VehiclePolicy Class
 *
 * Defines authorization rules for actions that can be performed on Vehicle instances.
 * This includes permissions for viewing, creating, updating, deleting, restoring,
 * and force deleting vehicles based on the user's relationship to the vehicle.
 */
class VehiclePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the authenticated user can view their own vehicle.
     *
     * @param  User  $user  The user attempting the action.
     * @param  Vehicle  $vehicle  The vehicle being accessed.
     * @return bool True if the user owns the vehicle, otherwise false.
     */
    public function viewOwn(User $user, Vehicle $vehicle): bool
    {

        return $user->id === $vehicle->user_id;
    }

    /**
     * Determine if the authenticated user can view any vehicle.
     *
     * @param  User  $user  The user attempting the action.
     * @param  Vehicle  $vehicle  The vehicle being accessed.
     * @return bool True if the user owns the vehicle, otherwise false.
     */
    public function view(User $user, Vehicle $vehicle): bool
    {

        return $user->id === $vehicle->user_id;
    }

    /**
     * Determine if the authenticated user can create a vehicle.
     *
     * @param  User  $user  The user attempting the action.
     * @return bool True if the user is authenticated, otherwise false.
     */
    public function create(User $user): true
    {

        return auth()->check();
    }

    /**
     * Determine if the authenticated user can update a vehicle.
     *
     * @param  User  $user  The user attempting the action.
     * @param  Vehicle  $vehicle  The vehicle being updated.
     * @return bool True if the user owns the vehicle, otherwise false.
     */
    public function update(User $user, Vehicle $vehicle): bool
    {

        return $user->id === $vehicle->user_id;
    }

    /**
     * Determine if the authenticated user can delete a vehicle.
     *
     * @param  User  $user  The user attempting the action.
     * @param  Vehicle  $vehicle  The vehicle being deleted.
     * @return bool True if the user owns the vehicle, otherwise false.
     */
    public function delete(User $user, Vehicle $vehicle): bool
    {

        return $user->id === $vehicle->user_id;
    }
}
