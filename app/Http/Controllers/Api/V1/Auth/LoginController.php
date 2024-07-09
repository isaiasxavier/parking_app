<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @group Auth
 *
 * @unauthenticated
 */
class LoginController extends Controller
{
    /**
     * Authenticate a user.
     *
     * This method authenticates a user by their email and password. If the credentials are correct,
     * it generates an access token for the user. The token's expiration can be extended if the 'remember' option is selected.
     *
     * @param  LoginRequest  $request  The login request containing the user's email and password.
     * @return JsonResponse Returns a JSON response with the access token on successful authentication.
     *
     * @throws ValidationException Throws an exception if the provided credentials are incorrect.
     */
    public function __invoke(LoginRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::where('email', $validatedData['email'])->first();

        if (! $user || ! Hash::check($validatedData['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $device = substr($request->userAgent() ?? '', 0, 255);
        $expiresAt = $request->remember ? null : now()->addMinutes((int) config('session.lifetime'));

        return response()->json([
            'access_token' => $user->createToken($device, expiresAt: $expiresAt)->plainTextToken,
        ], ResponseAlias::HTTP_CREATED);

    }
}
