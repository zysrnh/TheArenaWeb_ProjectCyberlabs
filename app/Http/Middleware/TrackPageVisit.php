<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\PageVisit;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class TrackPageVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya track GET requests dan bukan ajax/livewire
        if ($request->isMethod('GET') && !$request->ajax() && !$request->header('X-Livewire')) {
            // Cek apakah sudah visit dalam 30 menit terakhir (hindari spam)
            $recentVisit = PageVisit::where('session_id', session()->getId())
                ->where('url', $request->fullUrl())
                ->where('visited_at', '>', Carbon::now()->subMinutes(30))
                ->exists();

            if (!$recentVisit) {
                PageVisit::create([
                    'client_id' => auth()->guard('web')->id(), // NULL jika anonim
                    'ip_address' => $request->ip(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'user_agent' => $request->userAgent(),
                    'session_id' => session()->getId(),
                    'visited_at' => now(),
                ]);
            }
        }

        return $next($request);
    }
}