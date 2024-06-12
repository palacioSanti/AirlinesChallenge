<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\AirlineController;
use App\Http\Controllers\Api\FlightController;
use App\Http\Controllers\Api\CitiesByAirlineController;
use App\Http\Middleware\ForceJsonResponse;


Route::middleware(ForceJsonResponse::class)->group(function () {

    Route::prefix('cities')->name('api.cities.')->group(function () {
        Route::get('/', [CityController::class, 'index'])->name('index');
        Route::post('/', [CityController::class, 'store'])->name('store');
        Route::put('/{city}', [CityController::class, 'update'])->name('update');
        Route::delete('/{city}', [CityController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('airlines')->name('api.airlines.')->group(function () {
        Route::get('/', [AirlineController::class, 'index'])->name('index');
        Route::post('/', [AirlineController::class, 'store'])->name('store');
        Route::put('/{airline}', [AirlineController::class, 'update'])->name('update');
        Route::delete('/{airline}', [AirlineController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('flights')->name('api.flights.')->group(function () {
        Route::get('/', [FlightController::class, 'index'])->name('index');
        Route::post('/', [FlightController::class, 'store'])->name('store');
        Route::put('/{flight}', [FlightController::class, 'update'])->name('update');
        Route::delete('/{flight}', [FlightController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('citiesByAirline')->name('api.citiesByAirline.')->group(function () {
        Route::get('/', [CitiesByAirlineController::class, 'index'])->name('index');
    });
});
