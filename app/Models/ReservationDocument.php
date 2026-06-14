<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ReservationDocument extends Model
{
    use HasUlids;

    protected $fillable = [
        'reservation_id',
        'document_name',
        'file_path',
        'status',
        'notes',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
