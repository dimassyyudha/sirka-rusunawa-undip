<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use App\Models\Occupant;
use Carbon\Carbon;

class OccupantSeeder extends Seeder
{
    public function run(): void
    {
        Occupant::query()->delete();

        Room::query()->update([
            'occupied' => 0,
            'status' => 'tersedia',
        ]);

        $users = User::where('role', 'mahasiswa')
            ->whereHas('studentProfile', function ($query) {
                $query->where('status_mahasiswa', 'penghuni');
            })
            ->get();

        $rooms = Room::with('floor.building')
            ->orderBy('kode_kamar')
            ->get();

        if ($users->isEmpty() || $rooms->isEmpty()) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | KONDISI 1: Kamar terisi 1 orang, tapi masih kosong 1 slot
        |--------------------------------------------------------------------------
        */

        $roomTerisiSebagian = $rooms->shift();

        if ($roomTerisiSebagian) {
            $this->assignOccupant(
                user: $users->shift(),
                room: $roomTerisiSebagian
            );

            $roomTerisiSebagian->update([
                'occupied' => 1,
                'status' => 'tersedia',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | KONDISI 2: Kamar penuh
        |--------------------------------------------------------------------------
        */

        $roomPenuh = $rooms->shift();

        if ($roomPenuh) {
            $capacity = (int) ($roomPenuh->floor?->room_capacity ?? 2);

            for ($i = 1; $i <= $capacity; $i++) {
                if ($users->isEmpty()) {
                    break;
                }

                $this->assignOccupant(
                    user: $users->shift(),
                    room: $roomPenuh
                );
            }

            $roomPenuh->update([
                'occupied' => $capacity,
                'status' => 'penuh',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | KONDISI 3: Kamar maintenance
        |--------------------------------------------------------------------------
        */

        $roomMaintenance = $rooms->shift();

        if ($roomMaintenance) {
            $roomMaintenance->update([
                'occupied' => 0,
                'status' => 'maintenance',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | KONDISI 4: Beberapa kamar terisi random tapi belum tentu penuh
        |--------------------------------------------------------------------------
        */

        foreach ($rooms->take(10) as $room) {
            if ($users->isEmpty()) {
                break;
            }

            $capacity = (int) ($room->floor?->room_capacity ?? 2);

            $jumlahPenghuni = rand(0, max(1, $capacity));

            if ($jumlahPenghuni === 0) {
                $room->update([
                    'occupied' => 0,
                    'status' => 'tersedia',
                ]);

                continue;
            }

            for ($i = 1; $i <= $jumlahPenghuni; $i++) {
                if ($users->isEmpty()) {
                    break;
                }

                $this->assignOccupant(
                    user: $users->shift(),
                    room: $room
                );
            }

            $room->update([
                'occupied' => $jumlahPenghuni,
                'status' => $jumlahPenghuni >= $capacity ? 'penuh' : 'tersedia',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Sisa kamar dibuat kosong
        |--------------------------------------------------------------------------
        */

        foreach ($rooms->skip(10) as $room) {
            $room->update([
                'occupied' => 0,
                'status' => 'tersedia',
            ]);
        }
    }

    private function assignOccupant(?User $user, Room $room): void
    {
        if (! $user) {
            return;
        }

        $startDate = Carbon::now()->subMonths(rand(1, 6));
        $endDate = $startDate->copy()->addMonths(6);

        Occupant::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'reservation_id' => null,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);

        $user->studentProfile?->update([
            'room_id' => $room->id,
            'status_mahasiswa' => 'penghuni',
        ]);
    }
}
