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
            ->when($request->has('sort'), function ($query) use ($request) {
                $query->orderBy($request->sort, $request->order);
            })
            ->simplePaginate(10);

        if ($request->ajax()) {
            return response()->json([
                'table' => view('cities.partials.city_table', compact('cities'))->render(),
                'pagination' => view('cities.partials.pagination', compact('cities'))->render()
            ]);
        }

        $airlines = Airline::all();
        return view('cities.index', compact('cities', 'airlines'));
    }
}
