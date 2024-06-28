<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ParkingRequest;
use App\Http\Resources\ParkingResource;
use App\Models\Parking;
use App\Models\Scopes\Parking\StoppedScope;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ParkingController extends Controller
{
    use AuthorizesRequests;

    public function start(ParkingRequest $request)
    {
        $validatedData = $request->validated();

        if (Parking::withoutGlobalScope(StoppedScope::class)->where('vehicle_id', $request->vehicle_id)->exists()) {
            return response()->json([
                'errors' => ['general' => ['Can\'t start parking twice using same vehicle. Please stop currently active parking.']],
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parking = Parking::create($validatedData);
        $parking->load('vehicle', 'zone');

        return new ParkingResource($parking);
    }

    /*public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Parking::class);

        return ParkingResource::collection(Parking::all());
    }

    public function store(ParkingRequest $request): ParkingResource
    {
        $this->authorize('create', Parking::class);

        return new ParkingResource(Parking::create($request->validated()));
    }

    public function show(Parking $parking): ParkingResource
    {
        $this->authorize('view', $parking);

        return new ParkingResource($parking);
    }

    public function update(ParkingRequest $request, Parking $parking): ParkingResource
    {
        $this->authorize('update', $parking);

        $parking->update($request->validated());

        return new ParkingResource($parking);
    }

    public function destroy(Parking $parking): JsonResponse
    {
        $this->authorize('delete', $parking);

        $parking->delete();

        return response()->json();
    }*/
}
