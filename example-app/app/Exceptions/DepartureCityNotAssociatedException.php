<?php

namespace App\Exceptions;

use Exception;

class DepartureCityNotAssociatedException extends Exception
{
    protected $message = 'The airline is not associated with the departure city.';
}





