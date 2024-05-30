<?php

namespace App\Exceptions;

use Exception;

class InvalidDepartureTimeException extends Exception
{
    protected $message = 'The departure time must be greater than the current time.';
}
