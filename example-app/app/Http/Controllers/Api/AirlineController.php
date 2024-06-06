<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function store(Request $request)
    {
        $airline = Airline::create($request->all());
        return response()->json(['airline' => $airline], JsonResponse::HTTP_CREATED);
    }

    public function update(Request $request, Airline $airline)
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
