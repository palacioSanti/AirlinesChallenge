<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Airline;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $query = City::withCount(['departureFlights', 'arrivalFlights'])
            ->filter($request->input('airline_id'));

        $query
            ->when($request->has('sort'), function ($query) use ($request) {
                $query->orderBy($request->sort, $request->order);
            });

        $cities = $query->simplePaginate(10);

        if ($request->ajax()) {
            return view('cities.partials.city_table', compact('cities'))->render();
        }

        $airlines = Airline::all();
        return view('cities.index', compact('cities', 'airlines'));
    }
}
