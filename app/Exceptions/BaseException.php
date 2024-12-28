<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    public function __construct($message = "An exception occurred", $code = 0)
    {
        parent::__construct($message, $code);
    }

    public function render($request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $this->getMessage(),
            ], $this->code);
        }

        return response()->view('errors.' . $this->code, ['message' => $this->getMessage()], $this->code);
    }
}
