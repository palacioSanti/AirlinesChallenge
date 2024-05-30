<?php

namespace App\Exceptions;

use Exception;

class InvalidArrivalTimeException extends Exception
{
    protected $message = 'The arrival time must be greater than the departure time.';
}
