<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\{
    ArrivalCityNotAssociatedException,
    DepartureCityNotAssociatedException,
    InvalidArrivalTimeException,
    InvalidDepartureTimeException
};

class Flight extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($flight) {
            $isDepartureCityAssociated = $flight->airline->cities()
                ->where('city_id', $flight->departure_city_id)
                ->exists();

            if (!$isDepartureCityAssociated) {
                throw new DepartureCityNotAssociatedException();
            }

            $isArrivalCityAssociated = $flight->airline->cities()
                ->where('city_id', $flight->arrival_city_id)
                ->exists();

            if (!$isArrivalCityAssociated) {
                throw new ArrivalCityNotAssociatedException();
            }

            if ($flight->arrival_time <= $flight->departure_time) {
                throw new InvalidArrivalTimeException();
            }

            if ($flight->departure_time < 1) {
                throw new InvalidDepartureTimeException();
            }
        });
    }



    public function airline()
    {
        return $this->belongsTo(Airline::class);
    }

    public function departureCity()
    {
        return $this->belongsTo(City::class, 'departure_city_id');
    }

    public function arrivalCity()
    {
        return $this->belongsTo(City::class, 'arrival_city_id');
    }
}
