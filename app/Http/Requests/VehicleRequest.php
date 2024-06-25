<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{
    public function rules()
    : array
    {
        return [
            'user_id' => ['required', 'exists:users'],
            'plate_number' => ['required'],
        ];
    }

    public function authorize()
    : true
    {
        return true;
    }
}
