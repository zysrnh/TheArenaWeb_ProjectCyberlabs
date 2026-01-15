<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use App\Models\Facility;
use App\Models\EventNotif;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class AboutController extends Controller
{
    public function index()
    {
        try {
            $contents = AboutContent::active()->ordered()->get();

            $aboutData = [
                'hero' => $contents->where('section_key', 'hero')->first(),
                'arena' => $contents->where('section_key', 'arena')->first(),
                'komunitas' => $contents->where('section_key', 'komunitas')->first(),
                'tribun' => $contents->where('section_key', 'tribun')->first(),
                'full_description' => $contents->where('section_key', 'full_description')->first(),
            ];

            $facilities = Facility::active()->ordered()->get();

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

            return Inertia::render('About/About', [
                'auth' => [
                    'client' => auth('client')->user()
                ],
                'aboutData' => $aboutData,
                'facilities' => $facilities,
                'activeEventNotif' => $eventNotifData,
            ]);

        } catch (\Exception $e) {
            Log::error('Error loading about page: ' . $e->getMessage());
            
            return Inertia::render('About/About', [
                'auth' => [
                    'client' => auth('client')->user()
                ],
                'aboutData' => [
                    'hero' => null,
                    'arena' => null,
                    'komunitas' => null,
                    'tribun' => null,
                    'full_description' => null,
                ],
                'facilities' => [],
                'activeEventNotif' => null,
            ]);
        }
    }
}