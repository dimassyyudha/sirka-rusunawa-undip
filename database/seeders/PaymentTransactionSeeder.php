<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\PaymentTransaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentTransactionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (
            Invoice::where('status', 'paid')->get()
            as $invoice
        ) {

            PaymentTransaction::create([

                'invoice_id' =>
                $invoice->id,

                'user_id' =>
                $invoice->user_id,

                'order_id' =>
                $invoice->invoice_number,

                'order_hash' =>
                Str::uuid(),

                'gross_amount' =>
                $invoice->amount,

                'payment_type' =>
                fake()->randomElement([
                    'bank_transfer',
                    'qris',
                    'gopay',
                ]),

                'transaction_status' =>
                'settlement',

                'payment_gateway' =>
                'midtrans',

                'paid_at' =>
                now(),
            ]);
        }
    }
}
