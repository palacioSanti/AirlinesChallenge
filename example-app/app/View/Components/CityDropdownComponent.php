<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

class CityDropdownComponent extends Component
{
    public string $name;
    public Collection $cities;
    public string $label;

    public function __construct(string $name, Collection $cities, string $label)
    {
        $this->name = $name;
        $this->cities = $cities;
        $this->label = $label;
    }

    public function render(): \Illuminate\Contracts\View\View|\Closure|string
    {
        return view('components.city-dropdown-component');
    }
}
