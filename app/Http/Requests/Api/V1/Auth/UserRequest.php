<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @group Auth
 */
class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for the registration request. It ensures that:
     * - `name` is required, must be a string, at most 255 characters, and only contain letters, spaces, apostrophes, and hyphens.
     * - `email` is required, must be a string, a valid email format, at most 255 characters, and unique in the `users` table.
     * - `password` is required, must be confirmed, and meet the application's password security requirements.
     *
     * These rules help in maintaining the integrity of the user registration process by ensuring that only valid and properly formatted data is processed.
     *
     * @return array An array of validation rules.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\'\-]+$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
