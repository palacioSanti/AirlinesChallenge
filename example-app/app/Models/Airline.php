<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Airline extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function cities()
    {
        return $this->belongsToMany(City::class, 'airline_city');

    }

    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    public function scopeWithMinFlights(Builder $query, $count)
    {
        return $query->having('flights_count', '>=', $count);
    }

    public function scopeInCity(Builder $query, $cityId)
    {
        return $query->whereHas('flights', function ($q) use ($cityId) {
            $q->where('departure_city_id', $cityId)
              ->orWhere('arrival_city_id', $cityId);
        });
    }

    public function scopeApplyFilters(Builder $query, array $filters)
    {
        if (isset($filters['flights_count'])) {
            $query->withMinFlights($filters['flights_count']);
        }

        if (isset($filters['city']) && $filters['city'] !== '') {
            $query->inCity($filters['city']);
        }

        return $query;
    }

}
