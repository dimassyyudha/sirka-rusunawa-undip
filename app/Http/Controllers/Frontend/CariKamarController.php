<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Occupant;
use App\Models\Room;

class CariKamarController extends Controller
{
    public function index()
    {
        // dd(request()->all());
        $sort = request('sort', 'recommended');
        $gender = request('gender');
        $gedung = request('gedung');
        $lantai = request('lantai');

        $rooms = Room::with([
            'photos',
            'floor.building'
        ])
            ->where('rooms.status', 'tersedia')
            ->join('floors', 'rooms.floor_id', '=', 'floors.floor_id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.building_id')
            ->where('buildings.is_active', true)
            // ->whereRaw('rooms.occupied < floors.room_capacity')
            ->select([
                'rooms.*',
                'floors.floor_number as lantai',
                'floors.monthly_price as harga',
                'floors.room_capacity as capacity',
                'buildings.code as gedung',
                'buildings.name as nama_gedung',
                'buildings.gender_type',
            ]);

        if ($gender === 'laki-laki') {
            $rooms->where('buildings.gender_type', 'laki-laki');
        }

        if ($gender === 'perempuan') {
            $rooms->where('buildings.gender_type', 'perempuan');
        }

        if ($gedung) {
            $gedung = strtoupper(preg_replace('/^Gedung\s+/i', '', trim((string) $gedung)));
            $rooms->where('buildings.code', $gedung);
        }

        if ($lantai) {
            $rooms->where('floors.floor_number', $lantai);
        }

        if ($sort === 'price_low') {
            $rooms->orderBy('floors.monthly_price', 'asc');
        } elseif ($sort === 'price_high') {
            $rooms->orderBy('floors.monthly_price', 'desc');
        } elseif ($sort === 'slots_high') {
            $rooms->orderByRaw('(COALESCE(floors.room_capacity, 2) - COALESCE(rooms.occupied, 0)) DESC');
        } else {
            $rooms->orderBy('buildings.code')
                ->orderBy('rooms.kode_kamar');
        }

        $rooms = $rooms->paginate(10)->withQueryString();

        $rooms->getCollection()->transform(function ($room) {

            $room->occupied = Occupant::where('room_id', $room->room_id)
                ->where('status', 'active')
                ->count();

            $reservation = \App\Models\Reservation::where('room_id', $room->room_id)
                ->whereIn('status', ['active', 'approved'])
                ->latest()
                ->first();

            if ($reservation?->occupancy_type === 'private') {

                $room->slots = 0;
            } else {

                $room->slots =
                    max(
                        0,
                        ((int) $room->capacity) -
                            ((int) $room->occupied)
                    );
            }

            return $room;
        });

        $rooms->setCollection(
            $rooms->getCollection()
                ->filter(fn($room) => $room->slots > 0)
                ->values()
        );

        $gedungsList = Building::query()
            ->where('is_active', true)
            ->orderBy('code')
            ->get([
                'code',
                'gender_type'
            ])
            ->toArray();

        $floorInfoQuery = Floor::join(
            'buildings',
            'floors.building_id',
            '=',
            'buildings.building_id'
        )
            ->where('buildings.is_active', true)
            ->select(
                'buildings.code',
                'floors.floor_number',
                'floors.total_rooms'
            );
        $floorInfo = $floorInfoQuery
            ->orderBy('buildings.code')
            ->orderBy('floors.floor_number')
            ->get()
            ->groupBy('code')
            ->map(fn($items) => $items->pluck('total_rooms', 'floor_number')->toArray())
            ->toArray();

        if (request()->ajax()) {
            return view('pages.cari-kamar.partials.room-list', compact('rooms'))->render();
        }

        return view('pages.cari-kamar.index', compact(
            'rooms',
            'gedungsList',
            'floorInfo'
        ));
    }

    public function show(Room $room)
    {
        $building = $room->floor?->building;

        $gedungCode = $building?->code ?? '-';
        $gedungLabel = $gedungCode;
        $gedungLabelUpper = strtoupper($gedungCode);

        $buildingName = $building?->name ?? '-';
        $buildingGender = $building?->gender_type ?? '-';

        $lantai = $room->floor?->floor_number ?? '-';

        $harga = (int) ($room->floor?->monthly_price ?? 0);
        $room->load([
            'floor.building',
            'testimonials.user',
        ]);

        $visibleTestimonials = $room->testimonials
            ->where('is_visible', true);

        $averageRating = round($visibleTestimonials->avg('rating') ?? 0, 1);
        $totalTestimonials = $visibleTestimonials->count();

        // $capacity = (int) ($room->floor?->room_capacity ?? 2);
        // $occupied = (int) ($room->occupied ?? 0);
        // $slots = max(0, $capacity - $occupied);

        $reservation = \App\Models\Reservation::where('room_id', $room->room_id)
            ->whereIn('status', ['active', 'approved'])
            ->latest()
            ->first();

        $capacity = (int) ($room->floor?->room_capacity ?? 2);

        $occupied = Occupant::where('room_id', $room->room_id)
            ->where('status', 'active')
            ->count();

        if ($reservation?->occupancy_type === 'private') {

            $slots = 0;
        } else {

            $slots = max(0, $capacity - $occupied);
        }

        $harga = (int) ($room->floor?->monthly_price ?? 0);

        $isAvailable = $room->status === 'tersedia' && $slots > 0;

        $gedungLabel = $room->floor?->building?->code ?? '-';

        $fasilitasList = [];
        if ($room->fasilitas) {
            $fasilitasList = preg_split('/\r\n|\r|\n|,/', $room->fasilitas);
            $fasilitasList = array_filter(array_map('trim', $fasilitasList));
        }
        $user = auth()->user();

        $canReserve = $isAvailable;
        $reserveMessage = null;

        if (!$isAvailable) {

            $canReserve = false;

            $reserveMessage = 'Kamar sudah penuh.';
        } elseif ($user) {

            // ADMIN
            if ($user->role === 'admin') {

                $canReserve = false;

                $reserveMessage =
                    'Admin tidak dapat melakukan reservasi kamar.';
            }

            // SUDAH PUNYA KAMAR AKTIF
            elseif (
                Occupant::where('user_id', $user->user_id)
                ->where('status', 'active')
                ->exists()
            ) {

                $canReserve = false;

                $reserveMessage =
                    'Anda sudah memiliki kamar aktif.';
            }

            // CEK GENDER
            else {

                $userGender = strtolower($user->gender);

                $buildingGender = strtolower(
                    $room->floor?->building?->gender_type
                );

                $genderMatch =
                    ($userGender === 'laki-laki' &&
                        $buildingGender === 'laki-laki')
                    ||
                    ($userGender === 'perempuan' &&
                        $buildingGender === 'perempuan');

                if (!$genderMatch) {

                    $canReserve = false;

                    $reserveMessage =
                        $buildingGender === 'laki-laki'
                        ? 'Kamar ini hanya tersedia untuk mahasiswa laki-laki.'
                        : 'Kamar ini hanya tersedia untuk mahasiswa perempuan.';
                }
            }
        }
        $gallery = [];

        if ($room->photos->count()) {

            foreach (
                $room->photos
                    ->sortBy('order')
                    ->sortByDesc('is_primary')
                as $photo
            ) {

                $gallery[] = asset($photo->path);
            }
        } else {

            $gedung = strtoupper(
                $room->floor?->building?->code ?? ''
            );

            $folderMap = [
                'A' => 'a',
                'B' => 'b',
                'C' => 'c',
                'D' => 'd',
                'E' => 'e',
                'F' => 'f',
            ];

            $folder = $folderMap[$gedung] ?? null;

            if ($folder) {

                for ($i = 1; $i <= 6; $i++) {

                    $file =
                        public_path(
                            "images/{$folder}/{$folder}{$i}.jpg"
                        );

                    if (file_exists($file)) {

                        $gallery[] =
                            asset(
                                "images/{$folder}/{$folder}{$i}.jpg"
                            );
                    }
                }
            }
        }

        if (empty($gallery)) {

            $gallery[] =
                asset('assets-admin/images/hero-1.jpg');
        }
        return view('pages.cari-kamar.show', compact(
            'room',

            // gallery
            'gallery',

            // gedung
            'gedungCode',
            'gedungLabel',
            'gedungLabelUpper',
            'buildingName',
            'buildingGender',

            // floor
            'lantai',
            'harga',
            'capacity',
            'occupied',
            'slots',

            // room state
            'isAvailable',
            'canReserve',
            'reserveMessage',

            // fasilitas
            'fasilitasList',

            // review
            'visibleTestimonials',
            'averageRating',
            'totalTestimonials'
        ));
    }
}
