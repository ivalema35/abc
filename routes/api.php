<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CityController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\DoctorController;
use App\Http\Controllers\Api\V1\HospitalController;
use App\Http\Controllers\Api\V1\NgoController;
use App\Http\Controllers\Api\V1\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::apiResource('cities', CityController::class);
        Route::apiResource('ngos', NgoController::class);
        Route::apiResource('hospitals', HospitalController::class);
        Route::apiResource('doctors', DoctorController::class);
        Route::apiResource('vehicles', VehicleController::class);
        Route::post('cities/{city}', [CityController::class, 'update']);
        Route::post('ngos/{ngo}', [NgoController::class, 'update']);
        Route::post('hospitals/{hospital}', [HospitalController::class, 'update']);
        Route::post('doctors/{doctor}', [DoctorController::class, 'update']);
        Route::post('vehicles/{vehicle}', [VehicleController::class, 'update']);
        Route::get('/user', function (Request $request) {
            return response()->json(['success' => true, 'data' => $request->user()]);
        });
    });
});
