<?php

namespace App\Jobs;

use App\Models\Reservation;
use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendReservationApprovedWhatsappJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $reservationId;

    public function __construct(string $reservationId)
    {
        $this->reservationId = $reservationId;
    }

    public function handle(): void
    {
        $Reservation = Reservation::with([
            'room.floor.building',
            'user'
        ])->find($this->reservationId);

        if (!$Reservation) {
            return;
        }

        $message =
            "🎉 *RESERVASI RUSUNAWA UNIVERSITAS DIPONEGORO BERHASIL DIVERIFIKASI*\n\n" .

            "Kepada Yth. *{$Reservation->guest_name}*,\n\n" .

            "Selamat! Reservasi Anda telah disetujui oleh Admin Rusunawa UNDIP.\n\n" .

            "*Kode Reservasi:* {$Reservation->reservation_code}\n" .
            "*NIM:* {$Reservation->guest_nim}\n" .
            "*Gedung:* " . ($Reservation->room?->floor?->building?->name ?? '-') . "\n" .
            "*Lantai:* " . ($Reservation->room?->floor?->floor_number ?? '-') . "\n" .
            "*Kamar:* " . ($Reservation->room?->kode_kamar ?? '-') . "\n" .
            "*Status:* AKTIF\n\n" .

            "Tanggal Verifikasi: " .
            now()->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') .
            " WIB\n\n" .

            "*SIRKA Rusunawa UNDIP*";

        app(WhatsappService::class)
            ->send(
                $Reservation->contact_phone,
                $message
            );
    }
}
