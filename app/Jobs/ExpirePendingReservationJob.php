<?php

namespace App\Jobs;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpirePendingReservationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $reservationId;

    public function __construct(string $reservationId)
    {
        $this->reservationId = $reservationId;
    }

    public function handle(): void
    {
        $reservation = Reservation::find($this->reservationId);

        if (!$reservation) {
            return;
        }

        if (
            $reservation->payment_status === 'pending' &&
            $reservation->status === 'pending' &&
            $reservation->payment_expired_at &&
            now()->greaterThanOrEqualTo(
                $reservation->payment_expired_at
            )
        ) {
            $reservation->update([
                'payment_status' => 'expired',
                'status' => 'expired',
            ]);
        }
    }
}
