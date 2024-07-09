<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @group Auth
 */
class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for the login request. It ensures that:
     * - `email` is required, must be a valid email format, and must not exceed 254 characters.
     * - `password` is required.
     *
     * These rules help in maintaining the integrity of the authentication process by ensuring that only valid and
     * properly formatted data is processed.
     *
     * @return array An array of validation rules.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:254'],
            'password' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
