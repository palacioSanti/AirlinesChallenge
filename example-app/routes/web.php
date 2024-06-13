<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\FlightController;

/*Route::get('/', function () {
    return view('welcome');
});*/



Route::get('cities', [CityController::class, 'index'])->name('cities.index');

Route::get('airlines', [AirlineController::class, 'index'])->name('airlines.index');

Route::get('flights', [FlightController::class, 'index'])->name('flights.index');

