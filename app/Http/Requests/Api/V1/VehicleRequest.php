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
class VehicleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for vehicle operations. It ensures that:
     * - `user_id` is required and must exist in the `users` table.
     * - `plate_number` is required.
     *
     * These rules help in maintaining the integrity of the vehicle data by ensuring that only valid and authorized
     * data is processed.
     *
     * @return array An array of validation rules.
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users'],
            'plate_number' => ['required'],
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
