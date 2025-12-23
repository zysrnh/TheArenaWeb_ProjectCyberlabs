<?php

namespace App\Http\Controllers;

use App\Models\AboutContent;
use App\Models\Facility; // ✅ Import Facility
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

            // ✅ Ambil fasilitas yang aktif
            $facilities = Facility::active()->ordered()->get();

            return Inertia::render('About/About', [
                'auth' => [
                    'client' => auth('client')->user()
                ],
                'aboutData' => $aboutData,
                'facilities' => $facilities, // ✅ Kirim ke frontend
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
            ]);
        }
    }
}