<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
use App\Models\Reservation;
use App\Models\OccupancyPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $period = OccupancyPeriod::first();

        $rooms = Room::with('floor')
            ->where('status', 'tersedia')
            ->get();

        $users = User::where('role', 'mahasiswa')
            ->take(50)
            ->get();

        foreach ($users as $index => $user) {

            $room = $rooms[$index % $rooms->count()];

            $capacity = $room->floor->room_capacity;

            $occupancyType =
                fake()->boolean(70)
                ? 'shared'
                : 'private';

            $duration =
                fake()->randomElement([3, 6]);

            $price =
                $room->floor->monthly_price;

            Reservation::create([

                'reservation_code' =>
                strtoupper(Str::random(8)),

                'room_id' =>
                $room->room_id,

                'user_id' =>
                $user->id,

                'occupancy_period_id' =>
                $period->id,

                'reservation_type' =>
                'new',

                'contact_name' =>
                $user->name,

                'contact_phone' =>
                $user->number_phone,

                'contact_email' =>
                $user->email,

                'guest_name' =>
                $user->name,

                'guest_nim' =>
                $user->studentProfile->nim,

                'guest_faculty' =>
                $user->studentProfile->fakultas,

                'guest_major' =>
                $user->studentProfile->jurusan,

                'guest_intake_year' =>
                $user->studentProfile->angkatan,

                'parent_name' =>
                $user->studentProfile->nama_ortu,

                'parent_phone' =>
                $user->studentProfile->no_hp_ortu,

                'start_date' =>
                $period->lease_start_date,

                'end_date' =>
                $period->lease_end_date,

                'duration_month' =>
                $duration,

                'payment_term' =>
                $duration == 6 ? 2 : 1,

                'occupancy_type' =>
                $occupancyType,

                'slot_used' =>
                $occupancyType == 'private'
                    ? $capacity
                    : 1,

                'price_per_month' =>
                $price,

                'total_price' =>
                $price * $duration,

                'status' =>
                'active',

                'approved_at' =>
                now(),
            ]);
        }
    }
}
