<?php

use Anas\PropertyBooking\Http\Controllers\Api\BookingController;
use Anas\PropertyBooking\Http\Controllers\Api\PropertyPricingRuleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Anas\PropertyBooking\Http\Controllers\Api\PropertyController;
use Anas\PropertyBooking\Http\Controllers\Api\PropertyAvailabilityController;



Route::middleware('api')->prefix('api')->group(function () {

    Route::get('/test-from-package', function () {
        return ['msg' => 'Package API is working'];
    });

    Route::apiResource('properties', PropertyController::class);
    Route::apiResource('property-availabilities', PropertyAvailabilityController::class);
    Route::apiResource('properties/{property}/pricing-rules',PropertyPricingRuleController::class);
    Route::apiResource('bookings', BookingController::class);

});
