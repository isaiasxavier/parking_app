<?php

namespace App\Observers;

use App\Models\Vehicle;

/**
 * VehicleObserver Class
 *
 * Observes the Vehicle model's events to automatically handle model-specific actions
 * such as setting the user_id to the currently authenticated user's ID when a Vehicle model is being created.
 */
class VehicleObserver
{
    /**
     * Handle the Vehicle "creating" event.
     *
     * Automatically sets the user_id to the currently authenticated user's ID when a Vehicle model is being created.
     *
     * @param  Vehicle  $vehicle  The Vehicle model instance being created.
     */
    public function creating(Vehicle $vehicle): void
    {
        if (auth()->check()) {
            $vehicle->user_id = auth()->id();
        }
    }
}
