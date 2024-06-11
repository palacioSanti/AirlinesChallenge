<?php

namespace App\Actions;

use App\Http\Requests\StoreFlightRequest;
use App\Models\Flight;

class CreateFlightAction
{
    public function __invoke(StoreFlightRequest $request): Flight
    {
        $flight = Flight::create([
            'airline_id' => $request['airline_id'],
            'departure_city_id' => $request['departure_city_id'],
            'arrival_city_id' => $request['arrival_city_id'],
            'departure_datetime' => $request['departure_datetime'],
            'arrival_datetime' => $request['arrival_datetime'],
        ]);

        return $flight;
    }
}
