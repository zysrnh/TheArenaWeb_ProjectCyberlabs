<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\FaspayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $faspay;

    public function __construct(FaspayService $faspay)
    {
        $this->faspay = $faspay;
    }

    /**
     * ✅ Process payment untuk booking
     */
    public function process(Request $request, $bookingId)
    {
        try {
            $booking = Booking::with('client')->findOrFail($bookingId);

            // ✅ Authorization check
            if ($booking->client_id !== auth('client')->id()) {
                return redirect()->route('profile')->with('error', 'Unauthorized');
            }

            // ✅ Check if already paid
            if ($booking->isPaid()) {
                return redirect()->route('profile')->with('info', 'Booking ini sudah dibayar');
            }

            // ✅ Prepare data untuk createPayment()
            $orderId = (string) $booking->id;
            $amount = (int) $booking->total_price;
            
            // Customer data
            $customerData = [
                'name'  => $booking->client->name ?? 'Customer',
                'email' => $booking->client->email ?? '',
                'phone' => $booking->client->phone ?? '',
            ];

            // Items detail
            $venueType = match($booking->venue_type) {
                'full_court' => 'Full Court',
                'half_court' => 'Half Court',
                default => 'Lapangan Basket',
            };

            // ✅ FIX: Calculate price per item (bukan total)
            $quantity = count($booking->time_slots ?? []);
            $pricePerItem = $quantity > 0 ? (int)($amount / $quantity) : $amount;

            $items = [
                [
                    'name'     => "Booking {$venueType} - " . $booking->booking_date->format('d/m/Y'),
                    'quantity' => $quantity,
                    'price'    => $pricePerItem, // ✅ Price per item, NOT total
                ],
            ];

            Log::info('🏀 Creating Faspay Payment', [
                'booking_id'   => $bookingId,
                'order_id'     => $orderId,
                'amount'       => $amount,
                'customer'     => $customerData['name'],
                'venue_type'   => $booking->venue_type,
                'booking_date' => $booking->booking_date,
            ]);

            // ✅ Call createPayment dengan 4 parameter yang benar
            $result = $this->faspay->createPayment($orderId, $amount, $customerData, $items);

            if ($result['success'] && isset($result['redirect_url'])) {
                // ✅ Update booking dengan payment data
                $booking->update([
                    'bill_no'        => $result['bill_no'],
                    'trx_id'         => $result['trx_id'] ?? null,
                    'payment_status' => 'pending',
                ]);

                Log::info('✅ Booking updated, redirecting to Faspay', [
                    'booking_id' => $bookingId,
                    'bill_no'    => $result['bill_no'],
                    'redirect'   => $result['redirect_url'],
                ]);

                // ✅ Redirect ke halaman pembayaran Faspay
                return redirect()->away($result['redirect_url']);
            }

            // ✅ Handle payment creation failure
            $errorMessage = $result['error'] ?? $result['technical_error'] ?? 'Unknown error';
            
            Log::error('❌ Faspay Payment Creation Failed', [
                'booking_id' => $bookingId,
                'error'      => $errorMessage,
                'result'     => $result,
            ]);

            return redirect()->route('profile')->with('error', 'Gagal membuat pembayaran: ' . $errorMessage);

        } catch (\Exception $e) {
            Log::error('💥 Payment Process Exception', [
                'booking_id' => $bookingId,
                'message'    => $e->getMessage(),
                'file'       => $e->getFile(),
                'line'       => $e->getLine(),
            ]);
            
            return redirect()->route('profile')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * ✅ Callback dari Faspay (server-to-server)
     */
    public function callback(Request $request)
{
    // ✅ TAMBAH: Log raw callback data
    Log::info('🔥 RAW CALLBACK DATA', [
        'all_data' => $request->all(),
        'bill_no' => $request->input('bill_no'),
        'payment_status_code' => $request->input('payment_status_code'),
        'signature' => $request->input('signature'),
    ]);

    try {
        // ✅ Verify signature
        $signatureValid = $this->faspay->verifySignature($request->all());
        
        Log::info('🔐 Signature Verification', [
            'is_valid' => $signatureValid,
            'received_signature' => $request->input('signature'),
        ]);

        if (!$signatureValid) {
            Log::error('❌ Invalid Signature', [
                'received_data' => $request->all(),
            ]);
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid signature'
            ], 400);
        }

        $billNo            = $request->input('bill_no');
        $paymentStatusCode = $request->input('payment_status_code');
        $paymentMethod     = $request->input('payment_channel_name', 'Unknown');
        $trxId             = $request->input('trx_id');

        // ✅ Map payment status code ke internal status
        $paymentStatus = $this->mapPaymentStatus($paymentStatusCode);

        Log::info('📋 Payment Status Mapping', [
            'status_code' => $paymentStatusCode,
            'mapped_status' => $paymentStatus,
        ]);

        // ✅ Find booking by bill_no
        $booking = Booking::where('bill_no', $billNo)->first();

        if (!$booking) {
            Log::error('❌ Booking Not Found', [
                'bill_no' => $billNo,
            ]);
            return response()->json([
                'status'  => 'error',
                'message' => 'Booking not found'
            ], 404);
        }

        Log::info('🔍 BEFORE UPDATE', [
            'booking_id' => $booking->id,
            'current_payment_status' => $booking->payment_status,
            'current_is_paid' => $booking->is_paid,
            'current_status' => $booking->status,
        ]);

        // ✅ Update booking
        DB::beginTransaction();

        $booking->update([
            'trx_id'         => $trxId,
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentStatus,
            'paid_at'        => $paymentStatus === 'paid' ? now() : null,
            'is_paid'        => $paymentStatus === 'paid',
            'status'         => $paymentStatus === 'paid' ? 'confirmed' : $booking->status,
        ]);

        DB::commit();

        // ✅ REFRESH dan LOG AFTER UPDATE
        $booking->refresh();
        
        Log::info('✅ AFTER UPDATE - Booking Updated Successfully', [
            'booking_id'     => $booking->id,
            'bill_no'        => $billNo,
            'trx_id'         => $booking->trx_id,
            'payment_status' => $booking->payment_status,
            'is_paid'        => $booking->is_paid,
            'status'         => $booking->status,
            'paid_at'        => $booking->paid_at,
        ]);

        return response()->json(['status' => 'success'], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        
        Log::error('💥 Callback Processing Error', [
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
            'trace'   => $e->getTraceAsString(),
            'data'    => $request->all(),
        ]);
        
        return response()->json([
            'status'  => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}

    /**
     * ✅ Return URL (user kembali dari Faspay)
     * ⚠️ FIXED: Hapus parameter $bookingId, pakai bill_no dari query string
     */
    public function return(Request $request)
{
    try {
        $billNo = $request->query('bill_no');
        
        Log::info('📍 User Returned from Faspay', [
            'bill_no' => $billNo,
            'query'   => $request->query(),
        ]);

        if (!$billNo) {
            Log::warning('⚠️ No bill_no provided in return URL');
            return redirect()->route('profile')->with('info', 'Menunggu konfirmasi pembayaran.');
        }

        $booking = Booking::where('bill_no', $billNo)->first();

        if (!$booking) {
            Log::error('❌ Booking Not Found', ['bill_no' => $billNo]);
            return redirect()->route('profile')->with('error', 'Booking tidak ditemukan');
        }

        if ($booking->client_id !== auth('client')->id()) {
            Log::warning('⚠️ Unauthorized Access Attempt');
            return redirect()->route('profile')->with('error', 'Unauthorized');
        }

        $isPaid = $booking->isPaid();

        Log::info('📊 Payment Status Check', [
            'booking_id'     => $booking->id,
            'bill_no'        => $booking->bill_no,
            'is_paid'        => $isPaid,
            'payment_status' => $booking->payment_status,
        ]);

        // ✅ TAMBAHAN: Query param untuk trigger reload di frontend
        return redirect()->route('profile', ['from_payment' => 'true', 't' => time()])->with([
            'flash' => [
                'type'    => $isPaid ? 'success' : 'info',
                'message' => $isPaid 
                    ? '✅ Pembayaran berhasil! Booking Anda telah dikonfirmasi.' 
                    : '⏳ Menunggu konfirmasi pembayaran. Kami akan memberitahu Anda segera.',
            ]
        ]);

    } catch (\Exception $e) {
        Log::error('💥 Payment Return Error', [
            'message' => $e->getMessage(),
        ]);
        
        return redirect()->route('profile')->with('error', 'Terjadi kesalahan');
    }
}
    /**
     * ✅ Map Faspay payment status code ke internal status
     * 
     * Faspay Status Codes:
     * - 2: Success (Paid)
     * - 1: Pending
     * - 3: Failed
     * - 7: Expired
     * - 8: Cancelled
     */
    protected function mapPaymentStatus(string $statusCode): string
    {
        return match($statusCode) {
            '2'     => 'paid',
            '1'     => 'pending',
            '3'     => 'failed',
            '7'     => 'expired',
            '8'     => 'cancelled',
            default => 'pending',
        };
    }
}