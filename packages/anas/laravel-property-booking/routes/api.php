<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Anas\PropertyBooking\Http\Controllers\Api\PropertyController;

Route::middleware('api')->prefix('api')->group(function () {

    Route::get('/test-from-package', function () {
        return ['msg' => 'Package API is working'];
    });

    Route::prefix('properties')->group(function () {
        Route::get('/', [PropertyController::class, 'index']);
        Route::get('/{id}', [PropertyController::class, 'show']);
        Route::post('/', [PropertyController::class, 'store']);
        Route::put('/{id}', [PropertyController::class, 'update']);
        Route::delete('/{id}', [PropertyController::class, 'destroy']);
    });

});
