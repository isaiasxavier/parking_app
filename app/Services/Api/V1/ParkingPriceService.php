<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Services\Api\V1;

use App\Models\Zone;
use Carbon\Carbon;

/**
 * Class ParkingPriceService
 *
 * Provides functionality to calculate the parking price for a given zone and time period.
 */
class ParkingPriceService
{
    /**
     * Calculate the parking price.
     *
     * Calculates the total parking price based on the zone's price per hour, start time, and stop time.
     * If the stop time is not provided, the current time is used.
     *
     * @param  int  $zone_id  The ID of the parking zone.
     * @param  string  $startTime  The start time of the parking session in a string format that can be parsed by Carbon.
     * @param  string|null  $stopTime  Optional. The stop time of the parking session. If null, the current time is used.
     * @return int The total parking price in cents.
     */
    public static function calculatePrice(int $zone_id, string $startTime, ?string $stopTime = null): int
    {
        $start = new Carbon($startTime);
        $stop = (! is_null($stopTime)) ? new Carbon($stopTime) : now();

        $totalTimeByMinutes = $start->diffInMinutes($stop);

        $priceByMinutes = Zone::find($zone_id)->price_per_hour / 60;

        return (int) (($totalTimeByMinutes * $priceByMinutes) * 100);
    }
}
