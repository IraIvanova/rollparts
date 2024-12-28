<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int,class-string<Throwable>>
     */
    protected $dontReport = [
        AuthenticationException::class,
        ModelNotFoundException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // Check if it's an API request
        if ($request->expectsJson()) {
            return $this->handleApiException($request, $exception);
        }

        // Handle web requests
        return $this->handleWebException($request, $exception);
    }

    /**
     * Handle exceptions for API requests.
     */
    protected function handleApiException($request, Throwable $exception)
    {
        // Define the default response
        $statusCode = 500;
        $message = 'An error occurred. Please try again later.';

        if ($exception instanceof NotFoundHttpException) {
            $statusCode = 404;
            $message = 'Resource not found';
        } elseif ($exception instanceof AuthenticationException) {
            $statusCode = 401;
            $message = 'Unauthorized';
        } elseif ($exception instanceof CustomException) {
            $statusCode = 400;
            $message = $exception->getMessage();
        }

        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * Handle exceptions for web requests.
     */
    protected function handleWebException($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        } elseif ($exception instanceof AuthenticationException) {
            return redirect()->route('login')->withErrors('You must be logged in to access this page.');
        } elseif ($exception instanceof CustomException) {
            return response()->view('errors.custom', ['message' => $exception->getMessage()], 400);
        }

        // Default error page for general exceptions
        return response()->view('errors.500', ['message' => $exception->getMessage()], 500);
    }
}
