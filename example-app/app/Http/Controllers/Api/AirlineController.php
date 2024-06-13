<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAirlineRequest;
use App\Models\Airline;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class AirlineController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['flights_count', 'city']);

        $airlines = Airline::withCount('flights')
            ->applyFilters($filters)
            ->paginate(10);

        return response()->json($airlines);
    }

    public function store(StoreAirlineRequest $request)
    {
        $validatedData = $request->validated();
        $airline = Airline::create($validatedData);
        return response()->json(['airline' => $airline], JsonResponse::HTTP_CREATED);
    }

    public function update(StoreAirlineRequest $request, Airline $airline)
    {
        $validatedData = $request->validated();
        $airline->update($validatedData);
        return response()->json(['airline' => $airline], JsonResponse::HTTP_OK);
    }

    public function destroy(Airline $airline)
    {
        $airline->delete();
        return response()->json(['message' => 'Deleted successfully'], JsonResponse::HTTP_NO_CONTENT);
    }
}
