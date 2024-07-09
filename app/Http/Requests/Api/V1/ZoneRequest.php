<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @group Zones
 */
class ZoneRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for zone operations. It ensures that:
     * - `name` is required.
     * - `price_per_hour` is required.
     *
     * These rules help in maintaining the integrity of the zone data by ensuring that only valid and authorized
     * data is processed.
     *
     * @return array An array of validation rules.
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'price_per_hour' => ['required'],
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
