<?php

namespace App\Traits;

use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Return a success response
     */
    protected function successResponse($data = null, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return ApiResponse::success($data, $message, $statusCode);
    }

    /**
     * Return an error response
     */
    protected function errorResponse(string $message = 'Error', int $statusCode = 400, $errors = null): JsonResponse
    {
        return ApiResponse::error($message, $statusCode, $errors);
    }

    /**
     * Return a validation error response
     */
    protected function validationErrorResponse($errors, string $message = 'Validation failed'): JsonResponse
    {
        return ApiResponse::validationError($errors, $message);
    }

    /**
     * Return a not found response
     */
    protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return ApiResponse::notFound($message);
    }

    /**
     * Return an unauthorized response
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized'): JsonResponse
    {
        return ApiResponse::unauthorized($message);
    }

    /**
     * Return a forbidden response
     */
    protected function forbiddenResponse(string $message = 'Forbidden'): JsonResponse
    {
        return ApiResponse::forbidden($message);
    }

    /**
     * Return a created response
     */
    protected function createdResponse($data = null, string $message = 'Resource created successfully'): JsonResponse
    {
        return ApiResponse::created($data, $message);
    }

    /**
     * Return a paginated response
     */
    protected function paginatedResponse($data, string $message = 'Data retrieved successfully', string $resourceClass = null): JsonResponse
    {
        return ApiResponse::paginated($data, $message, $resourceClass);
    }

    /**
     * Return a server error response
     */
    protected function serverErrorResponse(string $message = 'Internal server error'): JsonResponse
    {
        return ApiResponse::serverError($message);
    }

    /**
     * Return a no content response
     */
    protected function noContentResponse(): JsonResponse
    {
        return ApiResponse::noContent();
    }
}
