<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Invoice extends Model
{
    use HasUlids;


    protected $fillable = [
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
        'amount' => 'integer',
        'due_at' => 'datetime',
        'paid_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(
            PaymentTransaction::class,
            'invoice_id'
        );
    }
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'paid', 'lunas', 'settlement' => 'Lunas',
            'unpaid', 'belum_lunas' => 'Belum Lunas',
            'pending' => 'Menunggu Pembayaran',
            'expired' => 'Kedaluwarsa',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount ?? 0, 0, ',', '.');
    }
}
