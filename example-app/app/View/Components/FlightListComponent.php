<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

class FlightListComponent extends Component
{

    /**
     * Create a new component instance.
     */
    public Collection $flights;

    public function __construct(Collection $flights)
    {
        $this->flights = $flights;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.flight-list-component');
    }
}
