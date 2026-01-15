<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\EventNotif;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display the contact page
     */
    public function index()
    {
        // ✅ GET ACTIVE EVENT NOTIF (POPUP) - FULL DATA
        $activeEventNotif = EventNotif::active()->first();

        $eventNotifData = null;
        if ($activeEventNotif) {
            $eventNotifData = [
                'id' => $activeEventNotif->id,
                'title' => $activeEventNotif->title,
                'description' => $activeEventNotif->description,
                'image_url' => $activeEventNotif->image_url,
                'formatted_date' => $activeEventNotif->formatted_date,
                'formatted_time' => $activeEventNotif->formatted_time,
                'location' => $activeEventNotif->location,

                // Pricing Options
                'monthly_original_price' => $activeEventNotif->monthly_original_price,
                'formatted_monthly_original_price' => $activeEventNotif->formatted_monthly_original_price,
                'monthly_price' => $activeEventNotif->monthly_price,
                'formatted_monthly_price' => $activeEventNotif->formatted_monthly_price,
                'monthly_discount_percent' => $activeEventNotif->monthly_discount_percent,
                'weekly_price' => $activeEventNotif->weekly_price,
                'formatted_weekly_price' => $activeEventNotif->formatted_weekly_price,

                // Monthly Benefits
                'monthly_frequency' => $activeEventNotif->monthly_frequency,
                'monthly_loyalty_points' => $activeEventNotif->monthly_loyalty_points,
                'monthly_note' => $activeEventNotif->monthly_note,

                // Weekly Benefits
                'weekly_loyalty_points' => $activeEventNotif->weekly_loyalty_points,
                'weekly_note' => $activeEventNotif->weekly_note,

                // General Benefits
                'benefits_list' => $activeEventNotif->benefits_array,
                'participant_count' => $activeEventNotif->participant_count,
                'level_tagline' => $activeEventNotif->level_tagline,

                // WhatsApp
                'whatsapp_number' => $activeEventNotif->whatsapp_number,
                'whatsapp_message' => $activeEventNotif->whatsapp_message,
                'whatsapp_url' => $activeEventNotif->whatsapp_url,
            ];
        }

        return Inertia::render('Contact/Contact', [
            'auth' => [
                'client' => auth('client')->user()
            ],
            'activeEventNotif' => $eventNotifData, // ✅ PASS EVENT NOTIF
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