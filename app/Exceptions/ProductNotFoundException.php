<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ProductNotFoundException extends BaseException
{
    public function __construct($message = "Product not found", $code = Response::HTTP_NOT_FOUND)
    {
        parent::__construct($message, $code);
    }
}
