<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $primaryKey = 'invoice_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'invoice_id',
        'user_id',
        'reservation_id',
        'room_id',
        'invoice_number',
        'invoice_type',
        'amount',
        'status',
        'due_at',
        'paid_at',
        'description',
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {

            /*
            |--------------------------------------------------------------------------
            | Invoice ID
            |--------------------------------------------------------------------------
            */

            if (!$invoice->invoice_id) {

                $last = self::orderByDesc('invoice_id')->first();

                $number = $last
                    ? ((int) substr($last->invoice_id, 3)) + 1
                    : 1;

                $invoice->invoice_id =
                    'INV' . str_pad($number, 6, '0', STR_PAD_LEFT);
            }

            /*
            |--------------------------------------------------------------------------
            | Invoice Number
            |--------------------------------------------------------------------------
            */

            if (!$invoice->invoice_number) {

                $invoice->invoice_number =
                    'INV-' .
                    now()->format('Ymd') .
                    '-' .
                    strtoupper(substr(md5(uniqid()), 0, 6));
            }

            /*
            |--------------------------------------------------------------------------
            | Default Description
            |--------------------------------------------------------------------------
            */

            if (empty($invoice->description)) {
                $invoice->description = '0';
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

    public function reservation()
    {
        return $this->belongsTo(
            Reservation::class,
            'reservation_id',
            'reservation_id'
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



    public function paymentTransactions()
    {
        return $this->hasMany(
            PaymentTransaction::class,
            'invoice_id',
            'invoice_id'
        );
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'paid' => 'Lunas',
            'unpaid' => 'Belum Lunas',
            'pending' => 'Menunggu',
            default => ucfirst($this->status),
        };
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
