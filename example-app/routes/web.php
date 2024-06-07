<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AirlineController;

/*Route::get('/', function () {
    return view('welcome');
});*/



Route::get('cities', [CityController::class, 'index'])->name('cities.index');

Route::get('airlines', [AirlineController::class, 'index'])->name('airlines.index');

