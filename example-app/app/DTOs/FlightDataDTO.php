<?php

namespace App\DTOs;

class FlightDataDTO
{
    public $airline_id;
    public $departure_city_id;
    public $arrival_city_id;
    public $departure_datetime;
    public $arrival_datetime;

    public function __construct($airline_id, $departure_city_id, $arrival_city_id, $departure_datetime, $arrival_datetime)
    {
        $this->airline_id = $airline_id;
        $this->departure_city_id = $departure_city_id;
        $this->arrival_city_id = $arrival_city_id;
        $this->departure_datetime = $departure_datetime;
        $this->arrival_datetime = $arrival_datetime;
    }

    public static function fromRequest($request)
    {
        return new self(
            $request->input('airline_id'),
            $request->input('departure_city_id'),
            $request->input('arrival_city_id'),
            $request->input('departure_datetime'),
            $request->input('arrival_datetime')
        );
    }
}
