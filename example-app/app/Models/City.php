<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function scopeFilter($query, $airlineId)
    {
        if (!$airlineId) {
            return;
        }
        $query->whereHas('departureFlights', function ($q) use ($airlineId) {
            $q->where('airline_id', $airlineId);
        })->orWhereHas('arrivalFlights', function ($q) use ($airlineId) {
            $q->where('airline_id', $airlineId);
        });
    }

    public function airlines()
    {
        return $this->belongsToMany(Airline::class, 'airline_city');
    }

    public function departureFlights()
    {
        return $this->hasMany(Flight::class, 'departure_city_id');
    }

    public function arrivalFlights()
    {
        return $this->hasMany(Flight::class, 'arrival_city_id');
    }
}
