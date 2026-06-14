<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasUlids;

    protected $fillable = [
        'invoice_id',
        'user_id',
        'order_id',
        'order_hash',
        'payment_gateway',
        'gross_amount',
        'payment_type',
        'transaction_status',
        'snap_token',
        'expired_at',
        'paid_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->hasOneThrough(
            Reservation::class,
            Invoice::class,
            'id',
            'id',
            'invoice_id',
            'reservation_id'
        );
    }
}
