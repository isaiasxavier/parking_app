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
use App\Services\Api\V1\ParkingPriceService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @group Parking
 *
 * @authenticated
 */
class ParkingController extends Controller
{
    use AuthorizesRequests;

    /**
     * List all parkings.
     *
     * This method retrieves all parking instances, including their related zone and vehicle information.
     * It also calculates the total price for each parking session that is still active.
     *
     * @return AnonymousResourceCollection Returns a collection of parking resources.
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Parking::class);

        $parkings = Parking::with(['zone', 'vehicle'])->get()->map(function ($parking) {
            if ($parking->stop_time === null) {
                $parking->total_price = ParkingPriceService::calculatePrice($parking->zone_id, $parking->start_time);
            } else {
                $parking->total_price = ParkingPriceService::calculatePrice($parking->zone_id, $parking->start_time, $parking->stop_time);
            }

            return $parking;
        });

        return ParkingResource::collection($parkings);
    }

    /**
     * Start a new parking session.
     *
     * Validates the incoming request and creates a new parking session if the vehicle is not already in an active session.
     * It loads the related vehicle and zone information for the newly created parking session.
     *
     * @param  ParkingRequest  $request  The parking request containing the necessary information to start a parking session.
     * @return ParkingResource|JsonResponse
     */
    public function start(ParkingRequest $request)
    {
        $this->authorize('create', Parking::class);

        $validatedData = $request->validated();

        if (Parking::active()->where('vehicle_id', $request->vehicle_id)->whereNull('stop_time')->exists()) {
            return response()->json([
                'errors' => ['general' => ['Can\'t start parking twice using same vehicle. Please stop currently active parking.']],
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parking = Parking::create($validatedData);
        $parking->load('vehicle', 'zone');

        return new ParkingResource($parking);
    }

    /**
     * Display a specific parking session.
     *
     * Retrieves and returns information about a specific parking session, including related zone and vehicle information,
     * if the session exists and the user has permission to view it.
     *
     * @param  int  $id  The ID of the parking session to retrieve.
     * @return ParkingResource|JsonResponse
     */
    public function show(int $id)
    {
        $parking = Parking::with(['zone', 'vehicle'])->find($id);

        if (! $parking) {
            return response()->json([
                'errors' => ['general' => ['You don\'t Have a Parking With this ID to SHOW!']],
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        $this->authorize('view', $parking);

        return new ParkingResource($parking);
    }

    /**
     * Stop an active parking session.
     *
     * Finds an active parking session by ID and stops it by setting the stop time and calculating the total price.
     * It checks if the session exists and if it has not already been stopped.
     *
     * @param  int  $id  The ID of the parking session to stop.
     * @return ParkingResource|JsonResponse Returns the updated parking resource on success, or a JSON response with errors on failure.
     */
    public function stop(int $id)
    {
        $parking = Parking::find($id);

        if (! $parking) {
            return response()->json([
                'errors' => ['general' => ['You don\'t Have a Parking With this ID to STOP!']],
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        if ($parking->stop_time !== null) {
            return response()->json([
                'errors' => ['general' => ['Parking already stopped.']],
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->authorize('update', $parking);

        $parking->update([
            'stop_time' => now(),
            'total_price' => ParkingPriceService::calculatePrice($parking->zone_id, $parking->start_time),
        ]);

        return new ParkingResource($parking);
    }

    /**
     * List all stopped parkings.
     *
     * Retrieves all parking sessions, including their related zone and vehicle information, regardless of their status.
     * This method is similar to index but does not filter by active sessions.
     *
     * @return AnonymousResourceCollection Returns a collection of all parking resources, including stopped sessions.
     */
    public function stoppedParking(): AnonymousResourceCollection
    {
        $this->authorize('viewAny', Parking::class);

        $parkings = Parking::with(['zone', 'vehicle'])->get();

        return ParkingResource::collection($parkings);
    }
}
