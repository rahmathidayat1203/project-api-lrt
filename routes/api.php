<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('schedules', \App\Http\Controllers\Api\SchedulesController::class);
Route::post('changepassword',[\App\Http\Controllers\Api\AuthController::class,'changepassword']);
Route::get('schedulesbysearchform',[\App\Http\Controllers\Api\SchedulesController::class,'getBySearchForm']);
Route::get('schedulesbydate',[\App\Http\Controllers\Api\SchedulesController::class,'getByDate']);
Route::apiResource('stations',\App\Http\Controllers\Api\StationController::class);
Route::apiResource('routes',\App\Http\Controllers\Api\RoutesController::class);
Route::apiResource('passengers',\App\Http\Controllers\Api\PassengerController::class);
Route::apiResource('segments',\App\Http\Controllers\Api\SegmentController::class);
Route::apiResource('cities',\App\Http\Controllers\Api\CityController::class);
Route::apiResource('bookings',\App\Http\Controllers\Api\BookingController::class);
Route::get('bookingbyidUser',[\App\Http\Controllers\Api\BookingController::class,'getByIdUser']);
