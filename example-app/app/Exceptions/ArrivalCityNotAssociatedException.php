<?php

namespace App\Exceptions;

use Exception;

class ArrivalCityNotAssociatedException extends Exception
{
    protected $message = 'The airline is not associated with the arrival city.';
}
