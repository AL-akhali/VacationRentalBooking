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
    Route::get('properties/{property}/check-availability', [PropertyController::class, 'checkAvailability']);

    Route::apiResource('properties/{property}/pricing-rules', PropertyPricingRuleController::class);
    Route::prefix('bookings')->middleware('auth:sanctum')->group(function () {
        Route::post('/', [BookingController::class, 'store']); // guest يحجز
        Route::get('/my', [BookingController::class, 'myBookings']); // guest
        Route::patch('{booking}/status', [BookingController::class, 'updateStatus']); // host أو admin
        Route::post('{booking}/pay', [BookingController::class, 'pay']);
        Route::get('/host', [BookingController::class, 'hostBookings']); // عرض حجوزات المضيف
        Route::middleware('auth:sanctum')->group(function () {
            Route::patch('{booking}', [BookingController::class, 'update']);
            Route::delete('{booking}', [BookingController::class, 'destroy']);
        });



    });


});
