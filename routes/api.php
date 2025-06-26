<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FormServiceController;

// Public routes (tidak perlu authentication)
Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes yang hanya bisa diakses oleh admin
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/users', function () {
        return response()->json(['message' => 'Admin access granted']);
    });
    
    Route::get('/admin/dashboard', function () {
        return response()->json(['message' => 'Admin dashboard']);
    });
    
    // Admin dapat mengakses semua form services
    Route::get('/form-services/statistics', [FormServiceController::class, 'getStatistics']);
    Route::apiResource('form-services', FormServiceController::class);
});

// Routes yang hanya bisa diakses oleh teknisi
Route::middleware(['auth:sanctum', 'role:teknisi'])->group(function () {
    Route::get('/teknisi/services', function () {
        return response()->json(['message' => 'Teknisi access granted']);
    });
    
    Route::get('/teknisi/dashboard', function () {
        return response()->json(['message' => 'Teknisi dashboard']);
    });
    
    // Teknisi dapat mengakses form services yang ditugaskan kepadanya
    Route::get('/teknisi/form-services', [FormServiceController::class, 'index']);
    Route::get('/teknisi/form-services/{formService}', [FormServiceController::class, 'show']);
    Route::put('/teknisi/form-services/{formService}/status', [FormServiceController::class, 'updateStatus']);
});

// Routes yang bisa diakses oleh admin atau teknisi
Route::middleware(['auth:sanctum'])->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/refresh-token', [AuthController::class, 'refresh']);
    
    Route::get('/profile-old', function (Request $request) {
        return response()->json([
            'user' => $request->user(),
            'role' => $request->user()->role
        ]);
    });
    
    // Customer routes
    Route::get('/customers/search', [CustomerController::class, 'search']);
    Route::get('/customers/statistics', [CustomerController::class, 'statistics']);
    Route::apiResource('customers', CustomerController::class);
    
    // Form service routes yang bisa diakses berdasarkan customer atau user
    Route::get('/customers/{customerId}/form-services', [FormServiceController::class, 'getByCustomer']);
    Route::get('/users/{userId}/form-services', [FormServiceController::class, 'getByUser']);
});
