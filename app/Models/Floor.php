<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;

    protected $table = 'floors';

    protected $primaryKey = 'floor_id';

    public $incrementing = false;

    
    protected $keyType = 'string';

    protected $fillable = [
        'floor_id',
        'building_id',
        'floor_number',
        'total_rooms',
        'monthly_price',
        'room_capacity',
    ];

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($floor) {

            if (!$floor->floor_id) {

                $last = self::orderByDesc('floor_id')->first();

                $number = $last
                    ? ((int) substr($last->floor_id, 3)) + 1
                    : 1;

                $floor->floor_id =
                    'FLR' . str_pad($number, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Building
     */
    public function building()
    {
        return $this->belongsTo(
            Building::class,
            'building_id',
            'building_id'
        );
    }

    /**
     * Rooms
     */
    public function rooms()
    {
        return $this->hasMany(
            Room::class,
            'floor_id',
            'floor_id'
        );
    }
}
