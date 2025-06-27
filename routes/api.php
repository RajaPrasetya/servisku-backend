<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FormServiceController;

// Public routes (tidak perlu authentication)
Route::post('/login', [AuthController::class, 'login']);

// Token validation endpoint - requires authentication
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/validate-token', [AuthController::class, 'validateToken']);
});

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
    
    // Admin dapat mengakses semua form services dan statistik
    Route::get('/form-services/statistics', [FormServiceController::class, 'getStatistics']);
    Route::get('/form-services', [FormServiceController::class, 'index']);
    Route::get('/form-services/{formService}', [FormServiceController::class, 'show']);
    Route::put('/form-services/{formService}', [FormServiceController::class, 'update']);
    Route::delete('/form-services/{formService}', [FormServiceController::class, 'destroy']);
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
Route::middleware(['auth:sanctum', 'role:admin,teknisi'])->group(function () {
    // SATU-SATUNYA endpoint untuk membuat form service lengkap
    // Dapat diakses oleh Admin dan Teknisi
    Route::post('/form-services', [FormServiceController::class, 'storeComplete']);
});

// Routes yang bisa diakses oleh semua user yang terautentikasi
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

// Routes yang bisa diakses oleh semua user yang terautentikasi
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
    
    // Debug endpoint for testing form service creation
    Route::post('/debug/form-service', function(Request $request) {
        \Log::info('Debug Form Service Request:', $request->all());
        
        $validated = $request->validate([
            'status' => 'required|string|in:diterima,proses,selesai,dibatalkan',
            'id_customer' => 'required|integer|exists:customers,id_customer',
            'id_user' => 'required|integer|exists:users,id_user',
        ]);
        
        \Log::info('Debug Validated Data:', $validated);
        
        try {
            $formService = \App\Models\FormService::create([
                'status' => $validated['status'],
                'id_customer' => $validated['id_customer'], 
                'id_user' => $validated['id_user'],
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Debug form service created',
                'data' => $formService
            ]);
        } catch (\Exception $e) {
            \Log::error('Debug Form Service Error:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error creating debug form service',
                'error' => $e->getMessage()
            ], 500);
        }
    });
});
