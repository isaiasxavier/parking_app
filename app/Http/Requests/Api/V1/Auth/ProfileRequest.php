<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @group Auth
 */
class ProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[\pL\s\'\-]+$/u'], // Only allows letters, spaces, apostrophes, and hyphens
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->user())],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
