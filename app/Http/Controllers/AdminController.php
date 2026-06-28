<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Occupant;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function redirectByRole()
    {
        $role = auth()->user()->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'mahasiswa') {
            return redirect()->route('page.beranda');
        }

        abort(403, 'Role tidak dikenal.');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $profile = $user->studentProfile;

        $activeReservation = Reservation::with(['room.floor.building'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'paid', 'approved', 'active'])
            ->latest()
            ->first();

        return view('pages.mahasiswa.dashboard', [
            'profile' => $profile,
            'activeReservation' => $activeReservation,
        ]);
    }

    public function admin()
    {
        $totalRooms = Room::count();

        $occupiedRooms = Room::whereHas('occupants', function ($query) {
            $query->where('status', 'active');
        })->count();

        $availableRooms = $totalRooms - $occupiedRooms;

        $fullRooms = Room::query()
            ->with('floor')
            ->get()
            ->filter(function ($room) {

                $capacity = $room->floor->room_capacity ?? 2;

                $activeOccupants = $room->occupants()
                    ->where('status', 'active')
                    ->count();

                $reservation = Reservation::where('room_id', $room->room_id)
                    ->whereIn('status', ['approved', 'active'])
                    ->latest()
                    ->first();

                if ($reservation?->occupancy_type === 'private') {
                    return true;
                }

                return $activeOccupants >= $capacity;
            })
            ->count();

        $activeOccupants = Occupant::where('status', 'active')->count();

        $buildings = Building::with(['rooms.floor'])
            ->where('is_active', true)
            ->orderBy('code')
            ->get();

        $statsByBuilding = $buildings->map(function ($building) {

            $rooms = $building->rooms;

            $totalRoom = $rooms->count();

            $tersedia = 0;
            $terisi = 0;
            $penuh = 0;

            foreach ($rooms as $room) {

                $capacity = $room->floor->room_capacity ?? 2;

                $activeOccupants = $room->occupants()
                    ->where('status', 'active')
                    ->count();

                $reservation = Reservation::where('room_id', $room->room_id)
                    ->whereIn('status', ['approved', 'active'])
                    ->latest()
                    ->first();

                $isPrivate =
                    $reservation &&
                    $reservation->occupancy_type === 'private';

                if ($isPrivate) {

                    $penuh++;
                } elseif ($activeOccupants <= 0) {

                    $tersedia++;
                } elseif ($activeOccupants >= $capacity) {

                    $penuh++;
                } else {

                    $terisi++;
                }
            }

            return [
                'nama_gedung' => $building->name,

                'total' => $totalRoom,

                // hanya kamar yang belum penuh
                'tersedia' => $totalRoom - $penuh,

                // hanya shared yang masih punya slot
                'terisi' => $terisi,

                // private aktif + shared penuh
                'full' => $penuh,
            ];
        });

        $availableRooms = collect($statsByBuilding)->sum('tersedia');

        $occupiedRooms = collect($statsByBuilding)->sum('terisi');

        $fullRooms = collect($statsByBuilding)->sum('full');


        //     $incomeByBuilding = Building::query()
        //         ->leftJoin('floors', 'buildings.id', '=', 'floors.building_id')
        //         ->leftJoin('rooms', 'floors.id', '=', 'rooms.floor_id')
        //         ->leftJoin('reservations', function ($join) {
        //             $join->on('rooms.id', '=', 'reservations.room_id')
        //                 ->whereIn('reservations.status', [
        //                     'paid',
        //                     'approved',
        //                     'active',
        //                     'completed'
        //                 ]);
        //         })
        //         ->leftJoin('invoices', function ($join) {
        //             $join->on('reservations.id', '=', 'invoices.reservation_id')
        //                 ->whereIn('invoices.status', [
        //                     'paid',
        //                     'settlement'
        //                 ]);
        //         })
        //         ->selectRaw("
        //     buildings.id,
        //     buildings.name as nama_gedung,
        //     COALESCE(SUM(invoices.amount),0) as income
        // ")
        //         ->where('buildings.is_active', true)
        //         ->groupBy(
        //             'buildings.id',
        //             'buildings.name'
        //         )
        //         ->orderBy('buildings.code')
        //         ->get();

        $incomeByBuilding = Building::query()
            ->leftJoin('floors', 'buildings.building_id', '=', 'floors.building_id')
            ->leftJoin('rooms', 'floors.floor_id', '=', 'rooms.floor_id')
            ->leftJoin('reservations', function ($join) {
                $join->on('rooms.room_id', '=', 'reservations.room_id')
                    ->whereIn('reservations.status', [
                        'active',
                        'approved',
                        'completed',
                    ]);
            })
            ->selectRaw("
        buildings.building_id,
        buildings.name as nama_gedung,
        COALESCE(SUM(reservations.total_price),0) as income
    ")
            ->groupBy('buildings.building_id', 'buildings.name')
            ->orderBy('buildings.code')
            ->get();

        $availableRooms = collect($statsByBuilding)->sum('tersedia');

        $occupiedRooms = collect($statsByBuilding)->sum('terisi');

        $fullRooms = collect($statsByBuilding)->sum('full');
        $latestReservations = Reservation::with(['user', 'room.floor.building'])
            ->latest()
            ->take(5)
            ->get();

        // =========================
        // RINGKASAN KEUANGAN BARU
        // =========================
        $totalIncome = $incomeByBuilding->sum('income');

        return view('pages.admin.dashboard', [
            'totalRooms' => $totalRooms,
            'availableRooms' => $availableRooms,
            'occupiedRooms' => $occupiedRooms,
            'fullRooms' => $fullRooms,
            'activeOccupants' => $activeOccupants,
            'statsByBuilding' => $statsByBuilding,
            'incomeByBuilding' => $incomeByBuilding,
            'latestReservations' => $latestReservations,
            'buildings' => $buildings,
            'totalIncome' => $totalIncome,
        ]);
    }
}
