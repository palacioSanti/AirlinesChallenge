<?php

namespace App\Exceptions;

use Exception;

class SameCityException extends Exception
{
    protected $message = 'The departure city and arrival city cannot be the same.';
}
