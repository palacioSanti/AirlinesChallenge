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
        $query->whereHas('departureFlights', fn ($q) => $q->where('airline_id', $airlineId))
            ->orWhereHas('arrivalFlights', fn ($q) => $q->where('airline_id', $airlineId));
    }

    public function scopeSort($request)
    {
        $request->when($request->has('sort'), fn ($q) => $q->orderBy($q->sort, $q->order));
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
