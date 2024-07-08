<?php
/*
 * @author Isaias Xavier Santana
 * <https://github.com/isaiasxavier>
 * Copyright (c) 2024.
 */

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\PasswordUpdateController;
use App\Http\Controllers\Api\V1\Auth\ProfileController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\ParkingController;
use App\Http\Controllers\Api\V1\VehicleController;
use App\Http\Controllers\Api\V1\ZoneController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/auth')->group(function () {

    Route::middleware('guestSanctum')->group(function () {
        Route::post('/register', RegisterController::class);
        Route::post('/login', LoginController::class);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);
        Route::put('/password', PasswordUpdateController::class);
        Route::post('/logout', LogoutController::class);
    });
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('/vehicles', VehicleController::class);

    Route::get('/parkings/', [ParkingController::class, 'index']);
    Route::post('/parkings/start', [ParkingController::class, 'start']);
    Route::get('/parkings/{parking}', [ParkingController::class, 'show']);
    Route::put('/parkings/{parking}', [ParkingController::class, 'stop']);
});

Route::get('v1/zones', [ZoneController::class, 'index']);
