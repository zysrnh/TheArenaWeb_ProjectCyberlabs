<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventNotif;
use Carbon\Carbon;

class EventNotifSeeder extends Seeder
{
    public function run(): void
    {
        // Event aktif (hanya 1)
        EventNotif::create([
            'title' => '🏀 Tournament Basketball Championship 2026',
            'description' => 'Ikuti turnamen basket terbesar tahun ini! Kompetisi seru dengan hadiah jutaan rupiah. Terbuka untuk semua kategori umur. Buruan daftar sebelum kuota penuh!',
            'image' => null,
            'event_date' => Carbon::now()->addDays(30),
            'event_time' => '09:00:00',
            'location' => 'The Arena PVJ - Bandung',
            'monthly_original_price' => 500000,
            'monthly_price' => 350000,
            'monthly_discount_percent' => 30,
            'weekly_price' => 100000,
            'whatsapp_number' => '081222977985',
            'whatsapp_message' => 'Halo! Saya ingin mendaftar untuk Tournament Basketball Championship 2026. Mohon info lebih lanjut.',
            'is_active' => true,
        ]);

        // Event lain (non-aktif)
        EventNotif::create([
            'title' => '🎤 Music Festival 2026',
            'description' => 'Nikmati konser musik spektakuler dengan artis nasional dan internasional. Tiket terbatas!',
            'image' => 'https://example.com/banner-musicfest.jpg',
            'event_date' => Carbon::now()->addDays(60),
            'event_time' => '18:30:00',
            'location' => 'Jakarta Convention Center',
            'monthly_original_price' => 750000,
            'monthly_price' => 600000,
            'monthly_discount_percent' => 20,
            'weekly_price' => 200000,
            'whatsapp_number' => '081300112233',
            'whatsapp_message' => 'Halo! Saya tertarik dengan Music Festival 2026. Mohon info tiket.',
            'is_active' => false,
        ]);

        EventNotif::create([
            'title' => '🏃 Fun Run Charity 2026',
            'description' => 'Lari bersama untuk amal! Semua hasil akan disumbangkan ke yayasan anak.',
            'image' => null,
            'event_date' => Carbon::now()->addDays(90),
            'event_time' => '06:00:00',
            'location' => 'Gasibu - Bandung',
            'weekly_price' => 50000,
            'whatsapp_number' => '081400223344',
            'whatsapp_message' => 'Halo! Saya ingin daftar Fun Run Charity 2026.',
            'is_active' => false,
        ]);
    }
}