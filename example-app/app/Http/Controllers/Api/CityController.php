<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCityRequest;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Js;

class CityController extends Controller
{


    public function index(Request $request)
    {
        $cities = City::withCount(['departureFlights', 'arrivalFlights'])
            ->filter($request->input('airline_id'))
            ->order($request->input('sort'), $request->input('order'))
            ->simplePaginate(10);

        return response()->json([
            'table' => view('cities.partials.city_table', compact('cities'))->render(),
            'pagination' => view('cities.partials.pagination', compact('cities'))->render()
        ]);
    }

    public function store(StoreCityRequest $request)
    {
        $validated = $request->validated();

        $city = City::create($validated);

        return response()->json(['city' => $city], JsonResponse::HTTP_CREATED);
    }

    public function update(StoreCityRequest $request, City $city)
    {
        $city->update([
            'name' => $request->string('name')->toString()
        ]);

        return response()->json(['city' => $city], JsonResponse::HTTP_OK);
    }

    public function destroy(City $city)
    {
        $city->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
