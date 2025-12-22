<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sponsor;
use App\Models\Partner;
use Illuminate\Support\Facades\File;

class SponsorPartnerSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        Sponsor::truncate();
        Partner::truncate();

        // Buat folder jika belum ada
        $sponsorPath = storage_path('app/public/sponsors');
        $partnerPath = storage_path('app/public/partners');
        
        if (!File::exists($sponsorPath)) {
            File::makeDirectory($sponsorPath, 0755, true);
        }
        
        if (!File::exists($partnerPath)) {
            File::makeDirectory($partnerPath, 0755, true);
        }

        // ========================================
        // SPONSORS (Presented By)
        // ========================================
        Sponsor::create([
            'name' => 'Livin by Mandiri',
            'image' => 'sponsors/livin.jpg',
            'order' => 1,
            'is_active' => true,
        ]);

        Sponsor::create([
            'name' => 'KUY! Media Group',
            'image' => 'sponsors/kuymedia.png',
            'order' => 2,
            'is_active' => true,
        ]);

        // ========================================
        // PARTNERS (Official Partner)
        // ========================================
        $partners = [
            ['name' => 'University Esa Unggul', 'image' => 'partners/eve.jpg', 'order' => 1],
            ['name' => 'Bank BJB', 'image' => 'partners/bjb.png', 'order' => 2],
            ['name' => 'Perbasi Banten', 'image' => 'partners/pbanten.jpg', 'order' => 3],
            ['name' => 'Glory', 'image' => 'partners/glo.jpg', 'order' => 4],
            ['name' => 'Bina Bangsa School', 'image' => 'partners/bbs.png', 'order' => 5],
            ['name' => 'Play FIBA 3x3', 'image' => 'partners/fiba.jpg', 'order' => 6],
        ];

        foreach ($partners as $partner) {
            Partner::create([
                'name' => $partner['name'],
                'image' => $partner['image'],
                'order' => $partner['order'],
                'is_active' => true,
            ]);
        }

        $this->command->info('✅ Sponsors & Partners seeded successfully!');
        $this->command->info('⚠️  IMPORTANT: Copy your logo images to:');
        $this->command->info('   - storage/app/public/sponsors/');
        $this->command->info('   - storage/app/public/partners/');
    }
}