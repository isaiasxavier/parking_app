<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ZoneRequest extends FormRequest
{
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
