<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'role',
        'gender',
        'number_phone',
        'profile_photo',
    ];

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {

            if (!$user->user_id) {

                $last = self::orderByDesc('user_id')->first();

                $next = $last
                    ? ((int) substr($last->user_id, 3)) + 1
                    : 1;

                $user->user_id = 'USR' . str_pad($next, 7, '0', STR_PAD_LEFT);
            }
        });
    }
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    public function activeOccupant()
    {
        return $this->hasOne(Occupant::class)
            ->where('status', 'active');
    }

    public function studentProfile()
    {
        return $this->hasOne(
            StudentProfile::class,
            'user_id',
            'user_id'
        );
    }

    public function invoices()
    {
        return $this->hasMany(
            Invoice::class,
            'user_id',
            'user_id'
        );
    }

    public function paymentTransactions()
    {
        return $this->hasMany(
            PaymentTransaction::class,
            'user_id',
            'user_id'
        );
    }

    public function occupants()
    {
        return $this->hasMany(
            Occupant::class,
            'user_id',
            'user_id'
        );
    }

    public function reservations()
    {
        return $this->hasMany(
            Reservation::class,
            'user_id',
            'user_id'
        );
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    public function profilePhotoUrl(): ?string
    {
        if (!$this->profile_photo) {
            return null;
        }

        if (
            str_starts_with($this->profile_photo, 'http://') ||
            str_starts_with($this->profile_photo, 'https://')
        ) {
            return $this->profile_photo;
        }

        if (str_starts_with($this->profile_photo, 'storage/')) {
            return asset($this->profile_photo);
        }

        return asset('storage/' . $this->profile_photo);
    }

    public function scopeFilter(Builder $query, $request, array $filterableColumns): Builder
    {
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('number_phone', 'like', "%{$search}%");
            });
        }

        foreach ($filterableColumns as $column) {
            if (!$request->filled($column)) {
                continue;
            }

            $value = $request->input($column);

            if ($column === 'email_verified_at') {
                $value === 'verified'
                    ? $query->whereNotNull('email_verified_at')
                    : $query->whereNull('email_verified_at');

                continue;
            }

            $query->where($column, $value);
        }

        return $query;
    }
}
