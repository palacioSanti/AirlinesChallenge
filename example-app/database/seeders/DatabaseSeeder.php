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

    private $airline;
    private $cities;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seedDatabase();
    }

    protected function seedDatabase()
    {
        $this->cities = City::factory()->count(2)->create();

        $this->airline = Airline::factory()->count(1)->create();

        $this->airline->cities()->attach($this->cities[0]->id);
        $this->airline->cities()->attach($this->cities[1]->id);
    }

    /**
     * Test to store a new flight.
     *
     * @return void
     */
    public function test_store_flight()
    {

        $data = [
            'airline_id' => $this->airline->id,
            'departure_city_id' => $this->cities[0]->id,
            'arrival_city_id' => $this->cities[1]->id,
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
        $data = [
            'airline_id' => $this->airline->id,
            'departure_city_id' => $this->cities[0]->id,
            'arrival_city_id' => $this->cities[1]->id,
            'departure_datetime' => now()->addHour()->toDateTimeString(),
            'arrival_datetime' => now()->addHours(2)->toDateTimeString(),
        ];

        $flight = $this->postJson('/api/flights', $data);

        $response = $this->deleteJson('/api/flights/' . $flight->id);

        $response->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('flights', [
            'id' => $flight->id,
        ]);
    }
}
