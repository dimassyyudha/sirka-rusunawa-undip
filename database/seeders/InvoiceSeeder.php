<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Reservation;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Reservation::all() as $i => $reservation) {

            Invoice::create([

                'user_id' =>
                $reservation->user_id,

                'reservation_id' =>
                $reservation->reservation_id,

                'room_id' =>
                $reservation->room_id,

                'invoice_number' =>
                'INV-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),

                'invoice_type' =>
                'new',

                'amount' =>
                $reservation->total_price,

                'status' =>
                fake()->boolean(80)
                    ? 'paid'
                    : 'unpaid',

                'paid_at' =>
                now(),

                'due_at' =>
                now()->addDays(7),
            ]);
        }
    }
}
