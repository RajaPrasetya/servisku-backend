<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\JsonResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Handle API requests with JSON responses
        if ($request->is('api/*') || $request->expectsJson()) {
            return $this->handleApiException($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Handle API exceptions and return JSON responses
     */
    protected function handleApiException($request, Throwable $exception): JsonResponse
    {
        $statusCode = 500;
        $message = 'Internal Server Error';

        // Handle ModelNotFoundException (when model not found)
        if ($exception instanceof ModelNotFoundException) {
            $statusCode = 404;
            $model = class_basename($exception->getModel());
            $message = "Data {$model} tidak ditemukan";
        }
        
        // Handle NotFoundHttpException
        elseif ($exception instanceof NotFoundHttpException) {
            $statusCode = 404;
            $message = 'Resource tidak ditemukan';
            
            // Check if it's caused by ModelNotFoundException
            $previous = $exception->getPrevious();
            if ($previous instanceof ModelNotFoundException) {
                $model = class_basename($previous->getModel());
                $message = "Data {$model} tidak ditemukan";
            }
        }
        
        // Handle validation errors
        elseif ($exception instanceof \Illuminate\Validation\ValidationException) {
            $statusCode = 422;
            $message = 'Data yang diberikan tidak valid';
            
            return response()->json([
                'status' => 'error',
                'message' => $message,
                'errors' => $exception->errors()
            ], $statusCode);
        }
        
        // Handle authentication errors
        elseif ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $statusCode = 401;
            $message = 'Unauthorized. Token tidak valid atau sudah expired';
        }
        
        // Handle authorization errors
        elseif ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            $statusCode = 403;
            $message = 'Akses ditolak. Anda tidak memiliki permission untuk mengakses resource ini';
        }

        // Default error response
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'code' => $statusCode
        ], $statusCode);
    }
}
