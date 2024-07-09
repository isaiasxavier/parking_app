<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Observers;

use App\Models\Parking;

/**
 * ParkingObserver Class
 *
 * Observes the Parking model's events to automatically handle model-specific actions
 * such as setting default values before creating a record.
 */
class ParkingObserver
{
    /**
     * Handle the Parking "creating" event.
     *
     * Automatically sets the user_id to the currently authenticated user's ID and
     * the start_time to the current time when a Parking model is being created.
     *
     * @param  Parking  $parking  The Parking model instance being created.
     */
    public function creating(Parking $parking): void
    {
        if (auth()->check()) {
            $parking->user_id = auth()->id();
        }
        $parking->start_time = now();
    }
}
