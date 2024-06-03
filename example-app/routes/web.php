<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;

/*Route::get('/', function () {
    return view('welcome');
});*/



Route::resource('cities', CityController::class)->except(['create', 'edit', 'show']);

//Route::get('cities', [CityController::class, 'index'])->name('cities.index');

