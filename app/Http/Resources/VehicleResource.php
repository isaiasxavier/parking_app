<?php

namespace App\Http\Resources;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Vehicle */
class VehicleResource extends JsonResource
{
    /**
     * Transform the vehicle resource into an array.
     *
     * This method takes the current Vehicle model instance and transforms it into an array format suitable for API
     * responses. It includes the vehicle's ID and plate number in the array.
     *
     * @param  Request  $request  The current request instance.
     * @return array An array representation of the Vehicle model, including id and plate number.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'plate_number' => $this->plate_number,
        ];
    }
}
