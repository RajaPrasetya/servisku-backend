<?php

use App\Helpers\ApiResponse;

if (!function_exists('api_success')) {
    /**
     * Return a success API response
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    function api_success($data = null, string $message = 'Success', int $statusCode = 200)
    {
        return ApiResponse::success($data, $message, $statusCode);
    }
}

if (!function_exists('api_error')) {
    /**
     * Return an error API response
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed $errors
     * @return \Illuminate\Http\JsonResponse
     */
    function api_error(string $message = 'Error', int $statusCode = 400, $errors = null)
    {
        return ApiResponse::error($message, $statusCode, $errors);
    }
}

if (!function_exists('api_validation_error')) {
    /**
     * Return a validation error API response
     *
     * @param mixed $errors
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    function api_validation_error($errors, string $message = 'Validation failed')
    {
        return ApiResponse::validationError($errors, $message);
    }
}

if (!function_exists('api_not_found')) {
    /**
     * Return a not found API response
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    function api_not_found(string $message = 'Resource not found')
    {
        return ApiResponse::notFound($message);
    }
}

if (!function_exists('api_unauthorized')) {
    /**
     * Return an unauthorized API response
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    function api_unauthorized(string $message = 'Unauthorized')
    {
        return ApiResponse::unauthorized($message);
    }
}

if (!function_exists('api_forbidden')) {
    /**
     * Return a forbidden API response
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    function api_forbidden(string $message = 'Forbidden')
    {
        return ApiResponse::forbidden($message);
    }
}

if (!function_exists('api_created')) {
    /**
     * Return a created API response
     *
     * @param mixed $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    function api_created($data = null, string $message = 'Resource created successfully')
    {
        return ApiResponse::created($data, $message);
    }
}

if (!function_exists('api_paginated')) {
    /**
     * Return a paginated API response
     *
     * @param mixed $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    function api_paginated($data, string $message = 'Data retrieved successfully')
    {
        return ApiResponse::paginated($data, $message);
    }
}
