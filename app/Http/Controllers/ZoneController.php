<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZoneRequest;
use App\Http\Resources\ZoneResource;
use App\Models\Zone;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ZoneController extends Controller
{
    use AuthorizesRequests;

    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Zone::class);

        return ZoneResource::collection(Zone::all());
    }

    public function store(ZoneRequest $request): ZoneResource
    {
        $this->authorize('create', Zone::class);

        return new ZoneResource(Zone::create($request->validated()));
    }

    public function show(Zone $zone): ZoneResource
    {
        $this->authorize('view', $zone);

        return new ZoneResource($zone);
    }

    public function update(ZoneRequest $request, Zone $zone): ZoneResource
    {
        $this->authorize('update', $zone);

        $zone->update($request->validated());

        return new ZoneResource($zone);
    }

    public function destroy(Zone $zone): JsonResponse
    {
        $this->authorize('delete', $zone);

        $zone->delete();

        return response()->json();
    }
}
