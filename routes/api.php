<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FormServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Struktur API Routes ServisKu:
| 1. Public Routes (tanpa autentikasi)
| 2. Token Validation Routes
| 3. Admin Only Routes
| 4. Teknisi Only Routes
| 5. Admin & Teknisi Routes
| 6. Authenticated User Routes
|
*/

// ============================================================================
// 1. PUBLIC ROUTES (Tanpa Autentikasi)
// ============================================================================
Route::post('/login', [AuthController::class, 'login']);

// ============================================================================
// 2. TOKEN VALIDATION ROUTES
// ============================================================================
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/validate-token', [AuthController::class, 'validateToken']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// ============================================================================
// 3. ADMIN ONLY ROUTES
// ============================================================================
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/users', function () {
        return response()->json(['message' => 'Admin access granted']);
    });
    Route::get('/admin/dashboard', function () {
        return response()->json(['message' => 'Admin dashboard']);
    });
    
    // Form Services - Admin Full Access
    Route::get('/form-services/statistics', [FormServiceController::class, 'getStatistics']);
    Route::get('/form-services', [FormServiceController::class, 'index']);
    Route::get('/form-services/{formService}', [FormServiceController::class, 'show']);
    Route::put('/form-services/{formService}', [FormServiceController::class, 'update']);
    Route::delete('/form-services/{formService}', [FormServiceController::class, 'destroy']);
});

// ============================================================================
// 4. TEKNISI ONLY ROUTES
// ============================================================================
Route::middleware(['auth:sanctum', 'role:teknisi'])->group(function () {
    // Teknisi Dashboard
    Route::get('/teknisi/services', function () {
        return response()->json(['message' => 'Teknisi access granted']);
    });
    Route::get('/teknisi/dashboard', function () {
        return response()->json(['message' => 'Teknisi dashboard']);
    });
    
    // Form Services - Teknisi Limited Access (only assigned services)
    Route::get('/teknisi/form-services', [FormServiceController::class, 'index']);
    Route::get('/teknisi/form-services/{formService}', [FormServiceController::class, 'show']);
    Route::put('/teknisi/form-services/{formService}/status', [FormServiceController::class, 'updateStatus']);
});

// ============================================================================
// 5. ADMIN & TEKNISI ROUTES
// ============================================================================
Route::middleware(['auth:sanctum', 'role:admin,teknisi'])->group(function () {
    // Form Service Creation - Available for Admin and Teknisi
    Route::post('/form-services', [FormServiceController::class, 'storeComplete']);
});

// ============================================================================
// 6. AUTHENTICATED USER ROUTES (All authenticated users)
// ============================================================================
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Authentication & Profile Management
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/refresh-token', [AuthController::class, 'refresh']);
    
    // Legacy profile endpoint (TODO: remove in future version)
    Route::get('/profile-old', function (Request $request) {
        return response()->json([
            'user' => $request->user(),
            'role' => $request->user()->role
        ]);
    });
    
    // Customer Management
    Route::get('/customers/search', [CustomerController::class, 'search']);
    Route::get('/customers/statistics', [CustomerController::class, 'statistics']);
    Route::apiResource('customers', CustomerController::class);
    
    // Form Service Relations
    Route::get('/customers/{customerId}/form-services', [FormServiceController::class, 'getByCustomer']);
    Route::get('/users/{userId}/form-services', [FormServiceController::class, 'getByUser']);
    
});
