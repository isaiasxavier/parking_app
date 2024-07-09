<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\UserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @group Auth
 *
 * @unauthenticated
 */
class RegisterController extends Controller
{
    /**
     * Register a new user.
     *
     * This method processes a UserRequest to validate the input data and creates a new user in the database.
     * It hashes the user's password for security, registers the user, and generates an access token for immediate use.
     * The method also logs the device used during registration for potential future security checks.
     *
     * @param  UserRequest  $request  The request object containing the validated input data for user registration.
     * @return JsonResponse Returns a JSON response with the user's access token and an HTTP 201 Created status code.
     */
    public function __invoke(UserRequest $request)
    {

        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        event(new Registered($user));

        $device = substr($request->userAgent() ?? '', 0, 255);

        return response()->json([
            'access_token' => $user->createToken($device)->plainTextToken,
        ], ResponseAlias::HTTP_CREATED);
    }
}
