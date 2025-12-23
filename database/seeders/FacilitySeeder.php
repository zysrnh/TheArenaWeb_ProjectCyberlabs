<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama jika ada
        Facility::truncate();

        Facility::create([
            'name' => 'Cafe & Resto',
            'description' => null,
            'image_url' => 'images/test.jpg', // Path dari public
            'is_active' => true,
            'order' => 1,
        ]);

        Facility::create([
            'name' => 'Jual Makanan Ringan',
            'description' => null,
            'image_url' => 'images/test.jpg',
            'is_active' => true,
            'order' => 2,
        ]);

        Facility::create([
            'name' => 'Jual Minuman',
            'description' => null,
            'image_url' => 'images/test.jpg',
            'is_active' => true,
            'order' => 3,
        ]);

        Facility::create([
            'name' => 'Ruang Ganti',
            'description' => null,
            'image_url' => 'images/test.jpg',
            'is_active' => true,
            'order' => 4,
        ]);

        Facility::create([
            'name' => 'Parkir Luas',
            'description' => null,
            'image_url' => 'images/test.jpg',
            'is_active' => true,
            'order' => 5,
        ]);

        Facility::create([
            'name' => 'Wifi Gratis',
            'description' => null,
            'image_url' => 'images/test.jpg',
            'is_active' => true,
            'order' => 6,
        ]);

        Facility::create([
            'name' => 'Tribun Penonton',
            'description' => null,
            'image_url' => 'images/test.jpg',
            'is_active' => true,
            'order' => 7,
        ]);
    }
}