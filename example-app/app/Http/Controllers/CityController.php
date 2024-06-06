<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Airline;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::withCount(['departureFlights', 'arrivalFlights'])
            ->filter($request->input('airline_id'))
            ->simplePaginate(10);

        $airlines = Airline::all();
        return view('cities.index', compact('cities', 'airlines'));
    }
}
