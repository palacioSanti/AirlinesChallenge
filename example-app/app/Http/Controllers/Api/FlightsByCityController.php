<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use Illuminate\Http\JsonResponse;

class FlightsByCityController extends Controller
{
    public function index(Request $request)
    {
        $airlineId = $request->input('airline_id');
        $cities = City::whereHas('airlines', function($query) use ($airlineId) {
            $query->where('airline_id', $airlineId);
        })->get();

        return response()->json(['cities' => $cities], JsonResponse::HTTP_OK);
    }

}
