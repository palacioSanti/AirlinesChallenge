<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{
    Airline,
    City
};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CityAirlineFactory extends Factory
{
    protected $model = \App\Models\City_Airline::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'airline_id' => Airline::inRandomOrder()->first()->id,
            'city_id' => City::inRandomOrder()->first()->id,
        ];
    }
}
