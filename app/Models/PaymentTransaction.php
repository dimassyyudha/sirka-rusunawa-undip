<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $table = 'payment_transactions';

    protected $primaryKey = 'payment_transaction_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'payment_transaction_id',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {

            /*
            |--------------------------------------------------------------------------
            | Payment Transaction ID
            |--------------------------------------------------------------------------
            */

            if (!$payment->payment_transaction_id) {

                $last = self::orderByDesc('payment_transaction_id')->first();

                $number = $last
                    ? ((int) substr($last->payment_transaction_id, 3)) + 1
                    : 1;

                $payment->payment_transaction_id =
                    'PAY' . str_pad($number, 6, '0', STR_PAD_LEFT);
            }

            /*
            |--------------------------------------------------------------------------
            | Order Hash
            |--------------------------------------------------------------------------
            */

            if (!$payment->order_hash) {
                $payment->order_hash = hash('sha256', uniqid());
            }

            /*
            |--------------------------------------------------------------------------
            | Default Value
            |--------------------------------------------------------------------------
            */

            if (empty($payment->payment_type)) {
                $payment->payment_type = '0';
            }

            if (empty($payment->transaction_status)) {
                $payment->transaction_status = '0';
            }

            if (empty($payment->snap_token)) {
                $payment->snap_token = '0';
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function invoice()
    {
        return $this->belongsTo(
            Invoice::class,
            'invoice_id',
            'invoice_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }
    public function reservation()
    {
        return $this->hasOneThrough(
            Reservation::class,
            Invoice::class,
            'invoice_id',      // FK di invoices
            'reservation_id',  // FK di reservations
            'invoice_id',      // FK di payment_transactions
            'reservation_id'   // PK/FK di invoices
        );
    }
}
