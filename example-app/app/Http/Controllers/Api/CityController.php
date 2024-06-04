<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCityRequest;
use App\Models\City;

class CityController extends Controller
{
    public function store(StoreCityRequest $request)
    {
        $validated = $request->validated();

        $city = City::create($validated);

        return response()->json(['city' => $city], 201);
    }

    public function update(StoreCityRequest $request, City $city)
    {
        //$validated = $request->validated($city->id);


        /*if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }*/

        $city->update([
            'name' => $request->string('name')->toString()
        ]);

        return response()->json(['city' => $city], 200);
    }

    public function destroy(City $city)
    {
        $city->delete();

        return response()->json(null, 204);
    }
}
