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
class PasswordUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for the password update request. It ensures that:
     * - `current_password` is required and must match the user's current password.
     * - `password` is required, must be confirmed, and meets the application's security requirements.
     *
     * These rules help in maintaining the security and integrity of the user's account by ensuring that only
     * valid and authorized password updates are processed.
     *
     * @return array An array of validation rules.
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
