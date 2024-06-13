<?php

namespace App\DTOs;

class FlightDataDTO
{

    public function __construct
    (
        public $airline_id,
        public $departure_city_id,
        public $arrival_city_id,
        public $departure_datetime,
        public $arrival_datetime,
    ) {}

}
