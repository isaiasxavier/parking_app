<?php

namespace App\Http\Resources;

use App\Models\Parking;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Parking */
class ParkingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_time' => $this->start_time->toDateTimeString(),
            'stop_time' => $this->stop_time?->toDateTimeString(),
            'total_price' => $this->total_price,

            'vehicle' => new VehicleResource($this->whenLoaded('vehicle')),
            'zone' => new ZoneResource($this->whenLoaded('zone')),

            /*'vehicle' => array_diff_key((new VehicleResource($this->whenLoaded('vehicle')))->resolve($request), array_flip(['id'])),
            'zone' => array_diff_key((new ZoneResource($this->whenLoaded('zone')))->resolve($request), array_flip(['id'])),*/
        ];
    }
}
