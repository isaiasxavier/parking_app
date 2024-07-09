<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ZoneResource;
use App\Models\Zone;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Zones
 *
 * @authenticated
 */
class ZoneController extends Controller
{
    use AuthorizesRequests;

    /**
     * List all zones.
     *
     * This method retrieves all zone instances. It ensures that the user has the permission to view any zone.
     *
     * @return AnonymousResourceCollection Returns a collection of zone resources.
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Zone::class);

        return ZoneResource::collection(Zone::all());
    }
}
