<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class RoomReview extends Model
{
    use HasUlids;

    protected $fillable = [
        'room_id',
        'user_id',
        'rating',
        'comment',
        'is_visible',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}