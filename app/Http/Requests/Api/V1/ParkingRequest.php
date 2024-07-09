<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @group Parking
 */
class ParkingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for the parking request. It ensures that:
     * - `vehicle_id` is required, must be an integer, and must exist in the `vehicles` table where `deleted_at` is null
     * and the `user_id` matches the authenticated user's ID.
     * - `zone_id` is required, must be an integer, and must exist in the `zones` table.
     *
     * These rules help in maintaining the integrity of the parking request data by ensuring that only valid and authorized data is processed.
     *
     * @return array An array of validation rules.
     */
    public function rules(): array
    {
        return [
            'vehicle_id' => ['required', 'integer',
                Rule::exists('vehicles', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)
                        ->where('user_id', $this->user()->id);
                }), ],
            'zone_id' => ['required', 'integer', Rule::exists('zones', 'id')],
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
