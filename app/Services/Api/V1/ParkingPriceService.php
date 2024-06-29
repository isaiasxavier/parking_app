<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Services\Api\V1;

use App\Models\Parking;
use App\Models\Zone;

class ParkingPriceService
{
    public static function calculatePrice(int $zone_id, string $start_time, ?string $stop_time = null): int
    {
        $parking = new Parking();
        $parking->start_time = $start_time;
        $parking->stop_time = ! is_null($stop_time) ? $stop_time : now();

        $totalTimeByMinutes = $parking->start_time->diffInMinutes($parking->stop_time);

        $priceByMinutes = Zone::find($zone_id)->price_per_hour / 60;

        return ceil($totalTimeByMinutes * $priceByMinutes);
    }
}
