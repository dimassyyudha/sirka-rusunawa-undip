<?php

namespace App\Events;

use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomAvailabilityUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public array $room;

    public function __construct(Room $room)
    {
        $room->load('floor.building');

        $capacity = (int) ($room->floor?->room_capacity ?? 2);
        $occupied = (int) ($room->occupied ?? 0);
        $slots = max(0, $capacity - $occupied);

        $this->room = [
            'id' => $room->room_id,
            'kode_kamar' => $room->kode_kamar,
            'gedung' => $room->floor?->building?->code,
            'lantai' => $room->floor?->floor_number,
            'capacity' => $capacity,
            'occupied' => $occupied,
            'slots' => $slots,
            'status' => $room->status,
        ];
    }

    public function broadcastOn(): Channel
    {
        return new Channel('rooms');
    }

    public function broadcastAs(): string
    {
        return 'room.availability.updated';
    }
}
