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
    /**
     * Get the validation rules that apply to the request.
     *
     * This method defines the validation rules for the profile update request. It ensures that:
     * - `name` is required, must be a string, at least 2 characters long, and not exceed 255 characters.
     * It also must only contain letters, spaces, apostrophes, and hyphens.
     * - `email` is required, must be a valid email format, and must be unique in the `users` table except for the
     * current user.
     *
     * These rules help in maintaining the integrity of the user's profile by ensuring that only valid and properly formatted data is processed.
     *
     * @return array An array of validation rules.
     */
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
