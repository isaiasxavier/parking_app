<?php

namespace App\Http\Resources;

use App\Models\Parking;
use App\Services\Api\V1\ParkingPriceService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Parking */
class ParkingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $totalPrice = $this->total_price ?? ParkingPriceService::calculatePrice(
            $this->zone_id,
            $this->start_time,
            $this->stop_time
        );

        return [
            'id' => $this->id,
            'start_time' => $this->start_time?->format('Y-m-d H:i:s'),
            'stop_time' => $this->stop_time?->format('Y-m-d H:i:s'),
            'total_price' => $totalPrice,

            'vehicle' => new VehicleResource($this->whenLoaded('vehicle')),
            'zone' => new ZoneResource($this->whenLoaded('zone')),
        ];
    }
}
