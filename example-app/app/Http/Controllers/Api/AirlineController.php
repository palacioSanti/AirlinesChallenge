<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAirlineRequest;
use App\Models\Airline;
use Illuminate\Http\JsonResponse;
use Exception;

class AirlineController extends Controller
{
    public function index()
    {
        try {
            $airlines = Airline::withCount('flights')->paginate(10);
            return response()->json($airlines);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error fetching airlines: ' . $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreAirlineRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $airline = Airline::create($validatedData);
            return response()->json(['airline' => $airline], JsonResponse::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error adding airline: ' . $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    public function update(StoreAirlineRequest $request, Airline $airline)
    {
        try {
            $validatedData = $request->validated();
            $airline->update($validatedData);
            return response()->json(['airline' => $airline], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error updating airline: ' . $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Airline $airline)
    {
        try {
            $airline->delete();
            return response()->json(['message' => 'Deleted successfully'], JsonResponse::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error deleting airline: ' . $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}
