<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return Inertia::render('Auth/Login', [
            'auth' => [
                'client' => auth('client')->user()
            ]
        ]);
    }

    // Proses login untuk client
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Login menggunakan guard 'client'
        if (Auth::guard('client')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            return redirect()->intended('/profile');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return Inertia::render('Auth/Register', [
            'auth' => [
                'client' => auth('client')->user()
            ]
        ]);
    }

    // Proses register untuk client
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:clients,name',
            'email' => 'required|string|email|max:255|unique:clients',
            'password' => 'required|string|min:8',
        ]);

        $client = Client::create([
            'name' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Login otomatis setelah register menggunakan guard 'client'
        Auth::guard('client')->login($client);

        return redirect('/profile');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}