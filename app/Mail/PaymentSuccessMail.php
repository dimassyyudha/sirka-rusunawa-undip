<?php

namespace App\Mail;

use App\Models\PaymentTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public PaymentTransaction $transaction;

    public function __construct(PaymentTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function build()
    {
        return $this
            ->subject(
                'Pembayaran Rusunawa Berhasil - ' .
                    $this->transaction->order_id
            )
            ->view('emails.payment-success');
    }
}
