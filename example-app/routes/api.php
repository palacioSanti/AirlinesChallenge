<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;

Route::prefix('cities')->name('api.cities.')->group(function () {
    Route::get('', [CityController::class, 'index'])->name('index');
    Route::post('', [CityController::class, 'store'])->name('store');
    Route::put('/{city}', [CityController::class, 'update'])->name('update');
    Route::delete('/{city}', [CityController::class, 'destroy'])->name('destroy');
});
