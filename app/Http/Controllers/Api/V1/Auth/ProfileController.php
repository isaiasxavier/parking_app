<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @group Auth
 *
 * @authenticated
 */
class ProfileController extends Controller
{
    /**
     * Display the user's profile information.
     *
     * This method retrieves the authenticated user's profile information, including their name and email.
     * It ensures that the user is authenticated before providing access to their profile data.
     *
     * @param  Request  $request  The request instance containing the user's authentication data.
     * @return JsonResponse Returns a JSON response containing the user's name and email.
     */
    public function show(Request $request): JsonResponse
    {
        return response()->json($request->user()->only('name', 'email'));
    }

    /**
     * Update the user's profile information.
     *
     * This method processes a ProfileRequest to validate the input data and updates the authenticated user's profile information.
     * It ensures that the user is authenticated and has the right to update their profile data.
     *
     * @param  ProfileRequest  $request  The request object containing the validated input data for the profile update.
     * @return JsonResponse Returns a JSON response with the updated profile data and an HTTP 202 Accepted status code.
     */
    public function update(ProfileRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        auth()->user()->update($validatedData);

        return response()->json($validatedData, ResponseAlias::HTTP_ACCEPTED);
    }
}
