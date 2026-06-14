<?php

namespace App\Models;


use App\Models\Floor;
use App\Models\Room;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'code',
        'gender_type',
        'total_floors',
        'is_active',
    ];

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }

    public function rooms()
    {
        return $this->hasManyThrough(Room::class, Floor::class);
    }

    public function getTotalRoomsAttribute()
    {
        return $this->floors->sum(fn($floor) => $floor->rooms->count());
    }
}
