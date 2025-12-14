<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display the contact page
     */
    public function index()
    {
        return Inertia::render('Contact/Contact', [
            'auth' => [
                'client' => auth('client')->user()
            ]
        ]);
    }

    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        // Check if user is authenticated
        if (!auth('client')->check()) {
            return back()->with('error', 'Anda harus login terlebih dahulu untuk mengirim pesan!');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'pesan' => 'required|string|max:2000',
        ]);

        // Simpan pesan kontak ke database
        ContactMessage::create($validated);
        
        return back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.');
    }
}