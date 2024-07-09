<?php

namespace App\Http\Resources;

use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Zone */
class ZoneResource extends JsonResource
{
    /**
     * Transform the zone resource into an array.
     *
     * This method takes the current Zone model instance and transforms it into an array format suitable for API
     * responses. It includes the zone's ID, name, and price per hour in the array. This provides a consistent and
     * convenient structure for consuming zone data in client applications.
     *
     * @param  Request  $request  The current request instance.
     * @return array An array representation of the Zone model, including id, name, and price per hour.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price_per_hour' => $this->price_per_hour,
        ];
    }
}
