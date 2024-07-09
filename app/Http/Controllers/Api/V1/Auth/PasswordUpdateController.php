<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\PasswordUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Auth
 *
 * @authenticated
 */
class PasswordUpdateController extends Controller
{
    /**
     * Update the authenticated user's password.
     *
     * This method processes a PasswordUpdateRequest to validate the input data. It first checks if the new password
     * matches the current password. If so, it returns a JSON response with an error message and a HTTP 422 Unprocessable
     * Entity status code. If the new password is different from the current password, it updates the user's password in the
     * database and returns a JSON response with a success message and a HTTP 202 Accepted status code.
     *
     * @param  PasswordUpdateRequest  $request  The request object containing the validated input data.
     * @return JsonResponse A JSON response containing a message and an HTTP status code.
     */
    public function __invoke(PasswordUpdateRequest $request)
    {
        $validatedData = $request->validated();
        $currentUser = auth()->user();

        if (Hash::check($validatedData['password'], $currentUser->password)) {
            return response()->json([
                'message' => 'The new password cannot be the same as the current password!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $currentUser->update([
            'password' => Hash::make($validatedData['password']),
        ]);

        return response()->json([
            'message' => 'Your Password Has Been Updated!',
        ], Response::HTTP_ACCEPTED);
    }
}
