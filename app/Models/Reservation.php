<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'reservation_code',

        'room_id',
        'user_id',

        'occupancy_period_id',
        'reservation_type',
        'previous_room_id',

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

        'requested_at',
        'approved_at',
        'checked_out_at',

        'document_path',
        'kip_document_path',
    ];

    protected $casts = [
        'duration_month' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'checked_out_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function previousRoom()
    {
        return $this->belongsTo(Room::class, 'previous_room_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeType($query, string $type)
    {
        return $query->where('reservation_type', $type);
    }

    public function occupancyPeriod()
    {
        return $this->belongsTo(OccupancyPeriod::class);
    }

    public function documents()
    {
        return $this->hasMany(ReservationDocument::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function paymentTransactions()
    {
        return $this->hasMany(
            PaymentTransaction::class,
            'invoice_id'
        );
    }
}
