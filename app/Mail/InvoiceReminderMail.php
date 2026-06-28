<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Mail\Mailable;

class InvoiceReminderMail extends Mailable
{
    public function __construct(
        public Invoice $invoice
    ) {}

    public function build()
    {
        return $this
            ->subject('Pengingat Pembayaran Rusunawa UNDIP')
            ->view('emails.invoice-reminder');
    }
}
