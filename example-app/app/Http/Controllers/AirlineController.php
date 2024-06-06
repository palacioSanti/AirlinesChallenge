<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airline;

class AirlineController extends Controller
{
    public function index()
    {
        $airlines = Airline::withCount('flights')->paginate(10);
        return view('airlines.index', compact('airlines'));
    }

}
