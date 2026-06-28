<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * Table
     */
    protected $table = 'reservations';

    /**
     * Primary Key
     */
    protected $primaryKey = 'reservation_id';

    public $incrementing = false;

    protected $keyType = 'string';


    /**
     * Mass Assignment
     */
    protected $fillable = [
        'reservation_id',
        'reservation_code',
        'room_id',
        'user_id',
        'occupancy_period_id',

        'contact_name',
        'contact_phone',
        'contact_email',

        'guest_name',
        'guest_nim',
        'guest_faculty',
        'guest_major',
        'guest_intake_year',

        'parent_name',
        'parent_phone',

        'start_date',
        'end_date',
        'duration_month',
        'payment_term',
        'occupancy_type',
        'slot_used',
        'price_per_month',
        'total_price',

        'status',
        'special_request',
        'reservation_type',
        'previous_room_id',
    ];

    /**
     * Cast
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reservation) {

            /*
            |--------------------------------------------------------------------------
            | Reservation ID
            |--------------------------------------------------------------------------
            */

            if (!$reservation->reservation_id) {

                $last = self::orderByDesc('reservation_id')->first();

                $number = $last
                    ? ((int) substr($last->reservation_id, 3)) + 1
                    : 1;

                $reservation->reservation_id =
                    'RES' . str_pad($number, 6, '0', STR_PAD_LEFT);
            }

            /*
            |--------------------------------------------------------------------------
            | Reservation Code
            |--------------------------------------------------------------------------
            */

            if (!$reservation->reservation_code) {

                do {

                    $code = strtoupper(substr(md5(uniqid()), 0, 8));
                } while (self::where('reservation_code', $code)->exists());

                $reservation->reservation_code = $code;
            }

            /*
            |--------------------------------------------------------------------------
            | Default Value
            |--------------------------------------------------------------------------
            */

            if (empty($reservation->special_request)) {
                $reservation->special_request = '0';
            }

            if (empty($reservation->previous_room_id)) {
                $reservation->previous_room_id = '0';
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * User
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }

    /**
     * Room
     */
    public function room()
    {
        return $this->belongsTo(
            Room::class,
            'room_id',
            'room_id'
        );
    }

    /**
     * Occupancy Period
     */
    public function occupancyPeriod()
    {
        return $this->belongsTo(
            OccupancyPeriod::class,
            'occupancy_period_id',
            'occupancy_period_id'
        );
    }

    /**
     * Invoice
     */
    public function invoices()
    {
        return $this->hasMany(
            Invoice::class,
            'reservation_id',
            'reservation_id'
        );
    }

    /**
     * Occupant
     */
    public function occupants()
    {
        return $this->hasMany(
            Occupant::class,
            'reservation_id',
            'reservation_id'
        );
    }

    public function paymentTransactions()
    {
        return $this->hasManyThrough(
            PaymentTransaction::class,
            Invoice::class,
            'reservation_id', // FK di invoices
            'invoice_id',     // FK di payment_transactions
            'reservation_id', // PK reservation
            'invoice_id'      // PK invoice
        );
    }

    /**
     * Kamar sebelumnya
     */
    public function previousRoom()
    {
        return $this->belongsTo(
            Room::class,
            'previous_room_id',
            'room_id'
        );
    }
}
