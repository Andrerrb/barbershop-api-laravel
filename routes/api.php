<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\SchedulingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::post('/clients/register', [ClientController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/schedulings/agenda', [
    SchedulingController::class,
    'agenda',
    ]);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/schedulings', [SchedulingController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('admins', AdminController::class);

    Route::apiResource('clients', ClientController::class)
        ->except(['store']);
    
    Route::apiResource('schedulings', SchedulingController::class)
        ->except(['store']);
});