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

    protected function setUp(): void
    {
        parent::setUp();

        $this->seedDatabase();
    }

    protected function seedDatabase()
    {
        City::factory()->count(4)->create();

        Airline::factory()->count(12)->create();

        Airline::all()->each(function ($airline) {
            $cities = City::inRandomOrder()->take(8)->pluck('id');
            $airline->cities()->attach($cities);
        });

        Flight::factory()->count(40)->create();
    }

}
