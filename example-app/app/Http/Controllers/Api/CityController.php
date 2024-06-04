<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCityRequest;
use App\Models\City;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Js;

class CityController extends Controller
{
    public function store(StoreCityRequest $request)
    {
        $validated = $request->validated();

        $city = City::create($validated);

        return response()->json(['city' => $city], JsonResponse::HTTP_CREATED);
    }

    public function update(StoreCityRequest $request, City $city)
    {
        //$validated = $request->validated($city->id);


        /*if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }*/

        $city->update($request->only('name'));

        return response()->json(['city' => $city], JsonResponse::HTTP_OK);
    }

    public function destroy(City $city)
    {
        $city->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
