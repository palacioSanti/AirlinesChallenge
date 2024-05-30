<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{
    Airline,
    City,
};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    protected $model = \App\Models\Flight::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $airline = Airline::inRandomOrder()->first();
        $departureCity = $airline->cities()->inRandomOrder()->first();
        $arrivalCity = $airline->cities()->inRandomOrder()->where('cities.id', '!=', $departureCity->id)->first();

        return [
            'airline_id' => $airline->id,
            'departure_city_id' => $departureCity->id,
            'arrival_city_id' => $arrivalCity->id,
            'departure_datetime' => $this->faker->dateTimeBetween('+1 days', '+2 days'),
            'arrival_datetime' => $this->faker->dateTimeBetween('+2 days', '+3 days'),
        ];

    }
}
