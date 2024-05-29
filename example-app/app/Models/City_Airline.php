<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class City_Airline extends Pivot
{
    protected $table = 'city_airlines';
}
