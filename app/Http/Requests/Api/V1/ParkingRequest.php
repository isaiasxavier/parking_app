<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParkingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vehicle_id' => ['required', 'integer',
                Rule::exists('vehicles', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)
                        ->where('user_id', $this->user()->id);
                }), ],
            'zone_id' => ['required', 'integer', Rule::exists('zones', 'id')],
            /*'start_time' => ['nullable', 'date'],
            'stop_time' => ['nullable', 'date'],
            'total_price' => ['nullable', 'integer'],*/
        ];
    }

    public function authorize(): true
    {
        return true;
    }
}
