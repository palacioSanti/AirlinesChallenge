<?php

namespace App\Http\Controllers;


use App\Models\City;

class AirlineController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return view('airlines.index', compact('cities'));
    }

}
