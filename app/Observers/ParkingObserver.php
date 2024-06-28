<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Observers;

use App\Models\Parking;

class ParkingObserver
{
    public function creating(Parking $parking): void
    {
        if (auth()->check()) {
            $parking->user_id = auth()->id();
        }
        $parking->start_time = now();
    }
}
