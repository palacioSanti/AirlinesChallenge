<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['airline_id'] ?? false, function ($query, $airlineId) {
            $query->whereHas('departureFlights', function ($q) use ($airlineId) {
                $q->where('airline_id', $airlineId);
            })->orWhereHas('arrivalFlights', function ($q) use ($airlineId) {
                $q->where('airline_id', $airlineId);
            });
        });

        $query->when($filters['sort'] ?? false, function ($query, $sort) {
            $query->orderBy($sort, $filters['order'] ?? 'asc');
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
