<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class OccupancyPeriod extends Model
{
    use HasUlids;

    protected $fillable = [
        'name',
        'semester_type',
        'academic_year_start',
        'academic_year_end',
        'registration_start_date',
        'registration_end_date',
        'lease_start_date',
        'lease_end_date',
        'payment_due_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'registration_start_date' => 'date',
        'registration_end_date' => 'date',
        'lease_start_date' => 'date',
        'lease_end_date' => 'date',
        'payment_due_date' => 'date',
    ];
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'occupancy_period_id');
    }

    public function getComputedStatusAttribute(): string
    {
        if ($this->status === 'open') {
            return 'open';
        }

        if ($this->status === 'closed') {
            return 'closed';
        }

        $today = now()->startOfDay();

        $start = $this->registration_start_date->copy()->startOfDay();
        $end = $this->registration_end_date->copy()->endOfDay();

        if ($today->between($start, $end)) {
            return 'open';
        }

        if ($today->lt($start)) {
            return 'upcoming';
        }

        return 'closed';
    }
}
