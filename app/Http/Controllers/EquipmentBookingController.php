<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EquipmentBookingController extends Controller
{
    public function index()
    {
        // Get all unique categories
        $categories = Equipment::where('is_available', true)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->toArray();

        $equipments = Equipment::where('is_available', true)
            ->get()
            ->map(function ($equipment) {
                return [
                    'id' => $equipment->id,
                    'name' => $equipment->name,
                    'category' => $equipment->category,
                    'description' => $equipment->description,
                    'price_per_item' => $equipment->price_per_item,
                    'formatted_price' => $equipment->formatted_price,
                    'image' => $equipment->main_image,
                    'images' => $equipment->images,
                ];
            });

        return Inertia::render('EquipmentBooking/EquipmentBooking', [
            'auth' => [
                'client' => Auth::guard('client')->user()
            ],
            'equipments' => $equipments,
            'categories' => $categories,
        ]);
    }

    public function show($id)
    {
        $equipment = Equipment::where('id', $id)
            ->where('is_available', true)
            ->firstOrFail();

        $otherEquipments = Equipment::where('is_available', true)
            ->where('id', '!=', $id)
            ->limit(3)
            ->get()
            ->map(function ($equipment) {
                return [
                    'id' => $equipment->id,
                    'name' => $equipment->name,
                    'category' => $equipment->category,
                    'description' => $equipment->description,
                    'price_per_item' => $equipment->price_per_item,
                    'formatted_price' => $equipment->formatted_price,
                    'image' => $equipment->main_image,
                    'images' => $equipment->images,
                ];
            });

        return Inertia::render('EquipmentBooking/EquipmentDetail', [
            'auth' => [
                'client' => Auth::guard('client')->user()
            ],
            'equipment' => [
                'id' => $equipment->id,
                'name' => $equipment->name,
                'category' => $equipment->category,
                'description' => $equipment->description,
                'price_per_item' => $equipment->price_per_item,
                'formatted_price' => $equipment->formatted_price,
                'image' => $equipment->main_image,
                'images' => $equipment->images,
            ],
            'otherEquipments' => $otherEquipments,
        ]);
    }
    
    public function getEquipments(Request $request)
    {
        $search = $request->get('search', '');
        $category = $request->get('category', 'Semua');

        $query = Equipment::where('is_available', true);

        // Filter by category
        if ($category && $category !== 'Semua') {
            $query->where('category', $category);
        }

        // Filter by search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $equipments = $query->get()->map(function ($equipment) {
            return [
                'id' => $equipment->id,
                'name' => $equipment->name,
                'category' => $equipment->category,
                'description' => $equipment->description,
                'price_per_item' => $equipment->price_per_item,
                'formatted_price' => $equipment->formatted_price,
                'image' => $equipment->main_image,
                'images' => $equipment->images,
            ];
        });

        return response()->json([
            'success' => true,
            'equipments' => $equipments,
        ]);
    }

    public function processBooking(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::guard('client')->check()) {
            // Cek apakah request dari API atau Web
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu untuk melakukan booking.'
                ], 401);
            }
            return back()->withErrors([
                'message' => 'Silakan login terlebih dahulu untuk melakukan booking.'
            ]);
        }

        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'quantity' => 'required|integer|min:1',
            'duration_hours' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $equipment = Equipment::findOrFail($validated['equipment_id']);

            $totalPrice = $equipment->price_per_item * $validated['quantity'] * $validated['duration_hours'];

            $booking = EquipmentBooking::create([
                'client_id' => Auth::guard('client')->id(),
                'equipment_id' => $validated['equipment_id'],
                'booking_date' => $validated['booking_date'],
                'quantity' => $validated['quantity'],
                'duration_hours' => $validated['duration_hours'],
                'total_price' => $totalPrice,
                'status' => 'pending',
                'notes' => $validated['notes'],
            ]);

            DB::commit();

            // Return response based on request type
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Booking berhasil dibuat!',
                    'booking' => [
                        'id' => $booking->id,
                        'equipment_name' => $equipment->name,
                        'booking_date' => $booking->booking_date->format('d M Y'),
                        'quantity' => $booking->quantity,
                        'duration_hours' => $booking->duration_hours,
                        'formatted_total_price' => $booking->formatted_total_price,
                        'status' => $booking->status,
                    ],
                ]);
            }

            return back()->with([
                'flash' => [
                    'success' => true,
                    'message' => 'Booking berhasil dibuat!',
                    'booking_id' => $booking->id,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memproses booking: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors([
                'message' => 'Terjadi kesalahan saat memproses booking: ' . $e->getMessage()
            ]);
        }
    }
}