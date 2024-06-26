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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'start_time' => $this->start_time,
            'stop_time' => $this->stop_time,
            'total_price' => $this->total_price,

            'user_id' => $this->user_id,
            'vehicle_id' => $this->vehicle_id,
            'zone_id' => $this->zone_id,

            'vehicle' => new VehicleResource($this->whenLoaded('vehicle')),
            'zone' => new ZoneResource($this->whenLoaded('zone')), //
        ];
    }
}
