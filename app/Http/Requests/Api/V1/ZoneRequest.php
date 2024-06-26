<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Requests\Api\V1;

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
