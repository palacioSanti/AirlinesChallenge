<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\AirlineController;

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
