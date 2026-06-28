<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Recommendation extends Model
{
    use HasUlids;
    // protected $primaryKey = 'recommendation_id';

    protected $fillable = [
        'room_id',
        'badge',
        'sort_order',
        'is_active',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }
}
