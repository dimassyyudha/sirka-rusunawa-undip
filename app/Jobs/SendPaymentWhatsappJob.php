<?php

namespace App\Jobs;

use App\Models\PaymentTransaction;
use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPaymentWhatsappJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $transactionId;

    public function __construct(string $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function handle(): void
    {
        $transaction = PaymentTransaction::with([
            'Reservation',
            'invoice',
            'Reservation.room.floor.building'
        ])->find($this->transactionId);

        if (!$transaction) {
            return;
        }

        $message =
            "✅ *PEMBAYARAN BERHASIL DITERIMA*\n\n" .
            "Nama : {$transaction->Reservation->guest_name}\n" .
            "Total : Rp " . number_format($transaction->gross_amount, 0, ',', '.') . "\n" .
            "Status : LUNAS";

        app(WhatsappService::class)
            ->send(
                $transaction->Reservation->contact_phone,
                $message
            );
    }
}
