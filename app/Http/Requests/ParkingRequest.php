<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParkingRequest extends FormRequest
{
    public function rules()
    : array
    {
        return [
            'user_id' => ['required', 'exists:users'],
            'vehicle_id' => ['required', 'exists:vehicles'],
            'zone_id' => ['required', 'exists:zones'],
            'start_time' => ['nullable', 'date'],
            'stop_time' => ['nullable', 'date'],
            'total_price' => ['nullable', 'integer'],
        ];
    }

    public function authorize()
    : true
    {
        return true;
    }
}
