<?php

namespace App\Actions;

use App\DTOs\FlightDataDTO;
use App\Models\Flight;

class CreateFlightAction
{
    public function execute(FlightDataDTO $requestDTO): Flight
    {
        $flight = Flight::create([
            'airline_id' => $requestDTO->airline_id,
            'departure_city_id' => $requestDTO->departure_city_id,
            'arrival_city_id' => $requestDTO->arrival_city_id,
            'departure_datetime' => $requestDTO->departure_datetime,
            'arrival_datetime' => $requestDTO->arrival_datetime,
        ]);

        return $flight;
    }
}
