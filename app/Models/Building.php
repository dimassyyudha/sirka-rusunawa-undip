<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Building extends Model
{
    use HasFactory;

    protected $table = 'buildings';

    protected $primaryKey = 'building_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'building_id',
        'name',
        'code',
        'gender_type',
        'total_floors',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($building) {

            if (!$building->building_id) {

                $last = self::orderByDesc('building_id')->first();

                $number = $last
                    ? ((int) substr($last->building_id, 3)) + 1
                    : 1;

                $building->building_id =
                    'BLD' . str_pad($number, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function floors()
    {
        return $this->hasMany(
            Floor::class,
            'building_id',
            'building_id'
        );
    }

    public function rooms(): HasManyThrough
    {
        return $this->hasManyThrough(
            Room::class,
            Floor::class,
            'building_id',
            'floor_id',
            'building_id',
            'floor_id'
        );
    }
}
