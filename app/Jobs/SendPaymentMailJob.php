<?php

namespace App\Jobs;

use App\Mail\PaymentSuccessMail;
use App\Models\PaymentTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPaymentMailJob implements ShouldQueue
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
            'invoice'
        ])->find($this->transactionId);

        if (!$transaction) {
            return;
        }

        $email = $transaction->Reservation?->contact_email;

        if (!$email) {
            return;
        }

        Mail::to($email)
            ->send(
                new PaymentSuccessMail($transaction)
            );
    }
}
