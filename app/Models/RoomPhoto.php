<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUlids;

class RoomPhoto extends Model
{
    use HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'room_id',
        'path',
        'is_primary',
        'order',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
