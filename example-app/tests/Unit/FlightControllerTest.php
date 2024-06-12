<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Flight;
use App\Models\Airline;
use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;

class FlightControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test to store a new flight.
     *
     * @return void
     */
    public function test_store_flight()
    {
        $airline = Airline::factory()->create();
        $departureCity = City::factory()->create();
        $arrivalCity = City::factory()->create();

        $airline->cities()->attach($departureCity->id);
        $airline->cities()->attach($arrivalCity->id);

        $data = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departureCity->id,
            'arrival_city_id' => $arrivalCity->id,
            'departure_datetime' => now()->addHour()->toDateTimeString(),
            'arrival_datetime' => now()->addHours(2)->toDateTimeString(),
        ];

        $response = $this->postJson('/api/flights', $data);

        $response->assertStatus(JsonResponse::HTTP_CREATED);
        $response->assertJsonStructure([
            'flight' => [
                'id',
                'airline_id',
                'departure_city_id',
                'arrival_city_id',
                'departure_datetime',
                'arrival_datetime',
                'created_at',
                'updated_at'
            ]
        ]);

        $this->assertDatabaseHas('flights', [
            'airline_id' => $data['airline_id'],
            'departure_city_id' => $data['departure_city_id'],
            'arrival_city_id' => $data['arrival_city_id'],
            'departure_datetime' => $data['departure_datetime'],
            'arrival_datetime' => $data['arrival_datetime'],
        ]);
    }

    /**
     * Test to delete a flight.
     *
     * @return void
     */
    public function test_destroy_flight()
    {
        $airline = Airline::factory()->create();
        $departureCity = City::factory()->create();
        $arrivalCity = City::factory()->create();

        $airline->cities()->attach($departureCity->id);
        $airline->cities()->attach($arrivalCity->id);

        $data = [
            'airline_id' => $airline->id,
            'departure_city_id' => $departureCity->id,
            'arrival_city_id' => $arrivalCity->id,
            'departure_datetime' => now()->addHour()->toDateTimeString(),
            'arrival_datetime' => now()->addHours(2)->toDateTimeString(),
        ];

        $flight = Flight::create($data);

        $response = $this->deleteJson('/api/flights/' . $flight->id);

        $response->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('flights', [
            'id' => $flight->id,
        ]);
    }
}
