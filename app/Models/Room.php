<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $primaryKey = 'room_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'room_id',
        'floor_id',
        'kode_kamar',
        'occupied',
        'fasilitas',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($room) {

            if (!$room->room_id) {

                $last = self::orderByDesc('room_id')->first();

                $number = $last
                    ? (int) substr($last->room_id, 2) + 1
                    : 1;

                $room->room_id = 'RM' . str_pad($number, 6, '0', STR_PAD_LEFT);
            }
            if (empty($room->fasilitas)) {
                $room->fasilitas = '';
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Floor
     */
    public function floor()
    {
        return $this->belongsTo(
            Floor::class,
            'floor_id',
            'floor_id'
        );
    }

    /**
     * Student Profiles
     */
    public function studentProfiles()
    {
        return $this->hasMany(
            StudentProfile::class,
            'room_id',
            'room_id'
        );
    }

    /**
     * Reservations
     */
    public function reservations()
    {
        return $this->hasMany(
            Reservation::class,
            'room_id',
            'room_id'
        );
    }

    /**
     * Invoices
     */
    public function invoices()
    {
        return $this->hasMany(
            Invoice::class,
            'room_id',
            'room_id'
        );
    }

    /**
     * Occupants
     */
    public function occupants()
    {
        return $this->hasMany(
            Occupant::class,
            'room_id',
            'room_id'
        );
    }

    /**
     * Testimonials
     */
    public function testimonials()
    {
        return $this->hasMany(
            Testimonial::class,
            'room_id',
            'room_id'
        );
    }
    public function penghuni()
    {
        return $this->hasMany(
            Occupant::class,
            'room_id',
            'room_id'
        );
    }
    public function photos()
    {
        return $this->hasMany(
            RoomPhoto::class,
            'room_id',
            'room_id'
        );
    }
}
