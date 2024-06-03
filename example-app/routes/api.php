<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;

Route::post('cities', [CityController::class, 'store'])->name('api.cities.store');
Route::put('cities/{city}', [CityController::class, 'update'])->name('api.cities.update');
Route::delete('cities/{city}', [CityController::class, 'destroy'])->name('api.cities.destroy');
