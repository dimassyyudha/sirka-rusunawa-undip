<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendReservationApprovedMailJob;
use App\Jobs\SendReservationApprovedWhatsappJob;
use App\Models\Occupant;
use App\Models\Reservation;
use App\Models\Room;
use App\Services\WhatsappService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservationVerificationController extends Controller
{
    private function generateReservationCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Reservation::where('reservation_code', $code)->exists());

        return $code;
    }
    public function index()
    {
        $status = request('status');

        $query = Reservation::with([
            'room.floor.building',
            'user.studentProfile',
            'invoices',
        ]);

        /*
    |--------------------------------------------------------------------------
    | DEFAULT
    |--------------------------------------------------------------------------
    */

        if (!$status) {

            $query->whereIn('status', [
                'paid',
                'active',
                'rejected',
            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | FILTER
    |--------------------------------------------------------------------------
    */

        if ($status === 'paid') {
            $query->where('status', 'paid');
        }

        if ($status === 'active') {
            $query->where('status', 'active');
        }

        if ($status === 'rejected') {
            $query->where('status', 'rejected');
        }

        $Reservations = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'pages.admin.verifikasi-reservasi.index',
            compact('Reservations', 'status')
        );
    }

    public function show(Reservation $Reservation)
    {
        $Reservation->load([
            'room.floor.building',
            'user.studentProfile'
        ]);

        return view('pages.admin.verifikasi-reservasi.show', compact('Reservation'));
    }

    public function approve(Reservation $Reservation)
    {
        DB::transaction(function () use ($Reservation) {

            $Reservation->loadMissing([
                'room.floor',
                'user.studentProfile'
            ]);

            /*
            |--------------------------------------------------------------------------
            | APPROVE RESERVATION
            |--------------------------------------------------------------------------
            */
            $Reservation->update([
                'status' => 'active',
                'reservation_code' => $Reservation->reservation_code
                    ?: $this->generateReservationCode(),
            ]);


            /*
            |--------------------------------------------------------------------------
            | CHECKOUT
            |--------------------------------------------------------------------------
            */

            if ($Reservation->reservation_type === 'checkout') {

                Occupant::where('user_id', $Reservation->user_id)
                    ->where('status', 'active')
                    ->update([
                        'status' => 'inactive',
                        'end_date' => now(),
                    ]);

                $student = $Reservation->user?->studentProfile;

                if ($student) {

                    $room = Room::find($student->room_id);

                    if ($room) {

                        $capacity = (int) ($room->floor?->room_capacity ?? 2);
                        $slotUsed = (int) ($Reservation->slot_used ?? 1);

                        $room->occupied = max(
                            0,
                            ((int) $room->occupied) - $slotUsed
                        );

                        $room->status = $room->occupied >= $capacity
                            ? 'penuh'
                            : 'tersedia';

                        $room->save();
                    }

                    $student->update([
                        'room_id' => null,
                        'status_mahasiswa' => 'non-penghuni',
                    ]);
                }

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | EXTENSION / TRANSFER
            |--------------------------------------------------------------------------
            */

            Occupant::updateOrCreate(
                [
                    'user_id' => $Reservation->user_id,
                ],
                [
                    'room_id' => $Reservation->room_id,
                    'reservation_id' => $Reservation->id,
                    'start_date' => $Reservation->start_date,
                    'end_date' => $Reservation->end_date,
                    'status' => 'active',
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | TRANSFER ROOM
            |--------------------------------------------------------------------------
            */

            if (
                $Reservation->reservation_type === 'transfer' &&
                $Reservation->previous_room_id
            ) {

                $previousRoom = Room::find(
                    $Reservation->previous_room_id
                );

                if ($previousRoom) {

                    $previousCapacity = (int) (
                        $previousRoom->floor?->room_capacity ?? 2
                    );

                    $previousRoom->occupied = max(
                        0,
                        ((int) $previousRoom->occupied) - 1
                    );

                    $previousRoom->status =
                        $previousRoom->occupied >= $previousCapacity
                        ? 'penuh'
                        : 'tersedia';

                    $previousRoom->save();
                }
            }

            /*
            |--------------------------------------------------------------------------
            | NEW ROOM
            |--------------------------------------------------------------------------
            */

            $room = $Reservation->room;

            if ($room) {

                $capacity = (int) ($room->floor?->room_capacity ?? 2);

                $slotUsed = (int) ($Reservation->slot_used ?? 1);

                if ($Reservation->occupancy_type === 'private') {

                    $room->occupied = $capacity;
                } else {

                    $room->occupied = min(
                        $capacity,
                        ((int) $room->occupied) + $slotUsed
                    );
                }

                $room->status = $room->occupied >= $capacity
                    ? 'penuh'
                    : 'tersedia';

                $room->save();
            }

            /*
            |--------------------------------------------------------------------------
            | UPDATE STUDENT PROFILE
            |--------------------------------------------------------------------------
            */

            $Reservation->user?->studentProfile?->update([
                'status_mahasiswa' => 'penghuni',
                'room_id' => $Reservation->room_id,
            ]);
        });

        SendReservationApprovedMailJob::dispatch(
            $Reservation->id
        );

        SendReservationApprovedWhatsappJob::dispatch(
            $Reservation->id
        );
        return redirect()
            ->route('admin.verifikasi.index')
            ->with(
                'success',
                'Reservation berhasil disetujui.'
            );
    }

    public function reject(Reservation $Reservation)
    {
        $Reservation->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route('admin.verifikasi.index')
            ->with(
                'success',
                'Reservation ditolak.'
            );
    }
}
