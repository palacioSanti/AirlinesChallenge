<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAirlineRequest;
use App\Models\Airline;
use Illuminate\Http\JsonResponse;

class AirlineController extends Controller
{
    public function store(StoreAirlineRequest $request)
    {

        $airline = Airline::create($request->all());
        return response()->json(['airline' => $airline], JsonResponse::HTTP_CREATED);
    }

    public function update(StoreAirlineRequest $request, Airline $airline)
    {

        $airline->update($request->all());
        return response()->json(['airline' => $airline], JsonResponse::HTTP_OK);
    }

    public function destroy(Airline $airline)
    {
        $airline->delete();
        return response()->json(['message' => 'Deleted successfully'], JsonResponse::HTTP_NO_CONTENT);
    }
}
