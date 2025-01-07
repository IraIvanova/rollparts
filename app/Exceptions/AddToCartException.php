<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class AddToCartException extends Exception
{
    public function __construct($message = "Product is not in stock or quantity is not enough", $code = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($message, $code);
    }
}
