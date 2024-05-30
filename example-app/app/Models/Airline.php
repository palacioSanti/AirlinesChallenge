<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    public function cities()
    {
        return $this->belongsToMany(City::class, 'airline_city');
    }

}
