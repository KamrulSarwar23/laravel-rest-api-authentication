<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Common authenticated user routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return response()->json(['message' => 'Admin dashboard']);
        });
    });

    // Vendor-only routes
    Route::middleware('vendor')->group(function () {
        Route::get('/vendor/dashboard', function () {
            return response()->json(['message' => 'Vendor dashboard']);
        });
    });

    // Customer-only routes
    Route::middleware('customer')->group(function () {
        Route::get('/customer/dashboard', function () {
            return response()->json(['message' => 'Customer dashboard']);
        });
    });
});
