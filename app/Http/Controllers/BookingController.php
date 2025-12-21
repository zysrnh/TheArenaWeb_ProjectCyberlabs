<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Booking;
use App\Models\BookedTimeSlot;
use App\Models\Review;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $weekOffset = $request->get('week', 0);
        $selectedVenueType = $request->get('venue', 'pvj');

        $venues = [
            'cibadak_a' => [
                'id' => 1,
                'venue_type' => 'cibadak_a',
                'name' => 'The Arena Basketball Cibadak A',
                'location' => 'Jl. Cibadak No. 1A, Bandung',
                'description' => 'Lapangan Indoor Premium dengan Kayu Jati Berkualitas',
                'full_description' => 'The Arena Basketball Cibadak A merupakan lapangan basket indoor premium yang berlokasi di kawasan Cibadak. Dilengkapi dengan lantai kayu jati berkualitas tinggi, sistem ventilasi optimal, dan pencahayaan LED modern untuk pengalaman bermain terbaik.',
                'invitation' => 'Rasakan pengalaman bermain basket di lapangan premium dengan standar internasional. Fasilitas lengkap dan lokasi strategis membuat Cibadak A menjadi pilihan utama para pecinta basket di Bandung.',
                'price_per_session' => 350000,
                'images' => [
                    'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=1200',
                    'https://images.unsplash.com/photo-1519861531473-9200262188bf?w=1200',
                    'https://images.unsplash.com/photo-1608245449230-4ac19066d2d0?w=1200',
                    'https://images.unsplash.com/photo-1504450874802-0ba2bcd9b5ae?w=1200',
                    'https://images.unsplash.com/photo-1574623452334-1e0ac2b3ccb4?w=1200',
                ],
                'facilities' => [
                    'Cafe & Resto',
                    'Parkir Mobil Luas',
                    'Parkir Motor',
                    'Toilet Bersih',
                    'AC Central',
                    'Tribun Penonton',
                    'Sound System',
                    'Locker Room',
                ],
                'rules' => [
                    'Dilarang merokok di seluruh area lapangan.',
                    'Dilarang meludah di area lapangan.',
                    'Wajib menggunakan sepatu khusus basket indoor.',
                    'Dilarang membawa makanan dan minuman ke area lapangan.',
                    'Harap menjaga kebersihan dan barang bawaan masing-masing.',
                    'Pemain harus datang tepat waktu sesuai jadwal booking.',
                    'Customer wajib dalam kondisi sehat jasmani.',
                    'Lapangan tidak bertanggung jawab atas kehilangan barang pribadi.',
                ],
            ],

            'cibadak_b' => [
                'id' => 2,
                'venue_type' => 'cibadak_b',
                'name' => 'The Arena Basketball Cibadak B',
                'location' => 'Jl. Cibadak No. 1B, Bandung',
                'description' => 'Lapangan Outdoor dengan Pencahayaan LED Modern',
                'full_description' => 'The Arena Basketball Cibadak B adalah lapangan basket outdoor terbaik di Bandung. Dilengkapi dengan sistem pencahayaan LED berkualitas tinggi yang memungkinkan permainan hingga malam hari. Surface lapangan menggunakan material anti-slip untuk keamanan maksimal.',
                'invitation' => 'Nikmati sensasi bermain basket outdoor dengan view terbuka dan udara segar. Cocok untuk sesi latihan sore hingga malam hari dengan pencahayaan yang sempurna.',
                'price_per_session' => 300000,
                'images' => [
                    'https://images.unsplash.com/photo-1504450874802-0ba2bcd9b5ae?w=1200',
                    'https://images.unsplash.com/photo-1515523110800-9415d13b84a8?w=1200',
                    'https://images.unsplash.com/photo-1574623452334-1e0ac2b3ccb4?w=1200',
                    'https://images.unsplash.com/photo-1608245449230-4ac19066d2d0?w=1200',
                    'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=1200',
                ],
                'facilities' => [
                    'Kantin',
                    'Area Parkir Luas',
                    'Toilet',
                    'Lampu LED Premium',
                    'Tribun Penonton',
                    'Shower Room',
                ],
                'rules' => [
                    'Dilarang merokok di area lapangan.',
                    'Dilarang meludah sembarangan.',
                    'Wajib menggunakan sepatu olahraga.',
                    'Dilarang membawa sampah ke area lapangan.',
                    'Harap menjaga kebersihan fasilitas.',
                    'Pemain harus datang tepat waktu.',
                    'Customer wajib dalam kondisi sehat.',
                ],
            ],

            'pvj' => [
                'id' => 3,
                'venue_type' => 'pvj',
                'name' => 'The Arena Basketball PVJ',
                'location' => 'Mall PVJ Bandung Lt P3',
                'description' => 'Premium Mall Basketball Court - Indoor Arena',
                'full_description' => 'The Arena Basketball PVJ berlokasi strategis di lantai P3 Mall PVJ Bandung. Lapangan indoor dengan lantai kayu jati premium, sistem sirkulasi udara terbaik, dan akses mudah dari berbagai area kota. Ideal untuk komunitas basket dan acara turnamen.',
                'invitation' => 'Main basket di pusat kota! Akses mudah, fasilitas mall lengkap, dan arena premium menanti Anda. Perfect untuk after-work basketball session.',
                'price_per_session' => 350000,
                'images' => [
                    'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=1200',
                    'https://images.unsplash.com/photo-1519861531473-9200262188bf?w=1200',
                    'https://images.unsplash.com/photo-1608245449230-4ac19066d2d0?w=1200',
                    'https://images.unsplash.com/photo-1504450874802-0ba2bcd9b5ae?w=1200',
                    'https://images.unsplash.com/photo-1574623452334-1e0ac2b3ccb4?w=1200',
                ],
                'facilities' => [
                    'Cafe & Resto',
                    'Parkir Mall 24 Jam',
                    'Food Court Access',
                    'Toilet Premium',
                    'AC Central',
                    'Tribun VIP',
                    'WiFi Gratis',
                ],
                'rules' => [
                    'Dilarang merokok di seluruh area mall.',
                    'Dilarang meludah di area lapangan.',
                    'Wajib menggunakan sepatu khusus basket indoor.',
                    'Dilarang membawa makanan berbau tajam ke area lapangan.',
                    'Harap menjaga barang bawaan pribadi.',
                    'Pemain harus datang sesuai jadwal booking.',
                    'Customer wajib dalam kondisi sehat.',
                    'Pihak lapangan tidak bertanggung jawab atas kecelakaan akibat kelalaian pemain.',
                ],
            ],

            'urban' => [
                'id' => 4,
                'venue_type' => 'urban',
                'name' => 'The Arena Basketball Urban',
                'location' => 'Jl. Urban Complex No. 88, Bandung',
                'description' => 'Ultra-Modern Indoor Arena di Jantung Kota',
                'full_description' => 'The Arena Basketball Urban adalah lapangan basket indoor paling modern di Bandung. Mengusung konsep international standard dengan teknologi scoring digital, AC central, sound system premium, dan viewing deck untuk spectator. Lokasi strategis di pusat bisnis Bandung.',
                'invitation' => 'Experience basketball like never before! Fasilitas bintang 5, teknologi modern, dan atmosfer profesional untuk pemain yang menginginkan yang terbaik.',
                'price_per_session' => 400000,
                'images' => [
                    'https://images.unsplash.com/photo-1574623452334-1e0ac2b3ccb4?w=1200',
                    'https://images.unsplash.com/photo-1515523110800-9415d13b84a8?w=1200',
                    'https://images.unsplash.com/photo-1504450874802-0ba2bcd9b5ae?w=1200',
                    'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=1200',
                    'https://images.unsplash.com/photo-1519861531473-9200262188bf?w=1200',
                ],
                'facilities' => [
                    'Cafe Premium',
                    'Parkir Basement Security',
                    'Locker Room Premium',
                    'Shower Room',
                    'AC Central',
                    'Sound System Premium',
                    'Tribun VIP',
                    'Digital Scoreboard',
                    'WiFi High Speed',
                ],
                'rules' => [
                    'Dilarang merokok di seluruh area.',
                    'Wajib menggunakan sepatu indoor khusus basket.',
                    'Wajib sewa locker untuk barang berharga.',
                    'Dilarang membawa makanan dari luar.',
                    'Harap menjaga kebersihan dan fasilitas.',
                    'Pemain harus datang tepat waktu.',
                    'Customer wajib dalam kondisi prima.',
                    'Lapangan tidak bertanggung jawab atas cedera akibat kelalaian pribadi.',
                ],
            ],
        ];

        $venue = $venues[$selectedVenueType] ?? $venues['pvj'];
        $schedules = $this->generateSchedules($weekOffset);

        // ✅ UPDATE: Ambil review dengan 3 aspek rating
        $reviews = Review::with('client:id,name,profile_image')
            ->approved() // ← TAMBAHKAN INI
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($review) {
                return [
                    'id' => $review->id,
                    'client_name' => $review->client->name,
                    'client_profile_image' => $review->client->profile_image,
                    'rating' => $review->rating,
                    'rating_facilities' => $review->rating_facilities,
                    'rating_hospitality' => $review->rating_hospitality,
                    'rating_cleanliness' => $review->rating_cleanliness,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at->diffForHumans(),
                ];
            });

        return Inertia::render('HomePage/Booking/Booking', [
            'auth' => [
                'client' => Auth::guard('client')->user()
            ],
            'venue' => $venue,
            'venues' => $venues,
            'schedules' => $schedules,
            'currentWeek' => $weekOffset,
            'reviews' => $reviews,
        ]);
    }

    private function generateSchedules($weekOffset = 0)
    {
        $schedules = [];
        $startDate = Carbon::now()->startOfWeek()->addWeeks((int)$weekOffset);

        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dayName = $days[$date->dayOfWeek];

            $schedules[] = [
                'date' => $date->format('Y-m-d'),
                'day_name' => $dayName,
                'date_number' => $date->format('d'),
                'month' => $date->format('F'),
                'year' => $date->format('Y'),
                'display_date' => $dayName . ', ' . $date->format('d F Y'),
                'is_past' => $date->lt(Carbon::today()),
            ];
        }

        return $schedules;
    }

    public function getTimeSlots(Request $request)
    {
        $date = $request->input('date');
        $venueType = $request->input('venue_type', 'indoor');

        $allTimeSlots = [
            ['time' => '06.00 - 08.00', 'duration' => 120, 'price' => 350000],
            ['time' => '08.00 - 10.00', 'duration' => 120, 'price' => 350000],
            ['time' => '10.00 - 12.00', 'duration' => 120, 'price' => 350000],
            ['time' => '12.00 - 14.00', 'duration' => 120, 'price' => 350000],
            ['time' => '14.00 - 16.00', 'duration' => 120, 'price' => 350000],
            ['time' => '16.00 - 18.00', 'duration' => 120, 'price' => 350000],
            ['time' => '18.00 - 20.00', 'duration' => 120, 'price' => 350000],
            ['time' => '20.00 - 22.00', 'duration' => 120, 'price' => 350000],
            ['time' => '22.00 - 00.00', 'duration' => 120, 'price' => 350000],
        ];

        $bookedSlots = BookedTimeSlot::where('date', $date)
            ->where('venue_type', $venueType)
            ->whereHas('booking', function ($query) {
                $query->whereIn('status', ['pending', 'confirmed']);
            })
            ->pluck('time_slot')
            ->toArray();

        $timeSlots = array_map(function ($slot) use ($bookedSlots) {
            $slot['status'] = in_array($slot['time'], $bookedSlots) ? 'booked' : 'available';
            return $slot;
        }, $allTimeSlots);

        return response()->json([
            'success' => true,
            'time_slots' => $timeSlots,
        ]);
    }

    public function processBooking(Request $request)
    {
        $validated = $request->validate([
            'venue_id' => 'required|integer',
            'date' => 'required|date|after_or_equal:today',
            'time_slots' => 'required|array|min:1',
            'time_slots.*.time' => 'required|string',
            'time_slots.*.price' => 'required|numeric',
            'time_slots.*.duration' => 'required|numeric',
            'venue_type' => 'required|string|in:cibadak_a,cibadak_b,pvj,urban',
        ]);

        if (!Auth::guard('client')->check()) {
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

        try {
            DB::beginTransaction();

            $requestedSlots = array_column($validated['time_slots'], 'time');
            $alreadyBooked = BookedTimeSlot::where('date', $validated['date'])
                ->where('venue_type', $validated['venue_type'])
                ->whereIn('time_slot', $requestedSlots)
                ->whereHas('booking', function ($query) {
                    $query->whereIn('status', ['pending', 'confirmed']);
                })
                ->exists();

            if ($alreadyBooked) {
                DB::rollBack();

                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maaf, ada slot waktu yang sudah dibooking oleh orang lain. Silakan pilih slot waktu lain.'
                    ], 422);
                }

                return back()->withErrors([
                    'message' => 'Maaf, ada slot waktu yang sudah dibooking oleh orang lain. Silakan pilih slot waktu lain.'
                ]);
            }

            $totalPrice = array_sum(array_column($validated['time_slots'], 'price'));

            $booking = Booking::create([
                'client_id' => Auth::guard('client')->id(),
                'venue_id' => $validated['venue_id'],
                'booking_date' => $validated['date'],
                'venue_type' => $validated['venue_type'],
                'time_slots' => $validated['time_slots'],
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            foreach ($validated['time_slots'] as $slot) {
                BookedTimeSlot::create([
                    'booking_id' => $booking->id,
                    'date' => $validated['date'],
                    'time_slot' => $slot['time'],
                    'venue_type' => $validated['venue_type'],
                ]);
            }

            DB::commit();

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Booking berhasil! Silakan lanjutkan ke pembayaran.',
                    'booking_id' => $booking->id,
                    'redirect_to_profile' => true,
                ]);
            }

            return back()->with([
                'flash' => [
                    'success' => true,
                    'message' => 'Booking berhasil! Silakan lanjutkan ke pembayaran.',
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

    // ========== METHOD BARU UNTUK REVIEW ========== //

    /**
     * ✅ UPDATE: Simpan review dengan 3 aspek rating
     */
    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'rating_facilities' => 'required|integer|min:1|max:5',
            'rating_hospitality' => 'required|integer|min:1|max:5',
            'rating_cleanliness' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000|min:10',
        ]);

        if (!Auth::guard('client')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        try {
            // Cek apakah user pernah booking yang sudah confirmed dan sudah lewat
            $hasCompletedBooking = Booking::where('client_id', Auth::guard('client')->id())
                ->where('status', 'confirmed')
                ->where('booking_date', '<', now()->toDateString())
                ->exists();

            if (!$hasCompletedBooking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus menyelesaikan booking terlebih dahulu untuk memberikan ulasan.'
                ], 422);
            }

            // Cek apakah user sudah pernah review
            $existingReview = Review::where('client_id', Auth::guard('client')->id())
                ->first();

            if ($existingReview) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah memberikan ulasan sebelumnya.'
                ], 422);
            }

            // Ambil booking terakhir yang sudah selesai
            $lastBooking = Booking::where('client_id', Auth::guard('client')->id())
                ->where('status', 'confirmed')
                ->where('booking_date', '<', now()->toDateString())
                ->latest('booking_date')
                ->first();

            // ✅ Hitung rating rata-rata untuk backward compatibility
            $averageRating = round(
                ($validated['rating_facilities'] + $validated['rating_hospitality'] + $validated['rating_cleanliness']) / 3
            );

            $review = Review::create([
                'client_id' => Auth::guard('client')->id(),
                'booking_id' => $lastBooking->id,
                'rating' => $averageRating,
                'rating_facilities' => $validated['rating_facilities'],
                'rating_hospitality' => $validated['rating_hospitality'],
                'rating_cleanliness' => $validated['rating_cleanliness'],
                'comment' => $validated['comment'],
                'is_approved' => false, // ✅ Default pending approval
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Terima kasih! Ulasan Anda akan ditampilkan setelah diverifikasi oleh admin.', // ✅ UPDATE MESSAGE
                'review' => [
                    'id' => $review->id,
                    'client_name' => Auth::guard('client')->user()->name,
                    'rating' => $review->rating,
                    'rating_facilities' => $review->rating_facilities,
                    'rating_hospitality' => $review->rating_hospitality,
                    'rating_cleanliness' => $review->rating_cleanliness,
                    'comment' => $review->comment,
                    'created_at' => 'Baru saja',
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ UPDATE: Ambil review dengan 3 aspek rating
     */
    public function getReviews()
    {
        // ✅ UPDATE: Hanya ambil approved reviews
        $reviews = Review::with('client:id,name,profile_image')
            ->approved() // ← TAMBAHKAN INI
            ->latest()
            ->take(8)
            ->get()
            ->map(function ($review) {
                return [
                    'id' => $review->id,
                    'client_name' => $review->client->name,
                    'client_profile_image' => $review->client->profile_image,
                    'rating' => $review->rating,
                    'rating_facilities' => $review->rating_facilities,
                    'rating_hospitality' => $review->rating_hospitality,
                    'rating_cleanliness' => $review->rating_cleanliness,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'reviews' => $reviews
        ]);
    }
}
