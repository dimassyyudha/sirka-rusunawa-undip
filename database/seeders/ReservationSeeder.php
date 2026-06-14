<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Room;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'mahasiswa')
            ->whereHas('studentProfile', fn($q) => $q->where('status_mahasiswa', 'calon_penghuni'))
            ->take(15)
            ->get();

        $rooms = Room::with('floor')->where('status', 'tersedia')->get();

        if ($users->isEmpty() || $rooms->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            $room = $rooms->random();

            $startDate = Carbon::now()->addDays(rand(1, 30));
            $duration = 6;

            Reservation::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
                'duration_month' => $duration,
                'start_date' => $startDate,
                'end_date' => $startDate->copy()->addMonths($duration),
                'status' => collect(['pending', 'approved', 'rejected', 'cancelled'])->random(),
                'notes' => fake('id_ID')->optional()->sentence(),
            ]);
        }
    }
}
