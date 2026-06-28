<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccupancyPeriod extends Model
{
    use HasFactory;

    protected $table = 'occupancy_periods';

    protected $primaryKey = 'occupancy_period_id';
    

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'occupancy_period_id',
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
        'registration_end_date'   => 'date',
        'lease_start_date'        => 'date',
        'lease_end_date'          => 'date',
        'payment_due_date'        => 'date',
    ];

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($period) {

            if (!$period->occupancy_period_id) {

                $last = self::orderByDesc('occupancy_period_id')->first();

                $number = $last
                    ? ((int) substr($last->occupancy_period_id, 3)) + 1
                    : 1;

                $period->occupancy_period_id =
                    'OCP' . str_pad($number, 6, '0', STR_PAD_LEFT);
            }

            if (empty($period->notes)) {
                $period->notes = '0';
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function reservations()
    {
        return $this->hasMany(
            Reservation::class,
            'occupancy_period_id',
            'occupancy_period_id'
        );
    }
    public function getRouteKeyName()
    {
        return 'occupancy_period_id';
    }
}
