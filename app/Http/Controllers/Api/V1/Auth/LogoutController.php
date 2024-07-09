<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

/**
 * @group Auth
 *
 * @authenticated
 */
class LogoutController extends Controller
{
    /**
     * Log out the authenticated user.
     *
     * This method deletes the current access token for the authenticated user, effectively logging them out.
     * It returns a no-content response, indicating the operation was successful.
     *
     * @return Response Returns a no-content response on successful logout.
     */
    public function __invoke()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
