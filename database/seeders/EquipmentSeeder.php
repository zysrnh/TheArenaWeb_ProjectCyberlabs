<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $equipments = [
            [
                'name' => 'Bola Basket Spalding',
                'category' => 'bola_basket',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'price_per_item' => 10000,
                'stock' => 15,
                'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800',
                'is_available' => true,
            ],
            [
                'name' => 'Ring Portable',
                'category' => 'ring_portable',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea',
                'price_per_item' => 500000,
                'stock' => 3,
                'image' => 'https://images.unsplash.com/photo-1519861531473-9200262188bf?w=800',
                'is_available' => true,
            ],
            [
                'name' => 'Rompi Basket',
                'category' => 'rompi',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'price_per_item' => 10000,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1608245449230-4ac19066d2d0?w=800',
                'is_available' => true,
            ],
            [
                'name' => 'Cone/Marker',
                'category' => 'cone',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea',
                'price_per_item' => 5000,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800',
                'is_available' => true,
            ],
            [
                'name' => 'Stopwatch',
                'category' => 'stopwatch',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'price_per_item' => 25000,
                'stock' => 10,
                'image' => 'https://images.unsplash.com/photo-1519861531473-9200262188bf?w=800',
                'is_available' => true,
            ],
        ];

        foreach ($equipments as $equipment) {
            DB::table('equipment')->insert(array_merge($equipment, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}