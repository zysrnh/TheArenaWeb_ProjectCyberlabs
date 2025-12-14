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
        // ✅ Livewire file upload (CRITICAL untuk fix 401 error)
        'livewire/upload-file',
        'livewire/upload-file/*',
        '/livewire/upload-file',
        '/livewire/upload-file/*',
        
        // ✅ Faspay callback URLs (WAJIB!)
        '/api/payment/faspay/callback',
        'api/payment/faspay/callback',
        '/payment/process/*',
        
        // ✅ Legacy support (kalau ada yang lama)
        '/payment/faspay/callback',
        'payment/faspay/callback',
        '/payment/callback',
        'payment/callback',
        
        // ✅ Other payment-related endpoints
        'payment/process',
        'payment/check-voucher',
        'form/prepare-checkout',
    ];
}