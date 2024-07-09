<?php

namespace App\Http\Resources;

use App\Models\Parking;
use App\Services\Api\V1\ParkingPriceService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Parking */
class ParkingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * This method takes the current Parking model instance and transforms it into an array format suitable for API
     * responses. It calculates the total price for parking either from the model's `total_price` attribute or by using
     * the `ParkingPriceService::calculatePrice` method if `total_price` is null. It formats the `start_time` and `stop_time`
     * to a 'Y-m-d H:i:s' format. Additionally, it conditionally includes `vehicle` and `zone` resources when they are loaded into the model.
     *
     * @param  Request  $request  The current request instance.
     * @return array An array representation of the Parking model, including id, start and stop times, total price,
     *               and optionally loaded vehicle and zone resources.
     */
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
