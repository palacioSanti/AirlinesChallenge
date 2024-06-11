<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFlightRequest;
use Illuminate\Http\Request;
use App\Models\Flight;
use Illuminate\Http\JsonResponse;

class FlightController extends Controller
{
    public function store(StoreFlightRequest $request)
    {
        $validated = $request->validated();

        $flight = Flight::create($validated);

        return response()->json(['flight' => $flight], JsonResponse::HTTP_CREATED);
    }

    public function destroy($id)
    {
        $flight = Flight::findOrFail($id);
        $flight->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
