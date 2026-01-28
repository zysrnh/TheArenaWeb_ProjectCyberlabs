<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ScanController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// ============================================
// API AUTHENTICATION
// ============================================
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::post('/mark', [ScanController::class, 'mark']);

// ============================================
// FASPAY PAYMENT GATEWAY (NO AUTH, NO CSRF)
// ============================================

// ✅ Server-to-server callback dari Faspay
// URL: /api/payment/faspay/callback
Route::post('/payment/faspay/callback', [PaymentController::class, 'callback'])
    ->name('payment.faspay.callback');

// ✅ Check payment status (untuk testing/monitoring)
// URL: /api/payment/check-status
Route::post('/payment/check-status', [PaymentController::class, 'checkStatus'])
    ->name('payment.check-status');

// ============================================
// TESTING ENDPOINTS (DEVELOPMENT ONLY)
// ============================================
if (config('app.env') !== 'production') {
    // Health check untuk callback endpoint
    Route::get('/payment/faspay/health', function () {
        return response()->json([
            'status' => 'healthy',
            'timestamp' => now()->toIso8601String(),
            'endpoint' => route('payment.faspay.callback'),
        ]);
    });
}