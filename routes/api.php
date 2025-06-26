<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
});

// Routes yang hanya bisa diakses oleh teknisi
Route::middleware(['auth:sanctum', 'role:teknisi'])->group(function () {
    Route::get('/teknisi/services', function () {
        return response()->json(['message' => 'Teknisi access granted']);
    });
    
    Route::get('/teknisi/dashboard', function () {
        return response()->json(['message' => 'Teknisi dashboard']);
    });
});

// Routes yang bisa diakses oleh admin atau teknisi
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', function (Request $request) {
        return response()->json([
            'user' => $request->user(),
            'role' => $request->user()->role
        ]);
    });
});
