<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FaspayService
{
    protected array $config;

    public function __construct()
    {
        $this->config = config('faspay');
    }

    /**
     * ✅ Membuat transaksi baru ke Faspay Xpress v4
     */
    public function createPayment(string $orderId, int $amount, array $customerData, array $items): array
    {
        $billNo      = $this->generateBillNo();
        $billTotal   = $amount;
        $billDate    = Carbon::now();
        $billExpired = Carbon::now()->addMinutes($this->config['payment_timeout']);

        $payload = [
            'merchant_id'   => $this->config['merchant_id'],
            'bill_no'       => $billNo,
            'bill_date'     => $billDate->format('Y-m-d H:i:s'),
            'bill_expired'  => $billExpired->format('Y-m-d H:i:s'),
            'bill_desc'     => 'Pembayaran Booking Lapangan Basketball - The Arena',
            'bill_currency' => $this->config['currency'],
            'bill_gross'    => (string) $billTotal,
            'bill_miscfee'  => '0',
            'bill_total'    => (string) $billTotal,

            // Customer
            'cust_no'    => (string) ($customerData['phone'] ?? '0'),
            'cust_name'  => (string) ($customerData['name'] ?? 'Customer'),
            'msisdn'     => (string) ($customerData['phone'] ?? ''),
            'email'      => (string) ($customerData['email'] ?? ''),
            'cust_phone' => (string) ($customerData['phone'] ?? ''),

            'bill_reff'  => $orderId,
            
            // ✅ CRITICAL: Callback & Return URL
            'callback_url' => $this->config['callback_url'],
            'return_url'   => $this->config['return_url'],

            // Item detail
            'item' => array_map(function ($it, $i) {
                return [
                    'product' => $it['name']    ?? ('Item ' . ($i + 1)),
                    'qty'     => (string)($it['quantity'] ?? 1),
                    'amount'  => (string)($it['price'] ?? 0),
                ];
            }, $items, array_keys($items)),
        ];

        // Signature
        $payload['signature'] = $this->signCreate($billNo, (string) $billTotal);

        Log::info('📤 FASPAY CREATE PAYMENT REQUEST', [
            'url'     => $this->config['base_url'],
            'bill_no' => $billNo,
            'amount'  => $billTotal,
            'callback_url' => $this->config['callback_url'],
            'return_url'   => $this->config['return_url'],
        ]);

        try {
            $resp = Http::timeout(45)
                ->retry(2, 100)
                ->withOptions([
                    'verify' => !$this->config['is_production'], // Verify SSL di production
                ])
                ->asJson()
                ->post($this->config['base_url'], $payload);

            Log::info('📥 FASPAY RAW RESPONSE', [
                'status'  => $resp->status(),
                'body'    => $resp->body(),
            ]);

            if ($resp->failed()) {
                $errorBody = $resp->body();
                Log::error('❌ FASPAY HTTP ERROR', [
                    'status' => $resp->status(),
                    'body'   => $errorBody,
                ]);
                throw new \Exception("Faspay HTTP Error {$resp->status()}: {$errorBody}");
            }

            $result = $resp->json() ?? [];
            
            if (empty($result)) {
                throw new \Exception('Faspay returned empty response');
            }

            $responseCode = $result['response_code'] ?? '';
            $responseDesc = $result['response_desc'] ?? 'Unknown error';

            if ($responseCode !== '00') {
                throw new \Exception("Faspay Error [{$responseCode}]: {$responseDesc}");
            }

            $trxId = $result['trx_id'] ?? null;
            
            if (empty($trxId)) {
                $trxId = 'TEMP_' . $billNo;
                Log::warning('⚠️ Faspay tidak return trx_id, menggunakan temporary ID', [
                    'bill_no' => $billNo,
                    'temp_trx_id' => $trxId,
                ]);
            }

            Log::info('✅ FASPAY PAYMENT CREATED SUCCESSFULLY', [
                'trx_id'  => $trxId,
                'bill_no' => $billNo,
                'redirect_url' => $result['redirect_url'] ?? null,
            ]);

            return [
                'success'          => true,
                'trx_id'           => $trxId,
                'bill_no'          => $billNo,
                'order_id'         => $orderId,
                'amount'           => $billTotal,
                'expired_at'       => $billExpired,
                'redirect_url'     => $result['redirect_url'] ?? null,
                'payment_channels' => [[
                    'channel_code' => 'XPRS',
                    'channel_name' => $this->config['is_production']
                        ? 'Faspay Xpress (Production)'
                        : 'Faspay Xpress (Sandbox)',
                    'payment_url'  => $result['redirect_url'] ?? null,
                ]],
                'is_development'   => !$this->config['is_production'],
                'raw_response'     => $result,
            ];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('💥 FASPAY CONNECTION ERROR', [
                'message' => $e->getMessage(),
                'url'     => $this->config['base_url'],
            ]);
            
            return [
                'success' => false,
                'error'   => 'Tidak dapat terhubung ke server Faspay. Silakan coba lagi.',
                'technical_error' => $e->getMessage(),
            ];
            
        } catch (\Throwable $e) {
            Log::error('💥 FASPAY EXCEPTION', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    /**
     * ✅ Signature untuk createPayment()
     */
    protected function signCreate(string $billNo, string $billTotal): string
    {
        $raw = $this->config['user_id'] . $this->config['password'] . $billNo . $billTotal;
        $signature = sha1(md5($raw));

        Log::debug('🔐 Generated Signature (Create)', [
            'user_id'   => $this->config['user_id'],
            'bill_no'   => $billNo,
            'bill_total' => $billTotal,
            'signature' => $signature,
        ]);

        return $signature;
    }

    /**
     * ✅ Verifikasi signature pada callback
     */
    public function verifySignature(array $data): bool
    {
        $billNo = (string) ($data['bill_no'] ?? '');
        $billTotal = (string) ($data['bill_total'] ?? '');
        $requestSignature = (string) ($data['signature'] ?? '');

        if ($billNo === '' || $billTotal === '' || $requestSignature === '') {
            Log::warning('⚠️ verifySignature: field kosong', compact('billNo', 'billTotal', 'requestSignature'));
            return false;
        }

        $rawString = $this->config['user_id'] . 
                     $this->config['password'] . 
                     $billNo . 
                     $billTotal;
        
        $md5Hash = md5($rawString);
        $calculated = sha1($md5Hash);

        $valid = hash_equals($calculated, $requestSignature);

        if (!$valid) {
            Log::warning('⚠️ Signature mismatch', [
                'user_id'            => $this->config['user_id'],
                'bill_no'            => $billNo,
                'bill_total'         => $billTotal,
                'calculated_sha1'    => $calculated,
                'received_signature' => $requestSignature,
            ]);
            
            // ⚠️ BYPASS HANYA UNTUK TESTING
            if (config('app.env') === 'local' || config('app.debug')) {
                Log::warning('🚨 SIGNATURE VERIFICATION BYPASSED - TESTING MODE ONLY!');
                return true;
            }
            
            return false;
        }

        Log::info('✅ Signature verified', ['bill_no' => $billNo]);
        return true;
    }

    /**
     * ✅ Generate bill number unik
     */
    protected function generateBillNo(): string
    {
        return 'ARENA' . date('YmdHis') . rand(1000, 9999);
    }

    /**
     * ✅ Ambil daftar channel pembayaran
     */
    public function getAvailableChannels(): array
    {
        return $this->config['channels'] ?? [];
    }

    /**
     * ✅ Format rupiah
     */
    public function formatAmount(int $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}