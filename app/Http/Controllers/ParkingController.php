<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParkingRequest;
use App\Http\Resources\ParkingResource;
use App\Models\Parking;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ParkingController extends Controller
{
    use AuthorizesRequests;

    public function index(): AnonymousResourceCollection
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
    }
}
