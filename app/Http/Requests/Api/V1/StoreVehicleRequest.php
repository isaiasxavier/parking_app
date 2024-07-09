<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @group Vehicles
 */
class StoreVehicleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for storing a vehicle. It ensures that:
     * - `plate_number` is required.
     *
     * These rules help in maintaining the integrity of the vehicle data by ensuring that only valid data is processed.
     *
     * @return array An array of validation rules.
     */
    public function rules(): array
    {
        return [
            'plate_number' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
