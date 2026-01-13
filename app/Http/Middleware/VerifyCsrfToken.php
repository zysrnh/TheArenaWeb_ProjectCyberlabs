<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $addHttpCookie = false;

    protected $except = [
        // ============================================
        // LIVEWIRE FILE UPLOAD
        // ============================================
        'livewire/upload-file',
        'livewire/upload-file/*',
        
        // ============================================
        // FASPAY PAYMENT GATEWAY CALLBACKS
        // ============================================
        // ✅ Server-to-server callback (Faspay -> Your Server)
        // Route: POST /api/payment/faspay/callback
        'api/payment/faspay/callback',
        
        // ✅ Check payment status endpoint (for testing/monitoring)
        // Route: POST /api/payment/check-status
        'api/payment/check-status',
        
        // ============================================
        // BOOKING API ENDPOINTS (AJAX)
        // ============================================
        'api/booking/process',
        'api/equipment-booking/process',
        'api/reviews/store',
        
        // ============================================
        // TESTING ENDPOINTS (DEVELOPMENT ONLY)
        // ============================================
        'test-manual-callback',
    ];
}