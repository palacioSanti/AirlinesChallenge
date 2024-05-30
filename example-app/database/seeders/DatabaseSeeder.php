<?php

namespace Database\Seeders;

use App\Models\{
    Airline,
    City,
    Flight,
};
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        City::factory()->count(15)->create();

        Airline::factory()->count(3)->create();

        Airline::all()->each(function ($airline) {
            $cities = City::inRandomOrder()->take(5)->pluck('id');
            $airline->cities()->attach($cities);
        });

        Flight::factory()->count(20)->create();
    }
}
