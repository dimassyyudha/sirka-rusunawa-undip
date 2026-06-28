<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupant extends Model
{
    use HasFactory;

    protected $table = 'occupants';

    protected $primaryKey = 'occupant_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'occupant_id',
        'user_id',
        'room_id',
        'reservation_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($occupant) {

            if (!$occupant->occupant_id) {

                $last = self::orderByDesc('occupant_id')->first();

                $number = $last
                    ? ((int) substr($last->occupant_id, 3)) + 1
                    : 1;

                $occupant->occupant_id =
                    'OCC' . str_pad($number, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }

    public function room()
    {
        return $this->belongsTo(
            Room::class,
            'room_id',
            'room_id'
        );
    }

    public function reservation()
    {
        return $this->belongsTo(
            Reservation::class,
            'reservation_id',
            'reservation_id'
        );
    }
}
