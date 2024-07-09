<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Vehicles
 *
 * @authenticated
 */
class VehicleController extends Controller
{
    use AuthorizesRequests;

    /**
     * List all vehicles for the authenticated user.
     *
     * This method retrieves all vehicle instances associated with the authenticated user's ID.
     * It ensures that the user has the permission to view their own vehicles.
     *
     * @return AnonymousResourceCollection Returns a collection of vehicle resources.
     */
    public function index(): AnonymousResourceCollection
    {
        $vehicles = Vehicle::where('user_id', auth()->id())->get();

        foreach ($vehicles as $vehicle) {
            $this->authorize('viewOwn', $vehicle);
        }

        return VehicleResource::collection($vehicles);
    }

    /**
     * Store a new vehicle.
     *
     * Validates the incoming request and creates a new vehicle instance for the authenticated user.
     * It ensures that the user has the permission to create a new vehicle.
     *
     * @param  StoreVehicleRequest  $request  The request containing the necessary information to create a new vehicle.
     * @return VehicleResource Returns a vehicle resource on successful creation.
     */
    public function store(StoreVehicleRequest $request): VehicleResource
    {
        $this->authorize('create', Vehicle::class);

        return new VehicleResource(Vehicle::create($request->validated()));
    }

    /**
     * Display the specified vehicle.
     *
     * Retrieves and returns information about a specific vehicle, ensuring that the user has permission to view it.
     *
     * @param  Vehicle  $vehicle  The vehicle instance to retrieve.
     * @return VehicleResource Returns a vehicle resource if found and authorized.
     */
    public function show(Vehicle $vehicle): VehicleResource
    {
        $this->authorize('view', $vehicle);

        return new VehicleResource($vehicle);
    }

    /**
     * Update the specified vehicle.
     *
     * Validates the incoming request and updates the specified vehicle instance.
     * It ensures that the user has the permission to update the vehicle.
     *
     * @param  StoreVehicleRequest  $request  The request containing the updated information for the vehicle.
     * @param  Vehicle  $vehicle  The vehicle instance to update.
     * @return JsonResponse Returns a JSON response with the updated vehicle resource on success.
     */
    public function update(StoreVehicleRequest $request, Vehicle $vehicle): JsonResponse
    {
        $this->authorize('update', $vehicle);

        $vehicle->update($request->validated());

        return response()->json(new VehicleResource($vehicle), Response::HTTP_ACCEPTED);
        /*return new VehicleResource($vehicle);*/
    }

    /**
     * Remove the specified vehicle.
     *
     * Deletes the specified vehicle instance, ensuring that the user has permission to delete it.
     * Returns a no-content response on successful deletion.
     *
     * @param  Vehicle  $vehicle  The vehicle instance to delete.
     * @return \Illuminate\Http\Response Returns a no-content response on successful deletion.
     */
    public function destroy(Vehicle $vehicle): \Illuminate\Http\Response
    {
        $this->authorize('delete', $vehicle);

        $vehicle->delete();

        return response()->noContent();
    }
}
