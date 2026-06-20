<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    /**
     * Get Midtrans Snap Token for a paid registration.
     */
    public static function getSnapToken(int $registrationId, int $amount, $user, $eventTitle, $createdAt = null): string
    {
        $serverKey = config('services.midtrans.server_key');
        
        if (empty($serverKey)) {
            Log::error('Midtrans Server Key is not configured in services config.');
            throw new \Exception('Metode pembayaran sedang tidak siap. Silakan hubungi admin.');
        }

        $authHeader = 'Basic ' . base64_encode($serverKey . ':');
        $timestamp = $createdAt ? strtotime($createdAt) : time();

        $payload = [
            'transaction_details' => [
                'order_id' => 'REG-' . $registrationId . '-' . $timestamp,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => 'EVENT-' . $registrationId,
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => substr($eventTitle, 0, 50),
                ]
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => $authHeader,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $payload);

            if ($response->successful()) {
                $token = $response->json('token');
                if ($token) {
                    return $token;
                }
            }

            Log::error('Midtrans Snap Error response: ' . $response->body());
            throw new \Exception('Gagal mendapatkan token pembayaran dari Midtrans.');
        } catch (\Exception $e) {
            Log::error('Midtrans API exception: ' . $e->getMessage());
            throw new \Exception('Terjadi kesalahan saat menghubungi payment gateway: ' . $e->getMessage());
        }
    }

    /**
     * Get transaction status from Midtrans API.
     */
    public static function getTransactionStatus(string $orderId): ?string
    {
        $serverKey = config('services.midtrans.server_key');
        if (empty($serverKey)) {
            return null;
        }

        $authHeader = 'Basic ' . base64_encode($serverKey . ':');

        try {
            $response = Http::withHeaders([
                'Authorization' => $authHeader,
                'Accept' => 'application/json',
            ])->get("https://api.sandbox.midtrans.com/v2/{$orderId}/status");

            if ($response->successful()) {
                return $response->json('transaction_status');
            }
        } catch (\Exception $e) {
            Log::error('Midtrans getTransactionStatus exception: ' . $e->getMessage());
        }

        return null;
    }
}
