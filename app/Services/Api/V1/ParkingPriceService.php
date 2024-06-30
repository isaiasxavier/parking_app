<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Services\Api\V1;

use App\Models\Zone;
use Carbon\Carbon;

class ParkingPriceService
{
    public static function calculatePrice(int $zone_id, string $startTime, ?string $stopTime = null): int
    {
        $start = new Carbon($startTime);
        $stop = (! is_null($stopTime)) ? new Carbon($stopTime) : now();

        $totalTimeByMinutes = $start->diffInMinutes($stop);

        $priceByMinutes = Zone::find($zone_id)->price_per_hour / 60;

        return (int) (($totalTimeByMinutes * $priceByMinutes) * 100);
    }
}
