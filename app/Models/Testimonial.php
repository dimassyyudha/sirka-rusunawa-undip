<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'testimonials';

    protected $primaryKey = 'testimonial_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'testimonial_id',
        'room_id',
        'user_id',
        'rating',
        'comment',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($testimonial) {

            if (!$testimonial->testimonial_id) {

                $last = self::orderByDesc('testimonial_id')->first();

                $number = $last
                    ? ((int) substr($last->testimonial_id, 3)) + 1
                    : 1;

                $testimonial->testimonial_id =
                    'TST' . str_pad($number, 6, '0', STR_PAD_LEFT);
            }

            if (empty($testimonial->comment)) {
                $testimonial->comment = '0';
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function room()
    {
        return $this->belongsTo(
            Room::class,
            'room_id',
            'room_id'
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
}
