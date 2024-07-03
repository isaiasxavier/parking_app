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
