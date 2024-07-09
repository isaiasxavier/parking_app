<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EnsureGuestSanctumMiddleware
{
    /**
     * Ensure guest access only via Sanctum.
     *
     * This middleware ensures that only guests (unauthenticated users) can access certain routes. It checks if the user
     * is authenticated using Sanctum's guard and returns a forbidden response if they are. Otherwise, it allows the request to proceed.
     *
     * @param  Request  $request  The request object.
     * @param  Closure  $next  The next middleware in the pipeline.
     * @return JsonResponse|Response Returns a JSON response with a forbidden message for authenticated users, or proceeds with the request for guests.
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse
    {
        if (Auth::guard('sanctum')->check()) {
            return response()->json(['message' => 'Action not allowed for authenticated users.'], 403);
        }

        return $next($request);
    }
}
