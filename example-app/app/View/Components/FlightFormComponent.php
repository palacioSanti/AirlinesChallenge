<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

class FlightFormComponent extends Component
{
    public Collection $airlines;
    public Collection $cities;

    public function __construct(Collection $airlines, Collection $cities)
    {
        $this->airlines = $airlines;
        $this->cities = $cities;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.flight-form-component');
    }
}
