<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\{
    ArrivalCityNotAssociatedException,
    DepartureCityNotAssociatedException,
    InvalidArrivalTimeException,
    InvalidDepartureTimeException,
    SameCityException
};

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline_id',
        'departure_city_id',
        'arrival_city_id',
        'departure_datetime',
        'arrival_datetime',
    ];

    protected $with = ['departureCity', 'arrivalCity', 'airline'];

    protected $casts = [
        'departure_datetime' => 'datetime',
        'arrival_datetime' => 'datetime',
    ];

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

            if ($flight->arrival_city_id === $flight->departure_city_id) {
                throw new SameCityException();
            }

            $departure_datetime = $flight->departure_datetime;
            $arrival_datetime = $flight->arrival_datetime;

            if ($departure_datetime->greaterThanOrEqualTo($arrival_datetime)) {
                throw new InvalidArrivalTimeException();
            }

            if ($departure_datetime->lessThanOrEqualTo(now())) {
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
