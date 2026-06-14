<?php

namespace App\Jobs;

use App\Mail\ReservationApprovedMail;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendReservationApprovedMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $reservationId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $reservationId)
    {
        $this->reservationId = $reservationId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $Reservation = Reservation::with([
            'room.floor.building',
            'user',
        ])->find($this->reservationId);

        if (!$Reservation) {
            return;
        }

        if (!$Reservation->contact_email) {
            return;
        }

        try {
            Log::info('EMAIL VERIFIKASI TERKIRIM', [
                'reservation_code' => $Reservation->reservation_code,
                'email' => $Reservation->contact_email,
            ]);

            Mail::to($Reservation->contact_email)
                ->send(
                    new ReservationApprovedMail(
                        $Reservation
                    )
                );
            Log::info('SESUDAH SEND EMAIL');
        } catch (\Throwable $e) {

            Log::error('EMAIL VERIFIKASI GAGAL', [
                'reservation_code' => $Reservation->reservation_code,
                'email' => $Reservation->contact_email,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
