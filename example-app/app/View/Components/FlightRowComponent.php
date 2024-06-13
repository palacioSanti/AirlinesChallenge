<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Flight;

class FlightRowComponent extends Component
{
    public Flight $flight;

    public function __construct(Flight $flight)
    {
        $this->flight = $flight;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.flight-row-component');
    }
}
