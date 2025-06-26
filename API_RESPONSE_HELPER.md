# API Response Helper Documentation

## Overview
Helper untuk standardisasi response API di aplikasi Laravel ServisKu Backend.

## Files Created
- `app/Helpers/ApiResponse.php` - Main helper class
- `app/Helpers/helpers.php` - Global helper functions  
- `app/Traits/ApiResponseTrait.php` - Trait untuk controller
- `app/Providers/HelperServiceProvider.php` - Service provider

## Response Format
Semua response menggunakan format JSON standar:

### Success Response
```json
{
    "success": true,
    "message": "Success message",
    "data": {
        // Data content
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        // Error details (optional)
    }
}
```

### Paginated Response
```json
{
    "success": true,
    "message": "Data retrieved successfully",
    "data": [
        // Array of items
    ],
    "pagination": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 10,
        "total": 50,
        "from": 1,
        "to": 10,
        "has_more_pages": true
    }
}
```

## Usage Examples

### 1. Using Class Methods
```php
use App\Helpers\ApiResponse;

// Success response
return ApiResponse::success($data, 'Data retrieved successfully');

// Error response
return ApiResponse::error('Something went wrong', 400);

// Validation error
return ApiResponse::validationError($validator->errors());

// Not found
return ApiResponse::notFound('User not found');

// Created
return ApiResponse::created($user, 'User created successfully');

// Paginated
return ApiResponse::paginated($users);
```

### 2. Using Global Helper Functions
```php
// Success response
return api_success($data, 'Data retrieved successfully');

// Error response
return api_error('Something went wrong', 400);

// Validation error
return api_validation_error($validator->errors());

// Not found
return api_not_found('User not found');

// Created
return api_created($user, 'User created successfully');

// Paginated
return api_paginated($users);
```

### 3. Using Trait in Controllers
```php
<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $users = User::paginate(10);
        return $this->paginatedResponse($users);
    }

    public function store(Request $request)
    {
        $user = User::create($request->validated());
        return $this->createdResponse($user, 'User created successfully');
    }

    public function show(User $user)
    {
        return $this->successResponse($user);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->validated());
        return $this->successResponse($user->fresh(), 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->successResponse(null, 'User deleted successfully');
    }
}
```

## Available Methods

### ApiResponse Class
- `success($data, $message, $statusCode)` - Success response
- `error($message, $statusCode, $errors)` - Error response
- `validationError($errors, $message)` - Validation error (422)
- `notFound($message)` - Not found error (404)
- `unauthorized($message)` - Unauthorized error (401)
- `forbidden($message)` - Forbidden error (403)
- `serverError($message)` - Server error (500)
- `created($data, $message)` - Created response (201)
- `paginated($data, $message)` - Paginated response
- `noContent()` - No content response (204)
- `custom($success, $message, $data, $statusCode, $meta)` - Custom response

### Global Helper Functions
- `api_success($data, $message, $statusCode)`
- `api_error($message, $statusCode, $errors)`
- `api_validation_error($errors, $message)`
- `api_not_found($message)`
- `api_unauthorized($message)`
- `api_forbidden($message)`
- `api_created($data, $message)`
- `api_paginated($data, $message)`

### Trait Methods (untuk Controller)
- `successResponse($data, $message, $statusCode)`
- `errorResponse($message, $statusCode, $errors)`
- `validationErrorResponse($errors, $message)`
- `notFoundResponse($message)`
- `unauthorizedResponse($message)`
- `forbiddenResponse($message)`
- `createdResponse($data, $message)`
- `paginatedResponse($data, $message)`
- `serverErrorResponse($message)`
- `noContentResponse()`

## HTTP Status Codes Used
- `200` - OK (Success)
- `201` - Created
- `204` - No Content
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Unprocessable Entity (Validation Error)
- `500` - Internal Server Error

## Installation
Helper sudah terdaftar otomatis melalui `HelperServiceProvider` yang sudah didaftarkan di `bootstrap/providers.php`.

## Best Practices
1. Gunakan trait `ApiResponseTrait` di controller untuk consistency
2. Selalu berikan message yang descriptive
3. Gunakan status code yang sesuai dengan HTTP standards
4. Untuk error handling, gunakan try-catch dan return server error jika ada exception
5. Untuk validation error, gunakan `validationError` method
6. Untuk response dengan pagination, gunakan `paginated` method
