<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'floor_id',
        'kode_kamar',
        'occupied',
        'fasilitas',
        'status',
    ];
    public function penghuni()
    {
        return $this->hasMany(StudentProfile::class, 'room_id')
            ->where('status_mahasiswa', 'penghuni');
    }

    public function Reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function occupants()
    {
        return $this->hasMany(Occupant::class);
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function getBuildingAttribute()
    {
        return $this->floor?->building;
    }

    public function getMonthlyPriceAttribute()
    {
        return $this->floor?->monthly_price;
    }

    public function getRoomCapacityAttribute()
    {
        return $this->floor?->room_capacity;
    }
    public function reviews()
    {
        return $this->hasMany(\App\Models\RoomReview::class);
    }

    public function activeOccupants()
    {
        return $this->hasMany(\App\Models\Occupant::class)->where('status', 'active');
    }
    public function photos()
    {
        return $this->hasMany(\App\Models\RoomPhoto::class, 'room_id');
    }
}
