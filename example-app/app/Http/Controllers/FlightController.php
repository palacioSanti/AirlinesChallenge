<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Airline;
use App\Models\City;

class FlightController extends Controller
{
    public function index()
    {
        $flights = Flight::all();
        $airlines = Airline::all();
        $cities = City::all();

        return view('flights.index', compact('flights', 'airlines', 'cities'));
    }

}
