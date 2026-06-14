<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class WhatsappService
{
    public function send(
        ?string $phone,
        string $message
    ): bool {

        if (!$phone) {
            return false;
        }

        try {

            $phone = $this->formatPhone($phone);

            $twilio = new Client(
                env('TWILIO_SID'),
                env('TWILIO_AUTH_TOKEN')
            );

            $response = $twilio->messages->create(
                'whatsapp:' . $phone,
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'body' => $message,
                ]
            );

            Log::info('WA TERKIRIM', [
                'phone' => $phone,
                'sid' => $response->sid,
            ]);

            return true;

        } catch (\Throwable $e) {

            Log::error('WA GAGAL', [
                'phone' => $phone,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function formatPhone(
        string $phone
    ): string {

        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '08')) {

            $phone = '62' . substr($phone, 1);

        } elseif (str_starts_with($phone, '8')) {

            $phone = '62' . $phone;

        } elseif (str_starts_with($phone, '62')) {

            // biarkan

        }

        return '+' . $phone;
    }
}